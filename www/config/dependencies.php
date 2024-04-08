<?php

declare(strict_types=1);

use DI\Container;
use Slim\Views\Twig;

$container = new Container();

$container->set('view', function () {
    return Twig::create(__DIR__ . '/../templates', ['cache' => false]);
});

// add use
$container->set(HomeController::class, function (ContainerInterface $c) {
    return new HomeController($c->get('view'));
});

// add controllers

$container->set('flash',  function () {
    return new Messages();
});