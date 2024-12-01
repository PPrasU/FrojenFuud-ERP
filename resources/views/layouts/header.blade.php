<meta charset="utf-8">
<link rel="icon" href="{{ asset('img/Logo FrojenFuud.png') }}" />

<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('source/plugins/fontawesome-free/css/all.min.css') }}">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet"
    href="{{ asset('source/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<!-- iCheck -->
<link rel="stylesheet" href="{{ asset('source/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<!-- JQVMap -->
<link rel="stylesheet" href="{{ asset('source/plugins/jqvmap/jqvmap.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('source/dist/css/adminlte.min.css') }}">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="{{ asset('source/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{ asset('source/plugins/daterangepicker/daterangepicker.css') }}">
<!-- summernote -->
<link rel="stylesheet" href="{{ asset('source/plugins/summernote/summernote-bs4.min.css') }}">
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('source/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('source/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('source/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{ asset('source/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="{{ asset('source/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('source/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('source/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<!-- Bootstrap4 Duallistbox -->
<link rel="stylesheet" href="{{ asset('source/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
<!-- BS Stepper -->
<link rel="stylesheet" href="{{ asset('source/plugins/bs-stepper/css/bs-stepper.min.css') }}">
<!-- dropzonejs -->
<link rel="stylesheet" href="{{ asset('source/plugins/dropzone/min/dropzone.min.css') }}">
{{-- Barcode --}}
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>

@include('sweetalert::alert')
{{-- Toaster CDN CSS --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
    integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    /* Select2 dropdown */
    .select2-container .select2-selection--single {
        height: 38px;
        /* Sesuaikan tinggi dengan select default */
        border: 1px solid #ced4da;
        /* Warna border */
        border-radius: 4px;
        /* Border melengkung */
        padding: 6px 12px;
        /* Padding agar sama */
        background-color: #fff;
        /* Warna latar */
    }

    /* Teks pada pilihan Select2 */
    .select2-container .select2-selection--single .select2-selection__rendered {
        line-height: 26px;
        /* Tinggi garis teks */
        font-size: 14px;
        /* Ukuran font */
        color: #495057;
        /* Warna teks */
    }

    /* Panah dropdown */
    .select2-container .select2-selection--single .select2-selection__arrow {
        height: 100%;
        /* Panjang panah */
        top: 0;
        /* Posisikan panah agar sejajar */
    }

    /* Dropdown hasil pencarian */
    .select2-container .select2-dropdown {
        border-radius: 4px;
        /* Sesuaikan border */
    }
</style>
