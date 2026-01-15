<?php

namespace App\Module\Wallet\Enums;

enum StatusEnum: string
{
    case ACTIVE = 'active';

    case CLOSED = 'closed';

    case BLOCKED = 'blocked';
}
