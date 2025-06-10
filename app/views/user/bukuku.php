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

    .action-button-red {
        background-color: #dc3545;
        color: white;
    }

    .action-button-red:hover {
        background-color: #c82333;
        transform: scale(1.01);
    }

    .action-button-yellow {
        background-color: #ffc107;
        color: white;
    }

    .action-button-yellow:hover {
        background-color: #e0a800;
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

    /* Modal Styling */
    .modal-content {
        background-color: #fcf8f5;
        border-radius: 0.5rem;
        padding: 2rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
            0 2px 4px -1px rgba(0, 0, 0, 0.06);
        text-align: center;
    }
</style>

<div class="p-4 sm:ml-64 mt-20">
    <p class="text-2xl text-[#424242] font-semibold mb-2">Buku Saya</p>
    <div class="p-4 rounded-lg border-2 border-gray-200 border-dashed h-[calc(100vh-110px)] overflow-y-auto main-content">
        <?php Flasher::flash(); ?>
        <?php if (empty($data['buku_dipinjam'])) : ?>
            <p class="text-center text-gray-500 mt-10">Anda belum memiliki buku yang sedang dipinjam.</p>
        <?php else : ?>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($data['buku_dipinjam'] as $peminjaman) : ?>
                    <div class="book-card">
                        <?php if ($peminjaman['gambar']) : ?>
                            <img src="<?= BASEURL; ?>/img/<?= $peminjaman['gambar']; ?>" alt="Sampul Buku <?= $peminjaman['judul']; ?>" class="book-card-image" />
                        <?php else : ?>
                            <img src="https://via.placeholder.com/120x180" alt="No Image" class="book-card-image" />
                        <?php endif; ?>
                        <div class="book-card-info">
                            <h3 class="book-card-title"><?= $peminjaman['judul']; ?></h3>
                            <p class="book-card-author">Oleh: <?= $peminjaman['penulis']; ?></p>
                            <p class="text-sm text-gray-600 mb-2">Dipinjam Sejak: <?= date('d M Y', strtotime($peminjaman['tanggal_peminjaman'])); ?></p>
                            <p class="text-sm text-gray-600 mb-2">Akan Kembali: <?= date('d M Y', strtotime($peminjaman['tanggal_kembali_expected'])); ?></p>
                            <span class="book-card-status status-<?= $peminjaman['status']; ?>">
                                Status: <?= ucfirst($peminjaman['status']); ?>
                            </span>

                            <div class="mt-4 flex flex-wrap gap-2">
                                <?php if ($peminjaman['status'] == 'proses') : ?>
                                    <button type="button" class="action-button action-button-red" data-modal-target="modal-batalkan" data-id="<?= $peminjaman['id_peminjaman']; ?>" onclick="openBatalkanModal(this)">
                                        Batalkan
                                    </button>
                                <?php endif; ?>

                                <?php if (($peminjaman['status'] == 'disetujui' || $peminjaman['status'] == 'terlambat') && $peminjaman['isEbook'] == 'Y') : ?>
                                    <a href="<?= BASEURL; ?>/user/read/<?= $peminjaman['id_buku']; ?>" class="action-button action-button-blue">
                                        Baca
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div id="modal-batalkan" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative modal-content">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">
                    Batalkan Peminjaman
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="modal-batalkan" onclick="closeModal()">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div class="p-4 md:p-5 text-center">
                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <h3 class="mb-5 text-lg font-normal text-gray-500">
                    Apakah Anda yakin ingin membatalkan peminjaman buku ini?
                </h3>
                <form id="form-batalkan-peminjaman" method="post">
                    <input type="hidden" name="id_peminjaman" id="batalkan_id_peminjaman">
                    <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Ya, Batalkan
                    </button>
                    <button data-modal-hide="modal-batalkan" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100" onclick="closeModal()">
                        Tidak
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
<script>
    // Function to open "Batalkan" modal and set the ID
    function openBatalkanModal(button) {
        const peminjamanId = button.dataset.id;
        document.getElementById('batalkan_id_peminjaman').value = peminjamanId;
        const modal = new Modal(document.getElementById('modal-batalkan'));
        modal.show();
    }

    // Function to close modal
    function closeModal() {
        const modal = new Modal(document.getElementById('modal-perpanjang'));
        modal.close();
    }
    document.querySelectorAll('[data-modal-hide]').forEach(button => {
        button.addEventListener('click', () => {
            const modalId = button.getAttribute('data-modal-hide');
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('hidden');
            }
        });
    });
</script>