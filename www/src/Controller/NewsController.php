<?php

declare(strict_types=1);

namespace Salle\Ca2CryptoNews\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Flash\Messages;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

final class NewsController
{
    private Twig $twig;
    private Messages $flash;

    public function __construct(Twig $twig, Messages $flash)
    {
        $this->twig = $twig;
        $this->flash = $flash;
    }

    public function apply(Request $request, Response $response): Response
    {
        if (!isset($_SESSION['user'])) {

            $this->flash->addMessage('unauthorized', 1);

            $routeParser = RouteContext::fromRequest($request)->getRouteParser();

            return $response
                ->withHeader('Location', $routeParser->urlFor('sign-in'))
                ->withStatus(303);
        }

        $articles = [];
        $articles[]['title'] = 'Test';
        $articles[]['date'] = '19/02/2021';
        $articles[]['author'] = 'John F. Biden';
        $articles[]['summary'] = 'This is an article about test';

        $articles[]['title'] = 'Lorem ipsum';
        $articles[]['date'] = '12/04/2015';
        $articles[]['author'] = 'John F. Obama';
        $articles[]['summary'] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';

        try {
            return $this->twig->render($response, 'news.twig', [
                'articles' => $articles
            ]);
        } catch (LoaderError | RuntimeError| SyntaxError $e) {
            return $response->withStatus(500);
        }
    }
}