<?php

namespace App\Module\Issuance\Enums;

enum IssuanceStatusEnum: string
{
    case ACTIVE = 'active';

    case RETURNED = 'returned';
}
