<?php

declare(strict_types=1);

include './header.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $firstName = $_POST['first-name'] ?? '';
  $lastName = $_POST['last-name'] ?? '';
  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';

  $errors = $validator->validateRegistrationData($firstName, $email, $password);

  if (empty($errors)) {
    if ($userModel->userExists($email)) {
      $error = "User with this email already exists.";
    } else {
      $userData = [
        'name' => $firstName . " " . $lastName,
        'email' => $email,
        'hashedPassword' => password_hash($password, PASSWORD_DEFAULT),
        'role' => 'customer',
        'transactions' => [],
        'balance' => 0,
      ];

      if ($userModel->saveUser($userData)) {
        $success = "User created successfully!";
      } else {
        $error = "Failed to save user.";
      }
    }
  } else {
    $error = "Please fix the following errors:";
  }
}
?>

<main class="-mt-32">
  <div class="px-4 pb-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg">
      <form method="POST" class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
        <?php if (!empty($error)) : ?>
          <div class="px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded">
            <?php echo $error; ?>
          </div>
        <?php elseif (!empty($success)) : ?>
          <div class="px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded">
            <?php echo $success; ?>
          </div>
        <?php endif; ?>
        <div class="px-4 py-6 sm:p-8">
          <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-3">
              <label for="first-name" class="block text-sm font-medium leading-6 text-gray-900">First Name</label>
              <div class="mt-2">
                <input type="text" name="first-name" id="first-name" autocomplete="given-name" required class="block w-full p-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6" />
              </div>
            </div>

            <div class="sm:col-span-3">
              <label for="last-name" class="block text-sm font-medium leading-6 text-gray-900">Last Name</label>
              <div class="mt-2">
                <input type="text" name="last-name" id="last-name" autocomplete="family-name" required class="block w-full p-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6" />
              </div>
            </div>

            <div class="sm:col-span-3">
              <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email Address</label>
              <div class="mt-2">
                <input type="email" name="email" id="email" autocomplete="email" required class="block w-full p-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6" />
              </div>
            </div>

            <div class="sm:col-span-3">
              <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
              <div class="mt-2">
                <input type="password" name="password" id="password" autocomplete="new-password" required class="block w-full p-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6" />
              </div>
            </div>
          </div>
        </div>
        <div class="flex items-center justify-end px-4 py-4 border-t gap-x-6 border-gray-900/10 sm:px-8">
          <button type="reset" class="text-sm font-semibold leading-6 text-gray-900">
            Cancel
          </button>
          <button type="submit" class="px-3 py-2 text-sm font-semibold text-white rounded-md shadow-sm bg-sky-600 hover:bg-sky-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600">
            Create Customer
          </button>
        </div>
      </form>
    </div>
  </div>
</main>
</body>

</html>