<!DOCTYPE html>
<html lang="sv">
<head><meta charset="UTF-8"><title>Bankomat - log in</title></head>
<body>
    <h1>Bankomat Ab</h1>

    // om fel lösenord angetts, e() för xss-skydd.
    <?php if (!empty($error) ): ?><p style="color: red;"><?= e($error) ?></p><?php endif; ?>

        <form method="post" action="/login">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            <p><label>Card Number:<br><input type="text" name="card_number" required autocomplete="off"></label></p>
            <p><label>PIN:<br><input type="password" name="pin" required></label></p>
            <p><input type="submit" value="Log in"></p>
        </form>
    </body>    
    </html>