<?php
declare(strict_types= 1);

class TransactionRepository {

    // PDO-objektet som används för databasinteraktion.
    public function __construct(private PDO $pdo) {}    

    // hämta alla transaktioner, till admin.
    public function findAll() : array {
        return $this->pdo->query("select * from transactions order by created_at desc")->fetchAll();
    }
    
   // insättning.
    public function deposit (int $account_id, float $amount): void {
        if ($amount <= 0) throw new InvalidArgumentException("Amount must be greater than 0.");
    
        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("update accounts set balance = balance + :amount where id= :id");
            $stmt->execute(['amount' => $amount, 'id' => $account_id]);

            $stmt = $this->pdo->prepare("Insert into transactions (to_account_id, type, amount) values (?, 'deposit', ?)");
            $stmt->execute([$account_id, $amount]);

            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
 
    // uttag.   
    public function withdraw (int $account_id, float $amount): void {
        if ($amount <= 0) throw new InvalidArgumentException("Amount must be greater than 0");

        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("update accounts set balance = balance - :amount where id = :id and balance >= :amount");
            $stmt->execute(['amount' => $amount, 'id' => $account_id]);

            if($stmt->rowCount() === 0) {
                throw new RuntimeException("withdrawal failed: not enough balance.");
            }
            
            $stmt = $this->pdo->prepare("insert into transactions (from_account_id, type, amount) values (?, 'withdrawal', ?)");
            $stmt->execute([$account_id, $amount]);
            
            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    // överföring.
    public function transfer (int $from_account_id, int $to_account_id, float $amount): void {
        if ($amount <= 0) throw new InvalidArgumentException("Amount must be greater than 0");
        if ($from_account_id === $to_account_id) throw new InvalidArgumentException("choice tow different accounts for transfer.");

        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("update accounts set balance = balance - :amount where id = :id and balance >= :amount");
            $stmt->execute(['amount' => $amount, 'id' => $from_account_id]);

            if($stmt->rowCount() === 0) {
                throw new RuntimeException("Transfer failed: not enough balance.");
            }

            $stmt = $this->pdo->prepare("update accounts set balance = balance + :amount where id = :id");
            $stmt->execute(['amount' => $amount, 'id' => $to_account_id]);
            
            $stmt = $this->pdo->prepare("insert into transactions (from_account_id, to_account_id, type, amount) values (?, ?, 'transfer', ?)");            
            $stmt->execute([$from_account_id, $to_account_id, $amount]);

            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
}