<?php

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Dompdf\Dompdf;
use Dompdf\Options;

class Payment extends Controller
{
    private $transactionModel;

    public function __construct()
    {
        $this->transactionModel = $this->model('Transaction_model');
    }

    public function processPayment()
    {
        $user = $this->model('User_model')->getUserByUsername($_SESSION['username']);
        $amount = $_POST['amount'];
        $customerName = $_SESSION['username'];
        $customerEmail = $_SESSION['email'];
        $paymentMethod = "Qris";

        if (!$amount || !$customerName || !$customerEmail || !$paymentMethod) {
            echo "Input tidak valid untuk pembayaran.";
            return;
        }

        $referenceId = 'TRX-' . uniqid();
        $paymentToken = bin2hex(random_bytes(16)); // Generate a unique token for QR

        $now = new DateTime();
        $timezone = new DateTimeZone('Asia/Jakarta');
        $now = new DateTime('now', $timezone);
        $expiresAt = $now->modify('+5 minutes')->format('Y-m-d H:i:s');

        $data = [
            'user_id'        => $user['id'],
            'reference_id'   => $referenceId,
            'payment_token'  => $paymentToken,
            'amount'         => $amount,
            'currency'       => 'IDR',
            'payment_method' => $paymentMethod,
            'customer_name'  => $customerName,
            'customer_email' => $customerEmail,
            'status'         => 'pending',
            'expires_at'     => $expiresAt // Store expiration time
        ];

        if ($this->transactionModel->create($data)) {
            header('Location: ' . BASEURL . '/payment/showQrPayment/?token=' . $paymentToken);
            exit();
        } else {
            header('Location: ' . BASEURL . '/user/profile');
        }
    }


    public function showQrPayment()
    {
        $paymentToken = $_GET['token'];
        if (!$paymentToken) {
            echo "Token pembayaran tidak ditemukan.";
            return;
        }

        $transaction = $this->transactionModel->findByPaymentToken($paymentToken);

        if (!$transaction) {
            echo "Transaksi tidak ditemukan.";
            return;
        }
        $timezone = new DateTimeZone('Asia/Jakarta');
        $now = new DateTime('now', $timezone);
        $now = $now->format('Y-m-d H:i:s');
        $expiresAt = (new DateTime($transaction['expires_at']))->format('Y-m-d H:i:s');

        if ($transaction['status'] !== 'pending' || $now > $expiresAt) {
            // If expired, update status to failed
            if ($transaction['status'] === 'pending' && $now > $expiresAt) {
                $this->transactionModel->updateStatus($transaction['payment_token'], 'failed', 'payment_token');
                $transaction['status'] = 'failed'; // Update current transaction array
            }
            // Redirect to status page if not pending or expired
            header('Location:' . BASEURL . '/payment/ShowPaymentStatus/?reference_id=' . $transaction['reference_id']);
            exit();
        }

        // Generate QR Code
        $options = new QROptions([
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel'   => QRCode::ECC_L,
            'scale'      => 8,
            'imageBase64' => true
        ]);

        // The URL embedded in the QR code will be the confirmation page
        // Use relative path from public/
        $qrData = 'http://' . BASEURL . '/payment/approveQrPayment/?token=' . $paymentToken;
        $qrcode = (new QRCode($options))->render($qrData);

        $expiresAt = new DateTime($expiresAt);
        $now = new DateTime($now);

        $data = [
            'reference_id'   => $transaction['reference_id'],
            'payment_token'  => $transaction['payment_token'],
            'amount'         => $transaction['amount'],
            'currency'       => $transaction['currency'],
            'payment_method' => $transaction['payment_method'],
            'customer_name'  => $transaction['customer_name'],
            'customer_email' => $transaction['customer_email'],
            'status'         => $transaction['status'],
            'change'         => $transaction['change'],
            'expires_at'     => $transaction['expires_at'],
            'qr_code'         => $qrcode,
        ];
        $this->view('user/payment/qr_payment', $data);
    }

