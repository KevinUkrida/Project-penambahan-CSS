<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>
        Data Mahasiswa
    </title>

</head>

<body>


<h1>
    Data Mahasiswa
</h1>

<?php

$message =
    $data["message"]
    ?? null;

$mahasiswa =
    $data["mahasiswa"]
    ?? [];

?>

<?php if ($message): ?>

    <p>
        <strong>
            <?= htmlspecialchars(
                $message
            ) ?>
        </strong>
    </p>

<?php endif; ?>


<p>

    <a
        href="index.php?action=mahasiswa-create"
    >
        Tambah Mahasiswa
    </a>

</p>


<hr>


<?php if (
    count($mahasiswa) > 0
): ?>


<table
    border="1"
    cellpadding="8"
>

    <tr>

        <th>No</th>
        <th>NIM</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Program Studi</th>
        <th>Aksi</th>

    </tr>


    <?php $no = 1; ?>


    <?php foreach (
        $mahasiswa
        as $row
    ): ?>

        <tr>

            <td>
                <?= $no ?>
            </td>


            <td>
                <?= htmlspecialchars(
                    $row["nim"]
                ) ?>
            </td>


            <td>
                <?= htmlspecialchars(
                    $row["nama"]
                ) ?>
            </td>


            <td>
                <?= htmlspecialchars(
                    $row["email"]
                ) ?>
            </td>


            <td>
                <?= htmlspecialchars(
                    $row["nama_prodi"]
                ) ?>
            </td>


            <td>

                <a
                    href="index.php?action=mahasiswa-edit&id=<?= $row["id"] ?>"
                >
                    Edit
                </a>

                |

                <a
                    href="index.php?action=mahasiswa-delete&id=<?= $row["id"] ?>"
                >
                    Hapus
                </a>

            </td>

        </tr>


        <?php $no++; ?>


    <?php endforeach; ?>


</table>


<?php else: ?>

    <p>
        Belum ada data mahasiswa.
    </p>

<?php endif; ?>


</body>

</html>