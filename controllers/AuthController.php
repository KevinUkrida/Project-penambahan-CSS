<?php

class AuthController extends Controller
{
    private Mahasiswa $mahasiswa;
    private Session $session;

    public function __construct(PDO $conn, Session $session)
    {
        $this->mahasiswa = new Mahasiswa($conn);
        $this->session   = $session;
    }

    public function login(): void
    {
        if ($this->session->has("user_id")) {
            $this->redirect("index.php?action=mahasiswa");
        }

        $message = $this->session->flash("message");

        $this->view("auth/login", [
            "errors"  => [],
            "old"     => [],
            "message" => $message,
        ]);
    }

    public function authenticate(): void
    {
        $email    = trim($_POST["email"] ?? "");
        $password = (string) ($_POST["password"] ?? "");

        if ($email === "" || $password === "") {
            $this->view("auth/login", [
                "errors"  => ["Email dan password wajib diisi."],
                "old"     => ["email" => $email],
                "message" => null,
            ]);
            return;
        }

        $user = $this->mahasiswa->findByEmail($email);

        $dbPassword = (string) ($user["password"] ?? "");
        $passwordValid = $user && (
            password_verify($password, $dbPassword)
            || hash_equals($dbPassword, $password)
        );

        if (!$passwordValid) {
            $this->view("auth/login", [
                "errors"  => ["Email atau password salah."],
                "old"     => ["email" => $email],
                "message" => null,
            ]);
            return;
        }

        $this->session->regenerate();
        $this->session->set("user_id", (int) $user["id"]);
        $this->session->set("user_nama", $user["nama"] ?? "");
        $this->session->set("user_nim", $user["nim"] ?? "");

        $this->redirect("index.php?action=mahasiswa");
    }

    public function logout(): void
    {
        $this->session->remove("user_id");
        $this->session->remove("user_nama");
        $this->session->remove("user_nim");
        $this->session->regenerate();
        $this->session->set("message", "Anda telah keluar.");

        $this->redirect("index.php?action=login");
    }
}