    public function approveQrPayment()
    {
        $paymentToken = $_GET['token'];
        if (!$paymentToken) {
            echo "Token pembayaran tidak ditemukan.";
            return;
        }

        $transaction = $this->transactionModel->findByPaymentToken($paymentToken);
        if (!$transaction) {
            echo "Transaksi tidak ditemukan.";
            return;
        }

        // Check if transaction has expired or is already processed
        $timezone = new DateTimeZone('Asia/Jakarta');
        $now = new DateTime('now', $timezone);
        $now = $now->format('Y-m-d H:i:s');
        $expiresAt = (new DateTime($transaction['expires_at']))->format('Y-m-d H:i:s');

        $expiresAt = new DateTime($expiresAt);
        $now = new DateTime($now);


        if ($transaction['status'] !== 'pending' || $now > $expiresAt) {
            // If expired, update status to failed
            if ($transaction['status'] === 'pending' && $now > $expiresAt) {
                $this->transactionModel->updateStatus($transaction['payment_token'], 'failed', 'payment_token');
                $transaction['status'] = 'failed'; // Update current transaction array
            }
            // Redirect to status page if not pending or expired
            header('Location:' . BASEURL . '/payment/showPaymentStatus/?reference_id=' . $transaction['reference_id']);
            exit();
        }
        $data = [
            'reference_id'   => $transaction['reference_id'],
            'payment_token'  => $transaction['payment_token'],
            'amount'         => $transaction['amount'],
            'currency'       => $transaction['currency'],
            'payment_method' => $transaction['payment_method'],
            'customer_name'  => $transaction['customer_name'],
            'customer_email' => $transaction['customer_email'],
            'status'         => $transaction['status'],
            'expires_at'     => $transaction['expires_at'],
        ];

        $this->view('user/payment/approve_payment', $data);
    }

