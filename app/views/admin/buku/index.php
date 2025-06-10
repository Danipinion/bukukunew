<div class="p-4 sm:ml-64 mt-20">
    <p class="text-2xl text-[#424242] font-semibold mb-2">
        Bacain/Manajemen/Buku
    </p>
    <div
        class="p-4 rounded-lg border-2 border-gray-200 border-dashed h-[calc(100vh-110px)] overflow-y-auto">
        <?php Flasher::flash(); ?>
        <div class="ml-5 flex items-center justify-between">
            <div class="flex items-center">
                <a href="<?= BASEURL; ?>/admin/buku">
                    <span
                        class="font-semibold bg-[#a0522d] text-white py-2 px-5 rounded-tl-lg flex items-center">Buku</span>
                </a>
                <a href="<?= BASEURL; ?>/admin/kategori">
                    <span
                        class="font-semibold bg-[#EFE5DB] hover:underline transition-all text-[#a0522d] py-2 px-5 flex items-center">Kategori</span>
                </a>
                <a href="<?= BASEURL; ?>/admin/user">
                    <span
                        class="font-semibold bg-[#EFE5DB] hover:underline transition-all text-[#a0522d] py-2 px-5 rounded-tr-lg flex items-center">User</span>
                </a>
            </div>
            <div>
                <button
                    data-modal-target="tambah-buku"
                    data-modal-toggle="tambah-buku"
                    class="block text-[#a0522d] bg-[#FFC857] hover:bg-[#FFD28F] focus:ring-4 focus:outline-none focus:ring-[#FFC857] font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                    type="button">
                    Tambah buku
                </button>

                <div
                    id="tambah-buku"
                    data-modal-backdrop="static"
                    tabindex="-1"
                    aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <div class="relative bg-[#EFE5DB] rounded-lg shadow">
                            <div
                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-300">
                                <h3 class="text-xl font-semibold text-[#424242]">
                                    Tambah Buku Baru
                                </h3>
                                <button
                                    type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                    data-modal-hide="tambah-buku">
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
                            <form action="<?= BASEURL; ?>/buku/tambah" method="post" enctype="multipart/form-data">
                                <div class="p-4 md:p-5 space-y-4">
                                    <div>
                                        <label
                                            for="judul_buku_modal"
                                            class="block mb-2 text-sm font-medium text-gray-900">Judul Buku</label>
                                        <input
                                            type="text"
                                            id="judul_buku_modal"
                                            name="judul_buku_modal"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#a0522d] focus:border-[#a0522d] block w-full p-2.5"
                                            placeholder="Masukkan judul buku"
                                            required />
                                    </div>
                                    <div>
                                        <label
                                            for="penulis_buku_modal"
                                            class="block mb-2 text-sm font-medium text-gray-900">Penulis</label>
                                        <input
                                            type="text"
                                            id="penulis_buku_modal"
                                            name="penulis_buku_modal"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#a0522d] focus:border-[#a0522d] block w-full p-2.5"
                                            placeholder="Masukkan nama penulis"
                                            required />
                                    </div>
                                    <div>
                                        <label
                                            for="deskripsi_buku_modal"
                                            class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
                                        <textarea
                                            id="deskripsi_buku_modal"
                                            name="deskripsi_buku_modal"
                                            rows="4"
                                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-[#a0522d] focus:border-[#a0522d]"
                                            placeholder="Masukkan deskripsi buku"></textarea>
                                    </div>
                                    <div>
                                        <label
                                            for="kategori_buku_modal"
                                            class="block mb-2 text-sm font-medium text-gray-900">Kategori</label>
                                        <select
                                            id="kategori_buku_modal"
                                            name="kategori_buku_modal"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#a0522d] focus:border-[#a0522d] block w-full p-2.5"
                                            required>
                                            <option value="">Pilih kategori</option>
                                            <?php foreach ($data['kategori'] as $kategori) : ?>
                                                <option value="<?= $kategori['id']; ?>"><?= $kategori['nama']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div>
                                        <label
                                            for="jumlah_buku_modal"
                                            class="block mb-2 text-sm font-medium text-gray-900">Jumlah</label>
                                        <input
                                            type="number"
                                            id="jumlah_buku_modal"
                                            name="jumlah_buku_modal"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#a0522d] focus:border-[#a0522d] block w-full p-2.5"
                                            placeholder="Masukkan jumlah buku"
                                            required />
                                    </div>
                                    <div>
                                        <label
                                            for="gambar_buku_modal"
                                            class="block mb-2 text-sm font-medium text-gray-900">Gambar Buku</label>
                                        <input
                                            type="file"
                                            id="gambar_buku_modal"
                                            name="gambar_buku_modal"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#a0522d] focus:border-[#a0522d] block w-full file:mr-4 file:py-2 file:px-4file:border-0 file:text-sm file:font-semibold file:bg-[#a0522d] file:text-white hover:file:bg-[#8b4513]"
                                            required />
                                    </div>
                                    <div>
                                        <label
                                            for="file_buku_modal"
                                            class="block mb-2 text-sm font-medium text-gray-900">File Buku</label>
                                        <input
                                            type="file"
                                            id="file_buku_modal"
                                            name="file_buku_modal"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#a0522d] focus:border-[#a0522d] block w-full file:mr-4 file:py-2 file:px-4file:border-0 file:text-sm file:font-semibold file:bg-[#a0522d] file:text-white hover:file:bg-[#8b4513]"
                                            accept=".pdf" />
                                    </div>
                                </div>
                                <div
                                    class="flex items-center justify-end p-4 md:p-5 border-t border-gray-200 rounded-b">
                                    <button
                                        data-modal-hide="tambah-buku"
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
                        Semua Data Buku
                    </p>
                </div>
                <table id="example" class="" style="width: 100%">
                    <thead>
                        <tr>
                            <th class="w-10">NO</th>
                            <th>Gambar</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Deskripsi</th>
                            <th>Kategori</th>
                            <th>Sisa</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($data['buku'] as $buku) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td>
                                    <?php if ($buku['gambar']) : ?>
                                        <img src="<?= BASEURL; ?>/img/<?= $buku['gambar']; ?>" alt="<?= $buku['judul']; ?>" class="w-20">
                                    <?php else : ?>
                                        <img src="https://via.placeholder.com/80" alt="No Image" class="w-20">
                                    <?php endif; ?>
                                </td>
                                <td><?= $buku['judul']; ?></td>
                                <td><?= $buku['penulis']; ?></td>
                                <td class="truncate max-w-[200px]"><?= $buku['deskripsi']; ?></td>
                                <td><?= $buku['nama_kategori']; ?></td>
                                <td><?= $buku['sisa']; ?></td>
                                <td>
                                    <a href="<?= BASEURL; ?>/buku/ubah/<?= $buku['id_buku']; ?>" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                    <span class="mx-2">|</span>
                                    <a href="<?= BASEURL; ?>/buku/hapus/<?= $buku['id_buku']; ?>" class="font-medium text-red-600 dark:text-red-500 hover:underline" onclick="return confirm('Apakah anda yakin ingin menghapus buku ini?');">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
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
</script>