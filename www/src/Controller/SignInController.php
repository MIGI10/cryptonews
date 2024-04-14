<?php

declare(strict_types=1);

namespace Salle\Ca2CryptoNews\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Salle\Ca2CryptoNews\Model\UserRepository;
use Slim\Flash\Messages;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

final class SignInController extends UserController
{
    private Messages $flash;

    public function __construct(Twig $twig, UserRepository $userRepository, Messages $flash)
    {
        parent::__construct($twig, $userRepository);
        $this->flash = $flash;
    }

    public function showForm(Request $request, Response $response): Response
    {
        $errors = [];
        $messages = $this->flash->getMessages();
        if (isset($messages['unauthorized'])) $errors['unauthorized'] = 'You must be logged in to access the news page.';

        try {
            return $this->twig->render($response, 'sign-in.twig', [
                'errors' => $errors
            ]);
        } catch (LoaderError | RuntimeError | SyntaxError $e) {
            return $response->withStatus(500);
        }
    }

    public function handleForm(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        $errors = $this->checkInput($data['email'], $data['pass']);

        if (empty($errors['email']) && $this->userRepository->fetch($data['email'], null) == null) {
            $errors['email'][] = 'User with this email address does not exist.';
        }

        $user = null;
        if (empty($errors['pass']) && ($user = $this->userRepository->fetch($data['email'], $data['pass'])) == null) {
            $errors['pass'][] = 'Your email and/or password are incorrect.';
        }

        if (empty($errors['email']) && empty($errors['pass'])) {

            $_SESSION['user'] = $user;

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