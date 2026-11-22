<?php

// ======================================================
// CLASS ROUTER
// ======================================================
// Router menyimpan daftar route aplikasi.
//
// Contoh:
//
// GET mahasiswa
// → MahasiswaController@index
//
// POST mahasiswa-store
// → MahasiswaController@store
// ======================================================

class Router
{
    private array $routes = [];


    // ==================================================
    // REGISTER GET ROUTE
    // ==================================================

    public function get(
        string $action,
        callable $handler
    ): void {

        $this->routes["GET"][$action] =
            $handler;
    }


    // ==================================================
    // REGISTER POST ROUTE
    // ==================================================

    public function post(
        string $action,
        callable $handler
    ): void {

        $this->routes["POST"][$action] =
            $handler;
    }


    // ==================================================
    // DISPATCH
    // ==================================================
    // Menentukan route yang akan dijalankan.
    // ==================================================

    public function dispatch(): void
    {
        $method =
            $_SERVER[
                "REQUEST_METHOD"
            ];


        // Default action adalah mahasiswa.

        $action =
            $_GET["action"]
            ?? "mahasiswa";


        if (
            !isset(
                $this->routes
                    [$method]
                    [$action]
            )
        ) {

            http_response_code(404);

            echo
                "404 - Route tidak ditemukan.";

            return;
        }


        // Jalankan Controller method.

        call_user_func(
            $this->routes
                [$method]
                [$action]
        );
    }
}