<?php

namespace App\CQRS;

use App\Application\Asset\Command\CreateAssetCommand;
use App\Application\Asset\Command\DeleteAssetCommand;
use App\Application\Asset\Command\UpdateAssetCommand;
use App\Application\Asset\Command\UpdateAssetQuantityCommand;
use App\Application\Asset\Command\UpdateAssetStatusCommand;
use App\Application\Asset\Query\GetAllAssetsQuery;
use App\Application\Asset\Query\GetAssetByIdQuery;
use App\Application\Authorization\Command\LoginCommand;
use App\Application\Authorization\Command\LogoutCommand;
use App\Application\Employee\Command\CreateEmployeeCommand;
use App\Application\Employee\Command\DeleteEmployeeCommand;
use App\Application\Employee\Command\UpdateEmployeeCommand;
use App\Application\Employee\Query\GetAllEmployeesQuery;
use App\Application\Employee\Query\GetEmployeeByIdQuery;
use App\Application\Issuance\Command\CreateIssuanceCommand;
use App\Application\Issuance\Command\CreateIssuanceCommentCommand;
use App\Application\Issuance\Command\UpdateIssuanceAssetCommand;
use App\Application\Issuance\Command\UpdateIssuanceCommentCommand;
use App\Application\Issuance\Command\UpdateIssuanceDeviceCommand;
use App\Application\Issuance\Command\UpdateIssuanceIssuableCommand;
use App\Application\Issuance\Command\UpdateIssuanceIssuedAtCommand;
use App\Application\Issuance\Command\UpdateIssuanceQuantityCommand;
use App\Application\Issuance\Command\UpdateIssuanceRoomCommand;
use App\Application\Issuance\Query\GetAllIssuancesQuery;
use App\Application\Issuance\Query\GetIssuanceByIdQuery;
use App\Application\Room\Command\CreateRoomCommand;
use App\Application\Room\Command\DeleteRoomCommand;
use App\Application\Room\Command\UpdateRoomCommand;
use App\Application\Room\Query\GetAllRoomQuery;
use App\Application\Room\Query\GetRoomByIdQuery;
use App\Application\RoomOccupant\Command\AssignOccupantsToRoomCommand;
use App\Application\RoomOccupant\Command\RemoveOccupantsFromRoomCommand;
use App\Application\Transaction\Command\CreateTransactionCommand;
use App\Application\Transaction\Command\UpdateTransactionStatusCommand;
use App\Application\User\Command\CreateUserCommand;
use App\Application\User\Command\DeleteUserCommand;
use App\Application\User\Command\UpdateProfileCommand;
use App\Application\User\Query\GetAllUsersQuery;
use App\Application\User\Query\GetUserByIdQuery;
use App\Application\User\Query\GetUserProfileQuery;
use App\Application\Wallet\Command\CreateWalletCommand;
use App\Application\Wallet\Command\UpdateWalletBalanceCommand;
use App\Application\Wallet\Query\GetWalletByIdQuery;
use App\Module\Asset\Command\CreateAssetHandler;
use App\Module\Asset\Command\DeleteAssetHandler;
use App\Module\Asset\Command\UpdateAssetHandler;
use App\Module\Asset\Command\UpdateAssetQuantityHandler;
use App\Module\Asset\Command\UpdateAssetStatusHandler;
use App\Module\Asset\Query\GetAllAssetsHandler;
use App\Module\Asset\Query\GetAssetByIdHandler;
use App\Module\Authorization\Handler\LoginHandler;
use App\Module\Authorization\Handler\LogoutHandler;
use App\Module\Employee\Command\CreateEmployeeHandler;
use App\Module\Employee\Command\DeleteEmployeeHandler;
use App\Module\Employee\Command\UpdateEmployeeHandler;
use App\Module\Employee\Query\GetAllEmployeesHandler;
use App\Module\Employee\Query\GetEmployeeByIdHandler;
use App\Module\Issuance\Command\CreateIssuanceCommentHandler;
use App\Module\Issuance\Command\CreateIssuanceHandler;
use App\Module\Issuance\Command\UpdateIssuanceAssetHandler;
use App\Module\Issuance\Command\UpdateIssuanceCommentHandler;
use App\Module\Issuance\Command\UpdateIssuanceDeviceHandler;
use App\Module\Issuance\Command\UpdateIssuanceIssuableHandler;
use App\Module\Issuance\Command\UpdateIssuanceIssuedAtHandler;
use App\Module\Issuance\Command\UpdateIssuanceQuantityHandler;
use App\Module\Issuance\Command\UpdateIssuanceRoomHandler;
use App\Module\Issuance\Query\GetAllIssuancesHandler;
use App\Module\Issuance\Query\GetIssuanceByIdHandler;
use App\Module\Room\Command\CreateRoomHandler;
use App\Module\Room\Command\DeleteRoomHandler;
use App\Module\Room\Command\UpdateRoomHandler;
use App\Module\Room\Query\GetAllRoomHandler;
use App\Module\Room\Query\GetRoomByIdHandler;
use App\Module\RoomOccupant\Command\AssignOccupantsToRoomHandler;
use App\Module\RoomOccupant\Command\RemoveOccupantsFromRoomHandler;
use App\Module\Transaction\Command\CreateTransactionHandler;
use App\Module\Transaction\Command\UpdateTransactionStatusHandler;
use App\Module\User\Command\CreateUserHandler;
use App\Module\User\Command\DeleteUserHandler;
use App\Module\User\Command\UpdateProfileHandler;
use App\Module\User\Query\GetAllUsersHandler;
use App\Module\User\Query\GetUserByIdHandler;
use App\Module\User\Query\GetUserProfileHandler;
use App\Module\Wallet\Handler\CreateWalletHandler;
use App\Module\Wallet\Handler\UpdateWalletBalanceHandler;
use App\Module\Wallet\Query\GetWalletByIdHandler;
use Illuminate\Bus\Dispatcher;
use Illuminate\Support\ServiceProvider;

class CQRSServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CommandBusInterface::class, CommandBus::class);
        $this->app->bind(QueryBusInterface::class, QueryBus::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(Dispatcher $dispatcher): void
    {
        // Command
        $this->registerCommands($dispatcher);

        //Query
        $this->registerQueries($dispatcher);
    }

    private function registerCommands(Dispatcher $dispatcher): void
    {
        $dispatcher->map([
            LoginCommand::class => LoginHandler::class,
            LogoutCommand::class => LogoutHandler::class,
            UpdateProfileCommand::class => UpdateProfileHandler::class,
            CreateUserCommand::class => CreateUserHandler::class,
            DeleteUserCommand::class => DeleteUserHandler::class,
            CreateWalletCommand::class => CreateWalletHandler::class,
            UpdateWalletBalanceCommand::class => UpdateWalletBalanceHandler::class,
            CreateAssetCommand::class => CreateAssetHandler::class,
            UpdateAssetCommand::class => UpdateAssetHandler::class,
            DeleteAssetCommand::class => DeleteAssetHandler::class,
            UpdateAssetQuantityCommand::class => UpdateAssetQuantityHandler::class,
            UpdateAssetStatusCommand::class => UpdateAssetStatusHandler::class,
            CreateTransactionCommand::class => CreateTransactionHandler::class,
            UpdateTransactionStatusCommand::class => UpdateTransactionStatusHandler::class,
            CreateEmployeeCommand::class => CreateEmployeeHandler::class,
            UpdateEmployeeCommand::class => UpdateEmployeeHandler::class,
            DeleteEmployeeCommand::class => DeleteEmployeeHandler::class,
            CreateRoomCommand::class => CreateRoomHandler::class,
            UpdateRoomCommand::class => UpdateRoomHandler::class,
            DeleteRoomCommand::class => DeleteRoomHandler::class,
            AssignOccupantsToRoomCommand::class => AssignOccupantsToRoomHandler::class,
            RemoveOccupantsFromRoomCommand::class => RemoveOccupantsFromRoomHandler::class,
            CreateIssuanceCommand::class => CreateIssuanceHandler::class,
            CreateIssuanceCommentCommand::class => CreateIssuanceCommentHandler::class,
            UpdateIssuanceAssetCommand::class => UpdateIssuanceAssetHandler::class,
            UpdateIssuanceRoomCommand::class => UpdateIssuanceRoomHandler::class,
            UpdateIssuanceIssuableCommand::class => UpdateIssuanceIssuableHandler::class,
            UpdateIssuanceDeviceCommand::class => UpdateIssuanceDeviceHandler::class,
            UpdateIssuanceQuantityCommand::class => UpdateIssuanceQuantityHandler::class,
            UpdateIssuanceIssuedAtCommand::class => UpdateIssuanceIssuedAtHandler::class,
            UpdateIssuanceCommentCommand::class => UpdateIssuanceCommentHandler::class,
        ]);
    }

    private function registerQueries(Dispatcher $dispatcher): void
    {
        $dispatcher->map([
            GetUserByIdQuery::class => GetUserByIdHandler::class,
            GetUserProfileQuery::class => GetUserProfileHandler::class,
            GetAllUsersQuery::class => GetAllUsersHandler::class,
            GetAllAssetsQuery::class => GetAllAssetsHandler::class,
            GetAssetByIdQuery::class => GetAssetByIdHandler::class,
            GetWalletByIdQuery::class => GetWalletByIdHandler::class,
            GetAllEmployeesQuery::class => GetAllEmployeesHandler::class,
            GetEmployeeByIdQuery::class => GetEmployeeByIdHandler::class,
            GetAllRoomQuery::class => GetAllRoomHandler::class,
            GetRoomByIdQuery::class => GetRoomByIdHandler::class,
            GetAllIssuancesQuery::class => GetAllIssuancesHandler::class,
            GetIssuanceByIdQuery::class => GetIssuanceByIdHandler::class,
        ]);
    }
}
