<?php


namespace Matucana\WeatherBot;

use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\Exception as OWMException;
use Matucana\WeatherBot\Handlers\Handler;

class App
{


    protected OpenWeatherMap $owm;

    private array $handlers;

    protected Converter $converter;

    private array $location;

    private string $units;

    private string $lang;

    public function __construct(Converter $converter, OpenWeatherMap $owm, array $location, string $units = 'metric', string $lang = 'ru')
    {
        $this->owm = $owm;
        $this->converter = $converter;
        $this->location = $location;
        $this->units = $units;
        $this->lang = $lang;
        $this->handlers = [];
    }

    public function getWeather(): OpenWeatherMap\CurrentWeather
    {
        try {
            return $this->owm->getWeather($this->location, $this->units, $this->lang);
        } catch (OWMException $e) {
            throw new AppException($e);
        }
    }

    public function getMessageCurrentWeather(): string
    {
        $weather = $this->getWeather();
        $message['last_update'] = $this->converter->dateTimeFormat($weather->lastUpdate);
        $message['temperature'] = $weather->temperature;
        $message['pressure'] = $this->converter->pressureConversion($weather->pressure->getValue());
        $message['humidity'] = $weather->humidity;
        $message['windSpeed'] = $weather->wind->speed->getValue();
        $message['windDirection'] = $this->converter->windConversion($weather->wind->direction->getValue());
        $message['clouds'] = $weather->clouds->getDescription();
        $message['precipitation'] = $weather->precipitation;
        $message['sunrise'] = $this->converter->dateTimeFormat($weather->sun->rise, 'Europe/Moscow', 'H:i:s');
        $message['sunset'] = $this->converter->dateTimeFormat($weather->sun->set, 'Europe/Moscow', 'H:i:s');
        return $this->formatMessage($message);
    }

    public function addHandler(Handler $handler)
    {
        $this->handlers[] = $handler;
    }

    public function addHandlers(array $handlers)
    {
        $this->handlers = array_merge($this->handlers, $handlers);
    }

    public function run()
    {
        if (count($this->handlers) !== 0) {
            foreach ($this->handlers as $handler) {
                $handler->handle($this->getMessageCurrentWeather());
            }
        }
    }

    private function formatMessage(array $message): string
    {
        return "\xe2\x9a\xa0 Погода на " . $message['last_update'] . "\n\xf0\x9f\x8c\xa1 Температура: " . $message['temperature'] . "\n\xf0\x9f\xa7\xaf Давление: " . $message['pressure'] . " мм. рт. ст.\n\xf0\x9f\x92\xa7 Влажность: " . $message['humidity'] . "\n\xf0\x9f\x8c\xac Скорость ветра: " . $message['windSpeed'] . " м/сек\n\xf0\x9f\xa7\xad Направление: " . $message['windDirection'] . "\n\xe2\x98\x81 Облачность: " . $message['clouds'] . "\n\xe2\x98\x94 Осадки: " . $message['precipitation'] . "%" . "\n\xf0\x9f\x8c\x85 Восход: " . $message['sunrise'] . "\n\xf0\x9f\x8c\x87 Закат: " . $message['sunset'];
    }

}