jQuery(document).ready(function () {
    var back = jQuery(".prev");
    var next = jQuery(".next");
    var steps = jQuery(".step");

    next.on("click", function () {
        steps.each(function (index) {
            if ($(this).hasClass("current") && index < steps.length - 1) {
                $(this).removeClass("current").addClass("done");
                $(steps[index + 1]).addClass("current");
                return false; // Stop the loop
            }
        });
    });

    back.on("click", function () {
        steps.each(function (index) {
            if ($(this).hasClass("current") && index > 0) {
                $(this).removeClass("current");
                $(steps[index - 1])
                    .removeClass("done")
                    .addClass("current");
                return false; // Stop the loop
            }
        });
    });
});

// UNTUK MENGAMBIL ID BOM YANG SELARAS DENGAN NAMA PRODUK
$("#nama_produk").change(function () {
    var id = $(this).val(); // Ambil ID produk yang dipilih

    // Jika id ada, kirimkan request ke server untuk mengambil Bill Of Material terkait
    if (id) {
        $.ajax({
            url: "/get-bill-of-materials/" + id, // Endpoint untuk mengambil data Bill Of Material
            type: "GET",
            success: function (data) {
                // Kosongkan dulu pilihan Bill Of Material
                $("#produkSelect").empty();

                // Tambahkan option default
                $("#produkSelect").append(
                    "<option selected disabled>-- Pilih --</option>"
                );

                // Looping melalui data Bill Of Material yang diterima dari server
                $.each(data, function (index, value) {
                    $("#produkSelect").append(
                        `<option value="${value.id}|${value.reference} ${value.nama_produk}" data-reference="${value.reference}">
                            ${value.reference} ${value.nama_produk}
                        </option>`
                    );
                });
            },
            error: function () {
                alert("Gagal mengambil data Bill Of Material!");
            },
        });
    }
});

$("#produkSelect").change(function () {
    var billOfMaterialId = $(this).val(); // Ambil ID Bill of Material yang dipilih

    // Ambil nilai reference dari atribut data-reference
    var selectedOption = $(this).find("option:selected"); // Opsi yang sedang dipilih
    var reference = selectedOption.data("reference"); // Ambil nilai data-reference

    // Isi input field "Reference" dengan nilai yang diambil
    $("#reference").val(reference);

    if (billOfMaterialId) {
        // Ajax request untuk mendapatkan data bahan
        $.ajax({
            url: "/get-bahan/" + billOfMaterialId,
            type: "GET",
            success: function (data) {
                // Bersihkan tabel bahan
                var tbody = $("table tbody");
                tbody.empty();

                // Fungsi untuk memformat angka ke format mata uang Rupiah
                function formatRupiah(angka) {
                    // Jika angka dalam bentuk string dengan awalan 'Rp', hilangkan 'Rp' dan spasi
                    angka = angka.toString().replace(/[^\d]/g, ""); // Hapus karakter selain angka
                    return "Rp " + angka.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                }                

                let totalHarga = 0; // Variabel untuk menyimpan total harga

                // Jika ada data bahan, tambahkan ke tabel
                if (data.length > 0) {
                    data.forEach(function (bahan) {
                        // Pastikan harga_satuan adalah angka
                        const hargaSatuan = parseFloat(bahan.harga_satuan) || 0;

                        totalHarga += hargaSatuan; // Tambahkan harga_satuan ke total
                        tbody.append(
                            `<tr>
                                <td>${bahan.nama_bahan}</td>
                                <td>${bahan.kuantitas}</td>
                                <td>${formatRupiah(hargaSatuan)}</td>
                            </tr>`
                        );
                    });

                    // Tambahkan baris untuk total harga per 1 produk
                    tbody.append(
                        `<tr>
                            <td colspan="2"><strong>Total Harga Per 1 Produk</strong></td>
                            <td><strong>${formatRupiah(totalHarga)}</strong></td>
                        </tr>`
                    );

                    // Masukkan total harga ke input hidden
                    $("#harga_produk").val(totalHarga);
                } else {
                    // Jika tidak ada bahan terkait
                    tbody.append(
                        `<tr>
                            <td colspan="3" class="text-center">Tidak ada bahan terkait</td>
                        </tr>`
                    );
                }
            },
            error: function () {
                alert("Gagal mengambil data bahan!");
            },
        });
    }
});




