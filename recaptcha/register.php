<?php
session_start(); // Wajib di baris paling atas
require_once 'config/db.php';

// === reCAPTCHA v2 config ===
$RECAPTCHA_SITE_KEY   = ''; // site key (punyamu)
$RECAPTCHA_SECRET_KEY = ''; // <-- GANTI dengan secret key pasangan

// --- BAGIAN KUNCI 1: TENTUKAN SIAPA YANG MENGAKSES ---
$isAdmin = (isset($_SESSION['role']) && $_SESSION['role'] === 'superadmin');

$errors  = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username         = trim($_POST['username'] ?? '');
    $password         = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? ''; // Untuk pendaftaran mandiri

    // --- BAGIAN KUNCI 2: TENTUKAN ROLE SECARA DINAMIS ---
    if ($isAdmin) {
        $role = $_POST['role'] ?? '';
    } else {
        $role = 'user';
    }

    // --- reCAPTCHA v2 verification (wajib untuk semua pendaftaran) ---
    $recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';
    if ($recaptchaResponse === '') {
        $errors[] = 'Silakan centang reCAPTCHA.';
    } else {
        $verify = @file_get_contents(
            'https://www.google.com/recaptcha/api/siteverify?secret='
            . urlencode($RECAPTCHA_SECRET_KEY)
            . '&response=' . urlencode($recaptchaResponse)
            . '&remoteip=' . urlencode($_SERVER['REMOTE_ADDR'] ?? '')
        );
        $captcha = json_decode($verify ?: '{}', true);
        if (empty($captcha['success'])) {
            $errors[] = 'Verifikasi reCAPTCHA gagal. Coba lagi.';
        }
    }

    // --- Validasi Input ---
    if ($username === '' || $password === '') {
        $errors[] = 'Username dan Password wajib diisi.';
    }
    if (strlen($password) < 8) {
        $errors[] = 'Password minimal harus 8 karakter.';
    }
    if (!$isAdmin && $password !== $confirm_password) {
        $errors[] = 'Konfirmasi password tidak cocok.';
    }
    if ($isAdmin && empty($role)) {
        $errors[] = 'Role wajib dipilih.';
    }

    // Hanya lanjut jika tidak ada error
    if (empty($errors)) {
        $stmt_check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt_check->bind_param("s", $username);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            $errors[] = 'Username "' . htmlspecialchars($username) . '" sudah digunakan.';
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt_insert = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
            $stmt_insert->bind_param("sss", $username, $hashedPassword, $role);
            
            if ($stmt_insert->execute()) {
                if ($isAdmin) {
                    $success = 'User "' . htmlspecialchars($username) . '" berhasil didaftarkan oleh admin.';
                } else {
                    $_SESSION['success_message'] = "Pendaftaran berhasil! Silakan login dengan akun baru Anda.";
                    header("Location: index.php");
                    exit;
                }
            } else {
                $errors[] = "Gagal mendaftarkan user.";
            }
            $stmt_insert->close();
        }
        $stmt_check->close();
    }
}
?>

<?php include_once ROOT_PATH .  '/views/layouts/header.php'; ?>

<!-- muat script reCAPTCHA v2 -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <h2 class="mb-4 text-center">
                <?= $isAdmin ? 'Register User Baru (Admin)' : 'Pendaftaran Akun' ?>
            </h2>

            <?php if (!empty($success)): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="card p-4">
                <form action="register.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username" class="form-control"
                               value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required minlength="8">
                        <div class="form-text">Minimal 8 karakter.</div>
                    </div>

                    <?php if (!$isAdmin): ?>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required minlength="8">
                        </div>
                    <?php endif; ?>

                    <?php if ($isAdmin): ?>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" id="role" class="form-select" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="user"       <?= (($_POST['role'] ?? '') === 'user') ? 'selected' : '' ?>>User</option>
                                <option value="superadmin" <?= (($_POST['role'] ?? '') === 'superadmin') ? 'selected' : '' ?>>Superadmin</option>
                            </select>
                        </div>
                    <?php endif; ?>

                    <!-- Widget reCAPTCHA v2 -->
                    <div class="mb-3">
                        <div class="g-recaptcha" data-sitekey="<?= htmlspecialchars($RECAPTCHA_SITE_KEY) ?>"></div>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <?= $isAdmin ? 'Daftarkan User' : 'Daftar' ?>
                        </button>
                    </div>
                </form>
            </div>
            
            <?php if (!$isAdmin): ?>
                <div class="text-center mt-3">
                    Sudah punya akun? <a href="index.php">Login di sini</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include_once ROOT_PATH .  '/views/layouts/footer.php'; ?>
