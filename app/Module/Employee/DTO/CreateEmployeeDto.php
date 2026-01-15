<?php

declare(strict_types=1);

namespace App\Module\Employee\DTO;

use Illuminate\Support\Arr;

final readonly class CreateEmployeeDto
{
    public function __construct(
        public string $surname,
        public string $name,
        public string $middleName,
    )
    {
    }

    public static function fromRequest(array $data): CreateEmployeeDto
    {
        return new self(
            Arr::get($data, 'surname'),
            Arr::get($data, 'name'),
            Arr::get($data, 'middleName'),
        );
    }
}
