<?php

// ======================================================
// MODEL MAHASISWA
// ======================================================
// Bertanggung jawab terhadap:
//
// CREATE
// READ
// UPDATE
// DELETE
//
// Termasuk business rule pembuatan NIM otomatis.
// ======================================================

class Mahasiswa
{
    private PDO $conn;

    public function findByEmail(string $email)
{
    $sql = "SELECT id, nim, nama, email, password, id_prodi
            FROM mahasiswa
            WHERE email = ?";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$email]);

    return $stmt->fetch();
}


    public function __construct(
        PDO $conn
    ) {
        $this->conn =
            $conn;
    }


    // ==================================================
    // READ ALL
    // ==================================================

    public function getAll(): array
    {
        $sql =
            "SELECT
                m.id,
                m.nim,
                m.nama,
                m.email,
                m.id_prodi,

                p.kd_prodi,
                p.nama_prodi

             FROM mahasiswa m

             JOIN program_studi p
                ON m.id_prodi =
                   p.id_prodi

             ORDER BY m.nim ASC";


        $stmt =
            $this->conn
                ->prepare($sql);


        $stmt->execute();


        return
            $stmt->fetchAll();
    }


    // ==================================================
    // READ ONE
    // ==================================================

    public function findById(
        int $id
    ) {

        $sql =
            "SELECT
                m.id,
                m.nim,
                m.nama,
                m.email,
                m.id_prodi,

                p.kd_prodi,
                p.nama_prodi

             FROM mahasiswa m

             JOIN program_studi p
                ON m.id_prodi =
                   p.id_prodi

             WHERE m.id = ?";


        $stmt =
            $this->conn
                ->prepare($sql);


        $stmt->execute([
            $id
        ]);


        return
            $stmt->fetch();
    }


    // ==================================================
    // GENERATE NIM
    // ==================================================
    //
    // Format:
    //
    // kd_prodi + angkatan + nomor urut 3 digit
    //
    // Contoh:
    //
    // kd_prodi = 42
    // angkatan  = 2026
    // urutan    = 001
    //
    // NIM = 422026001
    //
    // Method dibuat private karena hanya digunakan
    // di dalam Model Mahasiswa.
    // ==================================================

    private function generateNim(
        int $idProdi,
        int $angkatan
    ): string {

        // ==============================================
        // 1. Ambil kode program studi
        // ==============================================

        $sqlProdi =
            "SELECT kd_prodi
             FROM program_studi
             WHERE id_prodi = ?";


        $stmtProdi =
            $this->conn
                ->prepare($sqlProdi);


        $stmtProdi->execute([
            $idProdi
        ]);


        $prodi =
            $stmtProdi->fetch();


        if (!$prodi) {

            throw new Exception(
                "Program studi tidak ditemukan."
            );
        }


        $kodeProdi =
            $prodi["kd_prodi"];


        // ==============================================
        // 2. Buat prefix NIM
        // ==============================================
        //
        // Contoh:
        //
        // kd_prodi = 42
        // angkatan  = 2026
        //
        // prefix = 422026
        // ==============================================

        $prefix =
            $kodeProdi .
            $angkatan;


        // ==============================================
        // 3. Cari nomor urut terakhir
        // ==============================================
        //
        // Misalnya:
        //
        // 422026001
        // 422026002
        // 422026003
        //
        // RIGHT(nim, 3)
        //
        // menghasilkan:
        //
        // 001
        // 002
        // 003
        //
        // MAX = 3
        // nomor baru = 4
        // ==============================================

        $sqlUrutan =
            "SELECT
                MAX(
                    CAST(
                        RIGHT(nim, 3)
                        AS UNSIGNED
                    )
                )
                AS nomor_terakhir

             FROM mahasiswa

             WHERE nim LIKE ?";


        $stmtUrutan =
            $this->conn
                ->prepare(
                    $sqlUrutan
                );


        $stmtUrutan->execute([
            $prefix . "%"
        ]);


        $hasil =
            $stmtUrutan->fetch();


        $nomorTerakhir =
            (int) (
                $hasil[
                    "nomor_terakhir"
                ]
                ?? 0
            );


        $nomorBaru =
            $nomorTerakhir + 1;


        // Nomor urut hanya tersedia
        // dari 001 sampai 999.

        if ($nomorBaru > 999) {

            throw new Exception(
                "Nomor urut mahasiswa sudah melebihi 999."
            );
        }


        // ==============================================
        // 4. Format nomor menjadi tiga digit
        // ==============================================
        //
        // 1  -> 001
        // 9  -> 009
        // 12 -> 012
        // ==============================================

        $nomorUrut =
            str_pad(
                $nomorBaru,
                3,
                "0",
                STR_PAD_LEFT
            );


        // ==============================================
        // 5. Kembalikan NIM final
        // ==============================================

        return
            $prefix .
            $nomorUrut;
    }


