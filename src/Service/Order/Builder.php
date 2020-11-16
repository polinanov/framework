<?php

declare(strict_types = 1);

namespace Service\Order;

use Model;
use Service\Billing\IBilling;
use Service\Communication\ICommunication;
use Service\Discount\IDiscount;
use Service\User\ISecurity;


interface Builder
{

    public function setIDiscount(IDiscount $discount): Builder;
    public function getIDiscount(): IDiscount;

    public function setIBilling(IBilling $billing): Builder;
    public function getIBilling(): IBilling;

    public function setISecurity(ISecurity $security): Builder;
    public function getISecurity(): ISecurity;

    public function setICommunication(ICommunication $communication): Builder;
    public function getICommunication(): ICommunication;

}
