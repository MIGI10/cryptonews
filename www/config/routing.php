<?php

declare(strict_types=1);

use Salle\Ca2CryptoNews\Controller\HomeController;
use Salle\Ca2CryptoNews\Controller\MarketController;
use Salle\Ca2CryptoNews\Controller\NewsController;
use Salle\Ca2CryptoNews\Controller\SignInController;
use Salle\Ca2CryptoNews\Controller\SignUpController;
use Salle\Ca2CryptoNews\Middleware\SessionMiddleware;

$app->add(SessionMiddleware::class);

$app->get('/sign-up', SignUpController::class . ':showForm')->setName('sign-up');

$app->post('/sign-up', SignUpController::class . ':handleForm')->setName('sign-up-handle');

$app->get('/sign-in', SignInController::class . ':showForm')->setName('sign-in');

$app->post('/sign-in', SignInController::class . ':handleForm')->setName('sign-in-handle');

$app->get('/', HomeController::class . ':apply')->setName('home');

$app->get('/news', NewsController::class . ':apply')->setName('news');

$app->get('/mkt', MarketController::class . ':apply')->setName('market');