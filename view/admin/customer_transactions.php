<?php
include './header.php';

if (!isset($_GET['email'])) {
  echo "No user specified.";
  exit;
}

$email = $_GET['email'];

$user = $userModel->getUser($email);

if (!$user) {
  echo "User not found.";
  exit;
}

$transactions = $user['transactions'];
?>

<main class="-mt-32">
  <div class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg py-8">
      <!-- List of All The Transactions -->
      <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
          <div class="sm:flex-auto">
            <p class="mt-2 text-sm text-gray-700">
              List of transactions made by <?php echo htmlspecialchars($user['name']); ?>.
            </p>
          </div>
        </div>
        <div class="mt-8 flow-root">
          <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
              <table class="min-w-full divide-y divide-gray-300">
                <thead>
                  <tr>
                    <th scope="col" class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                      Receiver Name
                    </th>
                    <th scope="col" class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                      Email
                    </th>
                    <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">
                      Amount
                    </th>
                    <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">
                      Date
                    </th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                  <?php if (!empty($transactions)) : ?>
                    <?php foreach ($transactions as $transaction) : ?>
                      <tr>
                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-800 sm:pl-0">
                          <?php echo htmlspecialchars($transaction['name']); ?>
                        </td>
                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-500 sm:pl-0">
                          <?php echo htmlspecialchars($transaction['email']); ?>
                        </td>
                        <td class="whitespace-nowrap px-2 py-4 text-sm font-medium <?php echo $transaction['amount'] >= 0 ? 'text-emerald-600' : 'text-red-600'; ?>">
                          <?php echo $transaction['amount'] >= 0 ? '+' : ''; ?>$<?php echo htmlspecialchars($transaction['amount']); ?>
                        </td>
                        <td class="whitespace-nowrap px-2 py-4 text-sm text-gray-500">
                        <?= htmlspecialchars(date('d M Y, h:i A', strtotime($transaction['timestamp']))) ?>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else : ?>
                    <tr>
                      <td colspan="4" class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-800 sm:pl-0">
                        No transactions found for this user.
                      </td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
</div>
</body>

</html>