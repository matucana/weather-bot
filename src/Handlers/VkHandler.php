<?php

declare(strict_types=1);

namespace Matucana\WeatherBot\Handlers;


use VK\Client\VKApiClient;

class VkHandler implements Handler
{
    private VKApiClient $vk;

    private string $apiKey;

    private int $peerId;

    private float $lat;

    private float $long;

    public function __construct(string $apiKey, int $peerId, float $lat, float $long)
    {
        $this->vk = new VKApiClient();
        $this->apiKey = $apiKey;
        $this->peerId = $peerId;
        $this->lat = $lat;
        $this->long = $long;
    }

    public function handle(string $message)
    {
        return $this->vk->messages()->send(
            $this->apiKey,
            [
                'peer_id' => $this->peerId,
                'random_id' => $this->random(),
                'message' => $message,
                'lat' => $this->lat,
                'long' => $this->long
            ]
        );
    }

    private function random(): int
    {
        return mt_rand(0, mt_getrandmax());
    }
}