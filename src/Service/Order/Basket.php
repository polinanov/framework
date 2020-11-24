<?php

declare(strict_types = 1);

namespace Service\Order;

use Model;
use Service\Order\Facade;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Basket
{


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

    public function order(): array{
        $facade = new Facade($this, $this->session);
        return $facade->order();
    }

    /*
        /**
         * Оформление заказа
         *
         * @return array
         */
    /*  public function checkout(): array
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

          $builder = new BasketBuilder();
          $builder->setIDiscount($discount);
          $builder->setIBilling($billing);
          $builder->setISecurity($security);
          $builder->setICommunication($communication);

          $checkoutProcess = new CheckoutProcess($builder);
          return $checkoutProcess->checkoutProcess($this->getProductsInfo());
      }*/

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
    public function getProductIds(): array
    {
        return $this->session->get(static::BASKET_DATA_KEY, []);
    }

}
