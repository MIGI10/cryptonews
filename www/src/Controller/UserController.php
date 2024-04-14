<?php

namespace Salle\Ca2CryptoNews\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Salle\Ca2CryptoNews\Model\UserRepository;
use Slim\Views\Twig;

abstract class UserController
{

    protected Twig $twig;
    protected UserRepository $userRepository;

    public function __construct(Twig $twig, UserRepository $userRepository)
    {
        $this->twig = $twig;
        $this->userRepository = $userRepository;
    }

    abstract public function showForm(Request $request, Response $response): Response;

    abstract public function handleForm(Request $request, Response $response): Response;

    protected function checkInput(string $email, string $password): array
    {
        $errors = [];
        $errors['email'] = [];
        $errors['pass'] = [];

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'][] = 'The email address is not valid.';
        }
        else {
            if ($this->isDomainUnknown($email)) {
                $errors['email'][] = 'Only emails from the domain @salle.url.edu are accepted.';
            }
        }

        if (empty($password) || strlen($password) < 7) {
            $errors['pass'][] = 'The password must contain at least 7 characters.';
        }
        else {
            if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).+/', $password)) {
                $errors['pass'][] = 'The password must contain both upper and lower case letters and numbers.';
            }
        }

        return $errors;
    }

    private function isDomainUnknown(string $email): bool
    {
        $email_split = explode('@', $email);
        return count($email_split) != 2 || $email_split[1] !== "salle.url.edu";
    }
}