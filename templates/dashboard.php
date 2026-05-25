<?php
/** 
 * @var array $accounts 
*/
?> 
<!DOCTYPE html>
<html lang="sv">
<head><meta charset="UTF-8"><title>Bankomat - dashboard</title></head>
<body>

<h1>welcome <?php echo e($_SESSION['name']); ?></h1>
<nav>
    <a href="/dashboard">home</a> | 
    <a href="/deposit">Deposit money</a> | 
    <a href="/withdraw">Withdraw money</a> |
    <a href="/transfer">Transfer money</a> | 
    <a href="/logout">Log out</a>

    <?php if ($_SESSION['role'] === 'admin'): ?>
        <br><br><strong>Admin options:</strong><br>
        <a href="/admin/users">Manage users</a> |
        <a href="/admin/accounts">Manage accounts</a> |
        <a href="/admin/transactions">View transactions</a>
    <?php endif; ?>
</nav>
<hr>

<h2>Your accounts and transactions:</h2>
<table border="1" cellpadding="10" >
    <tr><th>Account ID</th><th>Account Type</th><th>Balance</th></tr>


    <?php foreach ($accounts as $acc): ?>
    <tr>
        <td><?= e($acc['id'])?></td>
        <td><?= e($acc['account_type'])?></td>
        <td><strong><?= e($acc['balance'])?> kr</strong></td>
    </tr> 
    <?php endforeach; ?>
</table>
</body>
</html>