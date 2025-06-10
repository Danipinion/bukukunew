<style>
    /* Pastikan font Ubuntu digunakan, jika tersedia */
    @import url('https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;600;700&display=swap');

    * {
        font-family: "Ubuntu", sans-serif;
    }

    body {
        overflow-x: hidden;
        overflow-y: auto !important;
    }

    /* Gaya tombol aksi umum */
    .action-button {
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        /* Sudut lebih membulat */
        font-weight: 600;
        /* Semibold */
        transition: all 0.2s ease-in-out;
        /* Transisi halus untuk semua properti */
        display: inline-flex;
        /* Gunakan flex untuk perataan */
        align-items: center;
        /* Pusatkan konten secara vertikal */
        justify-content: center;
        /* Pusatkan konten secara horizontal */
        text-align: center;
        cursor: pointer;
        font-size: 0.875rem;
        /* Ukuran font sedikit lebih kecil untuk tombol */
        border: none;
        /* Hapus border tombol default */
    }

    .action-button:hover {
        transform: translateY(-1px);
        /* Sedikit terangkat saat hover */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        /* Bayangan halus saat hover */
    }

    /* Warna tombol spesifik untuk tema ini */
    .action-button-primary {
        background-color: #a0522d;
        /* Sienna */
        color: white;
    }

    .action-button-primary:hover {
        background-color: #8b4513;
        /* Sienna lebih gelap */
    }

    .action-button-secondary {
        background-color: #FFC857;
        /* Oranye/Amber */
        color: #424242;
        /* Teks lebih gelap untuk kontras */
    }

    .action-button-secondary:hover {
        background-color: #FFD28F;
        /* Oranye/Amber lebih terang */
    }

    .action-button-danger {
        background-color: #dc3545;
        /* Merah standar untuk bahaya */
        color: white;
    }

    .action-button-danger:hover {
        background-color: #c82333;
    }

    /* Gaya kartu */
    .card {
        background-color: #EFE5DB;
        /* Latar belakang krem muda untuk kartu */
        border-radius: 0.75rem;
        /* Sudut membulat */
        padding: 2rem;
        /* Padding yang cukup */
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        /* Bayangan halus */
    }

    .card-header {
        border-bottom: 1px solid #d4c1ad;
        /* Border bernuansa Sienna */
        padding-bottom: 1rem;
        margin-bottom: 1.5rem;
        color: #424242;
        /* Teks gelap untuk header */
        font-weight: 600;
        font-size: 1.5rem;
    }

    /* Gaya untuk input field */
    .profile-input {
        background-color: #f3f4f6;
        /* Latar belakang abu-abu muda */
        border: 1px solid #d1d5db;
        /* Border abu-abu */
        color: #424242;
        /* Warna teks gelap */
        font-size: 0.9rem;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        transition: all 0.2s ease-in-out;
    }

    .profile-input:focus {
        border-color: #a0522d;
        /* Warna border sienna saat fokus */
        outline: none;
        box-shadow: 0 0 0 3px rgba(160, 82, 45, 0.2);
        /* Bayangan fokus sienna */
    }

    .profile-input:disabled {
        background-color: #e5e7eb;
        /* Latar belakang lebih gelap saat disabled */
        cursor: not-allowed;
    }

    /* Gaya label */
    .profile-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #424242;
        font-size: 0.9rem;
    }

    /* Gaya untuk area foto profil */
    .profile-photo-area {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 2rem;
    }

    .profile-photo-area img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #a0522d;
        /* Border sienna */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.2s ease-in-out;
    }

    .profile-photo-area img:hover {
        transform: scale(1.02);
        cursor: pointer;
    }

    .profile-photo-area .upload-button {
        margin-top: 1rem;
        padding: 0.6rem 1.2rem;
        border-radius: 0.375rem;
        background-color: #FFC857;
        /* Oranye/Amber */
        color: #424242;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.2s ease-in-out;
        display: none;
        /* Awalnya tersembunyi */
    }

    .profile-photo-area .upload-button:hover {
        background-color: #FFD28F;
    }

    /* New styles for card-wrapper and table */
    .card-wrapper {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        /* Space between cards */
    }

    .card-wrapper .card {
        padding: 1.5rem;
        /* Slightly less padding for these cards */
    }

    .card-wrapper .card .card-header {
        font-size: 1.3rem;
        /* Slightly smaller header for these cards */
        margin-bottom: 1rem;
    }

    .card-wrapper table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1.5rem;
    }

    .card-wrapper th,
    .card-wrapper td {
        padding: 0.75rem 1rem;
        text-align: left;
        border-bottom: 1px solid #d4c1ad;
        /* Sienna-nuanced border */
        color: #424242;
    }

    .card-wrapper th {
        background-color: #d4c1ad;
        /* Light sienna for table headers */
        font-weight: 600;
        color: #424242;
    }

    .card-wrapper tbody tr:last-child td {
        border-bottom: none;
        /* No border on the last row */
    }

    .card-wrapper .action-button-download {
        background-color: #5cb85c;
        /* Green for download */
        color: white;
    }

    .card-wrapper .action-button-download:hover {
        background-color: #4cae4c;
    }

    /* Utilitas tambahan untuk tampilan */
    .hidden {
        display: none;
    }
