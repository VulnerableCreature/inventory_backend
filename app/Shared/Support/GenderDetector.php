<?php

declare(strict_types=1);

namespace App\Shared\Support;

use Illuminate\Support\Str;
use morphos\Gender;
use morphos\Russian\FirstNamesInflection;

final readonly class GenderDetector
{
    /**
     * Определяет пол по ФИО с приоритетом на Отчество -> Имя -> Фамилию.
     *
     * @param string|null $middleName Отчество (самое важное)
     * @param string|null $name       Имя
     * @param string|null $surname    Фамилия
     *
     * @return string Gender::MALE или Gender::FEMALE
     */
    public static function detect(?string $middleName = null, ?string $name = null, ?string $surname = null): string
    {
        if (!empty($middleName)) {
            $upperMiddle = Str::upper($middleName);

            if (Str::endsWith($upperMiddle, 'НА')) {
                return Gender::FEMALE;
            }

            if (Str::endsWith($upperMiddle, 'ИЧ')) {
                return Gender::MALE;
            }
        }

        if (!empty($name)) {
            $gender = FirstNamesInflection::detectGender($name);
            if ($gender) {
                return $gender;
            }

            $upperName = Str::upper($name);

            if (Str::endsWith($upperName, ['А', 'Я'])) {
                return Gender::FEMALE;
            }
        }

        if (!empty($surname)) {
            $upperSurname = Str::upper($surname);

            if (Str::endsWith($upperSurname, ['ОВА', 'ЕВА', 'ИНА', 'АЯ'])) {
                return Gender::FEMALE;
            }

            if (Str::endsWith($upperSurname, ['ОВ', 'ЕВ', 'ИН', 'ЫЙ', 'ИЙ'])) {
                return Gender::MALE;
            }
        }

        return Gender::MALE;
    }
}
