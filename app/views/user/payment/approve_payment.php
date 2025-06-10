<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pembayaran</title>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Base styles consistent with your other pages */
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
            margin: 0;
            padding: 20px;
        }

        /* Reusing card styles */
        .card {
            background-color: #EFE5DB;
            /* Light cream background */
            border-radius: 0.75rem;
            padding: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            width: 100%;
            max-width: 550px;
            /* Adjust max-width for confirmation */
            margin: auto;
            /* Center the card */
            text-align: center;
        }

        .card-header {
            border-bottom: 1px solid #d4c1ad;
            /* Border bernuansa Sienna */
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
            color: #424242;
            /* Teks gelap untuk header */
            font-weight: 600;
            font-size: 1.8rem;
            /* Larger header */
            text-align: center;
        }

        /* Custom styles for action buttons */
        .action-button {
            padding: 0.75rem 1.5rem;
            /* Larger padding for buttons */
            border-radius: 0.375rem;
            font-weight: 600;
            transition: all 0.2s ease-in-out;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            cursor: pointer;
            font-size: 1rem;
            /* Standard font size */
            border: none;
            text-decoration: none;
            /* For potential <a> tags */
        }

        .action-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .action-button-primary {
            background-color: #a0522d;
            /* Sienna */
            color: white;
        }

        .action-button-primary:hover {
            background-color: #8b4513;
            /* Sienna darker */
        }

        .action-button-danger {
            background-color: #dc3545;
            /* Red */
            color: white;
        }

        .action-button-danger:hover {
            background-color: #c82333;
            /* Red darker */
        }

        /* Styles for the detail items */
        .payment-details-list {
            text-align: left;
            /* Align details to the left */
            margin: 0 auto 2rem auto;
            /* Center the block and add bottom margin */
            width: fit-content;
            /* Only take content width */
        }

        .payment-details-item {
            margin-bottom: 0.8rem;
            display: flex;
            /* Use flex for label and value alignment */
            align-items: baseline;
        }

        .payment-details-item label {
            font-size: 1rem;
            color: #666;
            margin-right: 0.5rem;
            /* Space between label and value */
            min-width: 120px;
            /* Consistent width for labels */
            text-align: right;
            /* Align labels to the right */
        }

        .payment-details-item span {
            font-size: 1.05rem;
            color: #424242;
            font-weight: 600;
            flex-grow: 1;
            /* Allow value to take remaining space */
            text-align: left;
            /* Align values to the left */
        }

        /* Specific style for status */
        .payment-details-item .status-pending {
            color: #FFC857;
            /* Amber for pending status */
            font-weight: 700;
        }

        .main-message {
            font-size: 1.1rem;
            color: #424242;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .button-group {
            display: flex;
            justify-content: center;
            /* Center the buttons */
            gap: 1.5rem;
            /* Space between buttons */
            margin-top: 2rem;
        }

        /* Responsive adjustments */
        @media (max-width: 600px) {
            .card {
                padding: 1.5rem;
            }

            .card-header {
                font-size: 1.5rem;
                margin-bottom: 1rem;
            }

            .main-message {
                font-size: 1rem;
                margin-bottom: 1rem;
            }

            .payment-details-list {
                width: 100%;
                text-align: left;
            }

            .payment-details-item {
                flex-direction: column;
                /* Stack label and value */
                align-items: flex-start;
                margin-bottom: 1rem;
            }

            .payment-details-item label {
                min-width: unset;
                text-align: left;
                margin-bottom: 0.2rem;
            }

            .button-group {
                flex-direction: column;
                gap: 1rem;
            }

            .action-button {
                width: 100%;
                /* Full width buttons */
            }
        }
    </style>
</head>

<body>
    <div class="card">
        <h2 class="card-header">Konfirmasi Pembayaran</h2>
        <p class="main-message">Anda akan melakukan pembayaran untuk transaksi berikut:</p>

        <div class="payment-details-list">
            <div class="payment-details-item">
                <label>Transaksi Ref:</label>
                <span><?= htmlspecialchars($data['reference_id']) ?></span>
            </div>
            <div class="payment-details-item">
                <label>Jumlah:</label>
                <span>Rp. <?= number_format(floatval($data['amount']), 0, ',', '.'); ?> <?= htmlspecialchars($data['currency']) ?></span>
            </div>
            <div class="payment-details-item">
                <label>Untuk:</label>
                <span><?= htmlspecialchars($data['customer_name']) ?></span>
            </div>
            <div class="payment-details-item">
                <label>Status Saat Ini:</label>
                <span class="status-pending"><?= htmlspecialchars(ucfirst($data['status'])) ?></span>
            </div>
        </div>

        <form action="<?php echo BASEURL; ?>/payment/finalizeApproval" method="POST">
            <input type="hidden" name="payment_token" value="<?= htmlspecialchars($data['payment_token']) ?>">
            <div class="button-group">
                <button type="submit" name="action" value="approve" class="action-button action-button-primary">
                    Setujui Pembayaran
                </button>
                <button type="submit" name="action" value="cancel" class="action-button action-button-danger">
                    Batalkan
                </button>
            </div>
        </form>
    </div>
</body>

</html>