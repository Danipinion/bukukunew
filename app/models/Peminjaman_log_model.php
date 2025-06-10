<?php


class Peminjaman_log_model
{
    protected $table = 'peminjaman_log';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function create($id_peminjaman, $id_user, $id_buku, $aksi, $catatan = null)
    {
        $this->db->query("INSERT INTO " . $this->table . " (id_peminjaman, id_user, id_buku, aksi, catatan) VALUES (:id_peminjaman, :id_user, :id_buku, :aksi, :catatan)");
        $this->db->bind(':id_peminjaman', $id_peminjaman);
        $this->db->bind(':id_user', $id_user);
        $this->db->bind(':id_buku', $id_buku);
        $this->db->bind(':aksi', $aksi);
        $this->db->bind(':catatan', $catatan);
        return $this->db->execute();
    }

    // Metode untuk mendapatkan semua log berdasarkan ID peminjaman
    public function getLogsByPeminjamanId($id_peminjaman)
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE id_peminjaman = :id_peminjaman ORDER BY tanggal_aksi ASC");
        $this->db->bind(':id_peminjaman', $id_peminjaman);
        return $this->db->resultSet();
    }
    public function getBorrowingTrendsWeekly()
    {
        // Mendapatkan tanggal hari ini
        $today = new DateTime();
        $end_date = $today->modify('+1 days')->format('Y-m-d');
        // Mendapatkan tanggal 7 hari yang lalu
        $start_date_obj = (new DateTime())->modify('-6 days'); // Current day + 6 previous days = 7 days total
        $start_date = $start_date_obj->format('Y-m-d');
        // Query untuk mengambil data peminjaman dan pengembalian dalam 7 hari terakhir
        // Menggunakan DAYOFWEEK (1=Minggu, 2=Senin, ..., 7=Sabtu) untuk pengurutan
        $query = "
            SELECT
                DAYOFWEEK(tanggal_aksi) AS day_num,
                DATE_FORMAT(tanggal_aksi, '%W') AS day_name,
                COUNT(CASE WHEN aksi IN ('proses', 'disetujui', 'terlambat') THEN 1 END) AS borrowed,
                COUNT(CASE WHEN aksi = 'dikembalikan' THEN 1 END) AS returned
            FROM " . $this->table . "
            WHERE tanggal_aksi BETWEEN :start_date AND :end_date
            GROUP BY day_num, day_name
            ORDER BY day_num ASC
        ";

        $this->db->query($query);
        $this->db->bind('start_date', $start_date);
        $this->db->bind('end_date', $end_date);
        $results = $this->db->resultSet();

        // Inisialisasi data untuk semua hari dalam seminggu
        $weekly_data = [
            'Minggu' => ['borrowed' => 0, 'returned' => 0],
            'Senin' => ['borrowed' => 0, 'returned' => 0],
            'Selasa' => ['borrowed' => 0, 'returned' => 0],
            'Rabu' => ['borrowed' => 0, 'returned' => 0],
            'Kamis' => ['borrowed' => 0, 'returned' => 0],
            'Jumat' => ['borrowed' => 0, 'returned' => 0],
            'Sabtu' => ['borrowed' => 0, 'returned' => 0],
        ];

        // Mapping nama hari dari bahasa Inggris ke Indonesia
        $day_name_map = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        ];

        // Mengisi data mingguan dengan hasil dari database
        foreach ($results as $row) {
            $english_day_name = $row['day_name'];
            $indonesian_day_name = $day_name_map[$english_day_name] ?? $english_day_name; // Fallback if not found

            if (isset($weekly_data[$indonesian_day_name])) {
                $weekly_data[$indonesian_day_name]['borrowed'] = (int)$row['borrowed'];
                $weekly_data[$indonesian_day_name]['returned'] = (int)$row['returned'];
            }
        }


        // Mengurutkan ulang data sesuai urutan hari dalam seminggu (dimulai dari Senin)
        $ordered_days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $final_trend_data = [];
        foreach ($ordered_days as $day) {
            if (isset($weekly_data[$day])) {
                $final_trend_data[$day] = $weekly_data[$day];
            } else {
                // Should not happen if weekly_data is properly initialized, but for safety
                $final_trend_data[$day] = ['borrowed' => 0, 'returned' => 0];
            }
        }
        return $final_trend_data;
    }
}
