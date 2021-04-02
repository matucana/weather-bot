<?php

declare(strict_types=1);

use Matucana\WeatherBot\App;
use Matucana\WeatherBot\Converter;
use Matucana\WeatherBot\Handlers\VkHandler;
use Matucana\WeatherBot\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Http\Factory\Guzzle\RequestFactory;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
use Cmfcmf\OpenWeatherMap;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions(
        [
            LoggerInterface::class => function (ContainerInterface $c) {
                $settings = $c->get(SettingsInterface::class);

                $loggerSettings = $settings->get('logger');
                $logger = new Logger($loggerSettings['name']);

                $processor = new UidProcessor();
                $logger->pushProcessor($processor);

                $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
                $logger->pushHandler($handler);

                return $logger;
            },
        ],
        [
            RequestFactory::class => function () {
                return new RequestFactory();
            }
        ],
        [
            GuzzleAdapter::class => function (ContainerInterface $c) {
                $settings = $c->get(SettingsInterface::class);
                $guzzle_config = $settings->get('guzzle_config');
                return GuzzleAdapter::createWithConfig($guzzle_config);
            }
        ],
        [
            OpenWeatherMap::class => function (ContainerInterface $c) {
                $settings = $c->get(SettingsInterface::class);
                $open_weather_api_key = $settings->get('open_weather_api_key');
                return new OpenWeatherMap(
                    $open_weather_api_key,
                    $c->get(GuzzleAdapter::class),
                    $c->get(RequestFactory::class)
                );
            }
        ],
        [
            Converter::class => function () {
                return new Converter();
            }

        ],
        [
            App::class => function (ContainerInterface $c) {
                $settings = $c->get(SettingsInterface::class);
                $location = ['lat' => $settings->get('lat'), 'lon' => $settings->get('long')];
                $units = $settings->get('units');
                $lang = $settings->get('lang');
                return new App($c->get(Converter::class), $c->get(OpenWeatherMap::class), $location, $units, $lang);
            }
        ],
        [
            VkHandler::class => function (ContainerInterface $c) {
                $settings = $c->get(SettingsInterface::class);
                $lat = $settings->get('lat');
                $long = $settings->get('long');
                $vk_api_key = $settings->get('vk_api_key');
                $vk_peer_id = $settings->get('vk_peer_id');
                return new VkHandler($vk_api_key, (int) $vk_peer_id, (float) $lat, (float) $long);
            }
        ]
    );
};