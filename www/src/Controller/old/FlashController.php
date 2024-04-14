<?php

declare(strict_types=1);

namespace Salle\Ca2CryptoNews\Controller\old;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Flash\Messages;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;

final class FlashController
{

    private Twig $twig;
    private Messages $flash;

    public function __construct(
        Twig $twig,
        Messages $flash
    ) {
        $this->flash = $flash;
        $this->twig = $twig;
    }

    public function addMessage(Request $request, Response $response): Response
    {
        $this->flash->addMessage('notifications', 'Flash messages in action!');

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();

        return $response
            ->withHeader('Location', $routeParser->urlFor("home"))
            ->withStatus(302);
    }
}