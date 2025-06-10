<div class="p-4 sm:ml-64 mt-20">
    <p class="text-2xl font-semibold mb-2">
        Bacain/Manajemen/Buku/Ubah
    </p>
    <div
        class="p-4 rounded-lg border-2 border-gray-200 border-dashed h-[calc(100vh-110px)] overflow-y-auto">
        <div class="ml-5">
            <a href="<?= BASEURL; ?>/admin/buku"
                class="inline-flex items-center text-[#a0522d] hover:underline mb-3">
                <svg class="w-5 h-5 me-2 rtl:rotate-180" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                        clip-rule="evenodd"></path>
                </svg>
                Kembali
            </a>
        </div>
        <div class="grid grid-cols-1 gap-4 mb-4">
            <div class="items-center justify-center rounded-lg bg-[#EFE5DB] px-10 py-5">
                <div class="flex items-center justify-between mb-5">
                    <p class="text-xl font-semibold">
                        Ubah Data Buku
                    </p>
                </div>
                <form action="<?= BASEURL; ?>/buku/ubah/<?= $data['buku']['id_buku']; ?>" method="post"
                    enctype="multipart/form-data">
                    <input type="hidden" name="id_buku" value="<?= $data['buku']['id_buku']; ?>">
                    <input type="hidden" name="gambar_lama" value="<?= $data['buku']['gambar']; ?>">
                    <div class="space-y-4">
                        <div>
                            <label for="judul_buku" class="block mb-2 text-sm font-medium text-gray-900">Judul Buku</label>
                            <input type="text" id="judul_buku" name="judul_buku_modal"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#a0522d] focus:border-[#a0522d] block w-full p-2.5"
                                placeholder="Masukkan judul buku" value="<?= $data['buku']['judul']; ?>" required>
                        </div>
                        <div>
                            <label for="penulis_buku" class="block mb-2 text-sm font-medium text-gray-900">Penulis</label>
                            <input type="text" id="penulis_buku" name="penulis_buku_modal"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#a0522d] focus:border-[#a0522d] block w-full p-2.5"
                                placeholder="Masukkan nama penulis" value="<?= $data['buku']['penulis']; ?>" required>
                        </div>
                        <div>
                            <label for="deskripsi_buku" class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
                            <textarea id="deskripsi_buku" name="deskripsi_buku_modal" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-[#a0522d] focus:border-[#a0522d]"
                                placeholder="Masukkan deskripsi buku"><?= $data['buku']['deskripsi']; ?></textarea>
                        </div>
                        <div>
                            <label for="kategori_buku" class="block mb-2 text-sm font-medium text-gray-900">Kategori</label>
                            <select id="kategori_buku" name="kategori_buku_modal"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#a0522d] focus:border-[#a0522d] block w-full p-2.5"
                                required>
                                <option value="">Pilih kategori</option>
                                <?php foreach ($data['kategori'] as $kategori) : ?>
                                    <option value="<?= $kategori['id']; ?>"
                                        <?= ($kategori['id'] == $data['buku']['id_kategori']) ? 'selected' : ''; ?>>
                                        <?= $kategori['nama']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label for="jumlah_buku" class="block mb-2 text-sm font-medium text-gray-900">Jumlah</label>
                            <input type="number" id="jumlah_buku" name="jumlah_buku_modal"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#a0522d] focus:border-[#a0522d] block w-full p-2.5"
                                placeholder="Masukkan jumlah buku" value="<?= $data['buku']['jumlah']; ?>" required>
                        </div>
                        <div>
                            <label for="sisa_buku" class="block mb-2 text-sm font-medium text-gray-900">Sisa</label>
                            <input type="number" id="sisa_buku" name="sisa_buku_modal"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#a0522d] focus:border-[#a0522d] block w-full p-2.5"
                                placeholder="Masukkan sisa buku" value="<?= $data['buku']['sisa']; ?>" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900" for="gambar_buku">Gambar Buku</label>
                            <?php if ($data['buku']['gambar']) : ?>
                                <img src="<?= BASEURL; ?>/img/<?= $data['buku']['gambar']; ?>"
                                    alt="<?= $data['buku']['judul']; ?>" class="w-32 mb-2">
                            <?php else : ?>
                                <img src="https://via.placeholder.com/128" alt="No Image" class="w-32 mb-2">
                            <?php endif; ?>
                            <input
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                                aria-describedby="user_avatar_help" id="gambar_buku" type="file"
                                name="gambar_buku_modal">
                            <p class="mt-1 text-sm text-gray-500" id="user_avatar_help">Biarkan kosong
                                jika tidak ingin mengubah gambar.</p>
                        </div>
                        <button type="submit"
                            class="text-white bg-[#a0522d] hover:bg-[#8b4513] focus:ring-4 focus:outline-none focus:ring-[#a0522d]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>