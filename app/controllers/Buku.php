<?php

class Buku extends Controller
{
    public function index()
    {
        $data['judul'] = 'Manajemen Buku';
        $data['buku'] = $this->model('Buku_model')->getAllBuku();
        $this->view('templates/headerAdmin', $data);
        $this->view('admin/buku/index', $data);
        $this->view('templates/footerAdmin');
    }

    public function tambah()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $namaFileGambar = null;
            $namaFilePdf = null;

            if (isset($_FILES['gambar_buku_modal']) && $_FILES['gambar_buku_modal']['error'] !== UPLOAD_ERR_NO_FILE) {
                $hasilUploadGambar = $this->uploadGambar();

                if ($hasilUploadGambar['error']) {
                    Flasher::setFlash('Gagal: ' . $hasilUploadGambar['message'], 'danger');
                    header('Location: ' . BASEURL . '/admin/buku');
                    exit;
                }
                $namaFileGambar = $hasilUploadGambar['file_name'];
            } else {
                Flasher::setFlash('Gagal: Gambar sampul buku wajib diupload.', 'danger');
                header('Location: ' . BASEURL . '/admin/buku');
                exit;
            }

            // 3. Tangani Upload PDF (Opsional)
            // Cek apakah pengguna memilih untuk mengupload file PDF
            if (isset($_FILES['file_buku_modal']) && $_FILES['file_buku_modal']['error'] !== UPLOAD_ERR_NO_FILE) {
                $hasilUploadPdf = $this->uploadFileBuku(); // Panggil fungsi upload PDF Anda

                // Jika ada file dipilih TAPI uploadnya gagal, hentikan proses
                if ($hasilUploadPdf['error']) {
                    Flasher::setFlash('Gagal: ' . $hasilUploadPdf['message'], 'danger');
                    header('Location: ' . BASEURL . '/admin/buku');
                    exit;
                }
                // Jika berhasil, simpan nama filenya
                $namaFilePdf = $hasilUploadPdf['file_name'];
            }

            $dataToInsert = [
                'id_kategori' => $_POST['kategori_buku_modal'],
                'pdf_file' => $namaFilePdf,
                'judul' => $_POST['judul_buku_modal'],
                'penulis' => $_POST['penulis_buku_modal'],
                'deskripsi' => $_POST['deskripsi_buku_modal'],
                'gambar' => $namaFileGambar,
                'jumlah' => $_POST['jumlah_buku_modal']
            ];

            if ($this->model('Buku_model')->tambahBuku($dataToInsert) > 0) {
                Flasher::setFlash('Data buku berhasil ditambahkan', 'success');
            } else {
                Flasher::setFlash('Data buku gagal ditambahkan', 'danger');
            }

