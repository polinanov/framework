<?php

declare(strict_types = 1);

namespace Service\Order;

use Model;
use Service\Billing\Card;
use Service\Billing\Exception\BillingException;
use Service\Billing\IBilling;
use Service\Communication\Email;
use Service\Communication\Exception\CommunicationException;
use Service\Communication\ICommunication;
use Service\Discount\IDiscount;
use Service\Discount\OrderDiscount;
use Service\Discount\ProductDiscount;
use Service\Discount\UserDiscount;
use Service\User\ISecurity;
use Service\User\Security;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Basket
{
    public const DISCOUNT_AMOUNT_ORDER = 10;
    public const DISCOUNT_AMOUNT_PRODUCT = 8;
    public const DISCOUNT_AMOUNT_USER = 5;

    /**
     * Сессионный ключ списка всех продуктов корзины
     */
    private const BASKET_DATA_KEY = 'basket';

    /**
     * @var SessionInterface
     */
    private SessionInterface $session;

    /**
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * Добавляем товар в заказ
     *
     * @param int $product
     *
     * @return void
     */
    public function addProduct(int $product): void
    {
        $basket = $this->session->get(static::BASKET_DATA_KEY, []);
        if (!in_array($product, $basket, true)) {
            $basket[] = $product;
            $this->session->set(static::BASKET_DATA_KEY, $basket);
        }
    }

    /**
     * Проверяем, лежит ли продукт в корзине или нет
     *
     * @param int $productId
     *
     * @return bool
     */
    public function isProductInBasket(int $productId): bool
    {
        return in_array($productId, $this->getProductIds(), true);
    }

    /**
     * Получаем информацию по всем продуктам в корзине
     *
     * @return Model\Entity\Product[]
     */
    public function getProductsInfo(): array
    {
        $productIds = $this->getProductIds();
        return $this->getProductRepository()->search($productIds);
    }

    /**
     * Оформление заказа
     *
     * @return array
     * @throws BillingException
     * @throws CommunicationException
     */
    public function checkout(): array
    {
        // Здесь должна быть некоторая логика выбора способа платежа
        $billing = new Card();



        // Здесь должна быть некоторая логика получения способа уведомления пользователя о покупке
        $communication = new Email();

        $security = new Security($this->session);

        // Здесь должна быть некоторая логика получения информации о скидки пользователя

        #Скидка дня рождения
        $discountUserBirth = new UserDiscount($security->getUser());

        #Скидка если заказ превышает N количество рублей
        $totalPrice = 0;
        foreach ($this->getProductsInfo() as $product) {
            $totalPrice += $product->getPrice();
        }
        $discountBasket = new OrderDiscount($totalPrice);

        #Скидка по определенному продукту
        $discountProduct = new ProductDiscount($this->getProductIds());

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

        return $this->checkoutProcess($discount, $billing, $security, $communication);
    }

    /**
     * Проведение всех этапов заказа
     *
     * @param IDiscount $discount ,
     * @param IBilling $billing ,
     * @param ISecurity $security ,
     * @param ICommunication $communication
     * @return array discount
     * @throws BillingException
     * @throws CommunicationException
     */
    public function checkoutProcess(
        IDiscount $discount,
        IBilling $billing,
        ISecurity $security,
        ICommunication $communication
    ): array
    {
        $totalPrice = 0;
        foreach ($this->getProductsInfo() as $product) {
            $totalPrice += $product->getPrice();
        }

        $discount_ = $discount->getDiscount();
        $totalPrice = $totalPrice - $totalPrice / 100 * $discount_;

        $billing->pay($totalPrice);

        $user = $security->getUser();
        $communication->process($user, 'checkout_template');

        return ['discount' => $discount_, 'totalPrice'=> $totalPrice, 'userId'=> $user->getId()];
    }

    /**
     * Фабричный метод для репозитория Product
     *
     * @return Model\Repository\Product
     */
    protected function getProductRepository(): Model\Repository\Product
    {
        return new Model\Repository\Product();
    }

    /**
     * Получаем список id товаров корзины
     *
     * @return array
     */
    private function getProductIds(): array
    {
        return $this->session->get(static::BASKET_DATA_KEY, []);
    }

}
