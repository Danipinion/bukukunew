<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran QRIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Base styles consistent with your profile page */
        * {
            font-family: "Ubuntu", sans-serif;
            box-sizing: border-box;
        }

        body {
            overflow-x: hidden;
            overflow-y: auto !important;
            background-color: #f8f5f1;
            /* Light background for the whole page */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            /* Full viewport height */
            margin: 0;
            padding: 20px;
        }

        /* Reusing and adapting card styles */
        .card {
            background-color: #EFE5DB;
            /* Light cream background */
            border-radius: 0.75rem;
            padding: 2.5rem;
            /* Increased padding for more space */
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            /* Stronger shadow for prominence */
            width: 100%;
            max-width: 680px;
            /* Adjusted max-width to fit the image layout better */
            position: relative;
            /* For absolute positioning of date */
        }

        /* New styles for the QRIS page layout */
        .qris-header {
            text-align: center;
            margin-bottom: 2rem;
            border-bottom: 1px solid #d4c1ad;
            /* Sienna-nuanced border */
            padding-bottom: 1.5rem;
        }

        .qris-header h2 {
            font-size: 2rem;
            /* Larger title */
            color: #424242;
            /* Dark text */
            font-weight: 700;
            margin-bottom: 0.75rem;
        }

        .qris-header p {
            font-size: 1rem;
            color: #666;
            line-height: 1.5;
            max-width: 80%;
            margin: 0 auto;
            /* Center the paragraph */
        }

        .qris-content {
            display: flex;
            flex-wrap: wrap;
            /* Allows columns to wrap on smaller screens */
            gap: 2.5rem;
            /* Space between columns */
            justify-content: center;
            align-items: flex-start;
            /* Align items to the top */
        }

        .qris-details-left {
            flex: 1.5;
            /* Give left column more space */
            min-width: 280px;
            /* Minimum width before wrapping */
        }

        .qris-details-right {
            flex: 1;
            /* Right column takes remaining space */
            min-width: 250px;
            /* Minimum width before wrapping */
            display: flex;
            flex-direction: column;
            align-items: center;
            /* Center items vertically within its column */
        }

        .qris-details-item {
            margin-bottom: 1.2rem;
            /* Space between detail items */
        }

        .qris-details-item label {
            display: block;
            font-size: 0.88rem;
            color: #666;
            margin-bottom: 0.3rem;
            font-weight: 500;
        }

        .qris-details-item span {
            display: block;
            font-size: 1.05rem;
            color: #424242;
            font-weight: 600;
            /* Semibold for values */
        }

        .qris-details-item.amount span {
            font-size: 1.7rem;
            /* Larger font for amount */
            font-weight: 700;
            color: #a0522d;
            /* Sienna for amount */
            margin-top: 0.5rem;
        }

        .qris-qr-area {
            text-align: center;
            padding: 1.5rem;
            border: 1px dashed #d4c1ad;
            /* Dashed border for the QR area */
            border-radius: 0.75rem;
            background-color: #fcfafa;
            /* Slightly lighter background for QR area */
            margin-top: 1rem;
            /* Space from amount */
        }

        .qris-qr-area img {
            width: 220px;
            /* Slightly larger QR code */
            height: 220px;
            object-fit: contain;
            border: none;
            margin: 0 auto;
            display: block;
        }

        .qris-qr-area .enlarge-text {
            font-size: 0.75rem;
            color: #888;
            margin-top: 0.75rem;
            display: block;
            cursor: pointer;
            /* Indicate it's clickable */
            text-decoration: underline;
        }

        .qris-countdown {
            font-size: 1.2em;
            font-weight: 600;
            color: #a0522d;
            /* Sienna for countdown */
            margin-top: 2rem;
            text-align: center;
            padding-top: 1.5rem;
            border-top: 1px dashed #d4c1ad;
        }

        .qris-footer-note {
            text-align: center;
            font-size: 0.9rem;
            color: #888;
            margin-top: 1.5rem;
        }

        .qris-transaction-date {
            position: absolute;
            bottom: 1.5rem;
            /* Align with bottom padding */
            right: 2.5rem;
            /* Align with right padding */
            font-size: 0.85rem;
            color: #999;
            text-align: right;
            padding-top: 1rem;
            border-top: 1px solid #e0e0e0;
            /* Light separator */
            width: calc(100% - 5rem);
            /* Adjust width to fit */
            left: 2.5rem;
            /* Align with left padding */
            pointer-events: none;
            /* Prevent interaction */
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .qris-header h2 {
                font-size: 1.8rem;
            }

            .qris-header p {
                max-width: 90%;
            }

            .qris-content {
                flex-direction: column;
                gap: 2rem;
            }

            .qris-details-left,
            .qris-details-right {
                min-width: unset;
                width: 100%;
                text-align: center;
                /* Center details for single column */
            }

            .qris-qr-area {
                margin: 1.5rem auto 0;
                /* Center QR area horizontally */
            }

            .qris-details-item {
                text-align: center;
            }

            .qris-details-item label,
            .qris-details-item span {
                text-align: center;
                /* Center text within items */
            }

            .qris-transaction-date {
                position: static;
                /* Position normally at the end of the content flow */
                margin-top: 2rem;
                text-align: center;
                border-top: none;
                /* Remove border if it's no longer at the bottom */
                width: auto;
                left: auto;
                right: auto;
            }
        }

        @media (max-width: 480px) {
            .card {
                padding: 1.5rem;
            }

            .qris-header {
                padding-bottom: 1rem;
                margin-bottom: 1.5rem;
            }

            .qris-header h2 {
                font-size: 1.5rem;
            }

            .qris-qr-area img {
                width: 180px;
                height: 180px;
            }
        }
    </style>
