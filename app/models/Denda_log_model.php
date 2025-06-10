<?php

class Denda_log_model
{
    private $table = 'denda_log';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function tambahDendaLog($userId, $jumlahDenda, $catatan)
    {
        $query = "INSERT INTO $this->table (user_id,  price, catatan) VALUES (:user_id, :price, :catatan)";
        $this->db->query($query);
        $this->db->bind('user_id', $userId);
        $this->db->bind('price', $jumlahDenda);
        $this->db->bind('catatan', $catatan);
        $this->db->execute();

        return $this->db->rowCount();
    }


    public function getAllDataByUserId($id)
    {
        $query = "SELECT * FROM $this->table WHERE user_id = :id ORDER BY created_at DESC";
        $this->db->query($query);
        $this->db->bind('id', $id);
        return $this->db->resultSet();
    }

    public function getDendaById($id)
    {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        return $this->db->single();
    }
}
