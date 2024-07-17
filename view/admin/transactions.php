<?php
include './header.php';

$users = $userModel->getAllUsers();
$allTransactions = [];

foreach ($users as $user) {
  if ($user['role'] !== 'admin') {
    $transactions = $user['transactions'];
    foreach ($transactions as $transaction) {
      $allTransactions[] = array_merge($transaction, ['userName' => $user['name'], 'userEmail' => $user['email']]);
    }
  }
}
?>

<main class="-mt-32">
  <div class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg py-8">
      <!-- List of All The Transactions -->
      <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
          <div class="sm:flex-auto">
            <p class="mt-2 text-sm text-gray-700">
              List of transactions made by the customers.
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
                      Customer Name
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
                  <?php if (!empty($allTransactions)) : ?>
                    <?php foreach ($allTransactions as $transaction) : ?>
                      <tr>
                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-800 sm:pl-0">
                          <?php echo htmlspecialchars($transaction['userName']); ?>
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
                      <td colspan="3" class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-800 sm:pl-0">
                        No transactions found for any user.
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
