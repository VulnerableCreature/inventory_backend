<?php

declare(strict_types=1);

namespace App\Application\Wallet\Query;

use App\CQRS\QueryInterface;

final readonly class GetWalletByIdQuery implements QueryInterface
{
    public function __construct(
        public int $id,
    )
    {
    }
}
