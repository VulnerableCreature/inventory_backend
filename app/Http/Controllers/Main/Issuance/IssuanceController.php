<?php

namespace App\Http\Controllers\Main\Issuance;

use App\Application\Issuance\Query\GetAllIssuancesQuery;
use App\Application\Issuance\Query\GetIssuanceByIdQuery;
use App\CQRS\CommandBusInterface;
use App\CQRS\QueryBusInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Issuance\CreateIssuanceRequest;
use App\Http\Requests\Issuance\UpdateIssuanceRequest;
use App\Http\Resources\Issuance\IssuanceCollection;
use App\Http\Resources\Issuance\IssuanceResource;
use App\Module\Issuance\Exceptions\IssuanceTargetTypeImmutableException;
use App\Module\Issuance\Exceptions\RoomNotAssignedToIssuableException;
use App\Module\Issuance\Orchestrators\CreateIssuanceOrchestrator;
use App\Module\Issuance\Orchestrators\UpdateIssuanceOrchestrator;
use Illuminate\Http\JsonResponse;
use Throwable;

final class IssuanceController extends Controller
{
    public function __construct(
        CommandBusInterface                         $commandBus,
        QueryBusInterface                           $queryBus,
        private readonly CreateIssuanceOrchestrator $createIssuanceOrchestrator,
        private readonly UpdateIssuanceOrchestrator $updateIssuanceOrchestrator,
    )
    {
        parent::__construct($commandBus, $queryBus);
    }

    public function index(): IssuanceCollection
    {
        $issuances = $this->queryBus->ask(new GetAllIssuancesQuery());

        return new IssuanceCollection($issuances);
    }

    public function show(int $id): IssuanceResource
    {
        $issuance = $this->queryBus->ask(new GetIssuanceByIdQuery($id));

        return new IssuanceResource($issuance);
    }

    /**
     * @throws Throwable
     */
    public function store(CreateIssuanceRequest $request): JsonResponse
    {
        $this->createIssuanceOrchestrator->execute($request->toDto());

        return response()->json([
            'message' => 'Issuance created successfully',
        ], 201);
    }

    /**
     * @throws IssuanceTargetTypeImmutableException
     * @throws Throwable
     * @throws RoomNotAssignedToIssuableException
     */
    public function update(UpdateIssuanceRequest $request, int $id): JsonResponse
    {
        $this->updateIssuanceOrchestrator->execute($request->toDto(), $id);

        return response()->json([
            'message' => 'Issuance updated successfully',
        ]);
    }
}
