<?php

declare(strict_types = 1);

namespace Service\Order;

use Model;
use Service\Billing\Exception\BillingException;
use Service\Billing\IBilling;
use Service\Communication\Exception\CommunicationException;
use Service\Communication\ICommunication;
use Service\Discount\IDiscount;
use Service\User\ISecurity;

/**
 * Проведение всех этапов заказа
 *
 * @param IDiscount $discount
 * @param IBilling $billing
 * @param ISecurity $security
 * @param ICommunication $communication
 * @return array discount
 * @throws BillingException
 * @throws CommunicationException
 */
class CheckoutProcess{
    private BasketBuilder $builder;

    public function __construct(BasketBuilder $builder)
    {
        $this->builder = $builder;
    }

    function checkoutProcess(array $products){
        $totalPrice = 0;
        foreach ($products as $product) {
            $totalPrice += $product->getPrice();
        }

        $discount_ = $this->builder->getIDiscount()->getDiscount();
        $totalPrice = $totalPrice - $totalPrice / 100 * $discount_;

        $billing_ = $this->builder->getIBilling();
        try {
            $billing_->pay($totalPrice);
        } catch (BillingException $e) {
        }

        $user = $this->builder->getISecurity()->getUser();
        try {
            $this->builder->getICommunication()->process($user, 'checkout_template');
        } catch (CommunicationException $e) {
        }

        return ['discount' => $discount_, 'totalPrice'=> $totalPrice, 'userId'=> $user->getId()];
    }
}