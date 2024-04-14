<?php

declare(strict_types=1);

namespace Salle\Ca2CryptoNews\Model\Repository;

use PDO;

final class PDOSingleton
{
    private const CONNECTION_STRING = '%s:host=%s;port=%s;dbname=%s';

    private static ?PDOSingleton $instance = null;

    private PDO $connection;

    private function __construct(
        string $service,
        string $username,
        string $password,
        string $host,
        string $port,
        string $database
    ) {
        $db = new PDO(
            sprintf(self::CONNECTION_STRING, $service, $host, $port, $database),
            $username,
            $password
        );

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->connection = $db;
    }

    public static function getInstance(
        string $service,
        string $username,
        string $password,
        string $host,
        string $port,
        string $database
    ): PDOSingleton {
        if (self::$instance === null) {
            self::$instance = new self(
                $service,
                $username,
                $password,
                $host,
                $port,
                $database
            );
        }

        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}