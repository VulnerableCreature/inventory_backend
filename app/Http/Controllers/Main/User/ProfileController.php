<?php

namespace App\Http\Controllers\Main\User;

use App\Application\User\Command\UpdateProfileCommand;
use App\Application\User\Query\GetUserProfileQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Http\Resources\User\ProfileResource;
use Illuminate\Http\JsonResponse;

final class ProfileController extends Controller
{
    public function index(): ProfileResource
    {
        $profile = $this->queryBus->ask(new GetUserProfileQuery());

        return new ProfileResource($profile);
    }

    public function update(UpdateProfileRequest $request): JsonResponse
    {
        $dto = $request->toDto();

        $this->commandBus->dispatch(new UpdateProfileCommand(
            auth()->id(),
            $dto->surname,
            $dto->name,
            $dto->middleName
        ));

        return response()->json([
            'message' => 'Profile successfully updated.'
        ]);
    }
}
