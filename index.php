<?php
require_once __DIR__.'/vendor/autoload.php';

use Dotenv\Dotenv;
use Matucana\WeatherBot\App;

Dotenv::createImmutable(__DIR__, '/config/.env')->load();


$app = new App(['lat' => $_ENV['LAT'], 'lon' => $_ENV['LONG']]);
$message =  $app->getMessageCurrentWeather();
$vk = new \VK\Client\VKApiClient();
$vk->messages()->send($_ENV['VK_API_KEY'],['peer_id' => $_ENV['VK_PEER_ID'], 'random_id' => mt_rand(0,99999999999999), 'message' => $message,'lat' => $_ENV['LAT'], 'long' => $_ENV['LONG'] ]);



