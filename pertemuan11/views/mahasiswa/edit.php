<?php

// ======================================================
// DATA DARI CONTROLLER
// ======================================================

$mahasiswa =
    $data["mahasiswa"]
    ?? [];

$programStudi =
    $data["programStudi"]
    ?? [];

$errors =
    $data["errors"]
    ?? [];

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>
        Edit Mahasiswa
    </title>

</head>

<body>


<h1>
    Edit Mahasiswa
</h1>


<p>

    <a
        href="index.php?action=mahasiswa"
    >
        Kembali
    </a>

</p>


<hr>


<?php if (
    count($errors) > 0
): ?>


    <h3>
        Terjadi Kesalahan
    </h3>


    <ul>

        <?php foreach (
            $errors
            as $error
        ): ?>

            <li>
                <?= htmlspecialchars(
                    $error
                ) ?>
            </li>

        <?php endforeach; ?>

    </ul>


<?php endif; ?>


<form
    method="POST"

    action="index.php?action=mahasiswa-update&id=<?= (int) (
        $mahasiswa["id"]
        ?? 0
    ) ?>"
>


    <!-- ============================================= -->
    <!-- NIM -->
    <!-- ============================================= -->
    <!--
        NIM hanya ditampilkan.

        User tidak boleh mengedit NIM secara manual.

        Jika Program Studi atau Angkatan berubah,
        Model akan membuat NIM baru otomatis.
    -->

    <p>

        <strong>
            NIM
        </strong>

        <br>

        <?= htmlspecialchars(
            $mahasiswa["nim"]
            ?? ""
        ) ?>

    </p>


    <!-- ============================================= -->
    <!-- NAMA -->
    <!-- ============================================= -->

    <p>

        <label>
            Nama
        </label>

        <br>

        <input
            type="text"
            name="nama"
            value="<?= htmlspecialchars(
                $mahasiswa["nama"]
                ?? ""
            ) ?>"
        >

    </p>


    <!-- ============================================= -->
    <!-- EMAIL -->
    <!-- ============================================= -->

    <p>

        <label>
            Email
        </label>

        <br>

        <input
            type="email"
            name="email"
            value="<?= htmlspecialchars(
                $mahasiswa["email"]
                ?? ""
            ) ?>"
        >

    </p>


    <!-- ============================================= -->
    <!-- PROGRAM STUDI -->
    <!-- ============================================= -->

    <p>

        <label>
            Program Studi
        </label>

        <br>


        <select
            name="id_prodi"
        >


            <option value="">
                -- Pilih Program Studi --
            </option>


            <?php foreach (
                $programStudi
                as $prodi
            ): ?>


                <option
                    value="<?= $prodi[
                        "id_prodi"
                    ] ?>"

                    <?=
                        (
                            (
                                $mahasiswa[
                                    "id_prodi"
                                ]
                                ?? ""
                            )
                            ==
                            $prodi[
                                "id_prodi"
                            ]
                        )
                        ? "selected"
                        : ""
                    ?>
                >

                    <?= htmlspecialchars(
                        $prodi["kd_prodi"]
                        .
                        " - "
                        .
                        $prodi["nama_prodi"]
                    ) ?>

                </option>


            <?php endforeach; ?>


        </select>

    </p>


    <!-- ============================================= -->
    <!-- ANGKATAN -->
    <!-- ============================================= -->

    <p>

        <label>
            Angkatan
        </label>

        <br>

        <input
            type="number"
            name="angkatan"
            min="2000"
            max="2100"
            value="<?= htmlspecialchars(
                $mahasiswa["angkatan"]
                ?? ""
            ) ?>"
        >

    </p>


    <button type="submit">
        Simpan Perubahan
    </button>


</form>


</body>

</html>