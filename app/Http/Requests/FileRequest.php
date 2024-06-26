<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class FileRequest extends FormRequest
{
    /**
     * @return array<string, string[]>
     */
    public function rules(): array
    {
        return [
            'xls_file' => ['required', 'file', 'mimes:xls,xlsx'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
