<?php

require_once __DIR__ . '/vendor/autoload.php';

use Matucana\WeatherBot\App;
use Matucana\WeatherBot\Handlers\VkHandler;
use Symfony\Component\Dotenv\Dotenv;
use DI\ContainerBuilder;

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/.env');

$containerBuilder = new ContainerBuilder();

$settings = require __DIR__ . '/app/settings.php';
$settings($containerBuilder);

$dependencies = require __DIR__ . '/app/dependencies.php';
$dependencies($containerBuilder);

$container = $containerBuilder->build();


$app = $container->get(App::class);
$app->addHandler($container->get(VkHandler::class));
$app->run();


