<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>
        Hapus Mahasiswa
    </title>

</head>

<body>
<?php

$mahasiswa =
    $data["mahasiswa"]
    ?? null;

if (!$mahasiswa) {
    die(
        "Data mahasiswa tidak tersedia."
    );
}

?>

<h1>
    Hapus Mahasiswa
</h1>


<p>
    Apakah Anda yakin ingin
    menghapus data berikut?
</p>


<hr>


<p>

    <strong>
        NIM:
    </strong>

    <?= htmlspecialchars(
        $mahasiswa["nim"]
    ) ?>

</p>


<p>

    <strong>
        Nama:
    </strong>

    <?= htmlspecialchars(
        $mahasiswa["nama"]
    ) ?>

</p>


<p>

    <strong>
        Email:
    </strong>

    <?= htmlspecialchars(
        $mahasiswa["email"]
    ) ?>

</p>


<p>

    <strong>
        Program Studi:
    </strong>

    <?= htmlspecialchars(
        $mahasiswa["nama_prodi"]
    ) ?>

</p>


<hr>


<form
    method="POST"
    action="index.php?action=mahasiswa-destroy&id=<?= $mahasiswa["id"] ?>"
>

    <button type="submit">
        Ya, Hapus
    </button>

</form>


<br>


<a
    href="index.php?action=mahasiswa"
>
    Batal
</a>


</body>

</html>