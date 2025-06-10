<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Gagal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: center;
        }

        .container {
            max-width: 500px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }

        h2 {
            color: #721c24;
        }

        p {
            margin-bottom: 10px;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Pembayaran Gagal!</h2>
        <p>Maaf, pembayaran Anda tidak dapat diproses.</p>
        <p>Referensi Transaksi: <strong><?= htmlspecialchars($data['reference_id']) ?></strong></p>
        <p>Jumlah: <strong><?= htmlspecialchars($data['amount']) ?> <?= htmlspecialchars($data['currency']) ?></strong></p>
        <p>Status: <span style="color: red;"><strong><?= htmlspecialchars(ucfirst($data['status'])) ?></strong></span></p>
        <p><a href="/user/public/index.php?action=showPaymentForm">Coba lagi</a></p>
    </div>
    <script>
        const isEmptyUser = () => {
            if ('<?= isset($_SESSION['user_id']); ?>' != "") {
                return true;
            } else {
                return false;
            }
        };
        setTimeout(function() {
            console.log(isEmptyUser());
            if (isEmptyUser()) {
                window.location.href = '<?= BASEURL; ?>/user/profile';
            } else {
                window.location.href = 'about:blank';
            }
        }, 5000);
    </script>
</body>

</html>