    public function finalizeApproval()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $paymentToken = filter_input(INPUT_POST, 'payment_token', FILTER_SANITIZE_STRING);
            $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);

            if (!$paymentToken || !in_array($action, ['approve', 'cancel'])) {
                echo "Input tidak valid.";
                return;
            }

            $transaction = $this->transactionModel->findByPaymentToken($paymentToken);
            if (!$transaction) {
                echo "Transaksi tidak ditemukan.";
                return;
            }

            $timezone = new DateTimeZone('Asia/Jakarta');
            $now = new DateTime('now', $timezone);
            $now = $now->format('Y-m-d H:i:s');
            $expiresAt = (new DateTime($transaction['expires_at']))->format('Y-m-d H:i:s');

            $expiresAt = new DateTime($expiresAt);
            $now = new DateTime($now);

            if ($transaction['status'] !== 'pending' || $now > $expiresAt) {
                header('Location:' . BASEURL . '/payment/showPaymentStatus/?reference_id=' . $transaction['reference_id']);
                exit();
            }

            $status = ($action === 'approve') ? 'success' : 'failed';


            if ($this->transactionModel->updateStatus($paymentToken, $status, 'payment_token', 'y')) {
                $userId = $this->model('User_model')->getUserByUsername($transaction['customer_name']);
                $this->model('User_model')->kurangDenda($userId['id'], $transaction['amount']);
                header('Location:' . BASEURL . '/payment/showPaymentStatus/?reference_id=' . $transaction['reference_id']);
                exit();
            } else {
                echo "Gagal memperbarui status transaksi.";
            }
        }
    }

    public function showPaymentStatus()
    {
        $referenceId = $_GET['reference_id'];
        if (!$referenceId) {
            echo "ID referensi transaksi tidak ditemukan.";
            return;
        }

        $transaction = $this->transactionModel->findByReferenceId($referenceId);

        if (!$transaction) {
            echo "Transaksi tidak ditemukan.";
            return;
        }

        if ($transaction['status'] === 'pending') {
            $timezone = new DateTimeZone('Asia/Jakarta');
            $now = new DateTime('now', $timezone);
            $now = $now->format('Y-m-d H:i:s');
            $expiresAt = (new DateTime($transaction['expires_at']))->format('Y-m-d H:i:s');

            $expiresAt = new DateTime($expiresAt);
            $now = new DateTime($now);
            if ($now > $expiresAt) {
                $this->transactionModel->updateStatus($referenceId, 'failed', 'reference_id');
                $transaction['status'] = 'failed'; // Update current transaction array
            }
        }
        $data = [
            'reference_id'   => $transaction['reference_id'],
            'payment_token'  => $transaction['payment_token'],
            'amount'         => $transaction['amount'],
            'currency'       => $transaction['currency'],
            'payment_method' => $transaction['payment_method'],
            'customer_name'  => $transaction['customer_name'],
            'customer_email' => $transaction['customer_email'],
            'status'         => $transaction['status'],
            'expires_at'     => $transaction['expires_at'],
        ];
        if ($transaction['status'] === 'success') {
            $this->view('user/payment/success_payment', $data);
        } else {
            $this->view('user/payment/failed_payment', $data);
        }
    }

    public function downloadPdfReceipt($id)
    {
        // 1. Validasi dan Ambil Data Transaksi
        // ================================================================
        if (empty($id) || !is_numeric($id)) {
            Flasher::setFlash('ID transaksi tidak valid.', 'danger');
            header('Location: ' . BASEURL . '/user/profile');
            exit;
        }

        $transaction = $this->transactionModel->findById($id);

        if (!isset($_SESSION['user_id'])) {
            Flasher::setFlash('Sesi tidak valid.', 'danger');
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
        $user = $this->model('User_model')->getUserById($_SESSION['user_id']);

        if (!$transaction || !$user || ($transaction['user_id'] != $user['id'] && $user['role'] != 'admin')) {
            Flasher::setFlash('Anda tidak memiliki akses ke bukti transaksi ini.', 'danger');
            header('Location: ' . BASEURL . '/user/profile');
            exit;
        }

        if ($transaction['status'] !== 'completed' && $transaction['status'] !== 'success') {
            Flasher::setFlash('Bukti PDF hanya tersedia untuk transaksi yang sudah selesai.', 'warning');
            header('Location: ' . BASEURL . '/user/profile');
            exit;
        }

        // 2. Siapkan Aset (Logo dan QR Code) untuk View PDF
        // ====================================================

        // Konversi logo ke base64 agar mudah di-embed di HTML
        $logoPath = 'img/logo.png'; // Path relatif dari folder public
        $logo_base64 = '';
        if (file_exists($logoPath)) {
            $type = pathinfo($logoPath, PATHINFO_EXTENSION);
            $fileData = file_get_contents($logoPath);
            $logo_base64 = 'data:image/' . $type . ';base64,' . base64_encode($fileData);
        } else {
            error_log("Logo file not found at path: " . $logoPath);
        }

        // Buat QR Code dan konversi ke base64
        $qr_base64 = '';
        try {
            $qrOptions = new QROptions([
                'outputType'  => QRCode::OUTPUT_IMAGE_PNG,
                'eccLevel'    => QRCode::ECC_L,
                'scale'       => 4,
                'imageBase64' => false, // Kita butuh data mentah (binary)
            ]);
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $host = $_SERVER['HTTP_HOST'];
            $qrDataUrl = BASEURL . '/payment/showPaymentStatus/?reference_id=' . $transaction['reference_id'];

            $qrCodeRawData = (new QRCode($qrOptions))->render($qrDataUrl);
            $qr_base64 = 'data:image/png;base64,' . base64_encode($qrCodeRawData);
        } catch (Exception $e) {
            error_log("Gagal membuat QR Code untuk struk PDF: " . $e->getMessage());
        }


        // 3. Render HTML menjadi String
        // ==============================
        ob_start();
        // Variabel yang dikirim ke view sekarang termasuk $logo_base64 dan $qr_base64
        require_once '../app/views/user/payment/receipt_pdf.php';
        $html = ob_get_clean();

        // 4. Konfigurasi dan Buat PDF dengan Dompdf
        // ============================================
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('chroot', realpath(__DIR__ . '/../../..'));

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A5', 'portrait');
        $dompdf->render();

        // 5. Kirim PDF ke Browser untuk Diunduh
        // =========================================
        $filename = 'bukti-pembayaran-' . $transaction['reference_id'] . '.pdf';
        $dompdf->stream($filename, ["Attachment" => true]);

        exit;
    }

    public function cleanupExpiredTransactions()
    {
        $expiredTransactions = $this->transactionModel->findExpiredPendingTransactions();
        $count = 0;
        foreach ($expiredTransactions as $transaction) {
            if ($this->transactionModel->updateStatus($transaction['payment_token'], 'failed', 'payment_token')) {
                $count++;
            }
        }
        echo "Cleaned up {$count} expired transactions.";
    }
}
