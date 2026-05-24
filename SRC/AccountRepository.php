<?php
declare(strict_types=1);

class AccountRepository {
    public function __construct(private PDO $pdo) {}

    // Hämta alla konton för en specifik användare.
    public function findByUserId(int $user_id): array {
        $stmt = $this->pdo->prepare("select * from accounts where user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll();
    }

    // Säkerhetsfunktion för användare, och hans konto id.   
    public function findByIdanduserId(int $id, int $user_id): ?array {
        $stmt = $this->pdo->prepare("select * from accounts where id = :id and user_id = :user_id");
        $stmt->execute(['id' => $id, 'user_id' => $user_id]);
        return $stmt->fetch() ?: null;
    }

   // Hämta alla konton med ägarens namn, användbart för admin. 
    public function findallwithOwners(): array {
        return $this->pdo->query ("
        select accounts.* users.name as owner_name from accounts
        join users on accounts.user_id = users.id")
        ->fetchAll ();
    }
}