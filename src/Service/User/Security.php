<?php

declare(strict_types = 1);

namespace Service\User;

use Model;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Security implements ISecurity
{
    private const SESSION_USER_IDENTITY = 'userId';
    private const SESSION_USER_LAST_ORDER = 0;

    /**
     * @var SessionInterface
     */
    private SessionInterface $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @inheritdoc
     */
    public function getUser(): ?Model\Entity\User
    {
        $userId = $this->session->get(self::SESSION_USER_IDENTITY);

        return $userId ? (new Model\Repository\User())->getById($userId) : null;
    }

    /**
     * @inheritdoc
     */
    public function isLogged(): bool
    {
        return $this->getUser() instanceof Model\Entity\User;
    }

    public function isAdmin(): bool
    {
        $userId = $this->session->get(self::SESSION_USER_IDENTITY);
        if ($userId == null)
            return false;
        return (new Model\Repository\User())->isAdministrator($userId);
    }

    /**
     * @inheritdoc
     */
    public function authentication(string $login, string $password): bool
    {
        $user = $this->getUserRepository()->getByLogin($login);

        if ($user === null) {
            return false;
        }

        if (!password_verify($password, $user->getPasswordHash())) {
            return false;
        }

        $this->session->set(self::SESSION_USER_IDENTITY, $user->getId());

        // Здесь могут выполняться другие действия связанные с аутентификацией пользователя

        return true;
    }

    /**
     * @inheritdoc
     */
    public function logout(): void
    {
        $this->session->set(self::SESSION_USER_IDENTITY, null);
        $this->session->set(self::SESSION_USER_LAST_ORDER, null);
        // Здесь могут выполняться другие действия связанные с разлогиниванием пользователя
    }

    public function setLastOrder(float $totalPrice): void
    {
        $this->session->set(self::SESSION_USER_LAST_ORDER, $totalPrice);

        // Здесь могут выполняться другие действия связанные с разлогиниванием пользователя
    }

    public function getLastOrderByUser(): array
    {
        $userId = $this->session->get(self::SESSION_USER_IDENTITY);
        $lastOrderAmount= $this->session->get(self::SESSION_USER_LAST_ORDER);
        return ['userId' => $userId, 'lastOrderAmount'=> $lastOrderAmount];
        // Здесь могут выполняться другие действия связанные с разлогиниванием пользователя
    }


    /**
     * Фабричный метод для репозитория User
     *
     * @return Model\Repository\User
     */
    protected function getUserRepository(): Model\Repository\User
    {
        return new Model\Repository\User();
    }
}
