<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\ImportDatesActionInterface;
use App\Http\Requests\FileRequest;

final class UploadController extends Controller
{
    public function upload(FileRequest $request, ImportDatesActionInterface $action): \Illuminate\Http\RedirectResponse
    {
        $file = $request->file('xls_file');
        if (is_array($file) || ! $file) {
            return back()->withErrors(['xls_file' => 'Поддерживается загрузка только одного файла']);
        }
        $path = $file->store('uploads');

        if (! $path) {
            return back()->withErrors(['xls_file' => 'Не возможно сохранить файл']);
        }
        $action->import($path);

        return back()->with('success', 'Файл успешно загружен!');
    }
}
