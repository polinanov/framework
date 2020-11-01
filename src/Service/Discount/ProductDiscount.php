<?php

declare(strict_types = 1);

namespace Service\Discount;

use Model;

class ProductDiscount implements IDiscount
{
    public const DISCOUNT_AMOUNT = 8;
    public const ID_DISCOUNT_PRODUCT = 8;

    /**
     * @var array
     */
    private array $productId;

    /**
     * @param array $productId
     */
    public function __construct(array $productId)
    {
            $this->productId = $productId;
    }

    /**
     * @inheritdoc
     */
    public function getDiscount(): float
    {
        $discount = 0;
        foreach ($this->productId as $item) {
            if ($item == self::ID_DISCOUNT_PRODUCT){
                $discount = self::DISCOUNT_AMOUNT;
                break;
            }
            else
                $discount = 0;
        }
        return $discount;
    }
}
