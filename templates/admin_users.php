<?php
/** 
 * @var array $users 
*/
?> 
<!DOCTYPE html>
<html lang="sv">
<head><meta charset="UTF-8"><title>Bankomat - dashboard</title></head>
<body>
    <h1>user list</h1>
    <p><a href="/dashboard">Tillbaka till dashboard</a></p>
    <hr>
    <table border="1" cellpadding="5">
        <tr><th>id</th><th>name</th><th>card number</th><th>role</th><th>created at</th></tr>
        <?php foreach ($users as $u): ?>
            <tr>
                <td><?= e($u['id']) ?></td>
                <td><?= e($u['name']) ?></td>
                <td><?= e($u['card_number']) ?></td>
                <td><?= e($u['role']) ?></td>
                <td><?= e($u['created_at']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </body>
    </html>
