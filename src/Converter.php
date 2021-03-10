<?php


namespace Matucana\WeatherBot;


use DateTime;
use DateTimeZone;

class Converter
{
    public function dateTimeFormat(DateTime $DateTime, string $timeZone = 'Europe/Moscow', string $format = 'd.m.Y H:i:s'): string
    {
        return $DateTime->setTimezone(new DateTimeZone($timeZone))->format($format);
    }

    public function pressureConversion(int $pressure): int
    {
        return $pressure / 1.333;
    }

    public function windConversion(int $degree): string
    {
        $direction = $degree / 22.5 + .5;
        $cardinal_array = ["Северный", "Северно-Северо-Восточный", "Северо-Восточный", "Восточно-Северо-Восточный", "Восточный", "Восточно-Юго-Восточный", "Юго-Восточный", "SSE", "Южный", "Южно-Юго-Восточный", "Юго-Западный", "Западо-Юго-Западный", "Западный", "Западно-Северно-Западный", "Северо-Западный", "Северно-Северо-Западный"];
        return $cardinal_array[ ( $direction % 16 )];
    }
}
