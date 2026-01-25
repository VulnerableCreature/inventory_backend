<?php

declare(strict_types=1);

namespace App\Module\Issuance\Query;

use App\Application\Issuance\Query\GetIssuanceByIdQuery;
use App\Models\Issuance;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphTo;

final readonly class GetIssuanceByIdHandler
{
    public function handle(GetIssuanceByIdQuery $byIdQuery): Issuance
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
                'device'
            ])
            ->findOrFail($byIdQuery->id);
    }
}
