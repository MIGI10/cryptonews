<?php

namespace Salle\Ca2CryptoNews\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

interface FormController
{
    public function showForm(Request $request, Response $response): Response;
    public function handleForm(Request $request, Response $response): Response;

}