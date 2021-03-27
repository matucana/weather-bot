
<img src="https://img.shields.io/packagist/php-v/matucana/weather-bot/v1.1.2?label=PHP" alt="php version">
<img src="https://img.shields.io/packagist/l/matucana/weather-bot" alt="License">

# Weather bot
Простой проект для отправки погоды в беседу Вконтакте.


## Какую задачу решает данный проект?
Есть беседа Вконтакте, в которой общаются работники небольшого тепличного хозяйства.
Для планирования деятельности в течение дня часто требуется узнавать прогноз погоды.
Данный проект, получает прогноз погоды, используя [API OpenWeatherMap](https://openweathermap.org/api), форматирует его, и отправляет его в беседу Вконтакте.
Отправка по расписанию производится с помощью cron.

## Установка и использование
Weather bot доступен в [Packagist](https://packagist.org/packages/matucana/weather-bot) (с использованием семантического управления версиями), и установка через Composer является рекомендуемым способом установки Weather bot.

Для установки, выполните команду:
```sh
composer create-project matucana/weather-bot
```

Перейдите в директорию `/config/` и переименуйте файл `example.env` в `.env`

Пропишите в файле.env необходимые настройки:

1. Ключ API **openweathermap.org**
2. Географическая широта местоположения, для которого необходимо получать погоду.
3. Географическая долгота местоположения, для которого необходимо получать погоду.
4. Ключ API **vk.com**
5. ID беседы, в которую будут отсылаться сообщения


Настройте запуск файла `index.php` в cron, с нужной для вас периодичностью.
## Обработчики
В текущей версии проекта есть два готовых обработчика:
`Matucana\WeatherBot\Handlers\VkHandler` - для отправки в беседу Вконтакте.
`Matucana\WeatherBot\Handlers\FileHandler` - для сохранения прогноза в файл.

## Создание обработчиков

Вы можете создать свой собственный обработчик, например для отправки в другой мессенджер, или для сохранения в файл.

Для этого вам необходимо, создать класс, который имплементирует интерфейс `Matucana\WeatherBot\Handlers\Handler`

```php
<?php

use Matucana\WeatherBot\Handlers\Handler;

class MainHandler implements Handler
{
    public function handle(string $message)
    {
        // TODO: Implement handle() method.
    }
}
```
Обработчик можно подключить с помощью метода  
`$app->addHandler(Handler $mainHandler)`
```php
$mainHandler = new MainHandler();
$app->addHandler(Handler $mainHandler);
$app->run();
```
Если вы хотите подключить несколько обработчиков, используйте метод 
`$app->addHandlers(array $handlers)`
```php
$mainHandler = new MainHandler();
$vkHandler = new VkHandler($_ENV['VK_API_KEY'], $_ENV['VK_PEER_ID']);
$app->addHandlers([$mainHandler, $vkHandler]);
$app->run();
```
## Полезные ссылки: 
1. [Документация Open Weather API](https://openweathermap.org/api) 
2. [Документация Vk.com API](https://vk.com/dev/first_guide)
3. [Репозиторий пакета `cmfcmf/openweathermap-php-api`](cmfcmf/openweathermap-php-api)
4. [Настройка Cron](https://losst.ru/nastrojka-cron)

## Лицензия
MIT License

Copyright (c) 2021 Matucana

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

## Контакты:
1. [Вконтакте](https://vk.com/winogradow.wiktor)
2. [Telegram](https://t.me/victor_dialogbox)
