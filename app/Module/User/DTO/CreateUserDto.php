<?php

declare(strict_types=1);

namespace App\Module\User\DTO;

use Illuminate\Support\Arr;

final readonly class CreateUserDto
{
    public function __construct(
        public string $login,
        public string $password,
    )
    {
    }

    public static function fromRequest(array $data): CreateUserDto
    {
        return new self(
            Arr::get($data, 'login'),
            Arr::get($data, 'password'),
        );
    }
}
