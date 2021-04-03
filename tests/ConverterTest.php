<?php

namespace Matucana\WeatherBot\Test;

use DateTime;
use Matucana\WeatherBot\Converter;
use PHPUnit\Framework\TestCase;

class ConverterTest extends TestCase
{
    public function testDateTimeFormat()
    {
        $converter = new Converter();
        $dateTime = new DateTime('03.04.2021', new \DateTimeZone('Europe/Moscow'));
        $dateTimeString = $converter->dateTimeFormat($dateTime, 'Europe/Moscow', 'd.m.Y');
        $this->assertEquals('03.04.2021', $dateTimeString);
    }

    public function testPressureConversion()
    {
        $converter = new Converter();
        $pressure = $converter->pressureConversion(133);
        $this->assertEquals(99, $pressure);

    }

    public function testWindConversion()
    {
        $converter = new Converter();
        $wind = $converter->windConversion(1);
        $this->assertEquals('Северный', $wind);
    }

}