<?php
declare(strict_types= 1);   

class UserRepository
{
    // PDO-objektet som används för databasinteraktion.
    public function __construct(private PDO $pdo) {}


   // Hitta en användare baserat på kortnummer, returnera null om ingen hittas.
    public function findbycardnumber(string $cardNumber): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE card_number = :card");
        $stmt->execute(['card' => $cardNumber]);
        return $stmt->fetch() ?: null;
    }


    // Hitta alla användare, returnera som en array.
    public function findall(): array {
        return $this->pdo->query("select id, name, card_number, role, created_at from users")->fetchAll();
    }
}