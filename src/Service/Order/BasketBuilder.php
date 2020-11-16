<?php

declare(strict_types = 1);

namespace Service\Order;

use Model;
use Service\Billing\IBilling;
use Service\Communication\ICommunication;
use Service\Discount\IDiscount;
use Service\User\ISecurity;


class BasketBuilder implements Builder
{
    private IDiscount $discount;
    private IBilling $billing;
    private ISecurity $security;
    private ICommunication $communication;

    public function setIDiscount(IDiscount $discount): Builder {
        $this->discount = $discount;
        return $this;
    }
    public function getIDiscount(): IDiscount {
        return $this->discount;
    }
    public function setIBilling(IBilling $billing): Builder {
        $this->billing = $billing;
        return $this;
    }
    public function getIBilling(): IBilling {
        return $this->billing;
    }
    public function setISecurity(ISecurity $security): Builder {
        $this->security = $security;
        return $this;
    }
    public function getISecurity(): ISecurity {
        return $this->security;
    }
    public function setICommunication(ICommunication $communication): Builder {
        $this->communication = $communication;
        return $this;
    }
    public function getICommunication(): ICommunication {
        return $this->communication;
    }
}
