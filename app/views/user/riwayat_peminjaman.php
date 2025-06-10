<style>
    * {
        font-family: "Ubuntu", sans-serif;
    }

    body {
        overflow-x: hidden;
    }

    /* Animasi hover pada sidebar */
    #logo-sidebar a:hover {
        transform: translateX(5px);
    }

    /* Animasi fade-in untuk konten utama */
    .main-content {
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
            transform: translateY(10px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Gaya Streamlit untuk elemen */
    .st-title {
        font-size: 2.5rem;
        color: #424242;
        margin-bottom: 1rem;
    }

    .st-subheader {
        font-size: 1.5rem;
        color: #424242;
        margin-bottom: 0.5rem;
    }

    .st-button {
        background-color: #a0522d;
        color: white;
        font-weight: bold;
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        transition: background-color 0.2s ease-in-out, transform 0.2s ease-in-out;
        cursor: pointer;
        display: inline-block;
        text-align: center;
    }

    .st-button:hover {
        background-color: #8c4525;
        transform: scale(1.01);
    }

    .action-button {
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        font-weight: bold;
        transition: background-color 0.2s ease-in-out, transform 0.2s ease-in-out;
        display: inline-block;
        text-align: center;
    }

    .action-button-blue {
        background-color: #007bff;
        color: white;
    }

    .action-button-blue:hover {
        background-color: #0056b3;
        transform: scale(1.01);
    }

    /* Card untuk setiap buku */
    .book-card {
        background-color: #EFE5DB;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        padding: 1.5rem;
        display: flex;
        gap: 1.5rem;
        align-items: center;
        animation: fadeIn 0.5s ease-in-out;
    }

    .book-card-image {
        width: 120px;
        height: 180px;
        object-fit: cover;
        border-radius: 0.25rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .book-card-info {
        flex-grow: 1;
    }

    .book-card-title {
        font-size: 1.75rem;
        font-weight: bold;
        color: #a0522d;
        margin-bottom: 0.5rem;
    }

    .book-card-author {
        font-size: 1rem;
        color: #424242;
        margin-bottom: 1rem;
    }

    .book-card-status {
        font-weight: 500;
        margin-bottom: 1rem;
        padding: 0.25rem 0.75rem;
        border-radius: 0.25rem;
        display: inline-block;
    }

    .status-proses {
        background-color: #ffc107;
        color: white;
    }

    .status-disetujui {
        background-color: #28a745;
        color: white;
    }

    .status-dikembalikan {
        background-color: #6c757d;
        color: white;
    }

    .status-ditolak {
        background-color: #dc3545;
        color: white;
    }

    .status-terlambat {
        background-color: #d63384;
        color: white;
    }
</style>

<div class="p-4 sm:ml-64 mt-20">
    <p class="text-2xl text-[#424242] font-semibold mb-2">Riwayat Peminjaman</p>
    <div class="p-4 rounded-lg border-2 border-gray-200 border-dashed h-[calc(100vh-110px)] overflow-y-auto main-content">
        <?php Flasher::flash(); ?>
        <?php if (empty($data['riwayat_peminjaman'])) : ?>
            <p class="text-center text-gray-500 mt-10">Anda belum memiliki riwayat peminjaman buku.</p>
        <?php else : ?>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($data['riwayat_peminjaman'] as $peminjaman) : ?>
                    <div class="book-card">
                        <?php if ($peminjaman['gambar']) : ?>
                            <img src="<?= BASEURL; ?>/img/<?= $peminjaman['gambar']; ?>" alt="Sampul Buku <?= $peminjaman['judul']; ?>" class="book-card-image" />
                        <?php else : ?>
                            <img src="https://via.placeholder.com/120x180" alt="No Image" class="book-card-image" />
                        <?php endif; ?>
                        <div class="book-card-info">
                            <h3 class="book-card-title"><?= $peminjaman['judul']; ?></h3>
                            <p class="book-card-author">Oleh: <?= $peminjaman['penulis']; ?></p>
                            <p class="text-sm text-gray-600 mb-2">Tanggal Pinjam: <?= date('d M Y', strtotime($peminjaman['tanggal_peminjaman'])); ?></p>
                            <p class="text-sm text-gray-600 mb-2">Tanggal Kembali (Estimasi): <?= date('d M Y', strtotime($peminjaman['tanggal_kembali_expected'])); ?></p>
                            <?php if ($peminjaman['tanggal_kembali_actual']) : ?>
                                <p class="text-sm text-gray-600 mb-2">Tanggal Dikembalikan: <?= date('d M Y', strtotime($peminjaman['tanggal_kembali_actual'])); ?></p>
                            <?php endif; ?>
                            <span class="book-card-status status-<?= $peminjaman['status']; ?>">
                                Status: <?= ucfirst($peminjaman['status']); ?>
                            </span>
                            <?php if (!empty($peminjaman['catatan_admin'])) : ?>
                                <p class="text-sm text-gray-700 mt-2">Catatan Admin: <?= $peminjaman['catatan_admin']; ?></p>
                            <?php endif; ?>
                            <div class="mt-4 flex flex-wrap gap-2">
                                <a href="<?= BASEURL; ?>/user/detail/<?= $peminjaman['id_buku']; ?>" class="action-button action-button-blue">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>