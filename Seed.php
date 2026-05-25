<?php
declare(strict_types= 1);

$dapath = __DIR__ . '/bankomat.db';

if (!file_exists($dapath)) {
    unlink($dapath);
}


$db = new PDO('sqlite:' . $dapath);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$Schema = file_get_contents(__DIR__ . '/schema.sql');
$db->exec($Schema);


$pinhash = password_hash('1234', PASSWORD_BCRYPT, ['cost' => 12]);


$stmt = $db->prepare("INSERT INTO users (card_number, pin_hash, name, role) VALUES (?,?,?,?)");
$stmt->execute(['11112222', $pinhash, 'admin Zaid', 'admin']);
$adminId = $db->lastInsertId();
$db->prepare("INSERT INTO accounts (user_id, account_type, balance) 
VALUES (?, 'checking', 15000.00)")->execute([$adminId]);


$stmt->execute(['33334444', $pinhash, 'sven Svensson', 'user']);
$svenId = $db->lastInsertId();
$db->prepare("INSERT INTO accounts (user_id, account_type, balance) 
VALUES (?, 'checking', 4500.00)")->execute([$svenId]);

$db->prepare("INSERT INTO accounts (user_id, account_type, balance) 
VALUES (?, 'saving', 85000.00)")->execute([$svenId]);


$stmt->execute(['55556666', $pinhash, 'Anna Andersson', 'user']);
$annaId = $db->lastInsertId();
$db->prepare("INSERT INTO accounts (user_id, account_type, balance) 
VALUES (?, 'checking', 1500.00)")->execute([$annaId]);

echo "testkonto: 
(pin: 1234, 
admin: 11112222,
user2: 33334444,
user3: 55556666)";


















?>
