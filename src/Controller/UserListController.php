<?php

declare(strict_types = 1);

namespace Controller;

use Exception;
use Framework\Render;
use Service\User\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserListController
{
    use Render;

    /**
     * Выводим список пользователей
     *
     * @param Request $request
     * @return Response
     */
    public function usersList(Request $request): Response
    {
        $user = new Security($request->getSession());
        return $this->render('user/users_list.html.php', ['user' => $user->getUser()]);
    }

}
