<?php
declare(strict_types=1);

namespace App\Model;

use App\Interface\UserDataHandlerInterface;

class UserModel implements UserDataHandlerInterface {
    private string $dataDir;

    public function __construct() {
        $this->dataDir = __DIR__ . "/../../.data/";
    }

    public function saveUser(array $userData): bool {
        $parsedEmail = $this->parseEmail($userData['email']);
        $filePath = $this->dataDir . $parsedEmail . '.json';

        if (!file_exists($this->dataDir)) {
            if (!mkdir($this->dataDir, 0777, true)) {
                return false;
            }
        }
        return file_put_contents($filePath, json_encode($userData)) !== false;
    }

    public function userExists(string $email): bool {
        $parsedEmail = $this->parseEmail($email);
        return file_exists($this->dataDir . $parsedEmail . '.json');
    }

    public function getUser(string $email): ?array {
        $parsedEmail = $this->parseEmail($email);
        $filePath = $this->dataDir . $parsedEmail . '.json';

        if (file_exists($filePath)) {
            return json_decode(file_get_contents($filePath), true);
        }

        return null;
    }

    public function parseEmail(string $email): string {
        return str_replace(['@', '.'], '', $email);
    }

    public function getAllUsers(): array {
        $users = [];
        $files = glob($this->dataDir . '*.json');
        foreach ($files as $file) {
            $users[] = json_decode(file_get_contents($file), true);
        }
        return $users;
    }
}
