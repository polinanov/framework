<?php

declare(strict_types = 1);

namespace Service\Order;

use Model;
use Service\Billing\Card;
use Service\Communication\Email;
use Service\Discount\OrderDiscount;
use Service\Discount\ProductDiscount;
use Service\Discount\UserDiscount;
use Service\User\Security;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Chekout{
    public const DISCOUNT_AMOUNT_ORDER = 10;
    public const DISCOUNT_AMOUNT_PRODUCT = 8;
    public const DISCOUNT_AMOUNT_USER = 5;

    private SessionInterface $session;
    private Basket $basket;

    public function __construct(Basket $basket, SessionInterface $session)
    {
        $this->session = $session;
        $this->basket = $basket;
    }

    public function checkout(): array
    {
        // Здесь должна быть некоторая логика выбора способа платежа
        $billing = new Card();

        // Здесь должна быть некоторая логика получения способа уведомления пользователя о покупке
        $communication = new Email();

        $security = new Security($this->session);

        #Скидка дня рождения
        $discountUserBirth = new UserDiscount($security->getUser());

        #Скидка если заказ превышает N количество рублей
        $totalPrice = 0;
        foreach ($this->basket->getProductsInfo() as $product) {
            $totalPrice += $product->getPrice();
        }
        $discountBasket = new OrderDiscount($totalPrice);

        #Скидка по определенному продукту
        $discountProduct = new ProductDiscount($this->basket->getProductIds());

        $discountArray = array($discountUserBirth->getDiscount(), $discountBasket->getDiscount(), $discountProduct->getDiscount());

        #Расчет максимальной скидки
        $discount = max($discountArray);
        if ($discount == self::DISCOUNT_AMOUNT_USER)
            $discount = $discountUserBirth;
        elseif ($discount == self::DISCOUNT_AMOUNT_PRODUCT)
            $discount = $discountProduct;
        elseif ($discount == self::DISCOUNT_AMOUNT_ORDER)
            $discount = $discountBasket;
        else
            $discount = $discountUserBirth;

        $builder = new BasketBuilder();
        $builder->setIDiscount($discount);
        $builder->setIBilling($billing);
        $builder->setISecurity($security);
        $builder->setICommunication($communication);

        $checkoutProcess = new CheckoutProcess($builder);
        return $checkoutProcess->checkoutProcess($this->basket->getProductsInfo());
    }

}
