<?php
declare(strict_types= 1);

$dbpath = __DIR__ ."bankomat.db";
$pdo = new PDO('sqlite:' . $dbpath);

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

return $pdo;

?>
