<?php


namespace Matucana\WeatherBot\Handlers;


interface Handler
{
    public function handle(string $message);
}