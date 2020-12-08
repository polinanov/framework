<?php

declare(strict_types = 1);

namespace Service\Product;

use Model;

class Context
{
    private Strategy $strategy;

    public function setStrategy(Strategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function executeStrategy()
    {
        return $this->strategy->execute();
    }
}
