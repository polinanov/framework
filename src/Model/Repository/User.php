<?php

declare(strict_types = 1);

namespace Model\Repository;

use Model\Entity;

class User
{

    /**
     * Получаем пользователя по идентификатору
     *
     * @param int $id
     * @return Entity\User|null
     */
    public function getById(int $id): ?Entity\User
    {
        foreach ($this->getDataFromSource(['id' => $id]) as $user) {
            return $this->createUser($user);
        }

        return null;
    }

    /**
     * Получаем пользователя по логину
     *
     * @param string $login
     * @return Entity\User
     */
    public function getByLogin(string $login): ?Entity\User
    {
        foreach ($this->getDataFromSource(['login' => $login]) as $user) {
            if ($user['login'] === $login) {
                return $this->createUser($user);
            }
        }

        return null;
    }

    /**
     * Фабрика по созданию сущности пользователя
     *
     * @param array $user
     * @return Entity\User
     */
    private function createUser(array $user): Entity\User
    {
        $role = $user['role'];

        return new Entity\User(
            $user['id'],
            $user['name'],
            $user['birthDate'],
            $user['AmountLastOrder'],
            $user['login'],
            $user['password'],
            new Entity\Role($role['id'], $role['title'], $role['role'])
        );
    }

    /**
     * Отображение всех пользователей
     *
     * @param void
     * @return void
     */
    public function outputUsers(): void
    {
        echo '<br>';
        echo 'Все зарегистрированные пользователи:';
        echo '<table border="1">';
        echo '<tr><th align="right">Имя</th><th align="right">Дата рождения</th><th align="right">Логин</th><th align="right">Роль</th></tr>';
        foreach ($this->getDataFromSource([]) as $user) {
            echo '<tr><td align="right">';
            echo (string)$user['name'];
            echo '</td><td align="right">';
            echo (string)$user['birthDate'];
            echo '</td><td align="right">';
            echo (string)$user['login'];
            echo '</td><td align="right">';
            echo (string)$user['role']['role'];
            echo '</td></tr>';
        }
        echo '</table>';
    }

    /**
     * Отображение данные пользователя
     *
     * @param int
     * @return void
     */
    public function outputDataUser(int $id): void
    {
        echo '<br>';
        echo 'Вы находитесь в личном кабинете пользователя';
        echo '<br><br>';
        echo 'Ваши данные:';
        echo '<table border="1">';
        echo '<tr><th align="right">Имя</th><th align="right">Дата рождения</th><th align="right">Сумма последнего заказа</th><th align="right">Логин</th></tr>';
        foreach ($this->getDataFromSource(['id' => $id]) as $user) {
            if ($user['id'] == $id) {
                echo '<tr><td align="right">';
                echo (string)$user['name'];
                echo '</td><td align="right">';
                echo (string)$user['birthDate'];
                echo '</td><td align="right">';
                echo (string)$user['AmountLastOrder'];
                echo '</td><td align="right">';
                echo (string)$user['login'];
                echo '</td></tr>';
            }
        }
        echo '</table>';
    }


    /**
     * Проверяем является ли пользователь администратором
     *
     * @param int $id
     *
     * @return bool
     */
    public function isAdministrator(int $id): bool
    {
        foreach ($this->getDataFromSource([]) as $user) {
            if ($user['id'] === $id) {
                if ($user['role']['role'] == 'admin') {
                    return true;
                }
                else {
                    return false;
                }
            }else
                return false;
        }
        return false;
    }

    /**
     * Получаем пользователей из источника данных
     *
     * @param array $search
     *
     * @return array
     */
    private function getDataFromSource(array $search = [])
    {
        $admin = ['id' => 1, 'title' => 'Super Admin', 'role' => 'admin'];
        $user = ['id' => 1, 'title' => 'Main user', 'role' => 'user'];
        $test = ['id' => 1, 'title' => 'For test needed', 'role' => 'test'];

        $dataSource = [
            [
                'id' => 1,
                'name' => 'Super Admin',
                'birthDate' => '26.10.1991',
                'AmountLastOrder' => 0,
                'login' => 'root',
                'password' => '$2y$10$GnZbayyccTIDIT5nceez7u7z1u6K.znlEf9Jb19CLGK0NGbaorw8W', // 1234
                'role' => $admin
            ],
            [
                'id' => 2,
                'name' => 'Doe John',
                'birthDate' => '05.10.1989',
                'AmountLastOrder' => 0,
                'login' => 'doejohn',
                'password' => '$2y$10$j4DX.lEvkVLVt6PoAXr6VuomG3YfnssrW0GA8808Dy5ydwND/n8DW', // qwerty
                'role' => $user
            ],
            [
                'id' => 3,
                'name' => 'Ivanov Ivan Ivanovich',
                'birthDate' => '11.01.2001',
                'AmountLastOrder' => 0,
                'login' => 'i**3',
                'password' => '$2y$10$TcQdU.qWG0s7XGeIqnhquOH/v3r2KKbes8bLIL6NFWpqfFn.cwWha', // PaSsWoRd
                'role' => $user
            ],
            [
                'id' => 4,
                'name' => 'Test Testov Testovich',
                'birthDate' => '28.02.2005',
                'AmountLastOrder' => 0,
                'login' => 'testok',
                'password' => '$2y$10$vQvuFc6vQQyon0IawbmUN.3cPBXmuaZYsVww5csFRLvLCLPTiYwMa', // testss
                'role' => $test
            ],
            [
                'id' => 5,
                'name' => 'Polina Novikova',
                'birthDate' => '06.06.1998',
                'AmountLastOrder' => 0,
                'login' => 'student',
                'password' => '$2y$10$GnZbayyccTIDIT5nceez7u7z1u6K.znlEf9Jb19CLGK0NGbaorw8W', // 1234
                'role' => $user
            ],
        ];

        if (!count($search)) {
            return $dataSource;
        }

        $productFilter = function (array $dataSource) use ($search): bool {
            return (bool) array_intersect_assoc($dataSource, $search);
        };

        return array_filter($dataSource, $productFilter);
    }
}
