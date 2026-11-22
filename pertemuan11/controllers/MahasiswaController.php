<?php

class MahasiswaController
    extends Controller
{
    private Mahasiswa $mahasiswa;

    private ProgramStudi $programStudi;

    private Session $session;


    // ==================================================
    // CONSTRUCTOR
    // ==================================================

    public function __construct(
        PDO $conn,
        Session $session
    ) {

        $this->mahasiswa =
            new Mahasiswa(
                $conn
            );


        $this->programStudi =
            new ProgramStudi(
                $conn
            );


        $this->session =
            $session;
    }


    // ==================================================
    // INDEX
    // ==================================================

    public function index(): void
    {
        $mahasiswa =
            $this->mahasiswa
                ->getAll();


        $message =
            $this->session
                ->flash(
                    "message"
                );


        $this->view(
            "mahasiswa/index",
            [
                "mahasiswa" =>
                    $mahasiswa,

                "message" =>
                    $message
            ]
        );
    }


    // ==================================================
    // CREATE
    // ==================================================

    public function create(): void
    {
        $programStudi =
            $this->programStudi
                ->getAll();


        $this->view(
            "mahasiswa/create",
            [
                "programStudi" =>
                    $programStudi,

                "errors" => [],

                "old" => []
            ]
        );
    }


    // ==================================================
    // STORE
    // ==================================================

    public function store(): void
    {
        // ==============================================
        // Ambil input form
        // ==============================================

        $nama =
            trim(
                $_POST["nama"]
                ?? ""
            );


        $email =
            trim(
                $_POST["email"]
                ?? ""
            );


        $password =
            $_POST["password"]
            ?? "";


        $idProdi =
            $_POST["id_prodi"]
            ?? "";


        $angkatan =
            $_POST["angkatan"]
            ?? "";


        $errors = [];


        // ==============================================
        // VALIDATION NAMA
        // ==============================================

        if ($nama === "") {

            $errors[] =
                "Nama wajib diisi.";
        }


        // ==============================================
        // VALIDATION EMAIL
        // ==============================================

        if ($email === "") {

            $errors[] =
                "Email wajib diisi.";

        } elseif (
            !filter_var(
                $email,
                FILTER_VALIDATE_EMAIL
            )
        ) {

            $errors[] =
                "Format email tidak valid.";

        } elseif (
            $this->mahasiswa
                ->emailExists(
                    $email
                )
        ) {

            $errors[] =
                "Email sudah digunakan.";
        }


        // ==============================================
        // VALIDATION PASSWORD
        // ==============================================

        if ($password === "") {

            $errors[] =
                "Password wajib diisi.";
        }


        // ==============================================
        // VALIDATION PROGRAM STUDI
        // ==============================================

        if (
            $idProdi === ""
            ||
            !is_numeric(
                $idProdi
            )
        ) {

            $errors[] =
                "Program studi wajib dipilih.";
        }


        // ==============================================
        // VALIDATION ANGKATAN
        // ==============================================

        if (
            $angkatan === ""
            ||
            !is_numeric(
                $angkatan
            )
        ) {

            $errors[] =
                "Angkatan wajib diisi.";

        } elseif (
            strlen(
                (string) $angkatan
            ) !== 4
        ) {

            $errors[] =
                "Angkatan harus terdiri dari 4 digit.";
        }


        // ==============================================
        // JIKA VALIDATION GAGAL
        // ==============================================

        if (
            count(
                $errors
            ) > 0
        ) {

            $programStudi =
                $this->programStudi
                    ->getAll();


            $this->view(
                "mahasiswa/create",
                [
                    "programStudi" =>
                        $programStudi,

                    "errors" =>
                        $errors,

                    "old" => [

                        "nama" =>
                            $nama,

                        "email" =>
                            $email,

                        "id_prodi" =>
                            $idProdi,

                        "angkatan" =>
                            $angkatan
                    ]
                ]
            );


            return;
        }


        // ==============================================
        // CREATE
        // ==============================================

        try {

            $this->mahasiswa
                ->create(
                    $nama,
                    $email,
                    $password,
                    (int) $idProdi,
                    (int) $angkatan
                );


            $this->session->set(
                "message",
                "Data mahasiswa berhasil ditambahkan."
            );


            $this->redirect(
                "index.php?action=mahasiswa"
            );


        } catch (
            Exception $e
        ) {

            $programStudi =
                $this->programStudi
                    ->getAll();


            $errors[] =
                $e->getMessage();


            $this->view(
                "mahasiswa/create",
                [
                    "programStudi" =>
                        $programStudi,

                    "errors" =>
                        $errors,

                    "old" => [

                        "nama" =>
                            $nama,

                        "email" =>
                            $email,

                        "id_prodi" =>
                            $idProdi,

                        "angkatan" =>
                            $angkatan
                    ]
                ]
            );
        }
    }


    // ==================================================
    // EDIT
    // ==================================================

    public function edit(): void
    {
        $id =
            $this->getId();


        $mahasiswa =
            $this->mahasiswa
                ->findById(
                    $id
                );


        if (!$mahasiswa) {

            die(
                "Data mahasiswa tidak ditemukan."
            );
        }


        // ==============================================
        // Ambil angkatan dari NIM
        // ==============================================

        $mahasiswa["angkatan"] =
            $this->mahasiswa
                ->getAngkatanFromNim(
                    $mahasiswa["nim"],
                    $mahasiswa["kd_prodi"]
                );


        $programStudi =
            $this->programStudi
                ->getAll();


        $this->view(
            "mahasiswa/edit",
            [
                "mahasiswa" =>
                    $mahasiswa,

                "programStudi" =>
                    $programStudi,

                "errors" =>
                    []
            ]
        );
    }


    // ==================================================
    // UPDATE
    // ==================================================

    public function update(): void
    {
        $id =
            $this->getId();


        $existing =
            $this->mahasiswa
                ->findById(
                    $id
                );


        if (!$existing) {

            die(
                "Data mahasiswa tidak ditemukan."
            );
        }


        // ==============================================
        // INPUT
        // ==============================================

        $nama =
            trim(
                $_POST["nama"]
                ?? ""
            );


        $email =
            trim(
                $_POST["email"]
                ?? ""
            );


        $idProdi =
            $_POST["id_prodi"]
            ?? "";


        $angkatan =
            $_POST["angkatan"]
            ?? "";


        $errors = [];


        // ==============================================
        // VALIDATION NAMA
        // ==============================================

        if ($nama === "") {

            $errors[] =
                "Nama wajib diisi.";
        }


        // ==============================================
        // VALIDATION EMAIL
        // ==============================================

        if ($email === "") {

            $errors[] =
                "Email wajib diisi.";

        } elseif (
            !filter_var(
                $email,
                FILTER_VALIDATE_EMAIL
            )
        ) {

            $errors[] =
                "Format email tidak valid.";

        } elseif (
            $this->mahasiswa
                ->emailExistsForOther(
                    $email,
                    $id
                )
        ) {

            $errors[] =
                "Email sudah digunakan mahasiswa lain.";
        }


        // ==============================================
        // VALIDATION PROGRAM STUDI
        // ==============================================

        if (
            $idProdi === ""
            ||
            !is_numeric(
                $idProdi
            )
        ) {

            $errors[] =
                "Program studi wajib dipilih.";
        }


        // ==============================================
        // VALIDATION ANGKATAN
        // ==============================================

        if (
            $angkatan === ""
            ||
            !is_numeric(
                $angkatan
            )
        ) {

            $errors[] =
                "Angkatan wajib diisi.";

        } elseif (
            strlen(
                (string) $angkatan
            ) !== 4
        ) {

            $errors[] =
                "Angkatan harus terdiri dari 4 digit.";
        }


        // ==============================================
        // JIKA VALIDATION GAGAL
        // ==============================================

        if (
            count(
                $errors
            ) > 0
        ) {

            $programStudi =
                $this->programStudi
                    ->getAll();


            $mahasiswa = [

                "id" =>
                    $id,

                "nim" =>
                    $existing["nim"],

                "nama" =>
                    $nama,

                "email" =>
                    $email,

                "id_prodi" =>
                    $idProdi,

                "angkatan" =>
                    $angkatan
            ];


            $this->view(
                "mahasiswa/edit",
                [
                    "mahasiswa" =>
                        $mahasiswa,

                    "programStudi" =>
                        $programStudi,

                    "errors" =>
                        $errors
                ]
            );


            return;
        }


        // ==============================================
        // UPDATE DATABASE
        // ==============================================

        try {

            $this->mahasiswa
                ->update(
                    $id,
                    $nama,
                    $email,
                    (int) $idProdi,
                    (int) $angkatan
                );


            $this->session->set(
                "message",
                "Data mahasiswa berhasil diperbarui."
            );


            $this->redirect(
                "index.php?action=mahasiswa"
            );


        } catch (
            Exception $e
        ) {

            die(
                $e->getMessage()
            );
        }
    }


    // ==================================================
    // DELETE
    // ==================================================

    public function delete(): void
    {
        $id =
            $this->getId();


        $mahasiswa =
            $this->mahasiswa
                ->findById(
                    $id
                );


        if (!$mahasiswa) {

            die(
                "Data mahasiswa tidak ditemukan."
            );
        }


        $this->view(
            "mahasiswa/delete",
            [
                "mahasiswa" =>
                    $mahasiswa
            ]
        );
    }


    // ==================================================
    // DESTROY
    // ==================================================

    public function destroy(): void
    {
        $id =
            $this->getId();


        $mahasiswa =
            $this->mahasiswa
                ->findById(
                    $id
                );


        if (!$mahasiswa) {

            die(
                "Data mahasiswa tidak ditemukan."
            );
        }


        try {

            $this->mahasiswa
                ->delete(
                    $id
                );


            $this->session->set(
                "message",
                "Data mahasiswa berhasil dihapus."
            );


        } catch (
            PDOException $e
        ) {

            $this->session->set(
                "message",
                "Data mahasiswa tidak dapat dihapus."
            );
        }


        $this->redirect(
            "index.php?action=mahasiswa"
        );
    }


    // ==================================================
    // GET ID
    // ==================================================

    private function getId(): int
    {
        $id =
            $_GET["id"]
            ?? null;


        if (
            $id === null
            ||
            !is_numeric(
                $id
            )
            ||
            (int) $id < 1
        ) {

            die(
                "ID tidak valid."
            );
        }


        return
            (int) $id;
    }
}