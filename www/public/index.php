<?php

declare(strict_types=1);

use Slim\Factory\AppFactory;
use Slim\Views\TwigMiddleware;

require __DIR__ . '/../vendor/autoload.php';

date_default_timezone_set('Europe/Madrid');

require_once __DIR__ . '/../config/dependencies.php';

AppFactory::setContainer($container);

$app = AppFactory::create();

$app->add(TwigMiddleware::createFromContainer($app));
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);
$app->addBodyParsingMiddleware();

require_once __DIR__ . '/../config/routing.php';

$app->run();