<?php

declare(strict_types=1);

namespace Salle\Ca2CryptoNews\Model\Repository;

use PDO;
use Salle\Ca2CryptoNews\Model\User;
use Salle\Ca2CryptoNews\Model\UserRepository;

final class MysqlUserRepository implements UserRepository
{
    private const DATE_FORMAT = 'Y-m-d H:i:s';

    private PDO $database;

    public function __construct(PDO $database)
    {
        $this->database = $database;
    }

    public function fetch(string $email, ?string $password): ?User
    {
        $query = <<<'QUERY'
        SELECT * FROM user
        WHERE email = :email AND password LIKE :password
        QUERY;

        $statement = $this->database->prepare($query);

        if ($password == null) $password = '%';

        $statement->bindParam('email', $email);
        $statement->bindParam('password', $password);

        $statement->execute();
        $user = $statement->fetchAll();

        if (empty($user)) return null;
        return new User($user[0]['email'], $user[0]['password'], $user[0]['numBitcoins'], $user[0]['created_at'], $user[0]['updated_at']);
    }

    public function save(User $user): void
    {
        $query = <<<'QUERY'
        INSERT INTO user(email, password, numBitcoins, createdAt, updatedAt)
        VALUES(:email, :password, :numBitcoins, :createdAt, :updatedAt)
        QUERY;

        $statement = $this->database->prepare($query);

        $email = $user->getEmail();
        $password = $user->getPassword();
        $numBitcoins = $user->getNumBitcoins();
        $createdAt = $user->getCreatedAt()->format(self::DATE_FORMAT);
        $updatedAt = $user->getUpdatedAt()->format(self::DATE_FORMAT);

        $statement->bindParam('email', $email);
        $statement->bindParam('password', $password);
        $statement->bindParam('numBitcoins', $numBitcoins);
        $statement->bindParam('createdAt',  $createdAt);
        $statement->bindParam('updatedAt', $updatedAt);

        $statement->execute();
    }
}