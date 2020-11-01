<?php

declare(strict_types = 1);

namespace Controller;

use Exception;
use Framework\Render;
use Service\User\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController
{
    use Render;

    /**
     * Производим аутентификацию и авторизацию
     *
     * @param Request $request
     * @return Response
     */
    public function authenticationAction(Request $request): Response
    {
        if ($request->isMethod(Request::METHOD_POST)) {
            $user = new Security($request->getSession());

            $isAuthenticationSuccess = $user->authentication(
                $request->request->get('login'),
                $request->request->get('password')
            );

            if ($isAuthenticationSuccess) {
                return $this->render('user/authentication_success.html.php', ['user' => $user->getUser()]);
            } else {
                $error = 'Неправильный логин и/или пароль';
            }
        }

        return $this->render('user/authentication.html.php', ['error' => $error ?? '']);
    }

    /**
     * Выходим из системы
     *
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function logoutAction(Request $request): Response
    {
        (new Security($request->getSession()))->logout();

        return $this->redirect('index');
    }

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
