<?php

class User extends Controller
{
    public function __construct()
    {
        if (!isset($_SESSION['login'])) {
            header('Location: ' . BASEURL . '/login');
            exit;
        }
    }
    public function index()
    {
        $data['judul'] = 'Beranda';
        $data['buku_pilihan'] = $this->model('Buku_model')->getBukuPilihan();
        $data['kategori'] = $this->model('Buku_model')->getKategori();
        $this->view('templates/header', $data);
        $this->view('user/index', $data);
        $this->view('templates/footer');
    }

    public function read($id)
    {
        $data['buku'] = $this->model('Buku_model')->getBukuById($id);
        $data['judul'] = 'Baca Buku' . $data['buku']['judul'];
        $this->view('user/view_book', $data);
    }

    public function kategori($id)
    {
        $data['kategori_detail'] = $this->model('Buku_model')->getKategoriById($id);
        if (!$data['kategori_detail']) {
            header('Location: ' . BASEURL);
            exit;
        }
        $data['judul'] = 'Kategori: ' . $data['kategori_detail']['nama'];
        $data['buku_by_kategori'] = $this->model('Buku_model')->getBukuByKategori($id);
        $data['kategori'] = $this->model('Buku_model')->getKategori();
        $this->view('templates/header', $data);
        $this->view('user/kategori', $data);
        $this->view('templates/footer');
    }

    public function profile()
    {
        $data['user'] = $this->model('User_model')->getUserById($_SESSION['user_id']);
        if (!$data['user']) {
            header('Location: ' . BASEURL);
            exit;
        }
        $data['judul'] = 'Profile: ' . $data['user']['username'];
        $data['transactions'] = $this->model('Transaction_model')->getTransactionsByUserId($data['user']['id']);
        $data['denda'] = $this->model('Denda_log_model')->getAllDataByUserId($data['user']['id']);
        $this->view('templates/header', $data);
        $this->view('user/profile', $data);
        $this->view('templates/footer');
    }

    public function updateProfile()
    {
        // Hanya izinkan akses jika method adalah POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Pastikan user sedang login dan memiliki ID user di sesi
            if (!isset($_SESSION['user_id'])) {
                Flasher::setFlash('Silakan login terlebih dahulu.', 'danger');
                header('Location: ' . BASEURL . '/login');
                exit;
            }

            $userId = $_SESSION['user_id'];
            $data = [
                'id_user' => $userId,
                'fullname' => $_POST['nama_lengkap'],
                'alamat' => $_POST['alamat'],
                'no_telepon' => $_POST['no_telepon'],
            ];

            // Handle Photo Upload
            $currentPhoto = $this->model('User_model')->getUserById($userId)['photo']; // Get current photo name
            $newPhotoName = $currentPhoto; // Initialize with current photo name

            if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'img/profile/'; // Directory for profile photos (relative to your public folder)
                $photoName = $_FILES['profile_photo']['name'];
                $photoTmpName = $_FILES['profile_photo']['tmp_name'];
                $photoSize = $_FILES['profile_photo']['size'];
                $photoError = $_FILES['profile_photo']['error'];
                $photoType = $_FILES['profile_photo']['type'];

                // Get file extension
                $fileExt = explode('.', $photoName);
                $fileActualExt = strtolower(end($fileExt));

                $allowed = array('jpg', 'jpeg', 'png', 'gif'); // Allowed file types

                if (in_array($fileActualExt, $allowed)) {
                    if ($photoError === 0) {
                        if ($photoSize < 5000000) { // Max 5MB
                            // Generate unique file name
                            $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                            $fileDestination = $uploadDir . $fileNameNew;

                            if (move_uploaded_file($photoTmpName, $fileDestination)) {
                                // If previous photo exists and is not default, delete it
                                if ($currentPhoto && $currentPhoto != 'default.jpg' && file_exists($uploadDir . $currentPhoto)) {
                                    unlink($uploadDir . $currentPhoto);
                                }
                                $newPhotoName = $fileNameNew;
                            } else {
                                Flasher::setFlash('Gagal mengunggah foto profil.', 'danger');
                                header('Location: ' . BASEURL . '/user/profile');
                                exit;
                            }
                        } else {
                            Flasher::setFlash('Ukuran foto terlalu besar (maks 5MB).', 'danger');
                            header('Location: ' . BASEURL . '/user/profile');
                            exit;
                        }
                    } else {
                        Flasher::setFlash('Terjadi kesalahan saat mengunggah foto.', 'danger');
                        header('Location: ' . BASEURL . '/user/profile');
                        exit;
                    }
                } else {
                    Flasher::setFlash('Tipe file foto tidak didukung.', 'danger');
                    header('Location: ' . BASEURL . '/user/profile');
                    exit;
                }
            }
            $data['photo'] = $newPhotoName;
            $_SESSION['photo'] = $newPhotoName;
            // Call model to update user data
            if ($this->model('User_model')->updateUserProfile($data) > 0) {
                Flasher::setFlash('Profil berhasil diperbarui!', 'success');
            } else {
                Flasher::setFlash('Gagal memperbarui profil. Tidak ada perubahan atau terjadi kesalahan.', 'warning');
            }

