<?php


namespace Matucana\WeatherBot\Handlers;


class FileHandler implements Handler
{
    private string $path;

    public function __construct(string $path = 'default')
    {
        if ($path === 'default') {
            $this->path = __DIR__.'/../../'.date('Ymd_His').".txt";
        }

    }
    public function handle(string $message)
    {
        return file_put_contents($this->path, $message);
    }
}