<?php

declare(strict_types=1);

namespace Salle\Ca2CryptoNews\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

final class SignUpController
{
    private Twig $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function showForm(Request $request, Response $response): Response
    {
        return $this->twig->render($response, 'sign-up.twig');
    }

    public function handleForm(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        $errors = [];
        $errors['email'] = [];
        $errors['pass'] = [];
        $errors['bitcoins'] = [];

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'][] = 'The email address is not valid.';
        }

        if ($this->isDomainUnknown($data['email'])) {
            $errors['email'][] = 'Only emails from the domain @salle.url.edu are accepted.';
        }

        // TODO: check unique email
        if (true) {
            $errors['email'][] = 'The email address is already registered.';
        }

        if (empty($data['pass']) || strlen($data['pass']) < 7) {
            $errors['pass'][] = 'The password must contain at least 7 characters.';
        }

        if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).+/', $data['pass'])) {
            $errors['pass'][] = 'The password must contain both upper and lower case letters and numbers.';
        }

        if ($data['pass'] !== $data['pass_confirm']) {
            $errors['pass'][] = 'Passwords do not match.';
        }

        if (empty($data['bitcoins']) || !preg_match('/^\d+$/', $data['bitcoins'])) {
            $errors['bitcoins'][] = 'The number of Bitcoins is not a valid number.';
        }

        if ($data['bitcoins'] < 0 || $data['bitcoins'] > 40000) {
            $errors['bitcoins'][] = 'Sorry, the number of Bitcoins is either below or above the limits.';
        }

        // TODO: store user & redirect?

        return $this->twig->render($response, 'sign-up.twig', [
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