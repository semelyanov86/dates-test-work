<?php

declare(strict_types=1);

namespace App\Actions;

interface ImportDatesActionInterface
{
    public function import(string $filePath): void;
}
