<?php

declare(strict_types=1);

namespace App\Module\Issuance\Command;

use App\Application\Issuance\Command\CreateIssuanceCommentCommand;
use App\Models\Employee;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use morphos\Russian\Cases;
use function morphos\Russian\inflectName;

final readonly class CreateIssuanceCommentHandler
{
    /**
     * @throws Exception
     */
    public function handle(CreateIssuanceCommentCommand $command): string
    {
        $roomLabel = $command->room->type->label();
        $roomNumber = $command->room->number;

        if ($command->asset->inventory_number === null) {
            $deviceName = $command->device?->original_name;
            $deviceInventory = $command->device?->inventory_number;

            return "Установлен в $deviceName ($deviceInventory) в $roomLabel №$roomNumber";
        }

        $issuableName = $this->resolveIssuableName($command->issuable);

        return "Выдан $issuableName в $roomLabel №$roomNumber";
    }

    /**
     * @throws Exception
     */
    private function resolveIssuableName(Model $issuable): string
    {
        [$surname, $name, $middleName] = match (true) {
            $issuable instanceof User => [
                $issuable->profile?->surname,
                $issuable->profile?->name,
                $issuable->profile?->middleName
            ],
            $issuable instanceof Employee => [
                $issuable->surname,
                $issuable->name,
                $issuable->middleName
            ],
            default => [null, null, null]
        };

        if ($surname === null) {
            return "Undefined {$issuable->getKey()} {$issuable->getMorphClass()}";
        }

        $inflectedSurname = inflectName((string)$surname, Cases::DAT);
        $initials = $this->formatInitials((string)$name, (string)$middleName);

        return "$inflectedSurname $initials";
    }

    private function formatInitials(string $name, string $middleName): string
    {
        $n = Str::take(Str::ucfirst($name), 1);
        $m = Str::take(Str::ucfirst($middleName), 1);

        return "$n.$m";
    }
}
