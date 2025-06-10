<div class="p-4 sm:ml-64 mt-20">
    <p class="text-2xl text-[#424242] font-semibold mb-2">
        Bacain/Manajemen/Kategori
    </p>
    <div class="mb-4">
        <?php Flasher::flash(); ?>
    </div>
    <div
        class="p-4 rounded-lg border-2 border-gray-200 border-dashed h-[calc(100vh-110px)] overflow-y-auto">
        <div class="ml-5 flex items-center justify-between">
            <div class="flex items-center">
                <a href="<?= BASEURL; ?>/admin/buku">
                    <span
                        class="font-semibold bg-[#EFE5DB] hover:underline transition-all text-[#a0522d] py-2 px-5 rounded-tl-lg flex items-center">Buku</span>
                </a>
                <a href="<?= BASEURL; ?>/admin/kategori">
                    <span
                        class="font-semibold bg-[#a0522d] text-white py-2 px-5  flex items-center">Kategori</span>
                </a>
                <a href="<?= BASEURL; ?>/admin/user">
                    <span
                        class="font-semibold bg-[#EFE5DB] hover:underline transition-all text-[#a0522d] py-2 px-5 rounded-tr-lg flex items-center">User</span>
                </a>
            </div>
            <div>
                <button
                    data-modal-target="tambah-kategori"
                    data-modal-toggle="tambah-kategori"
                    class="block text-[#a0522d] bg-[#FFC857] hover:bg-[#FFD28F] focus:ring-4 focus:outline-none focus:ring-[#FFC857] font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                    type="button">
                    Tambah kategori
                </button>

                <div
                    id="tambah-kategori"
                    data-modal-backdrop="static"
                    tabindex="-1"
                    aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <div class="relative bg-[#EFE5DB] rounded-lg shadow">
                            <div
                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-300">
                                <h3 class="text-xl font-semibold text-[#424242]">
                                    Tambah Kategori Baru
                                </h3>
                                <button
                                    type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                    data-modal-hide="tambah-kategori">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 256 256">
                                        <rect width="256" height="256" fill="none" />
                                        <line
                                            x1="200"
                                            y1="56"
                                            x2="56"
                                            y2="200"
                                            stroke="currentColor"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="16" />
                                        <line
                                            x1="200"
                                            y1="200"
                                            x2="56"
                                            y2="56"
                                            stroke="currentColor"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="16" />
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <form action="<?= BASEURL; ?>/admin/prosesTambahKategori" method="post">
                                <div class="p-4 md:p-5 space-y-4">
                                    <div>
                                        <label
                                            for="judul_kategori_modal"
                                            class="block mb-2 text-sm font-medium text-gray-900">Judul Kategori</label>
                                        <input
                                            type="text"
                                            id="judul_kategori_modal"
                                            name="nama"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#a0522d] focus:border-[#a0522d] block w-full p-2.5"
                                            placeholder="Masukkan judul Kategori"
                                            required />
                                    </div>
                                    <div>
                                        <label
                                            for="kategori_buku_modal"
                                            class="block mb-2 text-sm font-medium text-gray-900">Kategori</label>
                                        <select
                                            id="kategori_buku_modal"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#a0522d] focus:border-[#a0522d] block w-full p-2.5"
                                            name="jenis"
                                            required>
                                            <option value="">Pilih kategori</option>
                                            <option value="fiksi">Fiksi</option>
                                            <option value="nfiksi">Non Fiksi</option>
                                        </select>
                                    </div>
                                </div>
                                <div
                                    class="flex items-center justify-end p-4 md:p-5 border-t border-gray-200 rounded-b">
                                    <button
                                        data-modal-hide="tambah-kategori"
                                        type="button"
                                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-[#a0522d] focus:z-10 focus:ring-4 focus:ring-gray-100">
                                        Batal
                                    </button>
                                    <button
                                        type="submit"
                                        class="text-white bg-[#a0522d] hover:bg-[#8b4513] focus:ring-4 focus:outline-none focus:ring-[#a0522d]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                        Simpan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-4 mb-4">
            <div
                class="items-center justify-center rounded-lg bg-[#EFE5DB] px-10 py-5">
                <div class="flex items-center justify-between mb-5">
                    <p class="text-xl text-[#424242] font-semibold">
                        Semua Data Kategori
                    </p>
                </div>
                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <table id="example" class="" style="width: 100%">
                            <thead>
                                <tr>
                                    <th class="w-10">NO</th>
                                    <th>Nama</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data['kategori'] as $kategori) : ?>
                                    <?php if ($kategori['jenis'] === 'fiksi') : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $kategori['nama']; ?></td>
                                            <td>
                                                <?php
                                                $totalBukuKategori = $this->model('Kategori_model')->getTotalBukuByKategori($kategori['id']);
                                                echo $totalBukuKategori;
                                                ?>
                                            </td>
                                            <td>
                                                <button
                                                    data-modal-target="edit-kategori-<?= $kategori['id']; ?>"
                                                    data-modal-toggle="edit-kategori-<?= $kategori['id']; ?>"
                                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                                    type="button">
                                                    Edit
                                                </button>
                                                <span class="mx-2">|</span>
                                                <button
                                                    data-modal-target="<?= $kategori['id']; ?>"
                                                    data-modal-toggle="<?= $kategori['id']; ?>"
                                                    class="cursor-pointer text-center text-red-600 hover:underline"
                                                    type="button">
                                                    Hapus
                                                </button>
                                                <div id="<?= $kategori['id']; ?>" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                    <div class="relative p-4 w-full max-w-md max-h-full">
                                                        <div class="relative bg-white rounded-lg shadow-sm">
                                                            <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="<?= $kategori['id']; ?>">
                                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                                </svg>
                                                                <span class="sr-only">Close modal</span>
                                                            </button>
                                                            <div class="p-4 md:p-5 text-center">
                                                                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                                </svg>
                                                                <h3 class="mb-5 text-lg font-normal text-gray-500">Anda yakin ingin menghapus data ini? <?= $kategori['nama']; ?></h3>
                                                                <button onclick="window.location.href='<?= BASEURL; ?>/admin/prosesHapusKategori/<?= $kategori['id']; ?>'" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">Ya, saya yakin</button>
                                                                <button data-modal-hide="<?= $kategori['id']; ?>" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Batal</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="edit-kategori-<?= $kategori['id']; ?>" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                    <div class="relative p-4 w-full max-w-md max-h-full">
                                                        <div class="relative bg-[#EFE5DB] rounded-lg shadow">
                                                            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-300">
                                                                <h3 class="text-xl font-semibold text-[#424242]">
                                                                    Edit Kategori
                                                                </h3>
                                                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="edit-kategori-<?= $kategori['id']; ?>">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                                                        <rect width="256" height="256" fill="none" />
                                                                        <line x1="200" y1="56" x2="56" y2="200" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                                                        <line x1="200" y1="200" x2="56" y2="56" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                                                    </svg>
                                                                    <span class="sr-only">Close modal</span>
                                                                </button>
                                                            </div>
                                                            <form action="<?= BASEURL; ?>/admin/prosesUpdateKategori" method="post">
                                                                <input type="hidden" name="id" value="<?= $kategori['id']; ?>">
                                                                <div class="p-4 md:p-5 space-y-4">
                                                                    <div>
                                                                        <label for="judul_kategori_edit_<?= $kategori['id']; ?>" class="block mb-2 text-sm font-medium text-gray-900">Judul Kategori</label>
                                                                        <input type="text" id="judul_kategori_edit_<?= $kategori['id']; ?>" name="nama" value="<?= $kategori['nama']; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#a0522d] focus:border-[#a0522d] block w-full p-2.5" placeholder="Masukkan judul Kategori" required>
                                                                    </div>
                                                                    <div>
                                                                        <label for="kategori_buku_edit_<?= $kategori['id']; ?>" class="block mb-2 text-sm font-medium text-gray-900">Kategori</label>
                                                                        <select id="kategori_buku_edit_<?= $kategori['id']; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#a0522d] focus:border-[#a0522d] block w-full p-2.5" name="jenis" required>
                                                                            <option value="">Pilih kategori</option>
                                                                            <option value="fiksi" <?= ($kategori['jenis'] === 'fiksi') ? 'selected' : ''; ?>>Fiksi</option>
                                                                            <option value="nfiksi" <?= ($kategori['jenis'] === 'nfiksi') ? 'selected' : ''; ?>>Non Fiksi</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="flex items-center justify-end p-4 md:p-5 border-t border-gray-200 rounded-b">
                                                                    <button data-modal-hide="edit-kategori-<?= $kategori['id']; ?>" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-[#a0522d] focus:z-10 focus:ring-4 focus:ring-gray-100">
                                                                        Batal
                                                                    </button>
                                                                    <button type="submit" class="text-white bg-[#a0522d] hover:bg-[#8b4513] focus:ring-4 focus:outline-none focus:ring-[#a0522d]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                                        Simpan
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <h1
                            class="text-xl text-[#EFE5DB] mt-5 font-semibold text-center bg-[#a0522d] rounded-md py-1">
                            Fiksi
                        </h1>
                    </div>
                    <div>
                        <table id="example2" class="" style="width: 100%">
                            <thead>
                                <tr>
                                    <th class="w-10">NO</th>
                                    <th>Nama</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $noFiksi = 1; ?>
                                <?php foreach ($data['kategori'] as $kategori) : ?>
                                    <?php if ($kategori['jenis'] === 'nfiksi') : ?>
                                        <tr>
                                            <td><?= $noFiksi++; ?></td>
                                            <td><?= $kategori['nama']; ?></td>
                                            <td>
                                                <?php
                                                $totalBukuKategori = $this->model('Kategori_model')->getTotalBukuByKategori($kategori['id']);
                                                echo $totalBukuKategori;
                                                ?>
                                            </td>
                                            <td>
                                                <button
                                                    data-modal-target="edit-kategori-<?= $kategori['id']; ?>"
                                                    data-modal-toggle="edit-kategori-<?= $kategori['id']; ?>"
                                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                                    type="button">
                                                    Edit
                                                </button>
                                                <span class="mx-2">|</span>
                                                <button
                                                    data-modal-target="<?= $kategori['id']; ?>"
                                                    data-modal-toggle="<?= $kategori['id']; ?>"
                                                    class="cursor-pointer text-center text-red-600 hover:underline"
                                                    type="button">
                                                    Hapus
                                                </button>
                                                <div id="<?= $kategori['id']; ?>" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                    <div class="relative p-4 w-full max-w-md max-h-full">
                                                        <div class="relative bg-white rounded-lg shadow-sm">
                                                            <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="<?= $kategori['id']; ?>">
                                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                                </svg>
                                                                <span class="sr-only">Close modal</span>
                                                            </button>
                                                            <div class="p-4 md:p-5 text-center">
                                                                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                                </svg>
                                                                <h3 class="mb-5 text-lg font-normal text-gray-500">Anda yakin ingin menghapus data ini? <?= $kategori['nama']; ?></h3>
                                                                <button onclick="window.location.href='<?= BASEURL; ?>/admin/prosesHapusKategori/<?= $kategori['id']; ?>'" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">Ya, saya yakin</button>
                                                                <button data-modal-hide="<?= $kategori['id']; ?>" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Batal</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="edit-kategori-<?= $kategori['id']; ?>" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                    <div class="relative p-4 w-full max-w-md max-h-full">
                                                        <div class="relative bg-[#EFE5DB] rounded-lg shadow">
                                                            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-300">
                                                                <h3 class="text-xl font-semibold text-[#424242]">
                                                                    Edit Kategori
                                                                </h3>
                                                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="edit-kategori-<?= $kategori['id']; ?>">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                                                        <rect width="256" height="256" fill="none" />
                                                                        <line x1="200" y1="56" x2="56" y2="200" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                                                        <line x1="200" y1="200" x2="56" y2="56" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                                                    </svg>
                                                                    <span class="sr-only">Close modal</span>
                                                                </button>
                                                            </div>
                                                            <form action="<?= BASEURL; ?>/admin/prosesUpdateKategori" method="post">
                                                                <input type="hidden" name="id" value="<?= $kategori['id']; ?>">
                                                                <div class="p-4 md:p-5 space-y-4">
                                                                    <div>
                                                                        <label for="judul_kategori_edit_<?= $kategori['id']; ?>" class="block mb-2 text-sm font-medium text-gray-900">Judul Kategori</label>
                                                                        <input type="text" id="judul_kategori_edit_<?= $kategori['id']; ?>" name="nama" value="<?= $kategori['nama']; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#a0522d] focus:border-[#a0522d] block w-full p-2.5" placeholder="Masukkan judul Kategori" required>
                                                                    </div>
                                                                    <div>
                                                                        <label for="kategori_buku_edit_<?= $kategori['id']; ?>" class="block mb-2 text-sm font-medium text-gray-900">Kategori</label>
                                                                        <select id="kategori_buku_edit_<?= $kategori['id']; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#a0522d] focus:border-[#a0522d] block w-full p-2.5" name="jenis" required>
                                                                            <option value="">Pilih kategori</option>
                                                                            <option value="fiksi" <?= ($kategori['jenis'] === 'fiksi') ? 'selected' : ''; ?>>Fiksi</option>
                                                                            <option value="nfiksi" <?= ($kategori['jenis'] === 'nfiksi') ? 'selected' : ''; ?>>Non Fiksi</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="flex items-center justify-end p-4 md:p-5 border-t border-gray-200 rounded-b">
                                                                    <button data-modal-hide="edit-kategori-<?= $kategori['id']; ?>" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-[#a0522d] focus:z-10 focus:ring-4 focus:ring-gray-100">
                                                                        Batal
                                                                    </button>
                                                                    <button type="submit" class="text-white bg-[#a0522d] hover:bg-[#8b4513] focus:ring-4 focus:outline-none focus:ring-[#a0522d]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                                        Simpan
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <h1
                            class="text-xl text-[#EFE5DB] mt-5 font-semibold text-center bg-[#a0522d] rounded-md py-1">
                            Non-Fiksi
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
<script
    src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.2.2/datatables.min.js"
    integrity="sha384-h+dgoYlXhgp1Rdr2BQORgRZ8uTV8KHpMEDxsAXD5RMRvytPCeeiubqmZx5ZIewmp"
    crossorigin="anonymous"></script>
<script>
    new DataTable("#example", {
        info: false,
    });
    new DataTable("#example2", {
        info: false,
    });
</script>