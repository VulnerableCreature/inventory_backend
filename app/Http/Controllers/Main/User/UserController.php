<?php

namespace App\Http\Controllers\Main\User;

use App\Application\User\Command\CreateUserCommand;
use App\Application\User\Command\DeleteUserCommand;
use App\Application\User\Query\GetAllUsersQuery;
use App\Application\User\Query\GetUserByIdQuery;
use App\Application\Wallet\Command\CreateWalletCommand;
use App\CQRS\TransactionResultCollector;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UserFilterRequest;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Throwable;

final class UserController extends Controller
{
    public function index(UserFilterRequest $request): UserCollection
    {
        $users = $this->queryBus->ask(new GetAllUsersQuery($request->filters()));

        return new UserCollection($users);
    }

    public function show(int $id): UserResource
    {
        $user = $this->queryBus->ask(new GetUserByIdQuery($id));

        return new UserResource($user);
    }

    /**
     * @throws Throwable
     */
    public function store(CreateUserRequest $request): JsonResponse
    {
        $dto = $request->toDto();

        $commands = [
            new CreateUserCommand($dto->login, $dto->password),
            function(TransactionResultCollector $collector) {
                /** @var User $user */
                $user = $collector->first();
                return new CreateWalletCommand($user->id);
            }
        ];

        $this->commandBus->dispatchInTransaction($commands);

        return response()->json([
            'message' => 'User created successfully'
        ], status: 201);
    }

    public function delete(int $id): JsonResponse
    {
        $this->commandBus->dispatch(new DeleteUserCommand($id));

        return response()->json(status: 204);
    }
}
