// ======================================================
// STYLE.JS  ->  assets/js/style.js
// ======================================================

document.addEventListener("DOMContentLoaded", function () {

    // 1. Konfirmasi sebelum aksi berbahaya
    //    Pakai: <button data-confirm="Pesan konfirmasi">
    document.querySelectorAll("[data-confirm]").forEach(function (el) {
        el.addEventListener("click", function (e) {
            if (!confirm(el.getAttribute("data-confirm"))) {
                e.preventDefault();
            }
        });
    });


    // 2. Pencarian di tabel mahasiswa
    var searchInput = document.getElementById("searchMahasiswa");
    var tableBody = document.querySelector("#tableMahasiswa tbody");
    var noResult = document.getElementById("noResult");

    if (searchInput && tableBody) {
        searchInput.addEventListener("input", function () {
            var keyword = this.value.toLowerCase().trim();
            var visible = 0;

            tableBody.querySelectorAll("tr").forEach(function (row) {
                var cocok = row.textContent.toLowerCase().indexOf(keyword) !== -1;
                row.style.display = cocok ? "" : "none";
                if (cocok) visible++;
            });

            if (noResult) {
                noResult.hidden = visible > 0;
            }
        });
    }


    // 3. Tampilkan / sembunyikan password
    //    Pakai: <input type="checkbox" data-toggle-password="id_input">
    document.querySelectorAll("[data-toggle-password]").forEach(function (box) {
        var input = document.getElementById(box.getAttribute("data-toggle-password"));
        if (!input) return;

        box.addEventListener("change", function () {
            input.type = box.checked ? "text" : "password";
        });
    });


    // 4. Validasi form wajib isi (form dengan data-validate="true")
    document.querySelectorAll("form[data-validate='true']").forEach(function (form) {
        // Matikan bubble bawaan browser, kita pakai pesan sendiri.
        form.setAttribute("novalidate", "novalidate");

        form.querySelectorAll("[required]").forEach(function (field) {
            field.addEventListener("input", function () {
                field.classList.remove("is-invalid");
            });
        });

        form.addEventListener("submit", function (e) {
            var firstInvalid = null;

            form.querySelectorAll("[required]").forEach(function (field) {
                var kosong = !field.value.trim();
                field.classList.toggle("is-invalid", kosong);
                if (kosong && !firstInvalid) firstInvalid = field;
            });

            if (firstInvalid) {
                e.preventDefault();
                firstInvalid.focus();
                alert("Harap lengkapi semua kolom yang wajib diisi.");
            }
        });
    });


    // 5. Pesan sukses hilang sendiri setelah 4 detik
    document.querySelectorAll("[data-autohide='true']").forEach(function (el) {
        setTimeout(function () {
            el.style.opacity = "0";
            setTimeout(function () { el.remove(); }, 400);
        }, 4000);
    });

});