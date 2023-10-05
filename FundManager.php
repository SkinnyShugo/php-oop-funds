<?php
class FundManager {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addFunds($userId, $amount) {
        $stmt = $this->pdo->prepare("UPDATE users SET balance = balance + ? WHERE id = ?");
        $stmt->execute([$amount, $userId]);
        
        $stmt = $this->pdo->prepare("INSERT INTO transactions (user_id, type, amount) VALUES (?, 'add', ?)");
        $stmt->execute([$userId, $amount]);
    }

    public function withdrawFunds($userId, $amount) {
        $stmt = $this->pdo->prepare("UPDATE users SET balance = balance - ? WHERE id = ?");
        $stmt->execute([$amount, $userId]);
        
        $stmt = $this->pdo->prepare("INSERT INTO transactions (user_id, type, amount) VALUES (?, 'withdraw', ?)");
        $stmt->execute([$userId, $amount]);
    }
}
