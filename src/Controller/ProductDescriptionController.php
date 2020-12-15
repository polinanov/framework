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

class ProductDescriptionController
{
    use Render;

    public function listDescription(Request $request): Response
    {
        $productList = (new Product())->getAll($request->query->get('sort', ''));

        return $this->render('product/description.html.php', ['productList' => $productList]);
    }


}
