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

final class SignUpController extends UserController implements FormController
{

    public function __construct(Twig $twig, UserRepository $userRepository)
    {
        parent::__construct($twig, $userRepository);
    }

    public function showForm(Request $request, Response $response): Response
    {
        try {
            return $this->twig->render($response, 'sign-up.twig');
        } catch (LoaderError | RuntimeError | SyntaxError $e) {
            return $response->withStatus(500);
        }
    }

    public function handleForm(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        $errors = $this->checkInput($data['email'], $data['password']);

        if ($this->userRepository->fetch($data['email'], null) != null) {
            $errors['email'][] = 'The email address is already registered.';
        }

        if ($data['pass'] !== $data['pass_confirm']) {
            $errors['pass'][] = 'Passwords do not match.';
        }

        $errors['bitcoins'] = [];

        if (empty($data['bitcoins']) || !preg_match('/^\d+$/', $data['bitcoins'])) {
            $errors['bitcoins'][] = 'The number of Bitcoins is not a valid number.';
        }

        if ($data['bitcoins'] < 0 || $data['bitcoins'] > 40000) {
            $errors['bitcoins'][] = 'Sorry, the number of Bitcoins is either below or above the limits.';
        }

        if (empty($errors)) {
            $user = new User($data['email'], $data['pass'], $data['bitcoins'], new DateTime(), new DateTime());
            $this->userRepository->save($user);

            $routeParser = RouteContext::fromRequest($request)->getRouteParser();

            return $response
                ->withHeader('Location', $routeParser->urlFor('sign-in'))
                ->withStatus(303);
        }

        try {
            return $this->twig->render($response, 'sign-up.twig', [
                'errors' => $errors,
                'data' => $data
            ]);
        } catch (LoaderError|RuntimeError|SyntaxError $e) {
            return $response->withStatus(500);
        }
    }
}