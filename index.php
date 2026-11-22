<?php

// ======================================================
// FRONT CONTROLLER  ->  simpan sebagai: index.php (root)
// ======================================================
// Semua request aplikasi masuk melalui file ini.
// ======================================================

require_once __DIR__ . "/config/Database.php";
require_once __DIR__ . "/core/Controller.php";
require_once __DIR__ . "/core/Router.php";
require_once __DIR__ . "/core/Session.php";

require_once __DIR__ . "/models/Mahasiswa.php";
require_once __DIR__ . "/models/ProgramStudi.php";

require_once __DIR__ . "/controllers/AuthController.php";
require_once __DIR__ . "/controllers/MahasiswaController.php";


try {

    $database = new Database();
    $conn     = $database->getConnection();
    $session  = new Session();

    $authController      = new AuthController($conn, $session);
    $mahasiswaController = new MahasiswaController($conn, $session);

    $router = new Router();


    // ==================================================
    // PROTEKSI LOGIN
    // ==================================================
    // Hanya halaman login yang boleh dibuka tanpa login.
    // Selain itu, user dialihkan ke halaman login.
    // ==================================================

    $publicActions = ["login", "authenticate"];

    $action = $_GET["action"] ?? "mahasiswa";

    if (
        !$session->has("user_id")
        && !in_array($action, $publicActions, true)
    ) {
        header("Location: index.php?action=login");
        exit;
    }


    // ==================================================
    // ROUTES - AUTH
    // ==================================================

    $router->get("login",        [$authController, "login"]);
    $router->post("authenticate", [$authController, "authenticate"]);


    // ==================================================
    // ROUTES - MAHASISWA
    // ==================================================

    $router->get("mahasiswa",         [$mahasiswaController, "index"]);
    $router->get("mahasiswa-create",  [$mahasiswaController, "create"]);
    $router->post("mahasiswa-store",  [$mahasiswaController, "store"]);
    $router->get("mahasiswa-edit",    [$mahasiswaController, "edit"]);
    $router->post("mahasiswa-update", [$mahasiswaController, "update"]);
    $router->get("mahasiswa-delete",  [$mahasiswaController, "delete"]);
    $router->post("mahasiswa-destroy", [$mahasiswaController, "destroy"]);


    $router->dispatch();


} catch (PDOException $e) {
    echo "Terjadi kesalahan database: " . $e->getMessage();
}