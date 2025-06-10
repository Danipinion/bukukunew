<div class="p-4 sm:ml-64 mt-20">
    <p class="text-2xl text-[#424242] font-semibold mb-2">
        Bacain/Manajemen/User
    </p>
    <div
        class="p-4 rounded-lg border-2 border-gray-200 border-dashed h-[calc(100vh-110px)] overflow-y-auto">
        <div class="ml-5 flex items-center">
            <a href="<?= BASEURL; ?>/admin/buku">
                <span
                    class="font-semibold bg-[#EFE5DB] hover:underline transition-all text-[#a0522d] py-2 px-5 rounded-tl-lg flex items-center">Buku</span>
            </a>
            <a href="<?= BASEURL; ?>/admin/kategori">
                <span
                    class="font-semibold bg-[#EFE5DB] hover:underline text-[#a0522d] py-2 px-5 flex items-center">Kategori</span>
            </a>
            <a href="<?= BASEURL; ?>/admin/user">
                <span
                    class="font-semibold bg-[#a0522d] transition-all text-white py-2 px-5 rounded-tr-lg flex items-center">User</span>
            </a>
        </div>
        <div class="grid grid-cols-1 gap-4 mb-4">
            <div
                class="items-center justify-center rounded-lg bg-[#EFE5DB] px-10 py-5">
                <div class="flex items-center justify-between">
                    <p class="text-xl text-[#424242] font-semibold">Data User</p>
                </div>
                <table id="example" class="" style="width: 100%">
                    <thead>
                        <tr>
                            <th class="w-10">NO</th>
                            <th>Nama</th>
                            <th>Pinjam</th>
                            <th>Denda</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($data['user']) && !empty($data['user'])) {
                            $no = 1;
                            foreach ($data['user'] as $user) : ?>
                                <tr>
                                    <td class="text-right"><?= $no++; ?></td>
                                    <td><?= $user['username']; ?></td>
                                    <td class="text-right"><?= $user['pinjam']; ?></td>
                                    <td>Rp. <?= number_format((float)$user['denda'], 0, ',', '.'); ?></td>
                                    <td class="flex items-center gap-2">
                                        <a href="<?= BASEURL; ?>/admin/detailUser/<?= $user['id']; ?>"
                                            class="bg-[#a0522d] text-white px-3 py-1 rounded hover:bg-[#8b4513] transition-all">Detail</a>
                                        <button
                                            data-modal-target="tambah-denda"
                                            data-modal-toggle="tambah-denda"
                                            class="block text-[#a0522d] bg-[#FFC857] hover:bg-[#FFD28F] focus:ring-4 focus:outline-none focus:ring-[#FFC857] font-medium rounded-lg  px-3 py-1 text-center"
                                            type="button">
                                            Tambah Denda
                                        </button>

                                        <div
                                            id="tambah-denda"
                                            data-modal-backdrop="static"
                                            tabindex="-1"
                                            aria-hidden="true"
                                            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                            <div class="relative p-4 w-full max-w-md max-h-full">
                                                <div class="relative bg-[#EFE5DB] rounded-lg shadow">
                                                    <div
                                                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-300">
                                                        <h3 class="text-xl font-semibold text-[#424242]">
                                                            Tambah Denda
                                                        </h3>
                                                        <button
                                                            type="button"
                                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                                            data-modal-hide="tambah-denda">
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
                                                    <form action="<?= BASEURL; ?>/admin/tambahDendaUserManual" method="post">
                                                        <input type="text" name="id_user" value="<?= $user['id'] ?>" class="hidden">
                                                        <div class="p-4 md:p-5 space-y-4">
                                                            <div>
                                                                <label
                                                                    for="jumlah_denda_modal"
                                                                    class="block mb-2 text-sm font-medium text-gray-900">Jumlah denda</label>
                                                                <input
                                                                    type="number"
                                                                    id="jumlah_denda_modal"
                                                                    name="jumlah_denda_modal"
                                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#a0522d] focus:border-[#a0522d] block w-full p-2.5"
                                                                    placeholder="Masukkan jumlah denda"
                                                                    required />
                                                            </div>
                                                            <div>
                                                                <label
                                                                    for="catatan_denda_modal"
                                                                    class="block mb-2 text-sm font-medium text-gray-900">Catatan denda</label>
                                                                <input
                                                                    type="text"
                                                                    id="catatan_denda_modal"
                                                                    name="catatan_denda_modal"
                                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#a0522d] focus:border-[#a0522d] block w-full p-2.5"
                                                                    placeholder="Masukkan catatan denda"
                                                                    required />
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="flex items-center justify-end p-4 md:p-5 border-t border-gray-200 rounded-b">
                                                            <button
                                                                data-modal-hide="tambah-denda"
                                                                type="button"
                                                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-[#a0522d] focus:z-10 focus:ring-4 focus:ring-gray-100">
                                                                Batal
                                                            </button>
                                                            <button
                                                                type="submit"
                                                                class="text-white bg-[#a0522d] hover:bg-[#8b4513] focus:ring-4 focus:outline-none focus:ring-[#a0522d]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                                Tambah
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach;
                        } else { ?>
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data user</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
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
</div>