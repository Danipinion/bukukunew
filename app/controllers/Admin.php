<?php

class Admin extends Controller
{

    public function __construct()
    {
        if (!isset($_SESSION['login'])) {
            header('Location: ' . BASEURL . '/login');
            exit;
        } elseif ($_SESSION['role'] !== 'admin') {
            header('Location: ' . BASEURL . '/user');
            exit;
        }
    }

    public function index()
    {
        $data['judul'] = 'Dashboard';

        $data['total_users'] = $this->model('User_model')->countUsersByRole('user');
        $data['total_books'] = $this->model('Buku_model')->countAllBuku();
        $data['total_active_loans'] = $this->model('Peminjaman_model')->countPeminjamanByStatus(['proses', 'disetujui', 'terlambat']);
        $data['total_returned_books'] = $this->model('Peminjaman_model')->countPeminjamanByStatus(['dikembalikan']);

        $data['best_selling_books'] = $this->model('Peminjaman_model')->getBestSellingBooks(3);

        $borrowing_trends_raw = $this->model('Peminjaman_log_model')->getBorrowingTrendsWeekly();

        // Prepare data for ApexCharts
        $data['chart_categories'] = [];
        $data['chart_peminjaman_data'] = [];
        $data['chart_pengembalian_data'] = [];

        foreach ($borrowing_trends_raw as $day => $counts) {
            $data['chart_categories'][] = $day;
            $data['chart_peminjaman_data'][] = $counts['borrowed'];
            $data['chart_pengembalian_data'][] = $counts['returned'];
        }

        $this->view('templates/headerAdmin', $data);
        $this->view('admin/index', $data);
        $this->view('templates/footerAdmin');
    }

    public function buku()
    {
        $data['judul'] = 'Manajemen Buku';
        $data['buku'] = $this->model('Buku_model')->getAllBuku();
        $data['kategori'] = $this->model('Kategori_model')->getAllKategori();
        $this->view('templates/headerAdmin', $data);
        $this->view('admin/buku/index', $data);
        $this->view('templates/footerAdmin');
    }

    public function kategori()
    {
        $data['judul'] = 'Kategori';
        $data['kategori'] = $this->model('Kategori_model')->getAllKategori();
        $this->view('templates/headerAdmin', $data);
        $this->view('admin/kategori', $data);
        $this->view('templates/footerAdmin');
    }

    public function prosesTambahKategori()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nama = $_POST['nama'];
            $jenis = $_POST['jenis'];

            if (empty($nama) && empty($jenis)) {
                Flasher::setFlash('Nama kategori dan jenis wajib diisi.', 'danger');
                header('Location: ' . BASEURL . '/admin/kategori');
                exit;
            }

            if ($this->model('Kategori_model')->cekNamaKategori($nama)) {
                Flasher::setFlash('Nama kategori sudah ada.', 'danger');
                header('Location: ' . BASEURL . '/admin/kategori');
                exit;
            }

