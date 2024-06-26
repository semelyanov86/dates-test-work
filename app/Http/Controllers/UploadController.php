<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use App\Import\DateColumnsImport;

final class UploadController extends Controller
{
    public function upload(FileRequest $request): \Illuminate\Http\RedirectResponse
    {
        $file = $request->file('xls_file');
        if (is_array($file) || ! $file) {
            return back()->withErrors(['xls_file' => 'Поддерживается загрузка только одного файла']);
        }
        $path = $file->store('uploads');

        if (! $path) {
            return back()->withErrors(['xls_file' => 'Не возможно сохранить файл']);
        }
        $import = new DateColumnsImport(uniqid('', true));
        \Excel::queueImport($import, $path);

        return back()->with('success', 'Файл успешно загружен!');
    }
}
