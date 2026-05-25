<?php
/** 
 * @var array $accounts 
*/
?>

<!DOCTYPE html>
<html lang="sv">
<head><meta charset="UTF-8"><title>Bankomat - dashboard</title></head>
<body>
    <h1>account list</h1>
    <p><a href="/dashboard">Tillbaka till dashboard</a></p>
    <hr>
    <table border="1" cellpadding="6">
        <tr><th>id</th><th>owner name</th><th>account type</th><th>balance</th><th>
        <?php foreach ($accounts as $acc): ?>
            <tr>
                <td><?= e($acc['id']) ?></td>
                <td><?= e($acc['owner_name']) ?></td>
                <td><?= e($acc['account_type']) ?></td>
                <td><?= e($acc['balance']) ?> kr</td>
                
            </tr>
            <?php endforeach; ?>
        </table>
    </body>
    </html>