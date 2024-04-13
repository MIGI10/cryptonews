<?php

declare(strict_types=1);

namespace Salle\Ca2CryptoNews\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

final class SignInController
{
    private Twig $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function showForm(Request $request, Response $response): Response
    {
        return $this->twig->render($response, 'sign-in.twig');
    }

    public function handleForm(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        $errors = [];
        $errors['email'] = [];
        $errors['pass'] = [];

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'][] = 'The email address is not valid.';
        }

        if ($this->isDomainUnknown($data['email'])) {
            $errors['email'][] = 'Only emails from the domain @salle.url.edu are accepted.';
        }

        // TODO: check email existence
        if (true) {
            $errors['email'][] = 'User with this email address does not exist.';
        }

        // TODO: check invalid credentiaLs
        if (true) {
            $errors['email'][] = 'Your email and/or password are incorrect.';
        }

        if (empty($data['pass']) || strlen($data['pass']) < 7) {
            $errors['pass'][] = 'The password must contain at least 7 characters.';
        }

        if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).+/', $data['pass'])) {
            $errors['pass'][] = 'The password must contain both upper and lower case letters and numbers.';
        }

        // TODO: login?

        return $this->twig->render($response, 'sign-in.twig', [
            'errors' => $errors,
            'data' => $data
        ]);
    }

    private function isDomainUnknown(string $email): bool
    {
        $email_split = explode('@', $email);
        return count($email_split) == 2 && $email_split[1] === "salle.url.edu";
    }
}