<?php

declare(strict_types=1);

use Salle\Ca2CryptoNews\Controller\CookieMonsterController;
use Salle\Ca2CryptoNews\Controller\CreateUserController;
use Salle\Ca2CryptoNews\Controller\FlashController;
use Salle\Ca2CryptoNews\Controller\HomeController;
use Salle\Ca2CryptoNews\Controller\VisitsController;
use Salle\Ca2CryptoNews\Middleware\AfterMiddleware;
use Salle\Ca2CryptoNews\Middleware\SessionMiddleware;

$app->add(SessionMiddleware::class);

$app->get('/', HomeController::class . ':apply')->setName('home')->add(AfterMiddleware::class);

$app->get('/visits', VisitsController::class . ':showVisits')->setName('visits');

$app->get('/cookies', CookieMonsterController::class . ':showAdvice')->setName('cookies');

$app->get('/flash', FlashController::class . ':addMessage')->setName('flash');

$app->post('/user', CreateUserController::class . ":apply")->setName('create_user');

$app->get('/simple-form', SimpleFormController::class . ':showForm');

$app->post('/simple-form', SimpleFormController::class . ':handleFormSubmission')->setName('handle-form');