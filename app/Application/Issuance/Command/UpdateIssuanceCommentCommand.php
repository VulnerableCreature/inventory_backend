<?php

declare(strict_types=1);

namespace App\Application\Issuance\Command;

use App\CQRS\CommandInterface;
use App\Models\Asset;
use App\Models\Issuance;
use App\Models\Room;
use Illuminate\Database\Eloquent\Model;

final readonly class UpdateIssuanceCommentCommand implements CommandInterface
{
    public function __construct(
        public Issuance $issuance,
        public Asset    $asset,
        public Room     $room,
        public ?Asset   $device,
        public Model    $issuable,
    )
    {
    }
}
