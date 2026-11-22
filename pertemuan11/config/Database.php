<?php

// ======================================================
// CLASS DATABASE
// ======================================================
// Bertanggung jawab membuat koneksi database.
//
// Class lain TIDAK perlu mengetahui:
// - host
// - username
// - password
// - cara membuat object PDO
//
// Mereka cukup meminta:
// $database->getConnection();
// ======================================================

class Database
{
    private string $host = "localhost";

    private string $dbName =
        "student_portal";

    private string $username =
        "root";

    private string $password =
        "";


    // ==================================================
    // GET CONNECTION
    // ==================================================
    // Method mengembalikan object PDO.
    // ==================================================

    public function getConnection(): PDO
    {
        $dsn =
            "mysql:host={$this->host};" .
            "dbname={$this->dbName};" .
            "charset=utf8mb4";


        $conn =
            new PDO(
                $dsn,
                $this->username,
                $this->password
            );


        // Jika query bermasalah,
        // PDO akan menghasilkan Exception.

        $conn->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );


        // Hasil query otomatis associative array.

        $conn->setAttribute(
            PDO::ATTR_DEFAULT_FETCH_MODE,
            PDO::FETCH_ASSOC
        );


        return $conn;
    }
}