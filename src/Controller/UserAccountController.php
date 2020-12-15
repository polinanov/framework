<?php

declare(strict_types = 1);

namespace Controller;

use Exception;
use Framework\Render;
use Service\User\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAccountController
{
    use Render;

    /**
     * Личный кабинет
     *
     * @param Request $request
     * @return Response
     */
    public function userAccount(Request $request): Response
    {
        $user = new Security($request->getSession());
        $param = $user->getLastOrderByUser();
        return $this->render('user/user_account.html.php', ['user' => $user->getUser(), 'lastOrderAmount' => $param['lastOrderAmount']]);
    }


}
