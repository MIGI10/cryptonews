<?php

declare(strict_types=1);

namespace Salle\Ca2CryptoNews\Model\Repository;

use DateTime;
use Exception;
use PDO;
use Salle\Ca2CryptoNews\Model\User;
use Salle\Ca2CryptoNews\Model\UserRepository;

final class MysqlUserRepository implements UserRepository
{
    private const DATE_FORMAT = 'Y-m-d H:i:s';

    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function fetch(string $email, ?string $password): ?User
    {
        $query = <<<'QUERY'
        SELECT * FROM users
        WHERE email = :email AND password LIKE :password
        QUERY;

        $statement = $this->db->prepare($query);

        if ($password == null) $password = '%';

        $statement->bindParam('email', $email);
        $statement->bindParam('password', $password);

        $statement->execute();
        $user = $statement->fetchAll();

        if (empty($user)) return null;
        try {
            return new User($user[0]['email'], $user[0]['password'], $user[0]['numBitcoins'], new DateTime($user[0]['createdAt']), new DateTime($user[0]['updatedAt']));
        } catch (Exception $e) {
            return new User($user[0]['email'], $user[0]['password'], $user[0]['numBitcoins'], new DateTime("@0"), new DateTime("@0"));
        }
    }

    public function save(User $user): void
    {
        $query = <<<'QUERY'
        INSERT INTO users(email, password, numBitcoins, createdAt, updatedAt)
        VALUES(:email, :password, :numBitcoins, :createdAt, :updatedAt)
        QUERY;

        $statement = $this->db->prepare($query);

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