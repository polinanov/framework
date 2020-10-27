<?php

declare(strict_types = 1);

namespace Service\Discount;

use Model;

class UserDiscount implements IDiscount
{
    public const DISCOUNT_AMOUNT = 5;

    /**
     * @var string
     */
    private $user;

    /**
     * @param Model\Entity\User $user
     */
    public function __construct(Model\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * @inheritdoc
     */
    public function getDiscount(): float
    {
        $birthDate = $this->user->getBirthDate();
        return $this->getDiscountBirthday($birthDate);
    }

    public function getDiscountBirthday($birthDate): float
    {
        #$birthDate = '20.11.2010';
        $now = date('Y') - date('Y', strtotime($birthDate));

        $birthDateUnix = date('d.m.Y', strtotime('+'.$now.' year', strtotime($birthDate)));
        $dayBeforeDiscount = date('d.m.Y', strtotime('today 00:00:00 +5 days'));
        $dayAfterDiscount = date('d.m.Y', strtotime('today 00:00:00 -5 days'));

        if (($dayBeforeDiscount >= $birthDateUnix) and ($birthDateUnix >= $dayAfterDiscount)) {
            $discount = self::DISCOUNT_AMOUNT;
        } else {
            $discount = 0;
        }
        return $discount;
    }

}