            if ($this->model('Kategori_model')->tambahKategori(['nama' => $nama, 'jenis' => $jenis])) {
                Flasher::setFlash('Kategori berhasil ditambahkan.', 'success');
                header('Location: ' . BASEURL . '/admin/kategori');
                exit;
            } else {
                Flasher::setFlash('Gagal menambahkan kategori.', 'danger');
                header('Location: ' . BASEURL . '/admin/kategori');
                exit;
            }
        } else {
            header('Location: ' . BASEURL . '/admin/kategori');
            exit;
        }
    }

    public function prosesUpdateKategori()
    {
        if ($this->model('Kategori_model')->updateDataKategori($_POST) > 0) {
            Flasher::setFlash('berhasil diubah', 'success');
        } else {
            Flasher::setFlash('gagal diubah', 'danger');
        }
        header('Location: ' . BASEURL . '/admin/kategori');
        exit;
    }

    public function prosesHapusKategori($id)
    {
        if ($this->model('Kategori_model')->hapusKategori($id)) {
            Flasher::setFlash('Kategori berhasil dihapus.', 'success');
            header('Location: ' . BASEURL . '/admin/kategori');
            exit;
        } else {
            Flasher::setFlash('Gagal menghapus kategori.', 'danger');
            header('Location: ' . BASEURL . '/admin/kategori');
            exit;
        }
    }

    public function user()
    {
        $data['judul'] = 'User';
        $data['user'] = $this->model('User_model')->getAllUser();
        $this->view('templates/headerAdmin', $data);
        $this->view('admin/user', $data);
        $this->view('templates/footerAdmin');
    }

    public function detailUser($id)
    {
        $data['judul'] = 'Detail User';
        $data['user'] = $this->model('User_model')->getUserById($id);
        $data['peminjaman'] = $this->model('Peminjaman_model')->getPeminjamanByUserId($id);
        $data['denda'] = $this->model('Denda_log_model')->getAllDataByUserId($id);
        $this->view('templates/headerAdmin', $data);
        $this->view('admin/detailUser', $data);
        $this->view('templates/footerAdmin');
    }


    public function tambahDendaUserManual()
    {
        $data['judul'] = 'Tambah Denda';

        $id_user = $_POST['id_user'];
        $jumlah_denda = $_POST['jumlah_denda_modal'];
        $catatan = $_POST['catatan_denda_modal'];
        if ($this->model('User_model')->tambahDenda($id_user, $jumlah_denda) && $this->model('Denda_log_model')->tambahDendaLog($id_user, $jumlah_denda, $catatan)) {
            Flasher::setFlash('Berhasil menambahkan denda.', 'success');
            header('Location: ' . BASEURL . '/admin/detailUser/' . $id_user);
            exit;
        } else {
            Flasher::setFlash('Gagal menambahkan denda.', 'danger');
            header('Location: ' . BASEURL . '/admin/detailUser/' . $id_user);
            exit;
        }

        header('Location: ' . BASEURL . '/admin/user/');
        exit;
    }


    public function peminjaman()
    {
        $data['judul'] = 'Manajemen Peminjaman';
        $data['peminjaman'] = $this->model('Peminjaman_model')->getAllPeminjaman();
        $this->view('templates/headerAdmin', $data);
        $this->view('admin/peminjaman/index', $data);
        $this->view('templates/footerAdmin');
    }

    public function setujuiPeminjaman($id_peminjaman)
    {
        $peminjaman = $this->model('Peminjaman_model')->getPeminjamanById($id_peminjaman);

        if (!$peminjaman || $peminjaman['status'] !== 'proses') {
            Flasher::setFlash('Gagal menyetujui peminjaman. Peminjaman tidak ditemukan atau status tidak sesuai.', 'danger');
            header('Location: ' . BASEURL . '/admin/peminjaman');
            exit;
        }

        if ($this->model('Peminjaman_model')->updateStatusPeminjaman($id_peminjaman, 'disetujui') > 0) {
            Flasher::setFlash('Berhasil menyetujui peminjaman.', 'success');
        } else {
            Flasher::setFlash('Gagal menyetujui peminjaman.', 'danger');
        }
        header('Location: ' . BASEURL . '/admin/peminjaman');
        exit;
    }

    public function tolakPeminjaman($id_peminjaman)
    {
        $peminjaman = $this->model('Peminjaman_model')->getPeminjamanById($id_peminjaman);

        if (!$peminjaman || $peminjaman['status'] !== 'proses') {
            Flasher::setFlash('Gagal', 'menolak peminjaman. Peminjaman tidak ditemukan atau status tidak sesuai.', 'danger');
            header('Location: ' . BASEURL . '/admin/peminjaman');
            exit;
        }

        // Opsional: Ambil catatan penolakan dari POST
        $catatan = isset($_POST['catatan_penolakan']) ? $_POST['catatan_penolakan'] : null;

        if ($this->model('Peminjaman_model')->updateStatusPeminjaman($id_peminjaman, 'ditolak', $catatan) > 0) {
            // Kembalikan stok buku jika ditolak
            $this->model('Buku_model')->increaseSisaBuku($peminjaman['id_buku']);
            Flasher::setFlash('Berhasil', 'menolak peminjaman.', 'success');
        } else {
            Flasher::setFlash('Gagal', 'menolak peminjaman.', 'danger');
        }
        header('Location: ' . BASEURL . '/admin/peminjaman');
        exit;
    }

    public function perpanjangPeminjamanOlehAdmin($id_peminjaman)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $new_tanggal_kembali = $_POST['new_tanggal_kembali'];
            if ($this->model('Peminjaman_model')->perpanjangPeminjaman($id_peminjaman, $new_tanggal_kembali) > 0) {
                Flasher::setFlash('Berhasil memperpanjang peminjaman.', 'success');
            } else {
                Flasher::setFlash('Gagal memperpanjang peminjaman.', 'danger');
            }
            header('Location: ' . BASEURL . '/admin/peminjaman');
            exit;
        }
    }

    public function reservasi()
    {
        $data['judul'] = 'Reservasi';
        $this->view('templates/headerAdmin', $data);
        $this->view('admin/reservasi', $data);
        $this->view('templates/footerAdmin');
    }

    public function log()
    {
        $data['judul'] = 'Log Peminjaman';
        $data['log_peminjaman'] = $this->model('Peminjaman_model')->getAllPeminjaman();

        $this->view('templates/headerAdmin', $data);
        $this->view('admin/log', $data); // 
        $this->view('templates/footerAdmin');
    }

    public function kembalikanBuku($id_peminjaman)
    {
        $peminjaman = $this->model('Peminjaman_model')->getPeminjamanById($id_peminjaman);
        $userId = $peminjaman['id_user'];
        $bookId = $peminjaman['id_buku'];

        if (!$peminjaman || !in_array($peminjaman['status'], ['disetujui', 'terlambat'])) {
            Flasher::setFlash('Gagal mengembalikan buku', 'Peminjaman tidak ditemukan atau status tidak valid.', 'danger');
            header('Location: ' . BASEURL . '/admin/log');
            exit;
        }



        $tanggal_dikembalikan_aktual = date('Y-m-d');

        if ($this->model('Peminjaman_model')->updateStatusPeminjaman($id_peminjaman, 'dikembalikan', null, $tanggal_dikembalikan_aktual) > 0) {
            $this->model('Peminjaman_log_model')->create($id_peminjaman, $userId, $bookId, 'dikembalikan', '');
            $this->model('Buku_model')->increaseSisaBuku($peminjaman['id_buku']);
            Flasher::setFlash('Buku berhasil dikembalikan', 'success');

            $tanggal_kembali_expected = new DateTime($peminjaman['tanggal_kembali_expected']);
            $tanggal_aktual = new DateTime($tanggal_dikembalikan_aktual);
            if ($tanggal_aktual > $tanggal_kembali_expected) {
                $interval = $tanggal_aktual->diff($tanggal_kembali_expected);
                $jumlah_hari_terlambat = $interval->days;
                $denda_per_hari = 2000;
                $total_denda = $jumlah_hari_terlambat * $denda_per_hari;

                $this->model('User_model')->tambahDenda($peminjaman['id_user'], $total_denda);
                Flasher::setFlash('Denda: Rp ' . number_format($total_denda, 0, ',', '.') . ' dikenakan Karena keterlambatan ' . $jumlah_hari_terlambat . ' hari.', 'warning');
            }
        } else {
            Flasher::setFlash('Pengembalian buku gagal', 'Terjadi kesalahan.', 'danger');
        }
        header('Location: ' . BASEURL . '/admin/peminjaman');
        exit;
    }
}
