<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        * {
            font-family: "Ubuntu", sans-serif;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .popover {
            background-color: #fcf8f5;
            border-radius: 0.5rem;
            padding: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
                0 2px 4px -1px rgba(0, 0, 0, 0.06);
            z-index: 1001;
            text-align: center;
            animation: fadeIn 0.3s ease-in-out;
        }

        .hidden {
            display: none;
        }

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
            padding: 0.75rem 2rem;
            border-radius: 0.25rem;
            transition: background-color 0.2s ease-in-out,
                transform 0.2s ease-in-out;
            cursor: pointer;
        }

        .st-button:hover {
            background-color: #8c4525;
            transform: scale(1.01);
        }

        .book-cover-detail {
            width: 250px;
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 0.5s ease-in-out;
        }

        .book-detail-info {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            animation: fadeInRight 0.5s ease-in-out;
        }

        .book-detail-title {
            font-size: 3rem;
            font-weight: bold;
            color: #a0522d;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
        }

        .book-detail-author {
            font-size: 1.25rem;
            color: #424242;
            font-style: italic;
            margin-bottom: 1rem;
        }

        .book-detail-description {
            color: #424242;
            line-height: 1.6;
            text-align: justify;
            margin-bottom: 2rem;
        }

        .duration-options label {
            display: inline-flex;
            align-items: center;
            margin-right: 1rem;
        }

        .duration-options input[type="radio"] {
            appearance: none;
            width: 1rem;
            height: 1rem;
            border: 2px solid #a0522d;
            border-radius: 50%;
            outline: none;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }

        .duration-options input[type="radio"]:checked {
            background-color: #ffc857;
            border-color: #ffc857;
        }

        .duration-options span {
            margin-left: 0.5rem;
            color: #424242;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
    <title>Detail Buku</title>
</head>

<body class="bg-[#FCF8F5]">
    <div id="overlay" class="overlay hidden">
        <div id="popover" class="popover max-w-xl animate__animated animate__fadeIn">
            <h2 class="st-title mb-4">Yakin Mau Sewa?</h2>
            <p class="text-gray-700 text-sm mb-4 text-justify">
                Anda menyetujui peminjaman dengan durasi yang dipilih. Biaya keterlambatan pengembalian akan dikenakan denda sebesar
                Rp2.000,- per hari. Dengan menekan tombol "SETUJU", Anda dianggap telah membaca dan menyetujui ketentuan ini.
            </p>
            <form action="<?= BASEURL; ?>/user/ajukanSewa" method="post">
                <input type="hidden" name="id_buku" value="<?= $data['buku']['id_buku']; ?>">
                <div class="mb-4 duration-options">
                    <label class="inline-flex items-center mr-4">
                        <input type="radio" name="durasi_sewa" value="<?= date('Y-m-d', strtotime('+1 day')); ?>" class="form-radio text-[#a0522d] focus:ring-[#FFC857]" checked />
                        <span class="ml-2 text-gray-700">1 Hari</span>
                    </label>
                    <label class="inline-flex items-center mr-4">
                        <input type="radio" name="durasi_sewa" value="<?= date('Y-m-d', strtotime('+3 day')); ?>" class="form-radio text-[#a0522d] focus:ring-[#FFC857]" />
                        <span class="ml-2 text-gray-700">3 Hari</span>
                    </label>
                    <label class="inline-flex items-center mr-4">
                        <input type="radio" name="durasi_sewa" value="<?= date('Y-m-d', strtotime('+5 day')); ?>" class="form-radio text-[#a0522d] focus:ring-[#FFC857]" />
                        <span class="ml-2 text-gray-700">5 Hari</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="durasi_sewa" value="<?= date('Y-m-d', strtotime('+7 day')); ?>" class="form-radio text-[#a0522d] focus:ring-[#FFC857]" />
                        <span class="ml-2 text-gray-700">7 Hari</span>
                    </label>
                </div>
                <div class="flex justify-center gap-4">
                    <button id="tolakBtn" type="button" class="st-button bg-red-500 hover:bg-red-700">
                        Batal
                    </button>
                    <button id="setujuBtn" type="submit" class="st-button bg-green-500 hover:bg-green-700">
                        Setuju
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="p-6 sm:ml-0 mt-20 flex gap-10 justify-center items-start">
        <a href="<?= BASEURL; ?>/user" class=" bg-[#FFC857] text-[#a0522d] rounded-full p-2 shadow-md hover:scale-105 transition-transform">
            <svg class="w-8 h-8" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 19-7-7 7-7" />
            </svg>
        </a>
        <?php if ($data['buku']['gambar']) : ?>
            <img src="<?= BASEURL; ?>/img/<?= $data['buku']['gambar']; ?>" alt="Sampul Buku <?= $data['buku']['judul']; ?>" class="book-cover-detail" />
        <?php else : ?>
            <img src="https://via.placeholder.com/250" alt="No Image" class="book-cover-detail" />
        <?php endif; ?>
        <div class="book-detail-info">
            <div>
                <p class="book-detail-author animate__animated animate__fadeIn animate__delay-100ms">
                    <?= $data['buku']['penulis']; ?>
                </p>
                <h1 class="book-detail-title animate__animated animate__fadeIn animate__delay-200ms">
                    <?= $data['buku']['judul']; ?>
                </h1>
            </div>
            <p class="book-detail-description animate__animated animate__fadeIn animate__delay-300ms">
                <?= $data['buku']['deskripsi']; ?>
            </p>
            <div class="flex items-center gap-4 mb-4">
                <?php if ($data['peminjaman_aktif']) : ?>
                    <?php if ($data['peminjaman_aktif']['status'] == 'proses') : ?>
                        <span class="st-button bg-orange-500 cursor-not-allowed opacity-80">
                            Sedang Dipinjam (Menunggu Persetujuan Admin)
                        </span>
                    <?php elseif ($data['peminjaman_aktif']['status'] == 'disetujui') : ?>
                        <span class="st-button bg-green-500 cursor-not-allowed opacity-80">
                            Sudah Dipinjam (Hingga <?= date('d M Y', strtotime($data['peminjaman_aktif']['tanggal_kembali_expected'])); ?>)
                        </span>
                    <?php elseif ($data['peminjaman_aktif']['status'] == 'ditolak') : ?>
                        <span class="st-button bg-red-500 cursor-not-allowed opacity-80">
                            Pengajuan Ditolak Admin
                        </span>
                        <?php if (!empty($data['peminjaman_aktif']['catatan_admin'])) : ?>
                            <p class="text-sm text-red-700">Catatan Admin: <?= $data['peminjaman_aktif']['catatan_admin']; ?></p>
                        <?php endif; ?>
                    <?php elseif ($data['peminjaman_aktif']['status'] == 'dikembalikan') : ?>
                        <span class="st-button bg-gray-500 cursor-not-allowed opacity-80">
                            Sudah Dikembalikan
                        </span>
                    <?php elseif ($data['peminjaman_aktif']['status'] == 'terlambat') : ?>
                        <span class="st-button bg-red-700 cursor-not-allowed opacity-80">
                            Terlambat Dikembalikan!
                        </span>
                    <?php endif; ?>
                <?php else : ?>
                    <button class="st-button animate__animated animate__fadeIn animate__delay-400ms <?= ($data['buku']['sisa'] <= 0) ? 'cursor-not-allowed opacity-50' : ''; ?>" <?= ($data['buku']['sisa'] <= 0) ? 'disabled' : ''; ?> id="sewaBtn">
                        <?= ($data['buku']['sisa'] <= 0) ? 'STOK HABIS' : 'SEWA'; ?>
                    </button>
                <?php endif; ?>

                <?php
                $userId = $_SESSION['user_id'] ?? null;
                $isBookmarked = false;
                if ($userId) {
                    $isBookmarked = $this->model('User_model')->getBookmarksByUser($userId, $data['buku']['id_buku']);
                }
                ?>
                <?php if ($userId) : ?>
                    <a href="<?= BASEURL; ?>/user/<?= $isBookmarked ? 'hapusDariBookmark/' : 'tambahBookmark/'; ?><?= $data['buku']['id_buku']; ?>" class="text-gray-500 hover:text-[#a0522d] transition-colors">
                        <svg class="w-6 h-6 text-[#424242]/60 hover:text-[#a0522d] transition-colors <?= $isBookmarked ? 'fill-[#a0522d]' : ''; ?>" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M7.833 2c-.507 0-.98.216-1.318.576A1.92 1.92 0 0 0 6 3.89V21a1 1 0 0 0 1.625.78L12 18.28l4.375 3.5A1 1 0 0 0 18 21V3.889c0-.481-.178-.954-.515-1.313A1.808 1.808 0 0 0 16.167 2H7.833Z" />
                        </svg>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        const sewaBtn = document.getElementById("sewaBtn");
        const overlay = document.getElementById("overlay");
        const tolakBtn = document.getElementById("tolakBtn");

        if (sewaBtn) {
            sewaBtn.addEventListener("click", () => {
                overlay.classList.remove("hidden");
            });
        }


        tolakBtn.addEventListener("click", () => {
            overlay.classList.add("hidden");
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>