            header('Location: ' . BASEURL . '/admin/buku');
            exit;
        } else {
            $this->redirect('admin/buku');
        }
    }

    public function ubah($id)
    {
        // Bagian ini untuk menangani TAMPILAN form (GET request)
        // Logika Anda di sini sudah bagus, jadi kita pertahankan.
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $data['judul'] = 'Ubah Data Buku';
            $data['buku'] = $this->model('Buku_model')->getBukuById($id);
            // Penting: jika buku tidak ditemukan, beri pesan error
            if (!$data['buku']) {
                Flasher::setFlash('Data buku tidak ditemukan.', 'danger');
                header('Location: ' . BASEURL . '/admin/buku');
                exit;
            }
            $data['kategori'] = $this->model('Buku_model')->getKategori();
            $this->view('templates/headerAdmin', $data);
            $this->view('admin/buku/ubah', $data); // Pastikan view ini ada
            $this->view('templates/footerAdmin');
            return; // Hentikan eksekusi setelah menampilkan view
        }

        // Bagian ini untuk MEMPROSES data form (POST request)
        // 1. Ambil data buku saat ini dari database.
        // Ini lebih aman daripada mengandalkan input hidden dan berguna untuk menghapus file lama.
        $bukuSaatIni = $this->model('Buku_model')->getBukuById($id);
        if (!$bukuSaatIni) {
            Flasher::setFlash('Gagal: Data buku yang akan diubah tidak ada.', 'danger');
            header('Location: ' . BASEURL . '/admin/buku');
            exit;
        }

        // 2. Inisialisasi nama file dengan NAMA FILE LAMA.
        $namaFileGambar = $bukuSaatIni['gambar_buku']; // Ganti dengan nama kolom Anda
        $namaFilePdf = $bukuSaatIni['pdf_file'];    // Ganti dengan nama kolom Anda

        // 3. Proses upload GAMBAR BARU (jika ada)
        if (isset($_FILES['gambar_buku_modal']) && $_FILES['gambar_buku_modal']['error'] !== UPLOAD_ERR_NO_FILE) {
            $hasilUploadGambar = $this->uploadGambar(); // Panggil fungsi upload gambar
            if ($hasilUploadGambar['error']) {
                Flasher::setFlash('Gagal ubah gambar: ' . $hasilUploadGambar['message'], 'danger');
                header('Location: ' . BASEURL . '/admin/buku');
                exit;
            }
            // Jika berhasil, gunakan nama file baru dan hapus gambar lama
            $namaFileGambar = $hasilUploadGambar['file_name'];
            // Hapus file lama (jika ada dan bukan file default)
            if ($bukuSaatIni['gambar_buku'] && file_exists('../public/img/cover/' . $bukuSaatIni['gambar_buku'])) {
                unlink('../public/img/cover/' . $bukuSaatIni['gambar_buku']);
            }
        }

        // 4. Proses upload PDF BARU atau HAPUS PDF LAMA (jika ada)
        // Opsi 1: Pengguna mencentang checkbox untuk menghapus PDF
        if (isset($_POST['hapus_pdf_saat_ini']) && $_POST['hapus_pdf_saat_ini'] == '1') {
            // Hapus file lama jika ada
            if ($bukuSaatIni['pdf_file'] && file_exists('../public/pdf/' . $bukuSaatIni['pdf_file'])) {
                unlink('../public/pdf/' . $bukuSaatIni['pdf_file']);
            }
            $namaFilePdf = null; // Set nama file PDF menjadi null
        }
        // Opsi 2: Pengguna mengupload PDF baru
        elseif (isset($_FILES['file_buku_modal']) && $_FILES['file_buku_modal']['error'] !== UPLOAD_ERR_NO_FILE) {
            $hasilUploadPdf = $this->uploadFileBuku(); // Panggil fungsi upload PDF
            if ($hasilUploadPdf['error']) {
                Flasher::setFlash('Gagal ubah file PDF: ' . $hasilUploadPdf['message'], 'danger');
                header('Location: ' . BASEURL . '/admin/buku');
                exit;
            }
            // Jika berhasil, gunakan nama file baru dan hapus file PDF lama
            $namaFilePdf = $hasilUploadPdf['file_name'];
            if ($bukuSaatIni['pdf_file'] && file_exists('../public/pdf/' . $bukuSaatIni['pdf_file'])) {
                unlink('../public/pdf/' . $bukuSaatIni['pdf_file']);
            }
        }
        // 5. Siapkan data final untuk diupdate ke database
        $dataToUpdate = [
            'id_buku' => $id,
            'id_kategori' => $_POST['kategori_buku_modal'],
            'pdf_file' => $namaFilePdf,
            'judul' => $_POST['judul_buku_modal'],
            'penulis' => $_POST['penulis_buku_modal'],
            'deskripsi' => $_POST['deskripsi_buku_modal'],
            'gambar' => $namaFileGambar,
            'jumlah' => $_POST['jumlah_buku_modal']
        ];

        if ($this->model('Buku_model')->ubahBuku($dataToUpdate) > 0) {
            Flasher::setFlash('Data buku berhasil diubah', 'success');
        } else {
            Flasher::setFlash('Tidak ada data yang diubah', 'info');
        }
        header('Location: ' . BASEURL . '/admin/buku');
        exit;
    }

    public function hapus($id)
    {
        if ($this->model('Buku_model')->hapusBuku($id) > 0) {
            Flasher::setFlash('Berhasil dihapus', 'success');
        } else {
            Flasher::setFlash('Gagal dihapus', 'danger');
        }
        header('Location: ' . BASEURL . '/admin/buku');
    }

    private function uploadGambar()
    {
        $namaFile = $_FILES['gambar_buku_modal']['name'];
        $ukuranFile = $_FILES['gambar_buku_modal']['size'];
        $error = $_FILES['gambar_buku_modal']['error'];
        $tmpName = $_FILES['gambar_buku_modal']['tmp_name'];

        if ($error === 4) {
            return ['error' => true, 'message' => 'Tidak ada gambar yang diupload.'];
        }

        $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
        $ekstensiGambar = explode('.', $namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar));

        if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
            return ['error' => true, 'message' => 'Ekstensi gambar yang diupload tidak valid.'];
        }

        if ($ukuranFile > 1000000) { // Contoh batasan 1MB
            return ['error' => true, 'message' => 'Ukuran gambar yang diupload terlalu besar.'];
        }

        $namaFileBaru = uniqid();
        $namaFileBaru .= '.' . $ekstensiGambar;

        move_uploaded_file($tmpName,  '../public/img/' . $namaFileBaru);
        return ['error' => false, 'file_name' => $namaFileBaru];
    }

    private function uploadFileBuku()
    {

        $namaFile = $_FILES['file_buku_modal']['name'];
        $ukuranFile = $_FILES['file_buku_modal']['size'];
        $error = $_FILES['file_buku_modal']['error'];
        $tmpName = $_FILES['file_buku_modal']['tmp_name'];

        // Cek jika tidak ada file yang diupload (error code 4)
        if ($error === 4) {
            return ['error' => true, 'message' => 'Tidak ada file PDF yang diupload.'];
        }

        // --- Validasi Ekstensi ---
        $ekstensiFileValid = ['pdf'];
        $ekstensiFile = explode('.', $namaFile);
        $ekstensiFile = strtolower(end($ekstensiFile)); // Ambil ekstensi dan ubah ke huruf kecil

        if (!in_array($ekstensiFile, $ekstensiFileValid)) {
            return ['error' => true, 'message' => 'Ekstensi file yang diupload tidak valid. Hanya file .pdf yang diperbolehkan.'];
        }

        // --- Validasi Ukuran File ---
        // Batasan 5MB (5 * 1024 * 1024 bytes). Anda bisa sesuaikan.
        if ($ukuranFile > 10485760) {
            return ['error' => true, 'message' => 'Ukuran file PDF yang diupload terlalu besar (maks 10MB).'];
        }

        // --- Proses Upload Jika Lolos Validasi ---

        // Buat nama file baru yang unik untuk menghindari nama file yang sama
        $namaFileBaru = uniqid('ebook_');
        $namaFileBaru .= '.' . $ekstensiFile;

        // Tentukan folder tujuan
        $lokasiTujuan = '../public/files/pdf/' . $namaFileBaru;

        // Pindahkan file dari temporary location ke folder tujuan
        if (move_uploaded_file($tmpName, $lokasiTujuan)) {
            // Jika berhasil, kembalikan nama file baru
            return ['error' => false, 'file_name' => $namaFileBaru];
        } else {
            // Jika gagal memindahkan file
            return ['error' => true, 'message' => 'Gagal memindahkan file yang diupload.'];
        }
    }
}
