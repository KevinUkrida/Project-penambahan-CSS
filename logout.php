<?php

// ======================================================
// LOGOUT  ->  simpan di root, sejajar dengan index.php
// ======================================================
// Dipanggil lewat tombol "Keluar" (method POST).
// File ini berdiri sendiri, tidak butuh AuthController.
// ======================================================

require_once __DIR__ . "/core/Session.php";

$session = new Session();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $session->remove("user_id");
    $session->remove("user_nama");
    $session->remove("user_nim");

    $session->regenerate();

    $session->set("message", "Anda telah keluar.");
}

header("Location: index.php?action=login");
exit;