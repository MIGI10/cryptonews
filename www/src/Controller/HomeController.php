<?php

declare(strict_types=1);

namespace Student\SlimSkeleton\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

final class HomeController
{
    private Twig $twig;

    private Messages $flash;

    // You can also use https://stitcher.io/blog/constructor-promotion-in-php-8
    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
        $this->flash = $flash;
    }

    public function apply(Request $request, Response $response): Response
    {
        $messages = $this->flash->getMessages();

        $notifications = $messages['notifications'] ?? [];

        return $this->twig->render($response, 'home.twig', [
            'notifications' => $notifications
        ]);
        //return $this->twig->render($response, 'home.twig');
    }
}