<?php

declare(strict_types = 1);

namespace Service\SocialNetwork;

class VKAdapter implements ISocialNetwork
{
    private VK $adapt;
    public function __construct(VK $vk)
    {
        $this->adapt = $vk;
    }

    public function send(string $message): void
    {
        // реализация метода send
    }
}