</head>

<body>
    <?php
    $transaction_start_time = strtotime($data['expires_at']) - (10 * 60);
    ?>

    <div class="card">
        <div class="qris-header">
            <h2>Pembayaran Denda</h2>
            <p>Pastikan Anda melakukan pembayaran sebelum melewati batas pembayaran dan dengan nominal yang tepat.</p>
        </div>

        <div class="qris-content">
            <div class="qris-details-left">
                <div class="qris-details-item">
                    <label>Merchant</label>
                    <span>Bukuku</span>
                </div>
                <div class="qris-details-item">
                    <label>No. Invoice</label>
                    <span><?= htmlspecialchars($data['reference_id'] ?? 'N/A') ?></span>
                </div>
                <div class="qris-details-item">
                    <label>Nama</label>
                    <span><?= htmlspecialchars($data['customer_name'] ?? 'N/A') ?></span>
                </div>
                <div class="qris-details-item">
                    <label>Email</label>
                    <span><?= htmlspecialchars($data['customer_email'] ?? 'N/A') ?></span>
                </div>
            </div>

            <div class="qris-details-right">
                <div class="qris-details-item amount">
                    <label>Jumlah Tagihan</label>
                    <span>Rp. <?= number_format(floatval($data['amount']), 0, ',', '.'); ?></span>
                </div>
                <div class="qris-qr-area">
                    <img src="<?= htmlspecialchars($data['qr_code']) ?>" alt="QR Code Pembayaran">
                    <span class="enlarge-text">Klik untuk memperbesar</span>
                </div>
            </div>
        </div>

        <p class="qris-countdown">Waktu tersisa: <span id="time"></span></p>

        <p class="qris-footer-note">Anda akan diarahkan otomatis setelah pembayaran dikonfirmasi.</p>

        <div class="qris-transaction-date">
            <?= date('d M Y H:i', $transaction_start_time); ?>
        </div>
    </div>

    <script>
        let expiresAtTimestamp = new Date("<?= $data['expires_at'] ?>").getTime();
        let countdownElement = document.getElementById('time');

        function updateCountdown() {
            let now = new Date().getTime();
            let distance = expiresAtTimestamp - now;

            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((distance % (1000 * 60)) / 1000);

            if (distance < 0) {
                clearInterval(countdownInterval);
                countdownElement.innerHTML = "Waktu habis!";
                window.location.href = `/payment-gateway/public/index.php?action=paymentStatus&reference_id=<?= $data['reference_id'] ?>`;
            } else {
                countdownElement.innerHTML = minutes + "m " + seconds + "s ";
            }
        }

        updateCountdown();
        let countdownInterval = setInterval(updateCountdown, 1000); // Update every second

        let pollIntervalId = setInterval(function() {
            if ("<?= $data['change'] ?>" == "Y") {
                clearInterval(pollIntervalId);
                window.location.href = `<?= BASEURL; ?>/payment/showPaymentStatus/?reference_id=<?= $data['reference_id'] ?>`;
            } else {
                window.location.reload();
            }
        }, 3000);
    </script>
</body>

</html>