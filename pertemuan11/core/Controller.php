<?php

// ======================================================
// BASE CONTROLLER
// ======================================================
// Class Controller merupakan parent class
// untuk controller-controller aplikasi.
//
// Method umum seperti:
// - view()
// - redirect()
//
// tidak perlu dibuat ulang di setiap controller.
// ======================================================

class Controller
{
    // ==================================================
    // VIEW
    // ==================================================
    // Digunakan Controller untuk membuka file View
    // dan mengirim data ke View.
    // ==================================================

   protected function view(
        string $view,
        array $data = []
    ): void {

        $viewFile =
            __DIR__ .
            "/../views/" .
            $view .
            ".php";

        if (!file_exists($viewFile)) {
            die("View tidak ditemukan.");
        }

        require $viewFile;
    }


    // ==================================================
    // REDIRECT
    // ==================================================

    protected function redirect(
        string $url
    ): void {

        header(
            "Location: " . $url
        );

        exit;
    }
}