<?php

declare(strict_types=1);

namespace App\Module\User\Command;

use App\Application\User\Command\UpdateProfileCommand;
use App\Models\Profile;

final readonly class UpdateProfileHandler
{
    public function __construct()
    {
    }

    public function handle(UpdateProfileCommand $command): Profile
    {
        $profile = Profile::query()->firstOrCreate(
            ['user_id' => $command->id],
            [
                'surname' => $command->surname,
                'name' => $command->name,
                'middleName' => $command->middleName,
            ]
        );

        if ($profile->wasRecentlyCreated) {
            return $profile;
        }

        $profile->update([
            'surname' => $command->surname,
            'name' => $command->name,
            'middleName' => $command->middleName,
        ]);

        return $profile;
    }
}
