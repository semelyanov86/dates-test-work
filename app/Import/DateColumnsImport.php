<?php

declare(strict_types=1);

namespace App\Import;

use App\Models\Date;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redis;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\RemembersChunkOffset;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\AfterChunk;

/**
 * @property-read int $rowNumber
 */
final class DateColumnsImport implements ShouldQueue, ToModel, WithBatchInserts, WithCalculatedFormulas, WithChunkReading, WithEvents, WithStartRow, WithUpserts, WithValidation
{
    use Importable;
    use RegistersEventListeners;
    use RemembersChunkOffset;
    use RemembersRowNumber;

    public function __construct(
        protected string $id,
    ) {}

    /**
     * @param  array<int, string>  $row
     */
    public function model(array $row): Date
    {
        return new Date([
            'id' => (int) $row[0],
            'name' => $row[1],
            'date' => Carbon::parse($row[2]),
        ]);
    }

    /**
     * @return array<string|int, string[]>
     */
    public function rules(): array
    {
        return [
            '0' => ['required', 'integer', 'min:1'],
            '1' => ['required'],
            '2' => ['required'],
        ];
    }

    /**
     * @return positive-int
     */
    public function chunkSize(): int
    {
        /** @var positive-int $result */
        $result = config('excel.exports.chunk_size');

        return $result;
    }

    public function uniqueBy(): string
    {
        return 'id';
    }

    public function batchSize(): int
    {
        /** @var positive-int $result */
        $result = config('excel.exports.chunk_size');

        return $result;
    }

    public function startRow(): int
    {
        return 2;
    }

    /**
     * @return array<class-string, mixed>
     */
    public function registerEvents(): array
    {
        return [
            AfterChunk::class => function (AfterChunk $event) {
                /** @var self $context */
                $context = $event->getConcernable();
                Redis::set($context->id, $context->rowNumber);
            },
        ];
    }
}
