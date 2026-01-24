<?php

namespace App\Module\Asset\Enums;

enum OperationEnum: string
{
    case CREDIT = 'credit';

    case DEBIT = 'debit';
}
