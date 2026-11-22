<?php
// ======================================================
// VIEW LOGIN  ->  simpan di: views/auth/login.php
// ======================================================

$errors  = $data["errors"]  ?? [];
$old     = $data["old"]     ?? [];
$message = $data["message"] ?? null;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="login-box">

    <h2>Student Portal</h2>
    <p class="login-subtitle">Masuk dengan email dan password mahasiswa.</p>

    <?php if ($message): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <?php if (count($errors) > 0): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $error): ?>
                <div><?= htmlspecialchars($error) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="index.php?action=authenticate" data-validate="true">

        <div class="form-group">
            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                required
                autofocus
                value="<?= htmlspecialchars($old["email"] ?? "") ?>"
            >
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label class="check-label">
                <input type="checkbox" data-toggle-password="password">
                Tampilkan password
            </label>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Masuk</button>

    </form>

</div>

<script src="assets/js/style.js"></script>
</body>
</html>