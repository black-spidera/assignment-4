<?php
declare(strict_types=1);

namespace App\Helper;

use App\Interface\ValidatorInterface;

class Validator implements ValidatorInterface {
    public function validateRegistrationData(string $name, string $email, string $password): array {
        $errors = [];

        if (empty($name)) {
            $errors["name"] = "Name is required!";
        }

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "Valid email is required!";
        }

        if (empty($password)) {
            $errors["password"] = "Password is required!";
        } 

        return $errors;
    }

    public function validateLoginData(string $email, string $password): array {
        $errors = [];

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "Valid email is required!";
        }

        if (empty($password)) {
            $errors["password"] = "Password is required!";
        }

        return $errors;
    }
}
