<?php

declare(strict_types = 1);

namespace Controller;

use Exception;
use Framework\Render;
use Service\Order\Basket;
use Service\User\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderCheckoutController
{
    use Render;

    /**
     * Оформление заказа
     *
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function checkoutAction(Request $request): Response
    {
        $isLogged = (new Security($request->getSession()))->isLogged();
        if (!$isLogged) {
            return $this->redirect('user_authentication');
        }

        $param = (new Basket($request->getSession()))->order();

        (new Security($request->getSession()))->setLastOrder($param['totalPrice']);
        return $this->render('order/checkout.html.php', ['discount' => $param['discount'], 'totalPrice' => $param['totalPrice']]);
    }
}
