<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Bukti Pembayaran - <?= htmlspecialchars($transaction['reference_id']) ?></title>
    <style>
        @font-face {
            font-family: 'Ubuntu';
            font-style: normal;
            font-weight: 400;
            src: url('<?= realpath(__DIR__ . '/../../../../public/fonts/Ubuntu-Regular.ttf') ?>') format('truetype');
        }

        @font-face {
            font-family: 'Ubuntu';
            font-style: normal;
            font-weight: 700;
            src: url('<?= realpath(__DIR__ . '/../../../../public/fonts/Ubuntu-Bold.ttf') ?>') format('truetype');
        }

        body {
            font-family: 'Ubuntu', sans-serif;
            font-size: 11px;
            color: #333;
            background-color: #fff;
            margin: 0;
        }

        .receipt-container {
            border: 1px solid #e0e0e0;
            margin: 20px;
            padding: 25px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
        }

        .header {
            width: 100%;
            border-bottom: 2px solid #a0522d;
            /* Sienna */
            padding-bottom: 15px;
            margin-bottom: 15px;
        }

        .header td {
            vertical-align: middle;
        }

        .header .logo {
            width: 60px;
        }

        .header .logo img {
            width: 60px;
            height: auto;
        }

        .header .app-name {
            font-size: 20px;
            font-weight: 700;
            color: #a0522d;
            padding-left: 15px;
        }

        .header .receipt-title {
            font-size: 14px;
            font-weight: 700;
            color: #555;
            text-align: right;
            text-transform: uppercase;
        }

        .header .receipt-id {
            font-size: 11px;
            color: #777;
            text-align: right;
        }

        .details {
            width: 100%;
            margin-bottom: 20px;
        }

        .details .title {
            font-weight: 700;
            color: #555;
            margin-bottom: 8px;
        }

        .details table {
            width: 100%;
        }

        .details td {
            padding: 4px 0;
            vertical-align: top;
        }

        .details .label {
            color: #666;
            width: 120px;
        }

        .details .value {
            font-weight: 700;
            color: #333;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
        }

        .items-table th,
        .items-table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        .items-table th {
            background-color: #f7f7f7;
            font-weight: 700;
            color: #555;
            text-transform: uppercase;
        }

        .items-table .text-right {
            text-align: right;
        }

        .items-table .total-row td {
            border-top: 2px solid #333;
            border-bottom: none;
            font-weight: 700;
            font-size: 14px;
        }

        .items-table .total-row .total-amount {
            color: #a0522d;
            /* Sienna */
        }

        .footer {
            margin-top: 30px;
            text-align: center;
        }

        .footer .qr-code {
            margin-bottom: 15px;
        }

        .footer .qr-code img {
            width: 90px;
            height: 90px;
        }

        .footer .note {
            font-size: 10px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="receipt-container">

        <table class="header">
            <tr>
                <td class="logo"><img src="<?= $logo_base64 ?>" alt="Logo"></td>
                <td class="app-name">Bacain</td>
                <td>
                    <div class="receipt-title">Bukti Pembayaran</div>
                    <div class="receipt-id">#<?= htmlspecialchars($transaction['reference_id']) ?></div>
                </td>
            </tr>
        </table>

        <div class="details">
            <div class="title">Detail Pembayaran</div>
            <table>
                <tr>
                    <td class="label">Dibayarkan Kepada</td>
                    <td class="value">: Bacain Digital Library</td>
                </tr>
                <tr>
                    <td class="label">Tanggal Bayar</td>
                    <td class="value">: <?= date('d F Y, H:i:s', strtotime($transaction['updated_at'] ?: $transaction['created_at'])) ?></td>
                </tr>
            </table>
        </div>

        <div class="details">
            <div class="title">Dibayar Oleh</div>
            <table>
                <tr>
                    <td class="label">Nama Pelanggan</td>
                    <td class="value">: <?= htmlspecialchars($transaction['customer_name']) ?></td>
                </tr>
                <tr>
                    <td class="label">Email</td>
                    <td class="value">: <?= htmlspecialchars($transaction['customer_email']) ?></td>
                </tr>
            </table>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Deskripsi</th>
                    <th class="text-right">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Pembayaran Denda Perpustakaan</td>
                    <td class="text-right">Rp <?= number_format($transaction['amount'], 0, ',', '.') ?></td>
                </tr>
                <tr class="total-row">
                    <td>TOTAL</td>
                    <td class="text-right total-amount">Rp <?= number_format($transaction['amount'], 0, ',', '.') ?></td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <?php if (!empty($qr_base64)): ?>
                <div class="qr-code">
                    <img src="<?= $qr_base64 ?>" alt="QR Code">
                </div>
            <?php endif; ?>
            <div class="note">
                Ini adalah bukti pembayaran yang sah dan diterbitkan secara otomatis oleh sistem.
            </div>
        </div>

    </div>
</body>

</html>