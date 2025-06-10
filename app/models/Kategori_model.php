<?php

class Kategori_model
{
    private $table = 'kategori'; // Nama tabel di database
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllKategori()
    {
        $this->db->query('SELECT * FROM ' . $this->table);
        return $this->db->resultSet();
    }



    public function getTotalBukuByKategori($kategori_id)
    {
        $this->db->query('SELECT COUNT(*) AS total FROM buku WHERE id_kategori = :id');
        $this->db->bind(':id', $kategori_id);
        $this->db->execute();
        return $this->db->single()['total'];
    }

    public function tambahKategori($data)
    {
        $query = "INSERT INTO " . $this->table . " (nama, jenis) VALUES(:nama, :jenis)";
        $this->db->query($query);
        $this->db->bind(':nama', $data['nama']);
        $this->db->bind(':jenis', $data['jenis']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function getKategoriById($id)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->execute();
        return $this->db->single();
    }

    public function updateDataKategori($data)
    {
        $query = "UPDATE " . $this->table . " SET
                    nama = :nama,
                    jenis = :jenis
                  WHERE id = :id";
        $this->db->query($query);
        $this->db->bind(':nama', $data['nama']);
        $this->db->bind(':jenis', $data['jenis']);
        $this->db->bind(':id', $data['id']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function hapusKategori($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $this->db->query($query);
        $this->db->bind(':id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function cekNamaKategori($nama)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE nama = :nama');
        $this->db->bind(':nama', $nama);
        $this->db->execute();
        return $this->db->rowCount();
    }
}
