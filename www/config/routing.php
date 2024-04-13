<?php

declare(strict_types=1);

use Salle\Ca2CryptoNews\Controller\CookieMonsterController;
use Salle\Ca2CryptoNews\Controller\CreateUserController;
use Salle\Ca2CryptoNews\Controller\FlashController;
use Salle\Ca2CryptoNews\Controller\HomeController;
use Salle\Ca2CryptoNews\Controller\SignInController;
use Salle\Ca2CryptoNews\Controller\SignUpController;
use Salle\Ca2CryptoNews\Controller\SimpleFormController;
use Salle\Ca2CryptoNews\Controller\VisitsController;
use Salle\Ca2CryptoNews\Middleware\AfterMiddleware;
use Salle\Ca2CryptoNews\Middleware\SessionMiddleware;

$app->add(SessionMiddleware::class);

$app->get('/visits', VisitsController::class . ':showVisits')->setName('visits');

$app->get('/cookies', CookieMonsterController::class . ':showAdvice')->setName('cookies');

$app->get('/flash', FlashController::class . ':addMessage')->setName('flash');

$app->post('/user', CreateUserController::class . ":apply")->setName('create_user');

$app->get('/sign-up', SignUpController::class . ':showForm')->setName('sign-up');

$app->post('/sign-up', SignUpController::class . ':handleForm')->setName('sign-up-handle');

$app->get('/sign-in', SignInController::class . ':showForm')->setName('sign-in');

$app->post('/sign-in', SignInController::class . ':handleForm')->setName('sign-in-handle');

$app->get('/', HomeController::class . ':apply')->setName('home');