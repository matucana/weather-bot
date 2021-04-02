<?php

declare(strict_types=1);

use Matucana\WeatherBot\Settings\Settings;
use Matucana\WeatherBot\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions(
        [
            SettingsInterface::class => function () {
                return new Settings(
                    [
                        'displayErrorDetails' => false,
                        'logError' => false,
                        'logErrorDetails' => false,
                        'logger' => [
                            'name' => 'weather-bot',
                            'path' => __DIR__ . '/../logs/app.log',
                            'level' => Logger::DEBUG,
                        ],
                        'open_weather_api_key' => $_ENV['open_weather_api_key'],
                        'lat' => $_ENV['lat'],
                        'long' => $_ENV['long'],
                        'vk_api_key' => $_ENV['vk_api_key'],
                        'vk_peer_id' => $_ENV['vk_peer_id'],
                        'units' => 'metric',
                        'lang' => 'RU',
                        'guzzle_config' => []
                    ]
                );
            }
        ]
    );
};