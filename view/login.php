<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

use App\Controller\AuthController;
use App\Helper\Validator;
use App\Model\UserModel;

$validator = new Validator();
$userModel = new UserModel();
$auth = new AuthController($validator, $userModel);

$auth->sessionControl();

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $result = $auth->login($email, $password);

    if (is_array($result)) {
        $errors = $result;
    }
}

if (isset($_SESSION['success_message'])) {
    $success = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}
?>

<!DOCTYPE html>
<html class="h-full bg-white" lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    * {
      font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont,
        'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans',
        'Helvetica Neue', sans-serif;
    }
  </style>

  <title>Sign-In To Your Account</title>
</head>
<body class="h-full bg-slate-100">
  <div class="flex flex-col justify-center min-h-full py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <h2 class="mt-6 text-2xl font-bold leading-9 tracking-tight text-center text-gray-900">
        Sign In To Your Account
      </h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-[480px]">
      <div class="px-6 py-12 bg-white shadow sm:rounded-lg sm:px-12">
        <?php if (!empty($errors)): ?>
          <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul>
              <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
          <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            <?= htmlspecialchars($success) ?>
          </div>
        <?php endif; ?>
        <form class="space-y-6" action="" method="POST">
          <div>
            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
            <div class="mt-2">
              <input id="email" name="email" type="email" autocomplete="email" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600 p-2 sm:text-sm sm:leading-6" />
            </div>
          </div>

          <div>
            <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
            <div class="mt-2">
              <input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6 p-2" />
            </div>
          </div>

          <div>
            <button type="submit" class="flex w-full justify-center rounded-md bg-emerald-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600">
              Sign in
            </button>
          </div>
        </form>
      </div>

      <p class="mt-10 text-sm text-center text-gray-500">
        Don't have an account?
        <a href="./register.php" class="font-semibold leading-6 text-emerald-600 hover:text-emerald-500">Register</a>
      </p>
    </div>
  </div>
</body>
</html>
