<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;

final class UploadController extends Controller
{
    public function upload(FileRequest $request): \Illuminate\Http\RedirectResponse
    {
        return back()->with('success', 'Файл успешно загружен!');
    }
}
