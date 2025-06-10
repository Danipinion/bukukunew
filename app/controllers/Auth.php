<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Auth extends Controller
{

    private function generateCaptchaText($length = 6)
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $captcha_text = '';
        for ($i = 0; $i < $length; $i++) {
            $captcha_text .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $captcha_text;
    }
    private function generateOtp($length = 6)
    {
        $generator = "1357902468"; // Numeric OTP
        $result = "";
        for ($i = 1; $i <= $length; $i++) {
            $result .= substr($generator, (rand() % (strlen($generator))), 1);
        }
        return $result;
    }

    public function index()
    {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['role'] == 'admin') {
                header('Location: ' . BASEURL . '/admin');
                exit;
            } else {
                header('Location: ' . BASEURL . '/user');
                exit;
            }
        }
        $captcha_text = $this->generateCaptchaText();
        $_SESSION['captcha_text'] = $captcha_text;
        $data['captcha_text'] = $captcha_text;
        $data['title'] = 'Login';
        if (defined('GOOGLE_CLIENT_ID')) {
            $data['google_login_url'] = BASEURL . '/auth/google_login';
        } else {
            $data['google_login_url'] = null;
        }

        $this->view('templates/headerAuth', $data);
        $this->view('auth/index', $data);
        $this->view('templates/footerAuth');
    }

    public function daftar()
    {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['role'] == 'admin') {
                header('Location: ' . BASEURL . '/admin');
                exit;
            } else {
                header('Location: ' . BASEURL . '/user');
                exit;
            }
        }
        $captcha_text = $this->generateCaptchaText();
        $_SESSION['captcha_text'] = $captcha_text;
        $data['captcha_text'] = $captcha_text;
        $data['title'] = 'Daftar';
        $this->view('templates/headerAuth', $data);
        $this->view('auth/daftar', $data);
        $this->view('templates/footerAuth');
    }

    public function lupa_password()
    {
        $data['title'] = 'Lupa Password';
        $this->view('templates/headerAuth', $data);
        $this->view('auth/lupaPassword', $data);
        $this->view('templates/footerAuth');
    }

    public function proses_lupa_password()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_POST['email']) || empty(trim($_POST['email']))) {
                Flasher::setFlash('Email wajib diisi.', 'danger');
                header('Location: ' . BASEURL . '/auth/lupa_password');
                exit;
            }

            $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
            if (!$email) {
                Flasher::setFlash('Format email tidak valid.', 'danger');
                header('Location: ' . BASEURL . '/auth/lupa_password');
                exit;
            }

            $userModel = $this->model('User_model');
            $user = $userModel->getUserByEmail($email);

            if (!$user) {
                Flasher::setFlash('Email tidak terdaftar di sistem kami.', 'warning');
                header('Location: ' . BASEURL . '/auth/lupa_password');
                exit;
            }
            if (!empty($user['oauth_provider'])) {
                Flasher::setFlash('Akun ini terdaftar melalui ' . ucfirst($user['oauth_provider']) . '. Silakan login menggunakan metode tersebut atau hubungi admin jika Anda lupa akses.', 'warning');
                header('Location: ' . BASEURL . '/auth/lupa_password');
                exit;
            }

            // Generate OTP
            $otp = $this->generateOtp();
            $otp_expiry = date('Y-m-d H:i:s', time() + (OTP_EXPIRY_MINUTES * 60));

            if (!$userModel->storeOtp($user['id'], $otp, $otp_expiry)) {
                Flasher::setFlash('Gagal memproses permintaan. Silakan coba lagi.', 'danger');
                header('Location: ' . BASEURL . '/auth/lupa_password');
                exit;
            }

            // Send OTP email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = MAIL_HOST;
                $mail->SMTPAuth   = true;
                $mail->Username   = MAIL_USERNAME;
                $mail->Password   = MAIL_PASSWORD;
                $mail->SMTPSecure = MAIL_ENCRYPTION;
                $mail->Port       = MAIL_PORT;

                // Recipients
                $mail->setFrom(MAIL_FROM_ADDRESS, MAIL_FROM_NAME);
                $mail->addAddress($user['email'], $user['username']);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Reset Password Akun Bacain Anda';
                $mail->Body    = "Halo " . htmlspecialchars($user['username']) . ",<br><br>" .
                    "Anda menerima email ini karena ada permintaan untuk mereset password akun Anda.<br>" .
                    "Gunakan kode OTP berikut untuk mereset password Anda:<br><br>" .
                    "<b>" . $otp . "</b><br><br>" .
                    "Kode OTP ini akan kedaluwarsa dalam " . OTP_EXPIRY_MINUTES . " menit.<br>" .
                    "Jika Anda tidak meminta reset password, abaikan email ini.<br><br>" .
                    "Terima kasih,<br>Tim Bacain";
                $mail->AltBody = "Halo " . htmlspecialchars($user['username']) . ",\n\n" .
                    "Anda menerima email ini karena ada permintaan untuk mereset password akun Anda.\n" .
                    "Gunakan kode OTP berikut untuk mereset password Anda:\n\n" .
                    $otp . "\n\n" .
                    "Kode OTP ini akan kedaluwarsa dalam " . OTP_EXPIRY_MINUTES . " menit.\n" .
                    "Jika Anda tidak meminta reset password, abaikan email ini.\n\n" .
                    "Terima kasih,\nTim Bacain";

                $mail->send();

                $_SESSION['reset_email'] = $user['email'];

                Flasher::setFlash('Kode OTP telah dikirim ke email Anda. Silakan periksa kotak masuk atau folder spam.', 'success');
                header('Location: ' . BASEURL . '/auth/verifikasi_otp');
                exit;
            } catch (Exception $e) {
                Flasher::setFlash("Gagal mengirim email OTP. Mailer Error: {$mail->ErrorInfo}", 'danger');
                header('Location: ' . BASEURL . '/auth/lupa_password');
                exit;
            }
        } else {
            header('Location: ' . BASEURL . '/auth/lupa_password');
            exit;
        }
    }

    public function verifikasi_otp()
    {
        if (!isset($_SESSION['reset_email'])) {
            Flasher::setFlash('Sesi reset password tidak valid atau telah kedaluwarsa.', 'warning');
            header('Location: ' . BASEURL . '/auth/lupa_password');
            exit;
        }

        $data['title'] = 'Verifikasi OTP';
        $data['email'] = $_SESSION['reset_email']; // Pass email to the view for display
        $this->view('templates/headerAuth', $data);
        $this->view('auth/verifikasiOtp', $data); // New view for OTP entry
        $this->view('templates/footerAuth');
    }

    public function proses_verifikasi_otp()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_SESSION['reset_email'])) {
                Flasher::setFlash('Sesi reset password tidak valid atau telah kedaluwarsa.', 'warning');
                header('Location: ' . BASEURL . '/auth/lupa_password');
                exit;
            }

            $email = $_SESSION['reset_email'];
            $otp_input = $_POST['otp'] ?? '';
            $new_password = $_POST['password'] ?? '';
            $confirm_password = $_POST['cpassword'] ?? '';

            if (empty($otp_input) || empty($new_password) || empty($confirm_password)) {
                Flasher::setFlash('Semua field wajib diisi.', 'danger');
                header('Location: ' . BASEURL . '/auth/verifikasi_otp');
                exit;
            }

            if (strlen($new_password) < 6) { // Example: minimum password length
                Flasher::setFlash('Password baru minimal 6 karakter.', 'danger');
                header('Location: ' . BASEURL . '/auth/verifikasi_otp');
                exit;
            }

            if ($new_password !== $confirm_password) {
                Flasher::setFlash('Konfirmasi password baru tidak sesuai.', 'danger');
                header('Location: ' . BASEURL . '/auth/verifikasi_otp');
                exit;
            }

            $userModel = $this->model('User_model');
            $user = $userModel->getUserByEmailForOtpValidation($email); // Method to get user, OTP, and expiry

            if (!$user || $user['otp'] !== $otp_input) {
                Flasher::setFlash('Kode OTP salah.', 'danger');
                header('Location: ' . BASEURL . '/auth/verifikasi_otp');
                exit;
            }

            $current_time = time();
            $otp_expiry_time = strtotime($user['otp_expiry']);

            if ($current_time > $otp_expiry_time) {
                Flasher::setFlash('Kode OTP sudah kedaluwarsa. Silakan minta OTP baru.', 'danger');
                $userModel->clearOtp($user['id']); // Clear expired OTP
                header('Location: ' . BASEURL . '/auth/verifikasi_otp');
                exit;
            }

            // OTP is valid, update password and clear OTP
            $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
            if ($userModel->updatePasswordAndClearOtp($user['id'], $hashedPassword)) {
                unset($_SESSION['reset_email']); // Clear session
                Flasher::setFlash('Password berhasil direset. Silakan login dengan password baru Anda.', 'success');
                header('Location: ' . BASEURL . '/auth/index');
                exit;
            } else {
                Flasher::setFlash('Gagal mereset password. Terjadi kesalahan.', 'danger');
                header('Location: ' . BASEURL . '/auth/verifikasi_otp');
                exit;
            }
        } else {
            header('Location: ' . BASEURL . '/auth/verifikasi_otp');
            exit;
        }
    }

    public function proses_daftar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $cpassword = $_POST['cpassword'];
            $captcha = $_POST['captcha'];

            // Validasi sederhana
            if (empty($username) || empty($email) || empty($password) || empty($cpassword) || empty($captcha)) {
                Flasher::setFlash('Semua field wajib diisi.', 'danger');
                header('Location: ' . BASEURL . '/auth/daftar');
                exit;
            }

            if ($password !== $cpassword) {
                Flasher::setFlash('Konfirmasi password tidak sesuai.', 'danger');
                header('Location: ' . BASEURL . '/auth/daftar');
                exit;
            }

            if (!isset($_SESSION['captcha_text']) || strtolower($captcha) !== strtolower($_SESSION['captcha_text'])) {
                Flasher::setFlash('Captcha tidak sesuai.', 'danger');
                header('Location: ' . BASEURL . '/auth/daftar');
                exit;
            }
            unset($_SESSION['captcha_text']);

            if ($this->model('User_model')->cekUsername($username)) {
                Flasher::setFlash('Username sudah terdaftar.', 'danger');
                header('Location: ' . BASEURL . '/auth/daftar');
                exit;
            }

            if ($this->model('User_model')->cekEmail($email)) {
                Flasher::setFlash('Email sudah terdaftar.', 'danger');
                header('Location: ' . BASEURL . '/auth/daftar');
                exit;
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            if ($this->model('User_model')->tambahUser([
                'username' => $username,
                'email' => $email,
                'password' => $hashedPassword
            ])) {
                Flasher::setFlash('Pendaftaran berhasil. Silakan login.', 'success');
                header('Location: ' . BASEURL . '/auth/index');
                exit;
            } else {
                Flasher::setFlash('Pendaftaran gagal. Terjadi kesalahan.', 'danger');
                header('Location: ' . BASEURL . '/auth/daftar');
                exit;
            }
        } else {
            header('Location: ' . BASEURL . '/auth/daftar');
            exit;
        }
    }

    public function proses_login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            $captcha = $_POST['captcha'];
            $remember = isset($_POST['remember']);

            if (empty($username) || empty($password) || empty($captcha)) {
                Flasher::setFlash('Username, password, dan captcha wajib diisi.', 'danger');
                header('Location: ' . BASEURL . '/auth');
                exit;
            }

            if (!isset($_SESSION['captcha_text']) || strtolower($captcha) !== strtolower($_SESSION['captcha_text'])) {
                Flasher::setFlash('Captcha tidak sesuai.', 'danger');
                header('Location: ' . BASEURL . '/auth');
                exit;
            }
            unset($_SESSION['captcha_text']);

            $user = $this->model('User_model')->getUserByUsername($username);

            if ($user && empty($user['oauth_provider']) && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['photo'] = $user['photo'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['login'] = true;

                if ($remember) {
                    $key = bin2hex(random_bytes(32));
                    setcookie('remember_me', $user['id'] . ':' . $key, time() + (86400 * 30), '/');
                    $this->model('User_model')->updateRememberToken($user['id'], $key);
                }
                header('Location: ' . BASEURL . ($user['role'] == 'admin' ? '/admin' : '/user'));
                exit;
            } else {
                Flasher::setFlash('Username atau Password salah, atau akun terdaftar via Google.', 'danger');
                header('Location: ' . BASEURL . '/auth');
                exit;
            }
        } else {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function google_login()
    {
        if (!defined('GOOGLE_CLIENT_ID') || !defined('GOOGLE_REDIRECT_URI')) {
            Flasher::setFlash('Layanan Google Login tidak dikonfigurasi dengan benar.', 'danger');
            header('Location: ' . BASEURL . '/auth');
            exit;
        }

        // Generate and store a CSRF token (state)
        if (empty($_SESSION['oauth2state'])) {
            $_SESSION['oauth2state'] = bin2hex(random_bytes(16));
        }

        $params = [
            'response_type' => 'code',
            'client_id'     => GOOGLE_CLIENT_ID,
            'redirect_uri'  => GOOGLE_REDIRECT_URI,
            'scope'         => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile',
            'access_type'   => 'online', // Use 'offline' if you need refresh tokens
            'state'         => $_SESSION['oauth2state']
            // 'prompt'        => 'select_account' // Optional: forces account selection
        ];

        $auth_url = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params);
        header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
        exit;
    }

    public function google_callback()
    {
        if (!defined('GOOGLE_CLIENT_ID') || !defined('GOOGLE_CLIENT_SECRET') || !defined('GOOGLE_REDIRECT_URI')) {
            Flasher::setFlash('Layanan Google Login tidak dikonfigurasi dengan benar (callback).', 'danger');
            header('Location: ' . BASEURL . '/auth');
            exit;
        }

        // 1. Verify CSRF state token
        if (!isset($_GET['state']) || empty($_SESSION['oauth2state']) || $_GET['state'] !== $_SESSION['oauth2state']) {
            unset($_SESSION['oauth2state']); // Important: clear state
            Flasher::setFlash('Permintaan tidak valid atau sesi CSRF kedaluwarsa.', 'danger');
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
        unset($_SESSION['oauth2state']); // Clear state token after successful validation

        // Handle error from Google (e.g., user denied access)
        if (isset($_GET['error'])) {
            Flasher::setFlash('Google mengembalikan error: ' . htmlspecialchars($_GET['error_description'] ?? $_GET['error']), 'danger');
            header('Location: ' . BASEURL . '/auth');
            exit;
        }

        // 2. Exchange authorization code for an access token
        if (isset($_GET['code'])) {
            $code = $_GET['code'];
            $token_url = 'https://oauth2.googleapis.com/token';
            $token_params = [
                'code'          => $code,
                'client_id'     => GOOGLE_CLIENT_ID,
                'client_secret' => GOOGLE_CLIENT_SECRET,
                'redirect_uri'  => GOOGLE_REDIRECT_URI,
                'grant_type'    => 'authorization_code'
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $token_url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($token_params));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Set to true in production!

            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curl_error = curl_error($ch);
            curl_close($ch);

            if ($curl_error) {
                Flasher::setFlash('Kesalahan cURL saat meminta token: ' . htmlspecialchars($curl_error), 'danger');
                error_log('cURL token exchange error: ' . $curl_error . ' | Response: ' . $response);
                header('Location: ' . BASEURL . '/auth');
                exit;
            }

            $token_data = json_decode($response, true);

            if ($http_code !== 200 || isset($token_data['error'])) {
                Flasher::setFlash('Gagal mendapatkan token akses: ' . htmlspecialchars($token_data['error_description'] ?? $token_data['error'] ?? 'Unknown error'), 'danger');
                error_log('Token exchange failed (' . $http_code . '): ' . $response);
                header('Location: ' . BASEURL . '/auth');
                exit;
            }

            $access_token = $token_data['access_token'];

            // 3. Fetch user information using the access token
            // $userinfo_url = 'https://www.googleapis.com/oauth2/v3/userinfo'; // Standard userinfo
            $userinfo_url = 'https://openidconnect.googleapis.com/v1/userinfo'; // OIDC compliant, often preferred

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $userinfo_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $access_token]);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Set to true in production!

            $userinfo_response = curl_exec($ch);
            $userinfo_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $userinfo_curl_error = curl_error($ch);
            curl_close($ch);

            if ($userinfo_curl_error) {
                Flasher::setFlash('Kesalahan cURL saat mengambil info pengguna: ' . htmlspecialchars($userinfo_curl_error), 'danger');
                error_log('cURL userinfo error: ' . $userinfo_curl_error . ' | Response: ' . $userinfo_response);
                header('Location: ' . BASEURL . '/auth');
                exit;
            }

            $user_data_from_google = json_decode($userinfo_response, true);

            if ($userinfo_http_code !== 200 || isset($user_data_from_google['error'])) {
                Flasher::setFlash('Gagal mendapatkan informasi pengguna: ' . htmlspecialchars($user_data_from_google['error_description'] ?? $user_data_from_google['error'] ?? 'Unknown error'), 'danger');
                error_log('Userinfo fetch failed (' . $userinfo_http_code . '): ' . $userinfo_response);
                header('Location: ' . BASEURL . '/auth');
                exit;
            }

            // Expected keys from Google userinfo: sub, name, given_name, family_name, picture, email, email_verified, locale
            if (empty($user_data_from_google['email'])) {
                Flasher::setFlash('Tidak bisa mendapatkan email dari Google. Pastikan Anda memberikan izin.', 'danger');
                header('Location: ' . BASEURL . '/auth');
                exit;
            }

            // Prepare data for your User_model.
            // The User_model's findOrCreateUserByGoogle method expects an object with getId(), getEmail(), getName(), getPicture().
            // We create a compatible anonymous class (or you can pass an array and modify the model).
            $google_account_info_wrapper = new class($user_data_from_google) {
                private array $data;
                public function __construct(array $data)
                {
                    $this->data = $data;
                }
                public function getId(): ?string
                {
                    return $this->data['sub'] ?? null;
                } // 'sub' is the unique Google ID
                public function getEmail(): ?string
                {
                    return $this->data['email'] ?? null;
                }
                public function getName(): string
                {
                    return $this->data['name'] ?? trim(($this->data['given_name'] ?? '') . ' ' . ($this->data['family_name'] ?? ''));
                }
                public function getPicture(): ?string
                {
                    return $this->data['picture'] ?? null;
                }
            };

            $userModel = $this->model('User_model');
            $user = $userModel->findOrCreateUserByGoogle($google_account_info_wrapper);
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['photo'] = $user['photo'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['login'] = true;
                $_SESSION['oauth_provider'] = 'google';

                if ($user['role'] == 'admin') {
                    header('Location: ' . BASEURL . '/admin');
                    exit;
                } else {
                    header('Location: ' . BASEURL . '/user');
                    exit;
                }
            } else {
                Flasher::setFlash('Gagal memproses login Google. Tidak dapat menemukan atau membuat pengguna.', 'danger');
                header('Location: ' . BASEURL . '/auth');
                exit;
            }
        } else {
            Flasher::setFlash('Permintaan login Google tidak valid. Kode otorisasi tidak ditemukan.', 'warning');
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        if (isset($_COOKIE['remember_me'])) {
            unset($_COOKIE['remember_me']);
            setcookie('remember_me', '', time() - 3600, '/');
        }
        header('Location: ' . BASEURL . '/auth');
        exit;
    }
}
