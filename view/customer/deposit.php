<?php

declare(strict_types=1);

include './header.php';

use App\Model\UserModel;

$userModel = new UserModel();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;

  if ($amount <= 0) {
    $message = '<p class="text-red-600">Invalid amount. Please enter a positive number.</p>';
  } else {
    $currentUser = $_SESSION['user'];
    $user = $userModel->getUser($currentUser['email']);
    if ($user === null) {
      $message = '<p class="text-red-600">User not found.</p>';
    } else {
      $newBalance = $user['balance'] + $amount;
      $user['balance'] = $newBalance;
      $userModel->saveUser($user);
      $_SESSION['user'] = $user;
      $message = '<p class="text-green-600">Deposit successful! New balance: $' . number_format($newBalance, 2) . '</p>';
    }
  }
}
?>
<main class="-mt-32">
  <div class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg p-2">
      <!-- Current Balance Stat -->
      <dl class="mx-auto grid grid-cols-1 gap-px sm:grid-cols-2 lg:grid-cols-4">
        <div class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-2 bg-white px-4 py-10 sm:px-6 xl:px-8">
          <dt class="text-sm font-medium leading-6 text-gray-500">
            Current Balance
          </dt>
          <dd class="w-full flex-none text-3xl font-medium leading-10 tracking-tight text-gray-900">
            $<?= number_format($user['balance'], 2) ?>
          </dd>
        </div>
      </dl>

      <hr />
      <!-- Deposit Form -->
      <div class="sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <h3 class="text-lg font-semibold leading-6 text-gray-800">
            Deposit Money To Your Account
          </h3>
          <div class="mt-4 text-sm text-gray-500">
            <?= $message ?> <!-- Display message here -->
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
              <!-- Input Field -->
              <div class="relative mt-2 rounded-md">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-0">
                  <span class="text-gray-400 sm:text-4xl">$</span>
                </div>
                <input type="number" name="amount" id="amount" class="block w-full ring-0 outline-none text-xl pl-4 py-2 sm:pl-8 text-gray-800 border-b border-b-emerald-500 placeholder:text-gray-400 sm:text-4xl" placeholder="0.00" required />
              </div>

              <!-- Submit Button -->
              <div class="mt-5">
                <button type="submit" class="w-full px-6 py-3.5 text-base font-medium text-white bg-emerald-600 hover:bg-emerald-800 focus:ring-4 focus:outline-none focus:ring-emerald-300 rounded-lg sm:text-xl text-center">
                  Proceed
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
</div>
</body>

</html>