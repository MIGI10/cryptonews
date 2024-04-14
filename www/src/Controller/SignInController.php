<?php

declare(strict_types=1);

namespace Salle\Ca2CryptoNews\Controller;

use DateTime;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Salle\Ca2CryptoNews\Model\User;
use Salle\Ca2CryptoNews\Model\UserRepository;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

final class SignInController extends UserController implements FormController
{

    public function __construct(Twig $twig, UserRepository $userRepository)
    {
        parent::__construct($twig, $userRepository);
    }

    public function showForm(Request $request, Response $response): Response
    {
        try {
            return $this->twig->render($response, 'sign-in.twig');
        } catch (LoaderError | RuntimeError | SyntaxError $e) {
            return $response->withStatus(500);
        }
    }

    public function handleForm(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        $errors = $this->checkInput($data['email'], $data['password']);

        if ($this->userRepository->fetch($data['email'], null) == null) {
            $errors['email'][] = 'User with this email address does not exist.';
        }

        if (($user = $this->userRepository->fetch($data['email'], $data['password'])) == null) {
            $errors['pass'][] = 'Your email and/or password are incorrect.';
        }

        if (empty($errors)) {

            // TODO: store cookie?

            $routeParser = RouteContext::fromRequest($request)->getRouteParser();

            return $response
                ->withHeader('Location', $routeParser->urlFor('home'))
                ->withStatus(303);
        }

        try {
            return $this->twig->render($response, 'sign-in.twig', [
                'errors' => $errors,
                'data' => $data
            ]);
        } catch (LoaderError|RuntimeError|SyntaxError $e) {
            return $response->withStatus(500);
        }
    }
}