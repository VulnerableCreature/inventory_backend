<?php

declare(strict_types=1);

namespace App\Module\Issuance\Query;

use App\Models\Issuance;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Collection;

final readonly class GetAllIssuancesHandler
{
    public function handle(): Collection
    {
        return Issuance::query()
            ->with([
                'issuable' => function(MorphTo $morphTo) {
                    $morphTo->morphWith([
                        User::class => ['profile'],
                    ]);
                },
                'creator.profile',
                'asset',
                'room',
            ])
            ->orderByDesc('created_at')
            ->get();
    }
}
