<?php
class Transaction_model
{
    private $table = 'transactions';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function create(array $data): bool
    {
        $query = "INSERT INTO " . $this->table . " (user_id, reference_id, payment_token, amount, currency, payment_method, customer_name, customer_email, status, expires_at) VALUES (:user_id, :reference_id, :payment_token, :amount, :currency, :payment_method, :customer_name, :customer_email, :status, :expires_at)";
        $this->db->query($query);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':reference_id', $data['reference_id']);
        $this->db->bind(':payment_token', $data['payment_token']);
        $this->db->bind(':amount', $data['amount']);
        $this->db->bind(':currency', $data['currency']);
        $this->db->bind(':payment_method', $data['payment_method']);
        $this->db->bind(':customer_name', $data['customer_name']);
        $this->db->bind(':customer_email', $data['customer_email']);
        $this->db->bind(':status', $data['status'] ?? 'pending');
        $this->db->bind(':expires_at', $data['expires_at']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function findByReferenceId(string $referenceId): ?array
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE reference_id = :reference_id");
        $this->db->bind(':reference_id', $referenceId);
        $this->db->execute();
        return $this->db->single();
    }

    public function findById($id)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id = :id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function findByPaymentToken(string $paymentToken): ?array
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE payment_token = :payment_token");
        $this->db->bind(':payment_token', $paymentToken);
        $this->db->execute();
        return $this->db->single();
    }

    public function updateStatus(string $identifier, string $status,   string $identifierType = 'reference_id', $change = "y"): bool
    {
        if (!in_array($identifierType, ['reference_id', 'payment_token'])) {
            throw new \InvalidArgumentException("Invalid identifier type.");
        }
        $query = "UPDATE " . $this->table . " SET `status`=:status, `change`=:change WHERE {$identifierType} = :identifier";
        $this->db->query($query);
        $this->db->bind(':status', $status);
        $this->db->bind(':identifier', $identifier);
        $this->db->bind(':change', $change);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function findExpiredPendingTransactions(): array
    {
        $now = date('Y-m-d H:i:s');
        $this->db->query("SELECT * FROM " . $this->table . " WHERE status = 'pending' AND expires_at < :now");
        $this->db->bind(':now', $now);
        $this->db->execute();
        return $this->db->resultSet();
    }

    public function getAllTransactions(): array
    {
        $this->db->query("SELECT * FROM " . $this->table . " ORDER BY created_at DESC");
        return $this->db->resultSet();
    }

    public function getTransactionsByUserId($userId)
    {

        $this->db->query("SELECT * FROM transactions  WHERE user_id = :user_id ORDER BY created_at DESC LIMIT 5;");
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }
}
