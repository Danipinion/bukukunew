<?php

class User_model
{
    private $table = 'users';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }


    public function getAllUser()
    {
        $this->db->query(
            'SELECT
                u.*,
                (SELECT COUNT(p.id_peminjaman)
                 FROM peminjaman p
                 WHERE p.id_user = u.id AND p.status IN ("disetujui", "terlambat")) AS pinjam
            FROM ' . $this->table . ' u
            WHERE u.role = :role'
        );
        $this->db->bind('role', 'user');
        return $this->db->resultSet();
    }

    public function updateUserProfile($data)
    {
        $query = "UPDATE " . $this->table . " SET
                    fullname = :fullname,
                    alamat = :alamat,
                    no_telepon = :no_telepon,
                    photo = :photo
                  WHERE id = :id_user";

        $this->db->query($query);
        $this->db->bind('fullname', $data['fullname']);
        $this->db->bind('alamat', $data['alamat']);
        $this->db->bind('no_telepon', $data['no_telepon']);
        $this->db->bind('photo', $data['photo']);
        $this->db->bind('id_user', $data['id_user']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function getUserById($id)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id = :id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function cekUsername($username)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE username = :username');
        $this->db->bind(':username', $username);
        $this->db->execute();
        return $this->db->rowCount() > 0;
    }

    public function cekEmail($email)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE email = :email');
        $this->db->bind(':email', $email);
        $this->db->execute();
        return $this->db->rowCount() > 0;
    }

    public function tambahUser($data)
    {
        // Ensure 'role' and 'photo' have defaults if not provided
        $role = $data['role'] ?? 'user'; // Default role
        $photo = $data['photo'] ?? null; // Default photo

        $query = "INSERT INTO users (username, email, password, role, photo, oauth_provider, oauth_uid) 
                  VALUES (:username, :email, :password, :role, :photo, :oauth_provider, :oauth_uid)";
        $this->db->query($query);
        $this->db->bind('username', $data['username']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('password', $data['password']); // Can be null for Google-only signup
        $this->db->bind('role', $role);
        $this->db->bind('photo', $photo);
        $this->db->bind('oauth_provider', $data['oauth_provider'] ?? null);
        $this->db->bind('oauth_uid', $data['oauth_uid'] ?? null);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function getUserByEmail($email)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE email = :email');
        $this->db->bind('email', $email);
        return $this->db->single();
    }

    public function storeOtp($userId, $otp, $otpExpiry)
    {
        $this->db->query('UPDATE ' . $this->table . ' SET otp = :otp, otp_expiry = :otp_expiry WHERE id = :id');
        $this->db->bind('otp', $otp);
        $this->db->bind('otp_expiry', $otpExpiry);
        $this->db->bind('id', $userId);
        return $this->db->execute();
    }

    public function getUserByEmailForOtpValidation($email)
    {
        // Fetches user details including OTP and expiry for validation
        $this->db->query('SELECT id, username, email, otp, otp_expiry FROM ' . $this->table . ' WHERE email = :email');
        $this->db->bind('email', $email);
        return $this->db->single();
    }

    public function updatePasswordAndClearOtp($userId, $hashedPassword)
    {
        $this->db->query('UPDATE ' . $this->table . ' SET password = :password, otp = NULL, otp_expiry = NULL WHERE id = :id');
        $this->db->bind('password', $hashedPassword);
        $this->db->bind('id', $userId);
        return $this->db->execute();
    }

    public function clearOtp($userId)
    {
        $this->db->query('UPDATE ' . $this->table . ' SET otp = NULL, otp_expiry = NULL WHERE id = :id');
        $this->db->bind('id', $userId);
        return $this->db->execute();
    }

    public function getUserByUsername($username)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE username = :username');
        $this->db->bind(':username', $username);
        $this->db->execute();
        return $this->db->single(); // Mengembalikan satu data user atau false jika tidak ditemukan
    }

    public function updateRememberToken($id, $token)
    {
        $query = "UPDATE " . $this->table . " SET remember_token = :token WHERE id = :id";
        $this->db->query($query);
        $this->db->bind(':token', $token);
        $this->db->bind(':id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function getUserByRememberToken($token)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE remember_token = :token');
        $this->db->bind(':token', $token);
        $this->db->execute();
        return $this->db->single();
    }


    public function tambahBookmark($userId, $bookId)
    {
        $user = $this->getUserById($userId);
        if ($user) {
            $bookmarks = json_decode($user['bookmarks'], true) ?? [];
            if (!in_array($bookId, $bookmarks)) {
                $bookmarks[] = $bookId;
                $bookmarksJson = json_encode(array_values(array_unique($bookmarks))); // Ensure unique and re-index
                $this->db->query('UPDATE ' . $this->table . ' SET bookmarks = :bookmarks WHERE id = :id');
                $this->db->bind('bookmarks', $bookmarksJson);
                $this->db->bind('id', $userId);
                $this->db->execute();
                return $this->db->rowCount();
            }
            return 0; // Buku sudah di-bookmark
        }
        return 0; // User tidak ditemukan
    }

    public function hapusBookmark($userId, $bookId)
    {
        $user = $this->getUserById($userId);
        if ($user) {
            $bookmarks = json_decode($user['bookmarks'], true) ?? [];
            $index = array_search($bookId, $bookmarks);
            if ($index !== false) {
                unset($bookmarks[$index]);
                $bookmarksJson = json_encode(array_values($bookmarks)); // Re-index array
                $this->db->query('UPDATE ' . $this->table . ' SET bookmarks = :bookmarks WHERE id = :id');
                $this->db->bind('bookmarks', $bookmarksJson);
                $this->db->bind('id', $userId);
                $this->db->execute();
                return $this->db->rowCount();
            }
            return 0; // Buku tidak ada di bookmark
        }
        return 0; // User tidak ditemukan
    }

    public function getBookmarksByUser($userId)
    {
        $user = $this->getUserById($userId);
        if ($user && $user['bookmarks']) {
            return json_decode($user['bookmarks'], true);
        }
        return [];
    }

    public function tambahDenda($userId, $jumlahDenda)
    {
        $query = "UPDATE " . $this->table . " SET denda = denda + :jumlah_denda WHERE id = :id_user";
        $this->db->query($query);
        $this->db->bind('jumlah_denda', $jumlahDenda);
        $this->db->bind('id_user', $userId);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function kurangDenda($userId, $jumlahDenda)
    {
        $query = "UPDATE " . $this->table . " SET denda = denda - :jumlah_denda WHERE id = :id_user";
        $this->db->query($query);
        $this->db->bind('jumlah_denda', $jumlahDenda);
        $this->db->bind('id_user', $userId);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function countUsersByRole($role)
    {
        $this->db->query("SELECT COUNT(*) AS total FROM " . $this->table . " WHERE role = :role");
        $this->db->bind('role', $role);
        return $this->db->single()['total'];
    }

    public function getTotalUsers()
    {
        $this->db->query("SELECT COUNT(*) AS total FROM " . $this->table);
        return $this->db->single()['total'];
    }

    public function findOrCreateUserByGoogle($googleUser)
    {
        // 1. Try to find user by Google ID
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE oauth_provider = :provider AND oauth_uid = :uid');
        $this->db->bind('provider', 'google');
        $this->db->bind('uid', $googleUser->getId());
        $user = $this->db->single();

        if ($user) {
            // User found by Google ID, potentially update photo if changed
            if ($user['photo'] === 'default.jpg') {
                $this->db->query('UPDATE ' . $this->table . ' SET photo = :photo WHERE id = :id');
                $this->db->bind('photo', $googleUser->getPicture());
                $this->db->bind('id', $user['id']);
                $this->db->execute();
                $user['photo'] = $googleUser->getPicture(); // Update in current object
            }
            return $user;
        }

        // 2. User not found by Google ID, try to find by email
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE email = :email');
        $this->db->bind('email', $googleUser->getEmail());
        $user = $this->db->single();

        if ($user) {
            // User found by email, link their Google account
            // This assumes an existing user is now logging in with Google for the first time
            $this->db->query('UPDATE ' . $this->table . ' SET oauth_provider = :provider, oauth_uid = :uid, photo = :photo WHERE id = :id');
            $this->db->bind('provider', 'google');
            $this->db->bind('uid', $googleUser->getId());
            // Update photo if current one is empty or different
            $this->db->bind('photo', $user['photo'] ?: $googleUser->getPicture());
            $this->db->bind('id', $user['id']);
            $this->db->execute();

            // Refetch user data after update
            return $this->getUserById($user['id']);
        }

        // 3. User not found by Google ID or email, create a new user
        // Generate a username. You might want a more robust unique username generation.
        // For simplicity, let's try to use the part before @ from email, or the name.
        $username = explode('@', $googleUser->getEmail())[0];
        if ($this->cekUsername($username)) { // Check if username exists
            $username = $username . substr($googleUser->getId(), 0, 5); // Append part of Google ID for uniqueness
        }
        if (empty($username)) { // Fallback if name is empty
            $username = 'user_' . substr($googleUser->getId(), 0, 8);
        }


        $userData = [
            'username' => $username,
            'email' => $googleUser->getEmail(),
            'password' => null, // No local password for Google-only signup initially
            'photo' => $googleUser->getPicture(),
            'role' => 'user', // Default role
            'oauth_provider' => 'google',
            'oauth_uid' => $googleUser->getId()
        ];

        if ($this->tambahUser($userData)) {
            $lastId = $this->db->lastInsertId();
            return $this->getUserById($lastId);
        }
        return false; // Failed to create user
    }
}
