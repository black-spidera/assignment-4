<?php
declare(strict_types=1);

namespace App\Interface;

interface ValidatorInterface {
    public function validateRegistrationData(string $name, string $email, string $password): array;
    public function validateLoginData(string $email, string $password): array;
}
