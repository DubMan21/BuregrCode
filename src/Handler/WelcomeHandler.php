<?php

// src/Handler/WelcomeHandler.php
namespace App\Handler;

use Ratchet\ConnectionInterface;
use RollandRock\WebsocketBundle\Client\ClientStack;
use RollandRock\WebsocketBundle\Handler\HandlerInterface;

class WelcomeHandler implements HandlerInterface
{
    public static function getName(): string
    {
        return 'welcome';
    }

    public function handle(ClientStack $clientStack, ConnectionInterface $from, array $data)
    {
        // Handle the "welcome" message sent by $from, containing $data.
        // You also have access to the whole clients stack
    }
}