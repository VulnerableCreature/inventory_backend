<?php

declare(strict_types=1);

namespace App\Module\Wallet\Query;

use App\Application\Wallet\Query\GetWalletByIdQuery;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Relations\HasMany;

final readonly class GetWalletByIdHandler
{
    public function handle(GetWalletByIdQuery $walletByIdQuery): Wallet
    {
        return Wallet::query()
            ->with('transactions', function(HasMany $query) {
                $query->orderByDesc('created_at');
            })
            ->findOrFail($walletByIdQuery->id);
    }
}
