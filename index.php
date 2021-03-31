<?php

require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use Matucana\WeatherBot\App;
use Matucana\WeatherBot\Handlers\VkHandler;

Dotenv::createImmutable(__DIR__, '/config/.env')->load();


$app = new App(['lat' => $_ENV['LAT'], 'lon' => $_ENV['LONG']]);
$vkHandler = new VkHandler($_ENV['VK_API_KEY'], $_ENV['VK_PEER_ID']);
$app->addHandler($vkHandler);
$app->run();
