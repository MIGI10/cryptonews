<?php

declare(strict_types=1);

namespace Salle\Ca2CryptoNews\Model;

use DateTime;

final class User
{
    private int $id;
    private string $email;
    private string $password;
    private int $numBitcoins;
    private DateTime $createdAt;
    private DateTime $updatedAt;

    public function __construct(
        string $email,
        string $password,
        int $numBitcoins,
        DateTime $createdAt,
        DateTime $updatedAt
    ) {
        $this->email = $email;
        $this->password = $password;
        $this->numBitcoins = $numBitcoins;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getNumBitcoins(): int
    {
        return $this->numBitcoins;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }
}