            header('Location: ' . BASEURL . '/user/profile');
            exit;
        } else {
            header('Location: ' . BASEURL . '/user/profile');
            exit;
        }
    }

    public function detail($id)
    {
        $data['buku'] = $this->model('Buku_model')->getBukuById($id);
        if (!$data['buku']) {
            // Handle jika buku tidak ditemukan, misalnya tampilkan error page
            header('Location: ' . BASEURL); // Atau arahkan ke halaman buku
            exit;
        }
        $userId = $_SESSION['user_id'];
        $data['judul'] = 'Detail Buku: ' . $data['buku']['judul'];
        $data['peminjaman_aktif'] = $this->model('Peminjaman_model')->getPeminjamanByBukuIdAndUserId($id, $userId);
        $this->view('templates/header', $data);
        $this->view('user/detail', $data);
        $this->view('templates/footer');
    }

    public function tambahBookmark($bookId)
    {
        $userId = $_SESSION['user_id'];
        if ($this->model('User_model')->tambahBookmark($userId, $bookId) > 0) {
            Flasher::setFlash('Berhasil ditambahkan ke bookmark', 'success');
        } else {
            Flasher::setFlash('Gagal menambahkan ke bookmark (mungkin sudah ada)', 'warning');
        }
        header('Location: ' . BASEURL . '/user/detail/' . $bookId);
        exit;
    }

    public function hapusDariBookmark($bookId)
    {
        $userId = $_SESSION['user_id'];

        if ($this->model('User_model')->hapusBookmark($userId, $bookId) > 0) {
            Flasher::setFlash('Berhasil', 'dihapus dari bookmark', 'success');
        } else {
            Flasher::setFlash('Gagal', 'menghapus dari bookmark (mungkin tidak ada)', 'info');
        }
        header('Location: ' . BASEURL . '/user/detail/' . $bookId);
        exit;
    }

    public function bookmark()
    {
        $userId = $_SESSION['user_id'];

        $data['judul'] = 'Bookmark Anda';
        $bookIds = $this->model('User_model')->getBookmarksByUser($userId);
        $data['buku_bookmark'] = [];

        if (!empty($bookIds)) {
            foreach ($bookIds as $bookId) {
                $buku = $this->model('Buku_model')->getBukuById($bookId);
                if ($buku) {
                    $data['buku_bookmark'][] = $buku;
                }
            }
        }

        $this->view('templates/header', $data);
        $this->view('user/bookmark', $data);
        $this->view('templates/footer');
    }

    public function ajukanSewa()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userId = $_SESSION['user_id'];
            $bookId = $_POST['id_buku'];
            $durasi = $_POST['durasi_sewa'];

            $buku = $this->model('Buku_model')->getBukuById($bookId);
            if (!$buku || $buku['sisa'] <= 0) {
                Flasher::setFlash('Gagal mengajukan sewa. Buku tidak tersedia atau habis.', 'danger');
                header('Location: ' . BASEURL . '/user/detail/' . $bookId);
                exit;
            }

            $existingPeminjaman = $this->model('Peminjaman_model')->getPeminjamanByBukuIdAndUserId($bookId, $userId);
            if ($existingPeminjaman) {
                Flasher::setFlash('Gagal mengajukan sewa. Anda sudah meminjam buku ini atau sedang dalam proses persetujuan.', 'warning');
                header('Location: ' . BASEURL . '/user/detail/' . $bookId);
                exit;
            }

            $isEbook = $buku['pdf_file'] == '' ? 'N' : 'Y';
            $data = [
                'id_user' => $userId,
                'id_buku' => $bookId,
                'durasi' => $durasi,
                'isEbook' => $isEbook,
            ];


            if ($this->model('Peminjaman_model')->ajukanPeminjaman($data) > 0) {
                $lastPeminjaman = $this->model('Peminjaman_model')->getLatestPeminjamanByUserId($userId);
                $this->model('Peminjaman_log_model')->create($lastPeminjaman['id_peminjaman'], $userId, $bookId, $lastPeminjaman['status'], $lastPeminjaman['catatan_admin']);
                $this->model('Buku_model')->decreaseSisaBuku($bookId);
                Flasher::setFlash('Berhasil mengajukan sewa. Menunggu persetujuan admin.', 'success');
            } else {
                Flasher::setFlash('Gagal mengajukan sewa.', 'danger');
            }
            header('Location: ' . BASEURL . '/user/detail/' . $bookId);
            exit;
        } else {
            header('Location: ' . BASEURL . '/user');
            exit;
        }
    }

    // Fungsi untuk menampilkan buku yang sedang dipinjam (halaman "Bukuku" baru)
    public function bukuku()
    {
        $userId = $_SESSION['user_id'];
        $data['judul'] = 'Buku Pinjaman Saya';
        $data['buku_dipinjam'] = $this->model('Peminjaman_model')->getBukuDipinjamByUserId($userId);

        // Update status terlambat secara real-time jika diperlukan
        foreach ($data['buku_dipinjam'] as $key => $peminjaman) {
            if ($peminjaman['status'] == 'disetujui') {
                $tanggal_kembali_expected = new DateTime($peminjaman['tanggal_kembali_expected']);
                $today = new DateTime();
                if ($today > $tanggal_kembali_expected) {
                    $this->model('Peminjaman_model')->updateStatusPeminjaman($peminjaman['id_peminjaman'], 'terlambat', 'Terlambat dikembalikan');
                    $data['buku_dipinjam'][$key]['status'] = 'terlambat';
                }
            }
        }

        $this->view('templates/header', $data);
        $this->view('user/bukuku', $data);
        $this->view('templates/footer');
    }

    public function riwayatPeminjaman()
    {
        $userId = $_SESSION['user_id'];
        $data['judul'] = 'Riwayat Peminjaman';
        $data['riwayat_peminjaman'] = $this->model('Peminjaman_model')->getRiwayatPeminjamanByUserId($userId);

        $this->view('templates/header', $data);
        $this->view('user/riwayat_peminjaman', $data); // Menggunakan view baru
        $this->view('templates/footer');
    }

    public function batalkanPeminjaman($id_peminjaman)
    {
        $peminjaman = $this->model('Peminjaman_model')->getPeminjamanById($id_peminjaman);

        if (!$peminjaman || $peminjaman['id_user'] != $_SESSION['user_id'] || $peminjaman['status'] != 'proses') {
            Flasher::setFlash('Gagal membatalkan peminjaman. Peminjaman tidak ditemukan atau tidak dapat dibatalkan.', 'danger');
            header('Location: ' . BASEURL . '/user/bukuku');
            exit;
        }

        if ($this->model('Peminjaman_model')->updateStatusPeminjaman($id_peminjaman, 'ditolak', 'Dibatalkan oleh pengguna') > 0) {
            // Kembalikan stok buku
            $this->model('Buku_model')->increaseSisaBuku($peminjaman['id_buku']);
            Flasher::setFlash('Berhasil membatalkan peminjaman.', 'success');
        } else {
            Flasher::setFlash('Gagal membatalkan peminjaman.', 'danger');
        }
        header('Location: ' . BASEURL . '/user/bukuku');
        exit;
    }

    public function perpanjangPeminjaman()
    {
        if (!isset($_SESSION['user_id'])) {
            Flasher::setFlash('Silahkan login terlebih dahulu untuk memperpanjang buku', 'danger');
            header('Location: ' . BASEURL . '/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_peminjaman = $_POST['id_peminjaman'];
            $durasi_perpanjang = $_POST['durasi_perpanjang']; // This is the number of days (1, 3, or 7)

            $peminjaman = $this->model('Peminjaman_model')->getPeminjamanById($id_peminjaman);

            if (!$peminjaman || $peminjaman['id_user'] != $_SESSION['user_id'] || !in_array($peminjaman['status'], ['disetujui', 'terlambat'])) {
                Flasher::setFlash('Gagal memperpanjang peminjaman Peminjaman tidak ditemukan atau tidak dapat diperpanjang.', 'danger');
                header('Location: ' . BASEURL . '/user/bukuku');
                exit;
            }

            // Calculate the new expected return date
            $current_tanggal_kembali_expected = new DateTime($peminjaman['tanggal_kembali_expected']);
            $current_tanggal_kembali_expected->modify("+" . $durasi_perpanjang . " days");
            $tanggal_kembali_baru = $current_tanggal_kembali_expected->format('Y-m-d');


            if ($this->model('Peminjaman_model')->perpanjangPeminjaman($id_peminjaman, $tanggal_kembali_baru) > 0) {
                // If the status was 'terlambat', change it back to 'disetujui' after successful extension
                if ($peminjaman['status'] == 'terlambat') {
                    $this->model('Peminjaman_model')->updateStatusPeminjaman($id_peminjaman, 'disetujui');
                }
                Flasher::setFlash('Peminjaman berhasil diperpanjang Tanggal kembali baru: ' . date('d M Y', strtotime($tanggal_kembali_baru)), 'success');
            } else {
                Flasher::setFlash('Perpanjangan peminjaman gagal Terjadi kesalahan', 'danger');
            }
            header('Location: ' . BASEURL . '/user/bukuku');
            exit;
        } else {
            header('Location: ' . BASEURL . '/user/bukuku');
            exit;
        }
    }
    // New search method
    public function search()
    {
        $query = isset($_GET['query']) ? htmlspecialchars($_GET['query']) : '';
        $selectedCategory = isset($_GET['kategori']) ? htmlspecialchars($_GET['kategori']) : '';
        $selectedSort = isset($_GET['sort']) ? htmlspecialchars($_GET['sort']) : 'latest'; // Default sort
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 8; // Number of books per page

        $data['kategori'] = $this->model('Buku_model')->getKategori(); // Get all categories for the filter dropdown

        $offset = ($currentPage - 1) * $limit;

        if (empty($query) && empty($selectedCategory)) {
            // Get all books if no query or category filter
            $totalBooks = $this->model('Buku_model')->countAllBuku();
            $data['buku_results'] = $this->model('Buku_model')->getAllBukuWithPagination($limit, $offset, $selectedSort);
            $data['judul'] = 'Semua Buku';
        } else {
            // Search and filter books
            $totalBooks = $this->model('Buku_model')->countSearchBuku($query, $selectedCategory);
            $data['buku_results'] = $this->model('Buku_model')->searchBukuWithFilters($query, $selectedCategory, $limit, $offset, $selectedSort);
            $data['judul'] = 'Hasil Pencarian: "' . $query . '"';
            if (!empty($selectedCategory)) {
                $categoryName = '';
                foreach ($data['kategori'] as $cat) {
                    if ($cat['id'] == $selectedCategory) {
                        $categoryName = $cat['nama'];
                        break;
                    }
                }
                if (!empty($categoryName)) {
                    $data['judul'] .= ' di Kategori: ' . $categoryName;
                }
            }
        }

        $data['search_query'] = $query;
        $data['selected_category'] = $selectedCategory;
        $data['selected_sort'] = $selectedSort;
        $data['current_page'] = $currentPage;
        $data['total_pages'] = ceil($totalBooks / $limit);

        $this->view('templates/header', $data);
        $this->view('user/search_results', $data);
        $this->view('templates/footer');
    }
}
