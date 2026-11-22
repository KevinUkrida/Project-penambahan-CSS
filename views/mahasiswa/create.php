<?php
// ======================================================
// VIEW TAMBAH MAHASISWA  ->  views/mahasiswa/create.php
// ======================================================

$programStudi = $data["programStudi"] ?? [];
$errors       = $data["errors"]       ?? [];
$old          = $data["old"]          ?? [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Mahasiswa</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="container container-narrow">

    <div class="topbar">
        <h1>Tambah Mahasiswa</h1>
        <a href="index.php?action=mahasiswa" class="btn btn-sm">&larr; Kembali</a>
    </div>

    <?php if (count($errors) > 0): ?>
        <div class="alert alert-error">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="index.php?action=mahasiswa-store" data-validate="true">

        <div class="form-group">
            <label>NIM</label>
            <p class="hint">Dibuat otomatis oleh sistem (kode prodi + angkatan + nomor urut).</p>
        </div>

        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama" required
                   value="<?= htmlspecialchars($old["nama"] ?? "") ?>">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required
                   value="<?= htmlspecialchars($old["email"] ?? "") ?>">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <label class="check-label">
                <input type="checkbox" data-toggle-password="password">
                Tampilkan password
            </label>
        </div>

        <div class="form-group">
            <label for="id_prodi">Program Studi</label>
            <select id="id_prodi" name="id_prodi" required>
                <option value="">-- Pilih Program Studi --</option>
                <?php foreach ($programStudi as $prodi): ?>
                    <option
                        value="<?= (int) $prodi["id_prodi"] ?>"
                        <?= (($old["id_prodi"] ?? "") == $prodi["id_prodi"]) ? "selected" : "" ?>
                    >
                        <?= htmlspecialchars($prodi["kd_prodi"] . " - " . $prodi["nama_prodi"]) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="angkatan">Angkatan</label>
            <input type="number" id="angkatan" name="angkatan" min="2000" max="2100" required
                   value="<?= htmlspecialchars($old["angkatan"] ?? "") ?>">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="index.php?action=mahasiswa" class="btn">Batal</a>
        </div>

    </form>

</div>

<script src="assets/js/style.js"></script>
</body>
</html>