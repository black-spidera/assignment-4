<?php
include './header.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $amount = floatval($_POST['amount'] ?? 0);

    if (empty($email)) {
        $message = '<p class="text-red-600">Please enter the recipient\'s email address.</p>';
    } elseif ($amount <= 0) {
        $message = '<p class="text-red-600">Invalid amount. Please enter a positive number.</p>';
    } else {
        $validUser = $userModel->getUser($email);
        $currentUser = $_SESSION['user'];

        if ($validUser === null) {
            $message = '<p class="text-red-600">Recipient not found.</p>';
        } elseif ($validUser['email'] === $currentUser['email']) {
            $message = '<p class="text-red-600">You cannot transfer money to your own account.</p>';
        } else {
            $currentUserData = $userModel->getUser($currentUser['email']);
            if ($currentUserData['balance'] < $amount) {
                $message = '<p class="text-red-600">Insufficient balance.</p>';
            } else {
                $currentUserData['balance'] -= $amount;
                $validUser['balance'] += $amount;

                $userModel->saveUser($currentUserData);
                $userModel->saveUser($validUser);

                $transaction = [
                    'timestamp' => date('Y-m-d H:i:s'),
                    'email' => $validUser['email'],
                    'name'=>$validUser['name'],
                    'amount' => $amount,
                ];

                $currentUserData['transactions'][] = $transaction;
                $userModel->saveUser($currentUserData);

                $_SESSION['user'] = $currentUserData;

                $message = '<p class="text-green-600">Transfer successful! New balance: $' . number_format($currentUserData['balance'], 2) . '</p>';
            }
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
            $<?= $user['balance'] ?>
          </dd>
        </div>
      </dl>

      <hr />
      <!-- Transfer Form -->
      <div class="sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <div class="mt-4 text-sm text-gray-500">
            <form action="#" method="POST">
              <!-- Display message if exists -->
              <?php if (!empty($message)): ?>
                <div class="mb-4"><?= $message ?></div>
              <?php endif; ?>

              <!-- Recipient's Email Input -->
              <input type="email" name="email" id="email" class="block w-full ring-0 outline-none py-2 text-gray-800 border-b placeholder:text-gray-400 md:text-4xl" placeholder="Recipient's Email Address" required />

              <!-- Amount -->
              <div class="relative mt-4 md:mt-8">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-0">
                  <span class="text-gray-400 md:text-4xl">$</span>
                </div>
                <input type="number" name="amount" id="amount" class="block w-full ring-0 outline-none pl-4 py-2 md:pl-8 text-gray-800 border-b border-b-emerald-500 placeholder:text-gray-400 md:text-4xl" placeholder="0.00" required />
              </div>

              <!-- Submit Button -->
              <div class="mt-5">
                <button type="submit" class="w-full px-6 py-3.5 text-base font-medium text-white bg-emerald-600 hover:bg-emerald-800 focus:ring-4 focus:outline-none focus:ring-emerald-300 rounded-lg md:text-xl text-center">
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
