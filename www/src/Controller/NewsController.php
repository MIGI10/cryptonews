<?php

declare(strict_types=1);

namespace Salle\Ca2CryptoNews\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;

final class NewsController
{
    private Twig $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function apply(Request $request, Response $response): Response
    {

        if (!isset($_SESSION['user'])) {

            $routeParser = RouteContext::fromRequest($request)->getRouteParser();

            return $response
                ->withHeader('Location', $routeParser->urlFor('sign-in'))
                ->withStatus(303);
        }



        $user = isset($_SESSION['user']) ? explode('@', $_SESSION['user']->getEmail())[0] : 'stranger';

        return $this->twig->render($response, 'news.twig', [
            'user' => $user
        ]);
    }
}