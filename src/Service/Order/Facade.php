<?php

declare(strict_types = 1);

namespace Service\Order;

use Model;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Facade{
    private SessionInterface $session;
    private Basket $basket;

    public function __construct(Basket $basket, SessionInterface $session)
    {
        $this->session = $session;
        $this->basket = $basket;
    }

    public function order(){
        $chekout = new Chekout($this->basket, $this->session);
        return $chekout->checkout();
    }

}
