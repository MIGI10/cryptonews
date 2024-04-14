<?php

declare(strict_types=1);

namespace Salle\Ca2CryptoNews\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

final class HomeController
{
    private Twig $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function apply(Request $request, Response $response): Response
    {

        $user = isset($_SESSION['user']) ? explode('@', $_SESSION['user']->getEmail())[0] : 'stranger';

        try {
            return $this->twig->render($response, 'home.twig', [
                'user' => $user
            ]);
        } catch (LoaderError | RuntimeError | SyntaxError $e) {
            return $response->withStatus(500);
        }
    }
}