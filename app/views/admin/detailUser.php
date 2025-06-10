<style>
    /* Ensure Ubuntu font is used, if available */
    * {
        font-family: "Ubuntu", sans-serif;
    }

    body {
        overflow-x: hidden;
    }

    /* General action button styling (retained for consistency if needed elsewhere) */
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

    /* Specific button colors for this theme */
    .action-button-primary {
        /* For 'Setujui' and 'Kembalikan' in other contexts */
        background-color: #a0522d;
        /* Sienna */
        color: white;
    }

    .action-button-primary:hover {
        background-color: #8b4513;
        /* Darker Sienna */
    }

    .action-button-secondary {
        /* For 'Perpanjang' in other contexts */
        background-color: #FFC857;
        /* Orange/Amber */
        color: #424242;
        /* Darker text for contrast */
    }

    .action-button-secondary:hover {
        background-color: #FFD28F;
        /* Lighter Orange/Amber */
    }

    .action-button-danger {
        /* For 'Tolak' or delete actions */
        background-color: #dc3545;
        /* Standard red for danger */
        color: white;
    }

    .action-button-danger:hover {
        background-color: #c82333;
    }

    .action-button-inactive {
        /* For disabled/inactive buttons */
        background-color: #6c757d;
        /* Standard gray */
        color: white;
    }

    .action-button-inactive:hover {
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
        /* Light green */
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
        /* Light beige for table header */
        color: #a0522d;
        /* Sienna text */
        font-weight: 700;
        /* Bold headers */
    }

    .table-row-hover:hover {
        background-color: #f1f3f5;
        /* Lighter hover effect */
    }

    /* Card styling */
    .card {
        background-color: #EFE5DB;
        /* Light beige background for cards */
        border-radius: 0.75rem;
        /* Rounded corners */
        padding: 2rem;
        /* Ample padding */
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        /* Subtle shadow */
    }

    .card-header {
        border-bottom: 1px solid #d4c1ad;
        /* Sienna-toned border */
        padding-bottom: 1rem;
        margin-bottom: 1.5rem;
        color: #424242;
        /* Dark text for header */
        font-weight: 600;
        font-size: 1.5rem;
    }

    .card-body p {
        margin-bottom: 0.75rem;
        /* Spacing for paragraphs in card body */
        color: #424242;
        /* Dark text */
    }

    .card-body strong {
        color: #a0522d;
        /* Sienna for strong text */
    }

    /* Specific styling for fine status */
    .fine-status-paid {
        color: #155724;
        /* Dark green for paid */
        font-weight: 600;
    }

    .fine-status-unpaid {
        color: #dc3545;
        /* Red for unpaid */
        font-weight: 600;
    }
</style>

<div class="p-4 sm:ml-64 mt-20 overflow-y-scroll h-[calc(100vh-110px)]">
    <?php Flasher::flash(); ?>
    <div class="text-4xl font-extrabold text-[#424242] mb-8">
        <a href="<?= BASEURL; ?>/admin/user" class="inline-block">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        Detail User : <span class="font-semibold underline"><?= $data['user']['username']; ?></span>
    </div>

    <div class="card mb-8">
        <h2 class="card-header">Informasi User</h2>
        <div class="card-body grid grid-cols-1 md:grid-cols-2 gap-4">
            <p><strong>Username:</strong> <?= $data['user']['username']; ?></p>
            <p><strong>Nama Lengkap:</strong> <?= $data['user']['fullname'] ?: '-'; ?></p>
            <p><strong>Email:</strong> <?= $data['user']['email'] ?: '-'; ?></p>
            <p><strong>Alamat:</strong> <?= $data['user']['alamat'] ?: '-'; ?></p>
            <p><strong>No. Telepon:</strong> <?= $data['user']['no_telepon'] ?: '-'; ?></p>
            <p><strong>Tanggal Bergabung:</strong> <?= date('d M Y', strtotime($data['user']['created_at'])); ?></p>
            <p><strong>Total Denda:</strong> <?= $data['user']['denda'] ?: '0'; ?></p>

        </div>
    </div>

    <div class="card">
        <h2 class="card-header">Riwayat Peminjaman Buku</h2>
        <?php if (empty($data['peminjaman'])) : ?>
            <p class="text-center text-[#a0522d]">Belum ada riwayat peminjaman buku untuk user ini.</p>
        <?php else : ?>
            <div class="relative overflow-x-auto  sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs uppercase table-header">
                        <tr>
                            <th scope="col" class="py-3 px-6">No.</th>
                            <th scope="col" class="py-3 px-6">Buku</th>
                            <th scope="col" class="py-3 px-6">Tgl Pinjam</th>
                            <th scope="col" class="py-3 px-6">Tgl Kembali (Ekspektasi)</th>
                            <th scope="col" class="py-3 px-6">Tgl Kembali (Aktual)</th>
                            <th scope="col" class="py-3 px-6">Status</th>
                            <th scope="col" class="py-3 px-6">Catatan Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no_history = 1; ?>
                        <?php foreach ($data['peminjaman'] as $peminjaman) : ?>
                            <tr>
                                <td class="py-4 px-6 font-medium text-gray-900"><?= $no_history++; ?></td>
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
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <div class="card" style="margin-top: 20px;">
        <h2 class="card-header">Riwayat Denda</h2>
        <?php if (empty($data['peminjaman'])) : ?>
            <p class="text-center text-[#a0522d]">Belum ada riwayat Denda untuk user ini.</p>
        <?php else : ?>
            <div class="relative overflow-x-auto  sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs uppercase table-header">
                        <tr>
                            <th scope="col" class="py-3 px-6">No.</th>
                            <th scope="col" class="py-3 px-6">Jumlah</th>
                            <th scope="col" class="py-3 px-6">Catatan</th>
                            <th scope="col" class="py-3 px-6">Tanggal</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php $no_history = 1; ?>
                        <?php foreach ($data['denda'] as $denda) : ?>
                            <tr>
                                <td class="py-4 px-6 font-medium text-gray-900"><?= $no_history++; ?></td>
                                <td class="px-4 py-2">Rp. <?= number_format($denda['price'], 0, ',', '.'); ?></td>
                                <td class="py-4 px-6"><?= $denda['catatan']; ?></td>
                                <td class="py-4 px-6"><?= date('d M Y', strtotime($denda['created_at'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.bundle.min.js"></script>