<?php

// ======================================================
// FRONT CONTROLLER
// ======================================================
// Semua request aplikasi masuk melalui file ini.
// ======================================================


// ======================================================
// REQUIRE CORE
// ======================================================

require_once
    __DIR__ .
    "/config/Database.php";

require_once
    __DIR__ .
    "/core/Controller.php";

require_once
    __DIR__ .
    "/core/Router.php";

require_once
    __DIR__ .
    "/core/Session.php";


// ======================================================
// REQUIRE MODELS
// ======================================================

require_once
    __DIR__ .
    "/models/Mahasiswa.php";

require_once
    __DIR__ .
    "/models/ProgramStudi.php";


// ======================================================
// REQUIRE CONTROLLER
// ======================================================

require_once
    __DIR__ .
    "/controllers/MahasiswaController.php";


// ======================================================
// CREATE APPLICATION OBJECTS
// ======================================================

try {

    // Database object.

    $database =
        new Database();


    // PDO connection.

    $conn =
        $database
            ->getConnection();


    // Session object.

    $session =
        new Session();


    // Controller object.

    $mahasiswaController =
        new MahasiswaController(
            $conn,
            $session
        );


    // Router object.

    $router =
        new Router();


    // ==================================================
    // REGISTER ROUTES
    // ==================================================


    // ----------------------------------------------
    // READ
    // ----------------------------------------------

    $router->get(
        "mahasiswa",
        [
            $mahasiswaController,
            "index"
        ]
    );


    // ----------------------------------------------
    // CREATE FORM
    // ----------------------------------------------

    $router->get(
        "mahasiswa-create",
        [
            $mahasiswaController,
            "create"
        ]
    );


    // ----------------------------------------------
    // CREATE PROCESS
    // ----------------------------------------------

    $router->post(
        "mahasiswa-store",
        [
            $mahasiswaController,
            "store"
        ]
    );


    // ----------------------------------------------
    // EDIT FORM
    // ----------------------------------------------

    $router->get(
        "mahasiswa-edit",
        [
            $mahasiswaController,
            "edit"
        ]
    );


    // ----------------------------------------------
    // UPDATE PROCESS
    // ----------------------------------------------

    $router->post(
        "mahasiswa-update",
        [
            $mahasiswaController,
            "update"
        ]
    );


    // ----------------------------------------------
    // DELETE CONFIRMATION
    // ----------------------------------------------

    $router->get(
        "mahasiswa-delete",
        [
            $mahasiswaController,
            "delete"
        ]
    );


    // ----------------------------------------------
    // DELETE PROCESS
    // ----------------------------------------------

    $router->post(
        "mahasiswa-destroy",
        [
            $mahasiswaController,
            "destroy"
        ]
    );


    // ==================================================
    // DISPATCH
    // ==================================================

    $router->dispatch();


} catch (PDOException $e) {
    echo "Terjadi kesalahan database: " . $e->getMessage();
}