    // ==================================================
    // AMBIL ANGKATAN DARI NIM
    // ==================================================
    //
    // Contoh:
    //
    // nim        = 422026001
    // kd_prodi   = 42
    //
    // panjang kode = 2
    //
    // setelah kode prodi,
    // empat karakter berikutnya = 2026
    //
    // Angkatan tidak disimpan sebagai kolom database.
    // ==================================================

    public function getAngkatanFromNim(
        string $nim,
        string $kodeProdi
    ): string {

        $panjangKode =
            strlen(
                $kodeProdi
            );


        return
            substr(
                $nim,
                $panjangKode,
                4
            );
    }


    // ==================================================
    // CREATE
    // ==================================================
    //
    // NIM tidak lagi dikirim dari Controller.
    //
    // NIM dibuat oleh Model menggunakan:
    //
    // idProdi
    // +
    // angkatan
    //
    // ==================================================

    public function create(
        string $nama,
        string $email,
        string $password,
        int $idProdi,
        int $angkatan
    ): bool {

        // Generate NIM otomatis.

        $nim =
            $this->generateNim(
                $idProdi,
                $angkatan
            );


        $sql =
            "INSERT INTO mahasiswa
            (
                nim,
                nama,
                email,
                password,
                id_prodi
            )
            VALUES
            (?, ?, ?, ?, ?)";


        $stmt =
            $this->conn
                ->prepare($sql);


        // Password tetap di-hash.
        // password_verify() baru digunakan
        // saat Authentication pada P13.

        $passwordHash =
            password_hash(
                $password,
                PASSWORD_DEFAULT
            );


        return
            $stmt->execute([
                $nim,
                $nama,
                $email,
                $passwordHash,
                $idProdi
            ]);
    }


    // ==================================================
    // UPDATE
    // ==================================================
    //
    // NIM hanya berubah jika:
    //
    // 1. Program Studi berubah
    // atau
    // 2. Angkatan berubah
    //
    // Kalau hanya Nama atau Email berubah,
    // NIM tetap.
    // ==================================================

    public function update(
        int $id,
        string $nama,
        string $email,
        int $idProdi,
        int $angkatan
    ): bool {

        // ==============================================
        // Ambil data lama
        // ==============================================

        $dataLama =
            $this->findById(
                $id
            );


        if (!$dataLama) {

            return false;
        }


        // ==============================================
        // Ambil angkatan lama dari NIM
        // ==============================================

        $angkatanLama =
            $this->getAngkatanFromNim(
                $dataLama["nim"],
                $dataLama["kd_prodi"]
            );


        // Secara default NIM tetap.

        $nim =
            $dataLama["nim"];


        // ==============================================
        // Cek apakah Prodi / Angkatan berubah
        // ==============================================

        if (
            (int) $dataLama[
                "id_prodi"
            ] !== $idProdi
            ||
            (int) $angkatanLama
                !== $angkatan
        ) {

            // Jika berubah,
            // generate NIM baru.

            $nim =
                $this->generateNim(
                    $idProdi,
                    $angkatan
                );
        }


        // ==============================================
        // UPDATE DATABASE
        // ==============================================

        $sql =
            "UPDATE mahasiswa

             SET
                nim = ?,
                nama = ?,
                email = ?,
                id_prodi = ?

             WHERE id = ?";


        $stmt =
            $this->conn
                ->prepare($sql);


        return
            $stmt->execute([
                $nim,
                $nama,
                $email,
                $idProdi,
                $id
            ]);
    }


    // ==================================================
    // DELETE
    // ==================================================

    public function delete(
        int $id
    ): bool {

        $sql =
            "DELETE
             FROM mahasiswa
             WHERE id = ?";


        $stmt =
            $this->conn
                ->prepare($sql);


        return
            $stmt->execute([
                $id
            ]);
    }


    // ==================================================
    // CHECK EMAIL CREATE
    // ==================================================

    public function emailExists(
        string $email
    ): bool {

        $sql =
            "SELECT id
             FROM mahasiswa
             WHERE email = ?";


        $stmt =
            $this->conn
                ->prepare($sql);


        $stmt->execute([
            $email
        ]);


        return
            $stmt->fetch()
            !== false;
    }


    // ==================================================
    // CHECK EMAIL UPDATE
    // ==================================================

    public function emailExistsForOther(
        string $email,
        int $id
    ): bool {

        $sql =
            "SELECT id
             FROM mahasiswa

             WHERE email = ?
             AND id != ?";


        $stmt =
            $this->conn
                ->prepare($sql);


        $stmt->execute([
            $email,
            $id
        ]);


        return
            $stmt->fetch()
            !== false;
    }
}