<?php


namespace Matucana\WeatherBot\Handlers;


use VK\Client\VKApiClient;

class VkHandler implements Handler
{
    private VKApiClient $vk;

    private string $apiKey;

    private int $peerId;

    public function __construct(string $apiKey, int $peerId)
    {
        $this->vk = new VKApiClient();
        $this->apiKey = $apiKey;
        $this->peerId = $peerId;    }

    public function handle(string $message)
    {
        return $this->vk->messages()->send(
            $this->apiKey,
            [
                'peer_id' => $this->peerId,
                'random_id' => $this->random(),
                'message' => $message,
                'lat' => $_ENV['LAT'], 'long' => $_ENV['LONG']
            ]);
    }

    private function random(): int
    {
        return mt_rand(0,mt_getrandmax());
    }
}