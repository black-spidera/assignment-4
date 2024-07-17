<?php

declare(strict_types=1);

namespace App\Controller;

use App\Interface\ValidatorInterface;
use App\Interface\UserDataHandlerInterface;

class AuthController
{
    private ValidatorInterface $validator;
    private UserDataHandlerInterface $userDataHandler;

    public function __construct(ValidatorInterface $validator, UserDataHandlerInterface $userDataHandler)
    {
        $this->validator = $validator;
        $this->userDataHandler = $userDataHandler;
    }

    public function registration(string $name, string $email, string $password)
    {
        $errors = $this->validator->validateRegistrationData($name, $email, $password);
        $success = '';

        if ($this->userDataHandler->userExists($email)) {
            $errors["email"] = "Email already exists!";
        }

        if (empty($errors)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $userData = [
                'name' => $name,
                'email' => $email,
                'hashedPassword' => $hashedPassword,
                'role' => 'customer',
                'transactions' => [],
                'balance' => 0,
            ];

            if ($this->userDataHandler->saveUser($userData)) {
                $success = "Registration successful! User data saved.";
            } else {
                $errors["failed"] = "Failed to save user data.";
            }
        } else {
            return $errors;
        }
        return $success;
    }

    public function login(string $email, string $password)
    {
        $errors = $this->validator->validateLoginData($email, $password);

        if (empty($errors)) {
            $userData = $this->userDataHandler->getUser($email);

            if ($userData && password_verify($password, $userData['hashedPassword'])) {
                $_SESSION['user'] = [
                    'name' => $userData['name'],
                    'email' => $userData['email']
                ];
                if ($userData['role'] === 'customer') {
                    header('location:/customer/dashboard.php');
                } else {
                    header('location:/admin/customers.php');
                }
                exit;
            } else {
                $errors["email"] = $userData ? "Incorrect password." : "Email not found.";
            }
        }

        if (!empty($errors)) {
            return $errors;
        }
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header('location:/login.php');
    }

    public function sessionControl()
    {
        if (isset($_SESSION['user'])) {
            $currentUser = $_SESSION['user'];
            $validUser = $this->userDataHandler->getUser($currentUser['email']);
            if ($validUser['role'] === 'customer') {
                header('location:/customer/dashboard.php');
            } else {
                header('location:/admin/customers.php');
            }
            exit;
        }
    }
}