</style>

<div class="p-4 sm:ml-64 mt-20">
    <?php Flasher::flash(); ?>
    <h1 class="text-4xl font-extrabold text-[#424242] mb-8">Profil Pengguna</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-1">
        <div class="card w-xl">
            <h2 class="card-header">Informasi Profil</h2>
            <form id="profile-form" action="<?= BASEURL; ?>/user/updateProfile" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_user" value="<?= $data['user']['id']; ?>">

                <div class="profile-photo-area">
                    <img id="profile-photo-preview" src="<?= (stripos($data['user']['photo'], 'http') === 0 || stripos($data['user']['photo'], 'https') === 0) ? $data['user']['photo'] :  BASEURL . '/img/profile/' . $data['user']['photo']; ?>" alt="Foto Profil">
                    <input type="file" id="profile-photo-input" name="profile_photo" accept="image/*" class="hidden">
                    <button type="button" id="change-photo-button" class="upload-button">Ubah Foto Profil</button>
                </div>

                <div class="mb-4">
                    <label for="username" class="profile-label">Username</label>
                    <input type="text" id="username" name="username" value="<?= $data['user']['username']; ?>" class="profile-input w-full" disabled>
                </div>

                <div class="mb-4">
                    <label for="nama_lengkap" class="profile-label">Nama Lengkap</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?= $data['user']['fullname']; ?>" class="profile-input w-full" disabled>
                </div>

                <div class="mb-4">
                    <label for="email" class="profile-label">Email</label>
                    <input type="email" id="email" name="email" value="<?= $data['user']['email']; ?>" class="profile-input w-full" disabled>
                </div>

                <div class="mb-4">
                    <label for="alamat" class="profile-label">Alamat</label>
                    <textarea id="alamat" name="alamat" rows="3" class="profile-input w-full" disabled style="resize: none;"><?= $data['user']['alamat']; ?></textarea>
                </div>

                <div class="mb-6">
                    <label for="no_telepon" class="profile-label">Nomor Telepon</label>
                    <input type="tel" id="no_telepon" name="no_telepon" value="<?= $data['user']['no_telepon']; ?>" class="profile-input w-full" disabled>
                </div>

                <div class="flex justify-between items-center">
                    <button type="button" id="edit-toggle-button" class="action-button action-button-secondary">
                        Edit Profil
                    </button>
                    <button type="submit" id="update-button" class="action-button action-button-primary hidden">
                        Update Profil
                    </button>
                </div>
            </form>
        </div>

        <div class="card-wrapper">
            <div class="card w-2xl h-fit pb-6">
                <h2 class="card-header">Denda</h2>
                <p class="text-xl font-bold">Denda anda saat ini: Rp. <?= number_format($data['user']['denda'], 0, ',', '.'); ?></p>

                <?php if ($data['user']['denda'] > 0): ?>
                    <form id="pay-fine-form" action="<?= BASEURL; ?>/payment/processPayment" method="POST">
                        <input type="hidden" name="amount" value="<?= htmlspecialchars($data['user']['denda']); ?>">
                        <input type="hidden" name="customer_name" value="<?= htmlspecialchars($data['user']['fullname']); ?>">
                        <input type="hidden" name="customer_email" value="<?= htmlspecialchars($data['user']['email']); ?>">
                        <input type="hidden" name="payment_method" value="denda_payment">
                        <button type="submit" class="action-button action-button-primary mt-4">Bayar Denda</button>
                    </form>
                <?php else: ?>
                    <p class="text-green-600 mt-4">Tidak ada denda yang perlu dibayar.</p>
                <?php endif; ?>
            </div>
            <div class="card w-2xl h-fit pb-6">
                <h2 class="card-header">Riwayat Transaksi Denda</h2>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Tgl. Transaksi</th>
                                <th class="px-4 py-2">Nomor Transaksi</th>
                                <th class="px-4 py-2">Jumlah</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['transactions'] as $transaction): ?>
                                <tr>
                                    <td class="px-4 py-2"><?= date('d-m-Y H:i:s', strtotime($transaction['created_at'])); ?></td>
                                    <td class="px-4 py-2"><?= $transaction['reference_id']; ?></td>
                                    <td class="px-4 py-2">Rp. <?= number_format($transaction['amount'], 0, ',', '.'); ?></td>
                                    <td class="px-4 py-2"><?= $transaction['status']; ?></td>
                                    <td class="px-4 py-2">
                                        <?php if ($transaction['status'] === 'success'): ?>
                                            <a href="<?= BASEURL; ?>/payment/downloadPdfReceipt/<?= $transaction['id']; ?>" class="action-button action-button-download">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card w-2xl h-fit pb-6">
                <h2 class="card-header">Riwayat Denda</h2>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Nomor</th>
                                <th class="px-4 py-2">Jumlah</th>
                                <th class="px-4 py-2">Catatan</th>
                                <th class="px-4 py-2">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1 ?>
                            <?php foreach ($data['denda'] as $denda): ?>
                                <tr>
                                    <td class="px-4 py-2"><?= $no++; ?></td>
                                    <td class="px-4 py-2">Rp. <?= number_format($denda['price'], 0, ',', '.'); ?></td>
                                    <td class="px-4 py-2"><?= $denda['catatan']; ?></td>
                                    <td class="px-4 py-2"><?= date('d-m-Y', strtotime($denda['created_at'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const formFields = document.querySelectorAll('#profile-form input:not(#username):not(#email), #profile-form textarea');
        const usernameField = document.getElementById('username');
        const emailField = document.getElementById('email');
        const editToggleButton = document.getElementById('edit-toggle-button');
        const updateButton = document.getElementById('update-button');

        const profilePhotoInput = document.getElementById('profile-photo-input');
        const profilePhotoPreview = document.getElementById('profile-photo-preview');
        const changePhotoButton = document.getElementById('change-photo-button');

        let isEditing = false;

        // Function to toggle edit mode
        function toggleEditMode() {
            isEditing = !isEditing;

            formFields.forEach(field => {
                field.disabled = !isEditing;
            });

            // Toggle visibility of the "Ubah Foto Profil" button
            if (isEditing) {
                changePhotoButton.style.display = 'block';
                editToggleButton.textContent = 'Batalkan Edit';
                editToggleButton.classList.remove('action-button-secondary');
                editToggleButton.classList.add('action-button-danger');
                updateButton.classList.remove('hidden');
            } else {
                changePhotoButton.style.display = 'none';
                editToggleButton.textContent = 'Edit Profil';
                editToggleButton.classList.remove('action-button-danger');
                editToggleButton.classList.add('action-button-secondary');
                updateButton.classList.add('hidden');
            }
        }

        // Event listener for the "Edit Profil" / "Batalkan Edit" button
        editToggleButton.addEventListener('click', toggleEditMode);

        // Event listener for the hidden file input (triggered by button click)
        changePhotoButton.addEventListener('click', function() {
            profilePhotoInput.click(); // Programmatically click the hidden file input
        });

        // Event listener to display image preview when a file is selected
        profilePhotoInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profilePhotoPreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        usernameField.disabled = true;
        emailField.disabled = true;
    });
</script>