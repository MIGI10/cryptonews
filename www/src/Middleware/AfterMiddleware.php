<?php

declare(strict_types=1);

namespace Salle\Ca2CryptoNews\Middleware;

use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Response as SlimResponse;

final class AfterMiddleware
{
    public function __invoke(Request $request, RequestHandler $next): Response
    {
        $response = $next->handle($request);
        $response->getBody()->write('AFTER');

        return $response;
    }
}