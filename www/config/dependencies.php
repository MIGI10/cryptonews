<?php

declare(strict_types=1);

use DI\Container;
use Psr\Container\ContainerInterface;
use Salle\Ca2CryptoNews\Model\Repository\MysqlUserRepository;
use Salle\Ca2CryptoNews\Model\Repository\PDOSingleton;
use Salle\Ca2CryptoNews\Model\UserRepository;
use Slim\Flash\Messages;
use Slim\Views\Twig;

$container = new Container();

$container->set('view', function () {
    return Twig::create(__DIR__ . '/../templates', ['cache' => false]);
});

$container->set(Twig::class, function (ContainerInterface $c) {
    return $c->get('view');
});

$container->set(Messages::class,  function () {
    return new Messages();
});

$container->set(PDO::class, function () {
    return PDOSingleton::getInstance(
        $_ENV['DB_CONNECTION'],
        $_ENV['DB_USERNAME'],
        $_ENV['DB_PASSWORD'],
        $_ENV['DB_HOST'],
        $_ENV['MYSQL_PORT'],
        $_ENV['DB_DATABASE']
    )->getConnection();
});

$container->set(UserRepository::class, function (ContainerInterface $c) {
    return $c->get(MysqlUserRepository::class);
});