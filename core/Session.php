<?php

// ======================================================
// CLASS SESSION
// ======================================================
// Membungkus operasi $_SESSION menjadi sebuah object.
// ======================================================

class Session
{
    // Constructor otomatis menjalankan session.

    public function __construct()
    {
        $this->start();
    }


    // ==================================================
    // START
    // ==================================================

    private function start(): void
    {
        if (
            session_status()
            === PHP_SESSION_NONE
        ) {
            session_start();
        }
    }


    // ==================================================
    // SET
    // ==================================================

    public function set(
        string $key,
        $value
    ): void {

        $_SESSION[$key] =
            $value;
    }


    // ==================================================
    // GET
    // ==================================================

    public function get(
        string $key,
        $default = null
    ) {

        return
            $_SESSION[$key]
            ?? $default;
    }


    // ==================================================
    // HAS
    // ==================================================

    public function has(
        string $key
    ): bool {

        return isset(
            $_SESSION[$key]
        );
    }


    // ==================================================
    // REMOVE
    // ==================================================

    public function remove(
        string $key
    ): void {

        unset(
            $_SESSION[$key]
        );
    }


    // ==================================================
    // FLASH
    // ==================================================
    // Mengambil session kemudian langsung menghapusnya.
    //
    // Digunakan untuk pesan yang hanya tampil satu kali.
    // ==================================================

    public function flash(
        string $key
    ) {

        if (
            !$this->has($key)
        ) {
            return null;
        }


        $value =
            $this->get($key);


        $this->remove($key);


        return $value;
    }


    // ==================================================
    // REGENERATE
    // ==================================================
    // Membuat ID session baru (mencegah session fixation).
    // Dipanggil saat login dan logout.
    // ==================================================

    public function regenerate(): void
    {
        session_regenerate_id(true);
    }


    // ==================================================
    // DESTROY
    // ==================================================

    public function destroy(): void
    {
        $_SESSION = [];

        session_destroy();
    }
}