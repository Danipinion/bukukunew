<?php

class Peminjaman_model
{
    private $table = 'peminjaman';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function ajukanPeminjaman($data)
    {
        $query = "INSERT INTO " . $this->table . " (id_user, id_buku, tanggal_kembali_expected, status, isEbook)
                  VALUES (:id_user, :id_buku, :tanggal_kembali_expected, 'proses', :isEbook)";

        $this->db->query($query);
        $this->db->bind('id_user', $data['id_user']);
        $this->db->bind('id_buku', $data['id_buku']);
        $this->db->bind('tanggal_kembali_expected', $data['durasi']);
        $this->db->bind('isEbook', $data['isEbook']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function getLatestPeminjamanByUserId($id_user)
    {
        $query = "SELECT id_peminjaman, status, catatan_admin FROM " . $this->table . " WHERE id_user = :id_user ORDER BY tanggal_peminjaman DESC LIMIT 1";
        $this->db->query($query);
        $this->db->bind('id_user', $id_user);
        return $this->db->single();
    }


    public function getPeminjamanById($id_peminjaman)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id_peminjaman = :id_peminjaman');
        $this->db->bind('id_peminjaman', $id_peminjaman);
        return $this->db->single();
    }

    public function getPeminjamanByUserId($id_user)
    {
        $this->db->query('SELECT p.*, b.judul, b.gambar FROM ' . $this->table . ' p JOIN buku b ON p.id_buku = b.id_buku WHERE p.id_user = :id_user ORDER BY p.created_at DESC');
        $this->db->bind('id_user', $id_user);
        return $this->db->resultSet();
    }

    public function getRiwayatPeminjamanByUserId($id_user)
    {
        $query = "SELECT p.*, b.judul, b.penulis, b.gambar
                  FROM " . $this->table . " p
                  JOIN buku b ON p.id_buku = b.id_buku
                  WHERE p.id_user = :id_user
                  ORDER BY p.tanggal_peminjaman DESC";
        $this->db->query($query);
        $this->db->bind('id_user', $id_user);
        return $this->db->resultSet();
    }

    public function getPeminjamanByBukuIdAndUserId($id_buku, $id_user)
    {
        $query = "SELECT * FROM " . $this->table . "
                  WHERE id_buku = :id_buku AND id_user = :id_user
                  AND status IN ('proses', 'disetujui')
                  ORDER BY tanggal_peminjaman DESC LIMIT 1";
        $this->db->query($query);
        $this->db->bind('id_buku', $id_buku);
        $this->db->bind('id_user', $id_user);
        return $this->db->single();
    }

    public function getBukuDipinjamByUserId($id_user)
    {
        $query = "SELECT p.*, b.judul, b.penulis, b.gambar FROM peminjaman p JOIN buku b ON p.id_buku = b.id_buku WHERE p.id_user = :id_user AND p.status IN ('proses', 'disetujui') ORDER BY p.tanggal_peminjaman DESC";
        $this->db->query($query);
        $this->db->bind('id_user', $id_user);
        return $this->db->resultSet();
    }

    public function getAllPeminjaman()
    {
        $this->db->query('SELECT p.*, u.username, b.judul FROM ' . $this->table . ' p JOIN users u ON p.id_user = u.id JOIN buku b ON p.id_buku = b.id_buku ORDER BY p.created_at DESC');
        return $this->db->resultSet();
    }

    public function updateStatusPeminjaman($id_peminjaman, $status, $catatan = null, $tanggal_dikembalikan_aktual = null)
    {
        $query = "UPDATE " . $this->table . " SET status = :status";
        if ($catatan !== null) {
            $query .= ", catatan_admin = :catatan";
        }
        if ($tanggal_dikembalikan_aktual !== null) { // Add this condition
            $query .= ", tanggal_kembali_actual = :tanggal_dikembalikan_aktual"; // And this column
        }
        $query .= " WHERE id_peminjaman = :id_peminjaman";

        $this->db->query($query);
        $this->db->bind('status', $status);
        if ($catatan !== null) {
            $this->db->bind('catatan', $catatan);
        }
        if ($tanggal_dikembalikan_aktual !== null) { // Bind the new parameter
            $this->db->bind('tanggal_dikembalikan_aktual', $tanggal_dikembalikan_aktual);
        }
        $this->db->bind('id_peminjaman', $id_peminjaman);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function perpanjangPeminjaman($id_peminjaman, $tanggal_kembali_expected_baru)
    {
        $query = "UPDATE " . $this->table . " SET tanggal_kembali_expected = :tanggal_kembali_expected_baru WHERE id_peminjaman = :id_peminjaman";
        $this->db->query($query);
        $this->db->bind('tanggal_kembali_expected_baru', $tanggal_kembali_expected_baru);
        $this->db->bind('id_peminjaman', $id_peminjaman);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function kembalikanBuku($id_peminjaman)
    {
        $query = "UPDATE " . $this->table . " SET status = 'dikembalikan', tanggal_kembali_actual = CURRENT_TIMESTAMP WHERE id_peminjaman = :id_peminjaman";
        $this->db->query($query);
        $this->db->bind('id_peminjaman', $id_peminjaman);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function countPeminjamanByStatus($statuses = [])
    {
        if (empty($statuses)) {
            $this->db->query("SELECT COUNT(*) AS total FROM " . $this->table);
        } else {
            $placeholders = implode(',', array_fill(0, count($statuses), '?'));
            $query = "SELECT COUNT(*) AS total FROM " . $this->table . " WHERE status IN ({$placeholders})";
            $this->db->query($query);
            foreach ($statuses as $index => $status) {
                $this->db->bind($index + 1, $status);
            }
        }
        return $this->db->single()['total'];
    }

    public function getBestSellingBooks($limit = 3)
    {
        $query = "SELECT b.judul, COUNT(p.id_buku) AS total_peminjaman
                  FROM " . $this->table . " p
                  JOIN buku b ON p.id_buku = b.id_buku
                  GROUP BY b.judul
                  ORDER BY total_peminjaman DESC
                  LIMIT :limit";
        $this->db->query($query);
        $this->db->bind('limit', $limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }
}
