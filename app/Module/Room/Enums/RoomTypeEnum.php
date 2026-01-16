<?php

declare(strict_types=1);

namespace App\Module\Room\Enums;

enum RoomTypeEnum: string
{
    case OFFICE = 'office';

    case AUDITORIUM = 'auditorium';

    case WORKING_SPACE = 'working_space';

    public function label(): string
    {
        return match ($this) {
            self::OFFICE => "Кабинет",
            self::AUDITORIUM => "Аудитория",
            self::WORKING_SPACE => "Рабочее помещение",
        };
    }
}
