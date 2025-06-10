<style>
    /* Ensure Ubuntu font is used, if available */
    * {
        font-family: "Ubuntu", sans-serif;
    }

    body {
        overflow-x: hidden;
    }

    /* General action button styling */
    .action-button {
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        /* More rounded corners */
        font-weight: 600;
        /* Semibold */
        transition: all 0.2s ease-in-out;
        /* Smooth transition for all properties */
        display: inline-flex;
        /* Use flex for alignment */
        align-items: center;
        /* Center content vertically */
        justify-content: center;
        /* Center content horizontally */
        text-align: center;
        cursor: pointer;
        font-size: 0.875rem;
        /* Slightly smaller font for buttons */
        border: none;
        /* Remove default button border */
    }

    .action-button:hover {
        transform: translateY(-1px);
        /* Slight lift on hover */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        /* Subtle shadow on hover */
    }

    /* Adjusted button colors based on your provided code */
    .action-button-green {
        /* For 'Setujui' and 'Kembalikan' */
        background-color: #a0522d;
        /* Sienna */
        color: white;
    }

    .action-button-green:hover {
        background-color: #8b4513;
        /* Darker Sienna */
    }

    .action-button-blue {
        /* For 'Perpanjang' */
        background-color: #FFC857;
        /* Orange/Amber */
        color: #424242;
        /* Darker text for contrast */
    }

    .action-button-blue:hover {
        background-color: #FFD28F;
        /* Lighter Orange/Amber */
    }

    .action-button-red {
        /* For 'Tolak' */
        background-color: #dc3545;
        /* Keeping standard red for danger, or could use a darker brown */
        color: white;
    }

    .action-button-red:hover {
        background-color: #c82333;
    }

    .action-button-gray {
        background-color: #6c757d;
        /* Keeping standard gray for inactive */
        color: white;
    }

    .action-button-gray:hover {
        background-color: #5a6268;
    }

    /* Status badge styling */
    .status-badge {
        padding: 0.35rem 0.85rem;
        /* Slightly more padding */
        border-radius: 9999px;
        font-weight: 600;
        display: inline-block;
        text-align: center;
        white-space: nowrap;
        font-size: 0.75rem;
        /* Smaller font for badges */
        line-height: 1;
        /* Ensure proper vertical alignment */
    }

    /* Adjusted status badge colors based on your provided code's aesthetic */
    .status-proses {
        background-color: #FFC857;
        /* Orange/Amber */
        color: #424242;
        /* Darker text for contrast */
        border: 1px solid #FFD28F;
    }

    .status-disetujui {
        background-color: #d4edda;
        /* Light green - can be adjusted if a brown tone is preferred */
        color: #155724;
        /* Dark green */
        border: 1px solid #c3e6cb;
    }

    .status-ditolak {
        background-color: #f8d7da;
        /* Light red */
        color: #721c24;
        /* Dark red */
        border: 1px solid #f5c6cb;
    }

    .status-dikembalikan {
        background-color: #EFE5DB;
        /* Light beige - matching your provided code's background */
        color: #a0522d;
        /* Sienna text */
        border: 1px solid #d6d8db;
    }

    .status-terlambat {
        background-color: #fddde6;
        /* Keeping a pink/purple tone for warning */
        color: #880e4f;
        /* Darker text for contrast */
        border: 1px solid #fbc4d4;
    }

    /* Table styling */
    .table-header {
        background-color: #EFE5DB;
        /* Light beige for table header, matching your reference */
        color: #a0522d;
        /* Sienna text */
        font-weight: 700;
        /* Bold headers */
    }

    .table-row-hover:hover {
        background-color: #f1f3f5;
        /* Lighter hover effect */
    }

    /* Modal Styling */
    .modal-content {
        background-color: #EFE5DB;
        /* Light beige for modal background */
        border-radius: 0.75rem;
        /* More rounded corners */
        padding: 2.5rem;
        /* More padding */
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1),
            0 4px 6px -2px rgba(0, 0, 0, 0.05);
        /* Stronger shadow */
    }

    .modal-header {
        border-bottom: 1px solid #d4c1ad;
        /* Slightly darker beige border */
        padding-bottom: 1rem;
        margin-bottom: 1.5rem;
    }

    .modal-footer {
        border-top: 1px solid #d4c1ad;
        /* Slightly darker beige border */
        padding-top: 1.5rem;
        margin-top: 2rem;
    }
</style>

