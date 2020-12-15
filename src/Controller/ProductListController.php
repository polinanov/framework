<?php

declare(strict_types = 1);

namespace Controller;

use Exception;
use Framework\Render;
use Service\Order\Basket;
use Service\Product\Product;
use Service\SocialNetwork\SocialNetwork;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductListController
{
    use Render;

    /**
     * Список всех продуктов
     *
     * @param Request $request
     *
     * @return Response
     */
    public function listAction(Request $request): Response
    {
        $productList = (new Product())->getAll($request->query->get('sort', ''));

        return $this->render('product/list.html.php', ['productList' => $productList]);
    }

}
