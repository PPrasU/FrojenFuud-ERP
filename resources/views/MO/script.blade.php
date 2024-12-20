    {{-- Validasi Form --}}
    <script>
        $(function() {
            $('#inputManufacturingOrder').validate({
                rules: {
                    produk_id: {
                        required: true,
                    },
                    reference: {
                        required: true,
                    },
                    variasi: {
                        required: true,
                    },
                    kuantitas_produk: {
                        required: true,
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>

    {{-- Tambah Bahan Dinamis --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <script>
        jQuery(document).ready(function() {
            var back = jQuery(".prev");
            var next = jQuery(".next");
            var steps = jQuery(".step");

            next.on("click", function() {
                jQuery.each(steps, function(i) {
                    if (jQuery(steps[i]).hasClass('current') && !jQuery(steps[i]).hasClass("done")) {
                        jQuery(steps[i]).removeClass('current').addClass("done");
                        if (i + 1 < steps.length) {
                            jQuery(steps[i + 1]).addClass('current');
                        }
                        return false; // Stop the loop
                    }
                });
            });

            back.on("click", function() {
                jQuery.each(steps, function(i) {
                    if (jQuery(steps[i]).hasClass('done') && jQuery(steps[i + 1]).hasClass('current')) {
                        jQuery(steps[i + 1]).removeClass('current');
                        jQuery(steps[i]).removeClass('done').addClass('current');
                        return false; // Stop the loop
                    }
                });
            });
        });
    </script>

    <script>
        var billOfMaterialData = @json($billOfMaterial);
    </script>
    
    <script>
        document.querySelector('select[name="bom"]').addEventListener('change', function() {
            var billOfMaterialId = this.value; // ID dari Bill of Material yang dipilih
            var bahanTabelBody = document.getElementById('bahanTabelBody');
            bahanTabelBody.innerHTML = ''; // Kosongkan tabel bahan sebelumnya

            // Ambil data bahan yang sesuai dari server
            $.ajax({
                url: '/get-bahan/' + billOfMaterialId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data && data.length > 0) {
                        data.forEach(function(bahan) {
                            var newRow = `
                                <tr>
                                    <td>${bahan.bahans.nama_bahan}</td>
                                    <td>${bahan.kuantitas}</td>
                                </tr>
                            `;
                            bahanTabelBody.innerHTML += newRow;
                        });
                    } else {
                        bahanTabelBody.innerHTML = `
                            <tr>
                                <td colspan="2" class="text-center">Tidak ada bahan untuk Bill of Material ini.</td>
                            </tr>
                        `;
                    }
                },
                error: function() {
                    bahanTabelBody.innerHTML = `
                        <tr>
                            <td colspan="2" class="text-center">Gagal mengambil bahan, coba lagi.</td>
                        </tr>
                    `;
                }
            });
        });
    </script>


    <script>
        // Function untuk mengisi jam secara otomatis saat memilih tanggal
        document.getElementById('jadwal').addEventListener('change', function() {
            var inputDate = this.value; // Mendapatkan nilai input tanggal
            var hiddenTimeInput = document.getElementById('schedule_time');

            if (inputDate) {
                // Mendapatkan waktu saat ini
                var now = new Date();
                var currentHour = ('0' + now.getHours()).slice(-2); // Mendapatkan jam sekarang (2 digit)
                var currentMinute = ('0' + now.getMinutes()).slice(-2); // Mendapatkan menit sekarang (2 digit)
                var currentSecond = ('0' + now.getSeconds()).slice(-2); // Mendapatkan detik sekarang (2 digit)

                // Format waktu sekarang ke dalam bentuk jam:menit:detik
                var currentTime = currentHour + ':' + currentMinute + ':' + currentSecond;

                // Simpan waktu di input hidden
                hiddenTimeInput.value = currentTime;
            }
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#bomSelect').on('change', function() {
                var produkId = $(this).val();

                if (produkId) {
                    $.ajax({
                        url: '/get-reference/' + produkId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            if (data) {
                                $('#nama_produk').val(data.nama_produk);
                                $('#reference').val(data.reference);
                            }
                        },
                        error: function() {
                            $('#nama_produk').val('');
                            $('#reference').val('');
                        }
                    });
                } else {
                    $('#nama_produk').val('');
                    $('#reference').val('');
                }
            });
        });
    </script>