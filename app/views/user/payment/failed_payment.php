<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Gagal</title>
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
            /* Max width for consistency */
            margin: auto;
            text-align: center;
            position: relative;
            /* For the icon positioning */
        }

        .card-header {
            color: #424242;
            /* Dark text for header */
            font-weight: 700;
            /* Bolder header */
            font-size: 2rem;
            /* Larger header */
            margin-bottom: 1.5rem;
        }

        /* Failure Icon */
        .failure-icon {
            display: inline-block;
            width: 80px;
            height: 80px;
            background-color: #dc3545;
            /* Standard red for danger */
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem auto;
            color: white;
            font-size: 3rem;
            /* Size of the 'X' */
            font-weight: bold;
            line-height: 1;
        }

        /* Main failure message */
        .main-message {
            font-size: 1.1rem;
            color: #424242;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        /* Styles for transaction details */
        .transaction-details-list {
            text-align: left;
            margin: 0 auto 1.5rem auto;
            /* Adjusted margin */
            width: fit-content;
        }

        .transaction-details-item {
            margin-bottom: 0.8rem;
            display: flex;
            align-items: baseline;
        }

        .transaction-details-item label {
            font-size: 1rem;
            color: #666;
            margin-right: 0.5rem;
            min-width: 120px;
            text-align: right;
        }

        .transaction-details-item span {
            font-size: 1.05rem;
            color: #424242;
            font-weight: 600;
            flex-grow: 1;
            text-align: left;
        }

        /* Specific style for failed status */
        .transaction-details-item .status-failed {
            color: #dc3545;
            /* Red for failed status */
            font-weight: 700;
        }

        /* Reusing action button styles */
        .action-button {
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: 600;
            transition: all 0.2s ease-in-out;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            cursor: pointer;
            font-size: 1rem;
            border: none;
            text-decoration: none;
            margin-top: 1rem;
            /* Space above button */
        }

        .action-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .action-button-secondary {
            background-color: #FFC857;
            /* Amber */
            color: #424242;
        }

        .action-button-secondary:hover {
            background-color: #FFD28F;
            /* Amber lighter */
        }


        .redirect-message {
            font-size: 0.95rem;
            color: #888;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px dashed #d4c1ad;
            /* Consistent dashed border */
        }

        .redirect-message span {
            font-weight: 600;
            color: #a0522d;
            /* Sienna for highlight */
        }

        /* Responsive adjustments */
        @media (max-width: 600px) {
            .card {
                padding: 1.5rem;
            }

            .card-header {
                font-size: 1.6rem;
            }

            .failure-icon {
                width: 70px;
                height: 70px;
                font-size: 2.5rem;
            }

            .main-message {
                font-size: 1rem;
            }

            .transaction-details-list {
                width: 100%;
                text-align: left;
            }

            .transaction-details-item {
                flex-direction: column;
                align-items: flex-start;
                margin-bottom: 1rem;
            }

            .transaction-details-item label {
                min-width: unset;
                text-align: left;
                margin-bottom: 0.2rem;
            }
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="failure-icon">&#10006;</div>
        <h2 class="card-header">Pembayaran Gagal!</h2>
        <p class="main-message">Maaf, pembayaran Anda tidak dapat diproses. <?= htmlspecialchars($data['error_message'] ?? 'Silakan coba lagi atau hubungi dukungan.') ?></p>

        <div class="transaction-details-list">
            <div class="transaction-details-item">
                <label>Referensi Transaksi:</label>
                <span><?= htmlspecialchars($data['reference_id']) ?></span>
            </div>
            <div class="transaction-details-item">
                <label>Jumlah:</label>
                <span>Rp. <?= number_format(floatval($data['amount']), 0, ',', '.'); ?> <?= htmlspecialchars($data['currency']) ?></span>
            </div>
            <div class="transaction-details-item">
                <label>Status:</label>
                <span class="status-failed"><?= htmlspecialchars(ucfirst($data['status'])) ?></span>
            </div>
        </div>

        <p class="redirect-message">Anda akan dialihkan ke halaman <span>profil Anda</span> dalam <span id="countdown">5</span> detik...</p>
    </div>

    <script>
        const BASEURL = "<?= defined('BASEURL') ? BASEURL : '/your_app_base_path/public' ?>"; // Adjust to your actual base URL

        const isEmptyUser = () => {
            return "<?= isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) ? 'true' : 'false'; ?>" === 'true';
        };

        let countdown = 5;
        const countdownElement = document.getElementById('countdown');

        const updateCountdown = () => {
            countdown--;
            countdownElement.textContent = countdown;
            if (countdown <= 0) {
                clearInterval(countdownInterval);
                if (isEmptyUser()) {
                    window.location.href = `${BASEURL}/user/profile`;
                } else {
                    // For a failed payment, redirecting to login/home might be more appropriate.
                    window.location.href = `${BASEURL}/auth/login`; // Example: redirect to login
                    // window.location.href = 'about:blank'; // Your original logic
                }
            }
        };

        const countdownInterval = setInterval(updateCountdown, 1000);
    </script>
</body>

</html>