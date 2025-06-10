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
    <link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.2.2/datatables.min.css" rel="stylesheet">
    <style>
        * {
            font-family: "Ubuntu", sans-serif;
        }

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

        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 1rem;
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #ccc;
            border-radius: 0.25rem;
            padding: 0.5rem 1rem;
            width: 300px;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .dataTables_wrapper table.dataTable thead th {
            background-color: #a0522d;
            color: white;
            padding: 0.75rem 1rem;
            text-align: left;
            font-weight: bold;
            border-bottom: 2px solid #8c4525;
        }

        .dataTables_wrapper table.dataTable tbody td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e2e8f0;
            color: #424242;
        }

        .dataTables_wrapper table.dataTable tbody tr:nth-child(odd) {
            background-color: #fcf8f5;
        }

        .dataTables_wrapper table.dataTable tbody tr:nth-child(even) {
            background-color: #EFE5DB;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.5rem 1rem;
            margin: 0 0.25rem;
            border: 1px solid #ccc;
            border-radius: 0.25rem;
            cursor: pointer;
            background-color: white;
            color: #a0522d;
            transition: all 0.2s ease-in-out;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: #ffc857;
            border-color: #ffc857;
            color: white;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #a0522d;
            color: white;
            border-color: #a0522d;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 0.25rem;
            font-weight: 500;
            display: inline-block;
            color: white;
        }

        .status-proses {
            background-color: #ffc107;
        }

        .status-disetujui {
            background-color: #28a745;
        }

        .status-dikembalikan {
            background-color: #6c757d;
        }

        .status-ditolak {
            background-color: #dc3545;
        }

        .status-terlambat {
            background-color: #d63384;
        }

        .status-dibatalkan {
            background-color: #6c757d;
        }
    </style>
    <title><?= $data['judul']; ?></title>
</head>

<body class="bg-[#FCF8F5]">
    <div class="p-4 sm:ml-64 mt-20">
        <p class="text-2xl text-[#424242] font-semibold mb-2">Log Peminjaman</p>
        <div class="p-4 rounded-lg border-2 border-gray-200 border-dashed h-[calc(100vh-110px)] overflow-y-auto main-content">
            <div class="grid grid-cols-1 gap-4 mb-4">
                <div class="items-center justify-center rounded-lg bg-[#EFE5DB] px-10 py-5">
                    <div class="flex items-center justify-between">
                        <p class="text-xl text-[#424242] font-semibold">Semua Log Peminjaman</p>
                    </div>
                    <table id="logTable" class="" style="width: 100%">
                        <thead>
                            <tr>
                                <th class="w-10">NO</th>
                                <th>Nama User</th>
                                <th>Judul Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali (Estimasi)</th>
                                <th>Sisa Hari</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($data['log_peminjaman'] as $log) : ?>
                                <?php
                                $tanggal_kembali_expected = new DateTime($log['tanggal_kembali_expected']);
                                $today = new DateTime();
                                $interval = $today->diff($tanggal_kembali_expected);
                                $sisa_hari = $interval->days;
                                $is_terlambat = ($today > $tanggal_kembali_expected && $log['status'] == 'disetujui');

                                if ($is_terlambat) {
                                    $log['status'] = 'terlambat';
                                }
                                ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $log['username']; ?></td>
                                    <td><?= $log['judul']; ?></td>
                                    <td><?= date('d M Y', strtotime($log['tanggal_peminjaman'])); ?></td>
                                    <td><?= date('d M Y', strtotime($log['tanggal_kembali_expected'])); ?></td>
                                    <td>
                                        <?php
                                        if ($log['status'] == 'disetujui') {
                                            if ($is_terlambat) {
                                                echo '<span class="text-red-600 font-bold">' . $sisa_hari . ' Hari (Terlambat)</span>';
                                            } else {
                                                echo $sisa_hari . ' Hari';
                                            }
                                        } else {
                                            echo '-'; // Jika sudah dikembalikan, ditolak, atau proses
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?= $log['status']; ?>">
                                            <?= ucfirst($log['status']); ?>
                                        </span>
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
    <script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.2.2/datatables.min.js"></script>
    <script>
        new DataTable("#logTable", {
            info: false,
            // order: [[0, 'desc']], // Optional: order by newest first
            pageLength: 5

        });
    </script>
</body>

</html>