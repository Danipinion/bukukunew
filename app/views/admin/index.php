<div class="p-4 sm:ml-64 mt-20">
    <p class="text-2xl text-[#424242] font-semibold mb-2">Bacain/Dashboard</p>
    <div
        class="p-4 rounded-lg border-2 border-gray-200 border-dashed h-[calc(100vh-110px)] overflow-y-auto">
        <div class="grid grid-cols-1 gap-4 mb-4">
            <div
                class="items-center justify-center rounded-lg bg-[#EFE5DB] grid grid-cols-4 h-40 px-10">
                <div>
                    <div class="flex items-center gap-2">
                        <svg
                            class="w-10 h-10 bg-[#a0522d] text-[#EFE5DB] p-1 rounded-full"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24">
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 6.03v13m0-13c-2.819-.831-4.715-1.076-8.029-1.023A.99.99 0 0 0 3 6v11c0 .563.466 1.014 1.03 1.007 3.122-.043 5.018.212 7.97 1.023m0-13c2.819-.831 4.715-1.076 8.029-1.023A.99.99 0 0 1 21 6v11c0 .563-.466 1.014-1.03 1.007-3.122-.043-5.018.212-7.97 1.023" />
                        </svg>

                        <p class="text-xl text-[#424242] font-semibold">
                            Total User
                        </p>
                    </div>
                    <p class="text-7xl text-[#424242] font-semibold ml-12"><?= $data['total_users']; ?></p>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <svg
                            class="w-10 h-10 bg-[#a0522d] text-[#EFE5DB] p-1 rounded-full"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24">
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 6.03v13m0-13c-2.819-.831-4.715-1.076-8.029-1.023A.99.99 0 0 0 3 6v11c0 .563.466 1.014 1.03 1.007 3.122-.043 5.018.212 7.97 1.023m0-13c2.819-.831 4.715-1.076 8.029-1.023A.99.99 0 0 1 21 6v11c0 .563-.466 1.014-1.03 1.007-3.122-.043-5.018.212-7.97 1.023" />
                        </svg>

                        <p class="text-xl text-[#424242] font-semibold">
                            Total Buku
                        </p>
                    </div>
                    <p class="text-7xl text-[#424242] font-semibold ml-12"><?= $data['total_books']; ?></p>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <svg
                            class="w-10 h-10 bg-[#a0522d] text-[#EFE5DB] p-1 rounded-full"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24">
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 6.03v13m0-13c-2.819-.831-4.715-1.076-8.029-1.023A.99.99 0 0 0 3 6v11c0 .563.466 1.014 1.03 1.007 3.122-.043 5.018.212 7.97 1.023m0-13c2.819-.831 4.715-1.076 8.029-1.023A.99.99 0 0 1 21 6v11c0 .563-.466 1.014-1.03 1.007-3.122-.043-5.018.212-7.97 1.023" />
                        </svg>

                        <p class="text-xl text-[#424242] font-semibold">
                            Peminjaman Aktif
                        </p>
                    </div>
                    <p class="text-7xl text-[#424242] font-semibold ml-12"><?= $data['total_active_loans']; ?></p>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <svg
                            class="w-10 h-10 bg-[#a0522d] text-[#EFE5DB] p-1 rounded-full"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24">
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 6.03v13m0-13c-2.819-.831-4.715-1.076-8.029-1.023A.99.99 0 0 0 3 6v11c0 .563.466 1.014 1.03 1.007 3.122-.043 5.018.212 7.97 1.023m0-13c2.819-.831 4.715-1.076 8.029-1.023A.99.99 0 0 1 21 6v11c0 .563-.466 1.014-1.03 1.007-3.122-.043-5.018.212-7.97 1.023" />
                        </svg>

                        <p class="text-xl text-[#424242] font-semibold">
                            Buku Dikembalikan
                        </p>
                    </div>
                    <p class="text-7xl text-[#424242] font-semibold ml-12"><?= $data['total_returned_books']; ?></p>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div class="w-full bg-[#EFE5DB] rounded-lg p-3">
                <div class="flex items-center justify-between px-5 mb-5">
                    <p class="text-xl text-[#424242] font-semibold">
                        Tren Peminjaman
                    </p>
                </div>
                <div id="chart"></div>
            </div>
            <div class="w-full grid grid-rows-2 gap-3">
                <div class="w-full bg-[#EFE5DB] rounded-lg p-3">
                    <div class="flex items-center justify-between px-5">
                        <p class="text-xl text-[#424242] font-semibold">
                            Buku Terlaris
                        </p>

                        <div class="w-8 h-8 bg-[#FFC857] rounded-full"></div>
                    </div>
                    <table id="example" class="" style="width: 100%">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>Judul</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($data['best_selling_books'] as $book) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($book['judul']); ?></td>
                                    <td class="text-right"><?= $book['total_peminjaman']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script
    src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.2.2/datatables.min.js"
    integrity="sha384-h+dgoYlXhgp1Rdr2BQORgRZ8uTV8KHpMEDxsAXD5RMRvytPCeeiubqmZx5ZIewmp"
    crossorigin="anonymous"></script>

<script>
    new DataTable("#example", {
        info: false,
        ordering: false,
        paging: false,
        searching: false,
    });
    new DataTable("#example2", {
        info: false,
        ordering: false,
        paging: false,
        searching: false,
    });
</script>
<script>
    var options = {
        chart: {
            type: "line",
            toolbar: {
                show: false,
            },
        },
        markers: {
            size: 5,
        },
        stroke: {
            curve: "smooth",
            width: 2,
        },

        colors: ["#a0522d", "#FFC857"],
        series: [{
                name: "Peminjaman",
                data: <?= json_encode($data['chart_peminjaman_data']); ?>, // Dynamic data
            },
            {
                name: "Pengembalian",
                data: <?= json_encode($data['chart_pengembalian_data']); ?>, // Dynamic data
            },
        ],

        xaxis: {
            categories: <?= json_encode($data['chart_categories']); ?>,
        },
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);

    chart.render();
</script>