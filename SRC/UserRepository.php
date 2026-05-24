<?php
declare(strict_types= 1);   

class UserRepository
{
    public function __construct(private PDO $pdo) {}


    public function findbycardnumber(string $cardNumber): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE card_number = :card");
        $stmt->execute(['card' => $cardNumber]);
        return $stmt->fetch() ?: null;
    }


    public function findall(): array {
        return $this->pdo->query("select id, name, card_number, role, created_at from users")->fetchAll();
    }
}