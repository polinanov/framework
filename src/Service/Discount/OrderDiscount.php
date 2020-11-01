<?php

declare(strict_types = 1);

namespace Service\Discount;

use Model;

class OrderDiscount implements IDiscount
{
    public const TOTAL_PRICE = 40000;
    public const DISCOUNT_AMOUNT = 10;
    /**
     * @var float
     */
    private float $orderPrice;

    /**
     * @param float $orderPrice
     */
    public function __construct(float $orderPrice)
    {
        $this->orderPrice = $orderPrice;
    }

    /**
     * @inheritdoc
     */
    public function getDiscount(): float
    {
        if ($this->orderPrice >= self::TOTAL_PRICE){
            $discount = self::DISCOUNT_AMOUNT;
        }
        else
            $discount = 0;

        return $discount;
    }
}
