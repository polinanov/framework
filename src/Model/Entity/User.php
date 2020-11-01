<?php

declare(strict_types = 1);

namespace Model\Entity;

class User
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var string
     */
    private string $birthDate;

    /**
     * @var float
     */
    private float $AmountLastOrder;

    /**
     * @var string
     */
    private string $login;

    /**
     * @var string
     */
    private string $passwordHash;

    /**
     * @var Role
     */
    private Role $role;

    /**
     * @param int $id
     * @param string $name
     * @param string $birthDate
     * @param float $AmountLastOrder
     * @param string $login
     * @param string $password
     * @param Role $role
     */
    public function __construct(int $id, string $name, string $birthDate, float $AmountLastOrder, string $login, string $password, Role $role)
    {
        $this->id = $id;
        $this->name = $name;
        $this->birthDate = $birthDate;
        $this->AmountLastOrder = $AmountLastOrder;
        $this->login = $login;
        $this->passwordHash = $password;
        $this->role = $role;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getBirthDate(): string
    {
        return $this->birthDate;
    }

    /**
     * @return float
     */
    public function getAmountLastOrder(): float
    {
        return $this->AmountLastOrder;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    /**
     * @return Role
     */
    public function getRole(): Role
    {
        return $this->role;
    }

    public function setAmountLastOrder(float $lastOrder): float
    {
        $this->AmountLastOrder = $lastOrder;
        return $this->AmountLastOrder;
    }
}