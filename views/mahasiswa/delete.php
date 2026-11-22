<?php
// ======================================================
// VIEW HAPUS MAHASISWA  ->  views/mahasiswa/delete.php
// ======================================================

$mahasiswa = $data["mahasiswa"] ?? null;

if (!$mahasiswa) {
    die("Data mahasiswa tidak tersedia.");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hapus Mahasiswa</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="container container-narrow">

    <div class="topbar">
        <h1>Hapus Mahasiswa</h1>
    </div>

    <div class="alert alert-error">
        Apakah Anda yakin ingin menghapus data berikut? Tindakan ini tidak bisa dibatalkan.
    </div>

    <dl class="detail-list">
        <dt>NIM</dt>
        <dd><?= htmlspecialchars($mahasiswa["nim"]) ?></dd>

        <dt>Nama</dt>
        <dd><?= htmlspecialchars($mahasiswa["nama"]) ?></dd>

        <dt>Email</dt>
        <dd><?= htmlspecialchars($mahasiswa["email"]) ?></dd>

        <dt>Program Studi</dt>
        <dd><?= htmlspecialchars($mahasiswa["nama_prodi"]) ?></dd>
    </dl>

    <form
        method="POST"
        action="index.php?action=mahasiswa-destroy&id=<?= (int) $mahasiswa["id"] ?>"
        class="form-actions"
    >
        <button type="submit" class="btn btn-danger" data-confirm="Yakin ingin menghapus data ini?">
            Ya, Hapus
        </button>
        <a href="index.php?action=mahasiswa" class="btn">Batal</a>
    </form>

</div>

<script src="assets/js/style.js"></script>
</body>
</html>