<?php
// ======================================================
// VIEW DAFTAR MAHASISWA  ->  simpan di: views/mahasiswa/index.php
// ======================================================

$message   = $data["message"]   ?? null;
$mahasiswa = $data["mahasiswa"] ?? [];

$userNama = $_SESSION["user_nama"] ?? "";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Mahasiswa</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="container">

    <div class="topbar">
        <h1>Data Mahasiswa</h1>

        <div class="topbar-actions">
            <span class="user-badge"><?= htmlspecialchars($userNama) ?></span>

            <form method="POST" action="logout.php">
                <button type="submit" class="btn btn-sm">Keluar</button>
            </form>
        </div>
    </div>

    <?php if ($message): ?>
        <div class="alert alert-success" data-autohide="true">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <div class="table-toolbar">
        <input
            type="search"
            id="searchMahasiswa"
            class="search-box"
            placeholder="Cari NIM, nama, email, prodi..."
        >

        <a href="index.php?action=mahasiswa-create" class="btn btn-primary">
            + Tambah Mahasiswa
        </a>
    </div>

    <?php if (count($mahasiswa) > 0): ?>

        <div class="table-wrapper">
            <table id="tableMahasiswa">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Program Studi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($mahasiswa as $row): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row["nim"]) ?></td>
                            <td><?= htmlspecialchars($row["nama"]) ?></td>
                            <td><?= htmlspecialchars($row["email"]) ?></td>
                            <td><?= htmlspecialchars($row["nama_prodi"]) ?></td>
                            <td>
                                <div class="actions-cell">
                                    <a
                                        href="index.php?action=mahasiswa-edit&id=<?= (int) $row["id"] ?>"
                                        class="btn btn-sm"
                                    >Edit</a>

                                    <a
                                        href="index.php?action=mahasiswa-delete&id=<?= (int) $row["id"] ?>"
                                        class="btn btn-danger btn-sm"
                                    >Hapus</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <p id="noResult" class="empty-text" hidden>Data tidak ditemukan.</p>

    <?php else: ?>

        <p class="empty-text">Belum ada data mahasiswa.</p>

    <?php endif; ?>

</div>

<script src="assets/js/style.js"></script>
</body>
</html>