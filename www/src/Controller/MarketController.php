<?php

declare(strict_types=1);

namespace Salle\Ca2CryptoNews\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

final class MarketController
{
    private Twig $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function apply(Request $request, Response $response): Response
    {
        $balance = '';
        if (isset($_SESSION['user'])) {
            $balance = $_SESSION['user']->getNumBitcoins();
        }

        $currencies = [];
        $currencies[]['name'] = 'Bitcoin';
        $currencies[]['price'] = 'EUR 60.111,24';

        $currencies[]['name'] = 'Ethereum';
        $currencies[]['price'] = 'EUR 2.833,59';

        try {
            return $this->twig->render($response, 'market.twig', [
                'balance' => $balance,
                'currencies' => $currencies
            ]);
        } catch (LoaderError | RuntimeError| SyntaxError $e) {
            return $response->withStatus(500);
        }
    }
}