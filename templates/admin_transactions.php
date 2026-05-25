<?php
/** 
 * @var array $transactions 
*/
?>

<!DOCTYPE html>
<html lang="sv">
<head><meta charset="UTF-8"><title>Bankomat - dashboard</title></head>
<body>
    <h1>transaction list</h1>
    <p><a href="/dashboard">Tillbaka till dashboard</a></p>
    <hr>
    <table border="1" cellpadding="6">
        <tr><th>id</th><th>from account</th><th>to account</th><th>type</th><th>amount</th></tr>tidpunkt</th></tr>
        <?php foreach ($transactions as $t): ?>
            <tr>
                <td><?= e($t['id']) ?></td>
                <td><?= e($t['from_account_id']) ?></td>
                <td><?= e($t['to_account_id']) ?></td>
                <td><?= e($t['type']) ?></td>
                <td><strong><?= e($t['amount']) ?> kr</strong></td>
                <td><?= e($t['created_at']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </body>
    </html>