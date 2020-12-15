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

class ProductSNController
{
    use Render;

    /**
     * Публикация сообщения в соц.сети
     *
     * @param Request $request
     * @param string $network
     *
     * @return Response
     * @throws Exception
     */
    public function postAction(Request $request, string $network): Response
    {
        $courseName = $request->query->get('course', '');
        (new SocialNetwork())->create($network, $courseName);

        return $this->redirect('product_info', ['id' => $request->query->get('page_num', 1)]);
    }

    /**
     * Публикация сообщения в соц.сети
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function publish(Request $request): Response
    {
        $network= $request->query->get('network', '');
        $courseName = $request->query->get('course', '');

        return $this->render('product/product_into_social_network.html.php', ['network' => $network, 'course'=>$courseName]);
    }

}
