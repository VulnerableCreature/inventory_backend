<?php

namespace App\Module\Issuance\Traits;

use App\Application\Employee\Query\GetEmployeeByIdQuery;
use App\Application\User\Query\GetUserByIdQuery;
use App\Models\Employee;
use App\Models\User;
use App\Shared\Support\GenderDetector;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Str;
use InvalidArgumentException;
use morphos\Russian\Cases;
use morphos\Russian\LastNamesInflection;
use Throwable;

trait ResolvableIssuableTrait
{
    private function resolveIssuable(string $type, int $id): Model
    {
        $morphMap = Relation::morphMap();

        if (!isset($morphMap[$type])) {
            throw new InvalidArgumentException("Invalid issuable type: $type");
        }

        return match ($type) {
            'user' => $this->queryBus->ask(new GetUserByIdQuery($id)),
            'employee' => $this->queryBus->ask(new GetEmployeeByIdQuery($id)),
            default => throw new InvalidArgumentException("Unsupported issuable type: $type"),
        };
    }

    /**
     * @throws Exception
     */
    private function resolveIssuableName(Model $issuable): string
    {
        [$surname, $name, $middleName] = match (true) {
            $issuable instanceof User => [
                $issuable->profile?->surname ?? $issuable->login,
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

        if ($issuable instanceof User && !$issuable->profile) {
            return (string)$surname;
        }

        if ($surname === null) {
            return "Undefined {$issuable->getKey()} {$issuable->getMorphClass()}";
        }

        $gender = GenderDetector::detect($middleName, $name, (string)$surname);

        try {
            $inflectedSurname = LastNamesInflection::getCase(
                (string)$surname,
                Cases::DAT,
                $gender
            );
        } catch (Throwable) {
            $inflectedSurname = (string)$surname;
        }

        $initials = $this->formatInitials($name, $middleName);

        return trim("$inflectedSurname $initials");
    }

    private function formatInitials(?string $name, ?string $middleName): string
    {
        if (empty($name)) {
            return '';
        }

        $n = Str::upper(Str::substr($name, 0, 1));
        $initials = "$n.";

        if (!empty($middleName)) {
            $m = Str::upper(Str::substr($middleName, 0, 1));
            $initials .= "$m.";
        }

        return $initials;
    }
}
