<?php

// ======================================================
// DATA DARI CONTROLLER
// ======================================================

$programStudi =
    $data["programStudi"]
    ?? [];

$errors =
    $data["errors"]
    ?? [];

$old =
    $data["old"]
    ?? [];

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>
        Tambah Mahasiswa
    </title>

</head>

<body>


<h1>
    Tambah Mahasiswa
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
    action="index.php?action=mahasiswa-store"
>


    <!-- ============================================= -->
    <!-- NIM -->
    <!-- ============================================= -->
    <!--
        NIM tidak perlu diinput.

        NIM akan dibuat otomatis oleh sistem:

        kd_prodi
        +
        angkatan
        +
        nomor urut
    -->

    <p>

        <strong>
            NIM
        </strong>

        <br>

        Akan dibuat otomatis oleh sistem.

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
                $old["nama"]
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
                $old["email"]
                ?? ""
            ) ?>"
        >

    </p>


    <!-- ============================================= -->
    <!-- PASSWORD -->
    <!-- ============================================= -->

    <p>

        <label>
            Password
        </label>

        <br>

        <input
            type="password"
            name="password"
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
                                $old[
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
                $old["angkatan"]
                ?? ""
            ) ?>"
        >

    </p>


    <button type="submit">
        Simpan
    </button>


</form>


</body>

</html>