<div class="p-4 sm:ml-64 mt-20">
    <?php Flasher::flash(); ?>
    <h1 class="text-4xl font-extrabold text-[#424242] mb-8">Aktifitas Peminjaman Buku</h1>

    <?php if (empty($data['peminjaman'])) : ?>
        <div class="bg-[#EFE5DB] p-8 rounded-lg shadow-md text-center">
            <p class="text-lg text-[#a0522d]">Belum ada data peminjaman yang tersedia saat ini.</p>
        </div>
    <?php else : ?>
        <div class="relative overflow-x-auto  sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs uppercase table-header">
                    <tr>
                        <th scope="col" class="py-3 px-6">No.</th>
                        <th scope="col" class="py-3 px-6">User</th>
                        <th scope="col" class="py-3 px-6">Buku</th>
                        <th scope="col" class="py-3 px-6">Tgl Pinjam</th>
                        <th scope="col" class="py-3 px-6">Tgl Kembali (Ekspektasi)</th>
                        <th scope="col" class="py-3 px-6">Tgl Kembali (Aktual)</th>
                        <th scope="col" class="py-3 px-6">Status</th>
                        <th scope="col" class="py-3 px-6">Catatan Admin</th>
                        <th scope="col" class="py-3 px-6">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($data['peminjaman'] as $peminjaman) : ?>
                        <tr class="bg-[#EFE5DB]">
                            <td class="py-4 px-6 font-medium text-gray-900"><?= $no++; ?></td>
                            <td class="py-4 px-6"><?= $peminjaman['username']; ?></td>
                            <td class="py-4 px-6"><?= $peminjaman['judul']; ?></td>
                            <td class="py-4 px-6"><?= date('d M Y', strtotime($peminjaman['tanggal_peminjaman'])); ?></td>
                            <td class="py-4 px-6"><?= date('d M Y', strtotime($peminjaman['tanggal_kembali_expected'])); ?></td>
                            <td class="py-4 px-6"><?= $peminjaman['tanggal_kembali_actual'] ? date('d M Y', strtotime($peminjaman['tanggal_kembali_actual'])) : '-'; ?></td>
                            <td class="py-4 px-6">
                                <span class="status-badge status-<?= strtolower($peminjaman['status']); ?>">
                                    <?= ucfirst($peminjaman['status']); ?>
                                </span>
                                <?php
                                if ($peminjaman['status'] == 'disetujui' && strtotime($peminjaman['tanggal_kembali_expected']) < time() && !$peminjaman['tanggal_kembali_actual']) {
                                    $diff = date_diff(date_create($peminjaman['tanggal_kembali_expected']), date_create());
                                    $days_late = $diff->days;
                                    if ($diff->invert == 0) { // Check if the interval is positive (past due)
                                        echo '<br><span class="text-red-700 text-xs font-semibold mt-1 block">Terlambat ' . $days_late . ' hari</span>';
                                    }
                                }
                                ?>
                            </td>
                            <td class="py-4 px-6 text-gray-700"><?= $peminjaman['catatan_admin'] ?: '-'; ?></td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                <?php if ($peminjaman['status'] == 'proses') : ?>
                                    <a href="<?= BASEURL; ?>/admin/setujuiPeminjaman/<?= $peminjaman['id_peminjaman']; ?>" class="action-button action-button-green mr-2">Setujui</a>
                                    <button type="button" class="action-button action-button-red"
                                        data-modal-target="tolak-modal"
                                        data-id-peminjaman="<?= $peminjaman['id_peminjaman']; ?>"
                                        onclick="openTolakModal(this)">Tolak</button>
                                <?php elseif ($peminjaman['status'] == 'disetujui' || $peminjaman['status'] == 'terlambat') : ?>
                                    <button type="button" class="action-button action-button-blue mr-2"
                                        data-modal-target="perpanjang-admin-modal"
                                        data-id-peminjaman="<?= $peminjaman['id_peminjaman']; ?>"
                                        data-tanggal-kembali-expected="<?= $peminjaman['tanggal_kembali_expected']; ?>"
                                        onclick="openPerpanjangModal(this)">Perpanjang</button>
                                    <a href="<?= BASEURL; ?>/admin/kembalikanBuku/<?= $peminjaman['id_peminjaman']; ?>" class="action-button action-button-green">Kembalikan</a>
                                <?php elseif ($peminjaman['status'] == 'dikembalikan' || $peminjaman['status'] == 'ditolak') : ?>
                                    <span class="action-button action-button-gray opacity-75 cursor-not-allowed">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<div id="tolak-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative rounded-lg shadow modal-content">
            <button type="button" class="absolute top-4 right-4 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="tolak-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-4 md:p-5 text-center">
                <h3 class="mb-5 text-xl font-semibold text-[#424242] modal-header">Tolak Peminjaman</h3>
                <p class="mb-6 text-gray-600">Apakah Anda yakin ingin menolak permintaan peminjaman ini?</p>
                <form id="form-tolak-peminjaman" method="POST">
                    <input type="hidden" name="id_peminjaman_to_tolak" id="id_peminjaman_to_tolak">
                    <div class="mb-5 text-left">
                        <label for="catatan_penolakan" class="block mb-2 text-sm font-medium text-gray-900">Catatan Penolakan (Opsional):</label>
                        <textarea id="catatan_penolakan" name="catatan_penolakan" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-[#a0522d] focus:border-[#a0522d]" placeholder="Berikan alasan penolakan..."></textarea>
                    </div>
                    <div class="modal-footer flex justify-center space-x-4">
                        <button type="submit" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-6 py-2.5 text-center">
                            Ya, Tolak
                        </button>
                        <button data-modal-hide="tolak-modal" type="button" class="py-2.5 px-6 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-300 hover:bg-gray-100 hover:text-[#a0522d] focus:z-10 focus:ring-4 focus:ring-gray-200">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="perpanjang-admin-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative rounded-lg shadow modal-content">
            <button type="button" class="absolute top-4 right-4 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="perpanjang-admin-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-4 md:p-5 text-center">
                <h3 class="mb-5 text-xl font-semibold text-[#424242] modal-header">Perpanjang Peminjaman</h3>
                <p class="mb-6 text-gray-600">Pilih tanggal kembali yang baru untuk perpanjangan ini.</p>
                <form id="form-perpanjang-admin-peminjaman" method="POST">
                    <input type="hidden" name="id_peminjaman_to_perpanjang" id="id_peminjaman_to_perpanjang">
                    <div class="mb-5 text-left">
                        <label for="new_tanggal_kembali_admin" class="block mb-2 text-sm font-medium text-gray-900">Tanggal Kembali Baru:</label>
                        <input type="date" id="new_tanggal_kembali_admin" name="new_tanggal_kembali" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-[#a0522d] focus:border-[#a0522d]" required>
                    </div>
                    <div class="modal-footer flex justify-center space-x-4">
                        <button type="submit" class="text-white bg-[#a0522d] hover:bg-[#8b4513] focus:ring-4 focus:outline-none focus:ring-[#a0522d]/50 font-medium rounded-lg text-sm px-6 py-2.5 text-center">
                            Perpanjang
                        </button>
                        <button data-modal-hide="perpanjang-admin-modal" type="button" class="py-2.5 px-6 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-300 hover:bg-gray-100 hover:text-[#a0522d] focus:z-10 focus:ring-4 focus:ring-gray-200">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.bundle.min.js"></script>
<script>
    // Function to open "Tolak" modal and set the ID
    function openTolakModal(button) {
        const peminjamanId = button.dataset.idPeminjaman;
        document.getElementById('id_peminjaman_to_tolak').value = peminjamanId;
        document.getElementById('form-tolak-peminjaman').action = `<?= BASEURL; ?>/admin/tolakPeminjaman/${peminjamanId}`;
        const modal = new Modal(document.getElementById('tolak-modal'));
        modal.show();
    }

    // Function to open "Perpanjang" modal and set the ID and current expected return date
    function openPerpanjangModal(button) {
        const peminjamanId = button.dataset.idPeminjaman;
        const tanggalKembaliExpected = button.dataset.tanggalKembaliExpected;

        document.getElementById('id_peminjaman_to_perpanjang').value = peminjamanId;
        document.getElementById('form-perpanjang-admin-peminjaman').action = `<?= BASEURL; ?>/admin/perpanjangPeminjamanOlehAdmin/${peminjamanId}`;

        // Set the minimum date for the date picker to be one day after the current expected return date
        const minDate = new Date(tanggalKembaliExpected);
        minDate.setDate(minDate.getDate() + 1); // Add one day
        document.getElementById('new_tanggal_kembali_admin').min = minDate.toISOString().split('T')[0];
        document.getElementById('new_tanggal_kembali_admin').value = minDate.toISOString().split('T')[0]; // Pre-fill with min date

        const modal = new Modal(document.getElementById('perpanjang-admin-modal'));
        modal.show();
    }
</script>