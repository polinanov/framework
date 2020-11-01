<?php

declare(strict_types = 1);

namespace Service\Discount;

class PromoCode implements IDiscount
{
    /**
     * @var string
     */
    private string $promoCode;

    /**
     * @param string $promoCode
     */
    public function __construct(string $promoCode)
    {
        $this->promoCode = $promoCode;
    }

    /**
     * @inheritdoc
     */
    public function getDiscount(): float
    {
        // Получаем по промокоду размер скидки на заказ в процентах
        // $discount = $this->find($this->promoCode)->discount();
        // Запрос в систему хранения промокодов для пометки кода как использованный
        // $this->find($this->promoCode)->deactivate();

        return 5.50;
    }
}
