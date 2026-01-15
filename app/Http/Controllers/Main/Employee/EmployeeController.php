<?php

namespace App\Http\Controllers\Main\Employee;

use App\Application\Employee\Command\CreateEmployeeCommand;
use App\Application\Employee\Command\DeleteEmployeeCommand;
use App\Application\Employee\Command\UpdateEmployeeCommand;
use App\Application\Employee\Query\GetAllEmployeesQuery;
use App\Application\Employee\Query\GetEmployeeByIdQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\CreateEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Http\Resources\Employee\EmployeeCollection;
use App\Http\Resources\Employee\EmployeeResource;
use Illuminate\Http\JsonResponse;
use Throwable;

final class EmployeeController extends Controller
{
    public function index(): EmployeeCollection
    {
        $employees = $this->queryBus->ask(new GetAllEmployeesQuery());
        return new EmployeeCollection($employees);
    }

    public function show(int $id): EmployeeResource
    {
        $employee = $this->queryBus->ask(new GetEmployeeByIdQuery($id));
        return new EmployeeResource($employee);
    }

    /**
     * @throws Throwable
     */
    public function store(CreateEmployeeRequest $request): JsonResponse
    {
        $dto = $request->toDto();

        $this->commandBus->dispatch(new CreateEmployeeCommand($dto->surname, $dto->name, $dto->middleName));

        return response()->json([
            'message' => 'Employee created successfully'
        ], status: 201);
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateEmployeeRequest $request, int $id): JsonResponse
    {
        $dto = $request->toDto();

        $employee = $this->commandBus->dispatch(new UpdateEmployeeCommand($id, $dto->surname, $dto->name, $dto->middleName));

        return response()->json(new EmployeeResource($employee));
    }

    /**
     * @throws Throwable
     */
    public function destroy(int $id): JsonResponse
    {
        $this->commandBus->dispatch(new DeleteEmployeeCommand($id));

        return response()->json([
            'message' => 'The record was successfully deleted'
        ]);
    }
}
