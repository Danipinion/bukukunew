<?php

class Buku_model
{
    private $table = 'buku';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllBuku()
    {
        $this->db->query('SELECT buku.*, kategori.nama AS nama_kategori FROM ' . $this->table . ' JOIN kategori ON buku.id_kategori = kategori.id');
        return $this->db->resultSet();
    }

    public function getBukuById($id)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id_buku = :id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function tambahBuku($data)
    {
        $query = "INSERT INTO " . $this->table . " (id_kategori, pdf_file, judul, penulis, deskripsi, gambar, jumlah, sisa)
                    VALUES (:id_kategori, :pdf_file, :judul, :penulis, :deskripsi, :gambar, :jumlah, :jumlah)";
        $this->db->query($query);
        $this->db->bind('id_kategori', $data['id_kategori']);
        $this->db->bind('pdf_file', $data['pdf_file']);
        $this->db->bind('judul', $data['judul']);
        $this->db->bind('penulis', $data['penulis']);
        $this->db->bind('deskripsi', $data['deskripsi']);
        $this->db->bind('gambar', $data['gambar']);
        $this->db->bind('jumlah', $data['jumlah']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function ubahBuku($data)
    {
        $query = "UPDATE " . $this->table . " SET
                    id_kategori = :id_kategori,
                    pdf_file = :pdf_file,
                    judul = :judul,
                    penulis = :penulis,
                    deskripsi = :deskripsi,
                    gambar = :gambar,
                    jumlah = :jumlah,
                    sisa = :sisa
                  WHERE id_buku = :id";
        $this->db->query($query);
        $this->db->bind('id_kategori', $data['kategori_buku_modal']);
        $this->db->bind('pdf_file', $data['pdf_buku_modal']);
        $this->db->bind('judul', $data['judul_buku_modal']);
        $this->db->bind('penulis', $data['penulis_buku_modal']);
        $this->db->bind('deskripsi', $data['deskripsi_buku_modal']);
        $this->db->bind('gambar', $data['gambar_buku_modal']);
        $this->db->bind('jumlah', $data['jumlah_buku_modal']);
        $this->db->bind('sisa', $data['sisa_buku_modal']);
        $this->db->bind('id', $data['id_buku']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function hapusBuku($id)
    {
        $buku = $this->getBukuById($id);
        if ($buku) {
            $pdf_path = BASEURL . '/files/pdf/' . $buku['pdf_file'];
            if (file_exists($pdf_path)) {
                unlink($pdf_path);
            }
        }
        $query = "DELETE FROM " . $this->table . " WHERE id_buku = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function getKategori()
    {
        $this->db->query('SELECT * FROM kategori');
        return $this->db->resultSet();
    }

    public function getBukuPilihan($limit = 4)
    {
        $this->db->query('SELECT buku.*, kategori.nama AS nama_kategori FROM ' . $this->table . ' JOIN kategori ON buku.id_kategori = kategori.id ORDER BY buku.created_at DESC LIMIT :limit');
        $this->db->bind('limit', $limit);
        return $this->db->resultSet();
    }

    public function getBukuByKategori($id_kategori)
    {
        $this->db->query('SELECT buku.*, kategori.nama AS nama_kategori FROM ' . $this->table . ' JOIN kategori ON buku.id_kategori = kategori.id WHERE buku.id_kategori = :id_kategori');
        $this->db->bind('id_kategori', $id_kategori);
        return $this->db->resultSet();
    }

    public function getKategoriById($id_kategori)
    {
        $this->db->query('SELECT * FROM kategori WHERE id = :id');
        $this->db->bind('id', $id_kategori);
        return $this->db->single();
    }

    public function ubahBukuSisa($data)
    {
        $query = "UPDATE " . $this->table . " SET
                    sisa = :sisa
                  WHERE id_buku = :id";
        $this->db->query($query);
        $this->db->bind('sisa', $data['sisa']);
        $this->db->bind('id', $data['id_buku']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function decreaseSisaBuku($id_buku)
    {
        $query = "UPDATE " . $this->table . " SET sisa = sisa - 1 WHERE id_buku = :id_buku AND sisa > 0";
        $this->db->query($query);
        $this->db->bind('id_buku', $id_buku);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function increaseSisaBuku($id_buku)
    {
        $query = "UPDATE " . $this->table . " SET sisa = sisa + 1 WHERE id_buku = :id_buku";
        $this->db->query($query);
        $this->db->bind('id_buku', $id_buku);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function searchBukuByTitle($keyword)
    {
        // If keyword is empty, return all books
        if (empty($keyword)) {
            return $this->getAllBuku();
        }

        $query = "SELECT * FROM " . $this->table . " WHERE judul LIKE :keyword";
        $this->db->query($query);
        $this->db->bind('keyword', "%" . $keyword . "%");
        return $this->db->resultSet();
    }

    public function getAllBukuWithPagination($limit, $offset, $sort = 'latest')
    {
        $orderBy = $this->getOrderByClause($sort);
        $query = "SELECT * FROM " . $this->table . " ORDER BY " . $orderBy . " LIMIT :limit OFFSET :offset";
        $this->db->query($query);
        $this->db->bind('limit', $limit, PDO::PARAM_INT);
        $this->db->bind('offset', $offset, PDO::PARAM_INT);
        return $this->db->resultSet();
    }

    // New: Count all books
    public function countAllBuku()
    {
        $this->db->query("SELECT COUNT(*) AS total FROM " . $this->table);
        return $this->db->single()['total'];
    }

    // Modified/New: Search books with filters, pagination, and sorting
    public function searchBukuWithFilters($keyword, $id_kategori, $limit, $offset, $sort = 'latest')
    {
        $whereClause = [];
        $params = [];

        if (!empty($keyword)) {
            $whereClause[] = "judul LIKE :keyword";
            $params['keyword'] = "%" . $keyword . "%";
        }
        if (!empty($id_kategori)) {
            $whereClause[] = "id_kategori = :id_kategori";
            $params['id_kategori'] = $id_kategori;
        }

        $orderBy = $this->getOrderByClause($sort);

        $query = "SELECT * FROM " . $this->table;
        if (!empty($whereClause)) {
            $query .= " WHERE " . implode(" AND ", $whereClause);
        }
        $query .= " ORDER BY " . $orderBy . " LIMIT :limit OFFSET :offset";

        $this->db->query($query);
        foreach ($params as $key => $value) {
            $this->db->bind($key, $value);
        }
        $this->db->bind('limit', $limit, PDO::PARAM_INT);
        $this->db->bind('offset', $offset, PDO::PARAM_INT);

        return $this->db->resultSet();
    }

    // New: Count search results with filters
    public function countSearchBuku($keyword, $id_kategori)
    {
        $whereClause = [];
        $params = [];

        if (!empty($keyword)) {
            $whereClause[] = "judul LIKE :keyword";
            $params['keyword'] = "%" . $keyword . "%";
        }
        if (!empty($id_kategori)) {
            $whereClause[] = "id_kategori = :id_kategori";
            $params['id_kategori'] = $id_kategori;
        }

        $query = "SELECT COUNT(*) AS total FROM " . $this->table;
        if (!empty($whereClause)) {
            $query .= " WHERE " . implode(" AND ", $whereClause);
        }

        $this->db->query($query);
        foreach ($params as $key => $value) {
            $this->db->bind($key, $value);
        }

        return $this->db->single()['total'];
    }

    // Helper to get order by clause
    private function getOrderByClause($sort)
    {
        switch ($sort) {
            case 'title_asc':
                return 'judul ASC';
            case 'title_desc':
                return 'judul DESC';
            case 'latest':
            default:
                return 'created_at DESC';
        }
    }
}
