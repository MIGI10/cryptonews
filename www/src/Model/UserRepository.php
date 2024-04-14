<?php

declare(strict_types=1);

namespace Salle\Ca2CryptoNews\Model;

interface UserRepository
{
    public function fetch(string $email, ?string $password): ?User;
    public function save(User $user): void;
}