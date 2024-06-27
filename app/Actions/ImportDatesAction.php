<?php

declare(strict_types=1);

namespace App\Actions;

use App\Import\DateColumnsImport;

final class ImportDatesAction implements ImportDatesActionInterface
{
    public function import(string $filePath): void
    {
        $import = new DateColumnsImport($this->generateId());
        \Excel::queueImport($import, $filePath);
    }

    protected function generateId(): string
    {
        return uniqid('', true);
    }
}
