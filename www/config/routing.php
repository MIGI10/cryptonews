<?php

declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->add(SessionMiddleware::class);

$app->get('/', function (Request $request, Response $response): Response {
    return $this->get('view')->render($response, 'home.twig', []);
})->setName('home');

// $app->get('/', HomeController::class . ':apply')->setName('home');
// $app->get('/', HomeController::class . ':apply')->setName('home')
//    ->add(AfterMiddleware::class);

$container->set(
    HomeController::class,
    function (ContainerInterface $c) {
        $controller = new HomeController($c->get("view"), $c->get("flash"));
        return $controller;
    }
);

// global: $app->add(AfterMiddleware::class);

$app->get('/visits', VisitsController::class . ':showVisits')->setName('visits');

// $app->get('/cookies', VisitsController::class . ':showVisits')->setName('visits');

//$app->get('/flash', FlashController::class::class . ':showVisits')->setName('visits');

$app->post('/user', CreateUserController::class . ":apply")->setName('create_user');