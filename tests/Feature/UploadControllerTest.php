<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Actions\ImportDatesActionInterface;
use App\Events\DateImportedEvent;
use App\Http\Requests\FileRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Maatwebsite\Excel\Facades\Excel;
use Mockery;
use Tests\TestCase;

final class UploadControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_redirects_back_with_error_if_no_file_uploaded(): void
    {
        $request = Mockery::mock(FileRequest::class);
        // @phpstan-ignore-next-line
        $request->shouldReceive('file')->with('xls_file')->andReturn(null);

        $action = Mockery::mock(ImportDatesActionInterface::class);

        $response = $this->post(route('upload.file'), ['xls_file' => null]);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['xls_file' => 'The xls file field is required.']);
    }

    public function test_it_redirects_back_with_error_if_multiple_files_uploaded(): void
    {
        $file = UploadedFile::fake()->create('file.xls');
        $response = $this->post(route('upload.file'), ['xls_file' => [$file]]);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['xls_file' => 'The xls file field must be a file.']);
    }

    public function test_it_redirects_back_with_success_message_on_successful_upload(): void
    {
        $path = __DIR__.'/../Other/Files/rows_import.xlsx';
        Excel::fake();
        // @phpstan-ignore-next-line
        $file = UploadedFile::fake()->createWithContent('doc.xlsx', file_get_contents($path));

        $response = $this->post(route('upload.file'), ['xls_file' => $file]);

        $response->assertRedirect('/');
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('success', 'Файл успешно загружен!');
    }

    public function test_it_throws_an_event_and_runs_job(): void
    {
        $this->markTestSkipped();
        // @phpstan-ignore-next-line
        Event::fake();
        $path = __DIR__.'/../Other/Files/rows_import.xlsx';
        // @phpstan-ignore-next-line
        $file = UploadedFile::fake()->createWithContent('doc.xlsx', file_get_contents($path));

        $response = $this->post(route('upload.file'), ['xls_file' => $file]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseCount('dates', 4);
        Event::assertDispatched(DateImportedEvent::class);
    }
}
