<?php

declare(strict_types=1);

namespace App\Module\Authorization\DTO;

use Illuminate\Support\Arr;

final readonly class AuthorizationUserDto
{
    public function __construct(
        public string $login,
        public string $password,
    )
    {
    }

    public static function fromRequest(array $data): AuthorizationUserDto
    {
        return new self(
            Arr::get($data, 'login'),
            Arr::get($data, 'password'),
        );
    }
}
