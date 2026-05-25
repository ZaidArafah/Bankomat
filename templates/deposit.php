<?php
/** 
 * @var array $accounts 
*/
?> 
<!DOCTYPE html>
<html lang="sv">
<head><meta charset="UTF-8"><title>Bankomat - dashboard</title></head>
<body>

<h1>Deposit automatiskt</h1>
<p><a href="/dashboard">Tillbaka till dashboard</a></p>
<hr>
<?php if (!empty($success)): ?>
    <p style="color: green;"><?= e($success) ?></p><?php endif; ?>
<?php if (!empty($error)): ?>
    <p style="color: red;"><?= e($error) ?></p><?php endif; ?>

<form method="post" action="/deposit">
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
    <p><label>Choice account:<br>
     <select name="account_id" required>
        <?php foreach ($accounts as $acc): ?>
            <option value="<?= e($acc['id'])?>"><?= e($acc['account_type']) ?> 
            (balance: <?= e($acc['balance']) ?> kr)</option>
        <?php endforeach; ?>
    </select>
</label></p>

    <p><label>Amount to deposit (kr):<br><input type="number" name="amount" min="10" required></label></p>
    <p><button type="submit">Deposit</button></p>
</form>
</body>
</html>