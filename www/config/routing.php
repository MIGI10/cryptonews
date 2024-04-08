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

// global: $app->add(AfterMiddleware::class);

$app->get('/visits', VisitsController::class . ':showVisits')->setName('visits');

// $app->get('/cookies', VisitsController::class . ':showVisits')->setName('visits');