<?php

// ======================================================
// MODEL PROGRAM STUDI
// ======================================================
// Bertanggung jawab terhadap data program_studi.
// ======================================================

class ProgramStudi
{
    private PDO $conn;


    public function __construct(
        PDO $conn
    ) {
        $this->conn = $conn;
    }


    // ==================================================
    // READ ALL
    // ==================================================
    // Mengambil seluruh program studi.
    //
    // kd_prodi diperlukan untuk membentuk NIM.
    // ==================================================

    public function getAll(): array
    {
        $sql =
            "SELECT
                id_prodi,
                kd_prodi,
                nama_prodi
             FROM program_studi
             ORDER BY nama_prodi ASC";


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
                id_prodi,
                kd_prodi,
                nama_prodi
             FROM program_studi
             WHERE id_prodi = ?";


        $stmt =
            $this->conn
                ->prepare($sql);


        $stmt->execute([
            $id
        ]);


        return
            $stmt->fetch();
    }
}