<?php
declare(strict_types=1);

namespace App\Interface;

interface UserDataHandlerInterface {
    public function saveUser(array $userData): bool;
    public function userExists(string $email): bool;
    public function getUser(string $email): ?array;
    public function parseEmail(string $email): string;
}
