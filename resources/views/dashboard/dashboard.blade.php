<!DOCTYPE html>
<html lang="en">

<head>
    <title>FrojenFuud-ERP | Dashboard</title>
    @include('layouts/header')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('layouts/preloader')
        @include('layouts/navbar')
        @include('layouts/sidebar')
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Beranda</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                {{-- <li class="breadcrumb-item"><a href="/home">Beranda</a>
                                </li> --}}
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    <h5 class="mb-2">Manufacturing</h5>
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="small-box">
                                <div class="inner">
                                    <h3>Produk ({{ count($produk) }})</h3>
                                    @foreach ($produk as $item)
                                        <p>{{ $item->nama_produk }}: {{ $item->kuantitas_produk }} pcs</p>
                                    @endforeach
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag" style="color: black"></i>
                                </div>
                                <a href="/produk" class="small-box-footer" style="color: black">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box">
                                <div class="inner">
                                    <h3>Bahan Baku ({{ count($bahan) }})</h3><br>
                                    @foreach ($bahan as $index => $item)
                                        {{ $item->nama_bahan }}@if ($index < $bahan->count() - 1), @endif
                                    @endforeach
                                </div>
                                <div class="icon">
                                    <i class="ion ion-cube" style="color: black"></i>
                                </div>
                                <a href="/bahan-baku" class="small-box-footer" style="color: black">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box">
                                <div class="inner">
                                    <h3>Bill Of Material ({{ count($billOfMaterial) }})</h3>
                                    @foreach ($billOfMaterial as $item)
                                        <p>{{ $item->reference }}</p>
                                    @endforeach
                                </div>
                                <div class="icon">
                                    <i class="ion ion-clipboard" style="color: black"></i>
                                </div>
                                <a href="/BillOfMaterial" class="small-box-footer" style="color: black">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box">
                                <div class="inner">
                                    <h4><strong>Manufacturing Order ({{ count($manufacturingOrder) }})</strong></h4>
                                    {{-- @foreach ($manufacturingOrder as $index => $item)
                                        {{ $item->reference }}@if ($index < $manufacturingOrder->count() - 1), @endif
                                    @endforeach --}}
                                    @foreach ($manufacturingOrder as $item)
                                        <p>{{ $item->reference }}</p>
                                    @endforeach
                                </div>
                                <div class="icon">
                                    <i class="ion ion-cash" style="color: black"></i>
                                </div>
                                <a href="#" class="small-box-footer" style="color: black">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="row">
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box">
                                <span class="info-box-icon"><i class="nav-icon fas fa-archive"
                                        style="color: black"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Produk</span>
                                    <span class="info-box-number">---</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box">
                                <span class="info-box-icon"><i class="nav-icon fas fa-cubes"
                                        style="color: black"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Bahan Baku</span>
                                    <span class="info-box-number">---</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box">
                                <span class="info-box-icon"><i class="nav-icon fas fa-clipboard "
                                        style="color: black"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Daftar Material (BoM)</span>
                                    <span class="info-box-number">---</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box">
                                <span class="info-box-icon"><i class="nav-icon fas fa-industry"
                                        style="color: black"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Pesanan Produksi</span>
                                    <span class="info-box-number">---</span>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="row">
                        {{-- To Do List --}}
                        {{-- <section class="col-lg-7 connectedSortable">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="ion ion-clipboard mr-1"></i>
                                        To Do List
                                    </h3>
                                    <div class="card-tools">
                                        <ul class="pagination pagination-sm">
                                            <li class="page-item"><a href="#" class="page-link">&laquo;</a>
                                            </li>
                                            <li class="page-item"><a href="#" class="page-link">1</a></li>
                                            <li class="page-item"><a href="#" class="page-link">2</a></li>
                                            <li class="page-item"><a href="#" class="page-link">3</a></li>
                                            <li class="page-item"><a href="#" class="page-link">&raquo;</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <ul class="todo-list" data-widget="todo-list">
                                        <li>
                                            <span class="handle">
                                                <i class="fas fa-ellipsis-v"></i>
                                                <i class="fas fa-ellipsis-v"></i>
                                            </span>
                                            <div class="icheck-primary d-inline ml-2">
                                                <input type="checkbox" value="" name="todo1" id="todoCheck1">
                                                <label for="todoCheck1"></label>
                                            </div>
                                            <span class="text">Design a nice theme</span>
                                            <small class="badge badge-danger"><i class="far fa-clock"></i> 2
                                                mins</small>
                                            <div class="tools">
                                                <i class="fas fa-edit"></i>
                                                <i class="fas fa-trash-o"></i>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="handle">
                                                <i class="fas fa-ellipsis-v"></i>
                                                <i class="fas fa-ellipsis-v"></i>
                                            </span>
                                            <div class="icheck-primary d-inline ml-2">
                                                <input type="checkbox" value="" name="todo2" id="todoCheck2"
                                                    checked>
                                                <label for="todoCheck2"></label>
                                            </div>
                                            <span class="text">Make the theme responsive</span>
                                            <small class="badge badge-info"><i class="far fa-clock"></i> 4
                                                hours</small>
                                            <div class="tools">
                                                <i class="fas fa-edit"></i>
                                                <i class="fas fa-trash-o"></i>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="handle">
                                                <i class="fas fa-ellipsis-v"></i>
                                                <i class="fas fa-ellipsis-v"></i>
                                            </span>
                                            <div class="icheck-primary d-inline ml-2">
                                                <input type="checkbox" value="" name="todo3"
                                                    id="todoCheck3">
                                                <label for="todoCheck3"></label>
                                            </div>
                                            <span class="text">Let theme shine like a star</span>
                                            <small class="badge badge-warning"><i class="far fa-clock"></i> 1
                                                day</small>
                                            <div class="tools">
                                                <i class="fas fa-edit"></i>
                                                <i class="fas fa-trash-o"></i>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="handle">
                                                <i class="fas fa-ellipsis-v"></i>
                                                <i class="fas fa-ellipsis-v"></i>
                                            </span>
                                            <div class="icheck-primary d-inline ml-2">
                                                <input type="checkbox" value="" name="todo4"
                                                    id="todoCheck4">
                                                <label for="todoCheck4"></label>
                                            </div>
                                            <span class="text">Let theme shine like a star</span>
                                            <small class="badge badge-success"><i class="far fa-clock"></i> 3
                                                days</small>
                                            <div class="tools">
                                                <i class="fas fa-edit"></i>
                                                <i class="fas fa-trash-o"></i>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="handle">
                                                <i class="fas fa-ellipsis-v"></i>
                                                <i class="fas fa-ellipsis-v"></i>
                                            </span>
                                            <div class="icheck-primary d-inline ml-2">
                                                <input type="checkbox" value="" name="todo5"
                                                    id="todoCheck5">
                                                <label for="todoCheck5"></label>
                                            </div>
                                            <span class="text">Check your messages and notifications</span>
                                            <small class="badge badge-primary"><i class="far fa-clock"></i> 1
                                                week</small>
                                            <div class="tools">
                                                <i class="fas fa-edit"></i>
                                                <i class="fas fa-trash-o"></i>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="handle">
                                                <i class="fas fa-ellipsis-v"></i>
                                                <i class="fas fa-ellipsis-v"></i>
                                            </span>
                                            <div class="icheck-primary d-inline ml-2">
                                                <input type="checkbox" value="" name="todo6"
                                                    id="todoCheck6">
                                                <label for="todoCheck6"></label>
                                            </div>
                                            <span class="text">Let theme shine like a star</span>
                                            <small class="badge badge-secondary"><i class="far fa-clock"></i> 1
                                                month</small>
                                            <div class="tools">
                                                <i class="fas fa-edit"></i>
                                                <i class="fas fa-trash-o"></i>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-footer clearfix">
                                    <button type="button" class="btn btn-primary float-right"><i
                                            class="fas fa-plus"></i> Add item</button>
                                </div>
                            </div>
                        </section> --}}
                        {{-- Calendar --}}
                        {{-- <section class="col-lg-5 connectedSortable">
                            <div class="card bg-gradient-success">
                                <div class="card-header border-0">

                                    <h3 class="card-title">
                                        <i class="far fa-calendar-alt"></i>
                                        Calendar
                                    </h3>
                                    <div class="card-tools">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-success btn-sm dropdown-toggle"
                                                data-toggle="dropdown" data-offset="-52">
                                                <i class="fas fa-bars"></i>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <a href="#" class="dropdown-item">Add new event</a>
                                                <a href="#" class="dropdown-item">Clear events</a>
                                                <div class="dropdown-divider"></div>
                                                <a href="#" class="dropdown-item">View calendar</a>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-success btn-sm"
                                            data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-success btn-sm"
                                            data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div id="calendar" style="width: 100%"></div>
                                </div>
                            </div>
                        </section> --}}
                    </div>
                </div>
            </section>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Monthly Recap Report</h5>
            
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                                        <i class="fas fa-wrench"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                                        <a href="#" class="dropdown-item">Action</a>
                                        <a href="#" class="dropdown-item">Another action</a>
                                        <a href="#" class="dropdown-item">Something else here</a>
                                        <a class="dropdown-divider"></a>
                                        <a href="#" class="dropdown-item">Separated link</a>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <p class="text-center">
                                        <strong>Sales: December 2024</strong>
                                    </p>
                                    <div class="chart">
                                        <canvas id="salesChart" height="180" style="height: 180px;"></canvas>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <p class="text-center">
                                        <strong>Goal Completion</strong>
                                    </p>
            
                                    <div class="progress-group">
                                        Add Products to Cart
                                        <span class="float-right"><b>160</b>/200</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-primary" style="width: 80%"></div>
                                        </div>
                                    </div>
            
                                    <div class="progress-group">
                                        Complete Purchase
                                        <span class="float-right"><b>310</b>/400</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-danger" style="width: 75%"></div>
                                        </div>
                                    </div>
            
                                    <div class="progress-group">
                                        <span class="progress-text">Visit Premium Page</span>
                                        <span class="float-right"><b>480</b>/800</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success" style="width: 60%"></div>
                                        </div>
                                    </div>
            
                                    <div class="progress-group">
                                        Send Inquiries
                                        <span class="float-right"><b>250</b>/500</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-warning" style="width: 50%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-3 col-6">
                                    <div class="description-block border-right">
                                        <h5 class="description-header">Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</h5>
                                        <span class="description-text">TOTAL PENDAPATAN</span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-6">
                                    <div class="description-block border-right">
                                        <h5 class="description-header">Rp{{ number_format($totalCost, 0, ',', '.') }}</h5>
                                        <span class="description-text">TOTAL COST</span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-6">
                                    <div class="description-block border-right">
                                        <span class="description-percentage {{ $percentageClass }}">
                                            <i class="fas {{ $caretDirection }}"></i> {{ $percentageText }}%
                                        </span>
                                        <h5 class="description-header">Rp{{ number_format($totalProfit, 0, ',', '.') }}</h5>
                                        <span class="description-text">TOTAL PROFIT</span>
                                    </div>
                                </div>                                
                                <div class="col-sm-3 col-6">
                                    <div class="description-block">
                                        <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                                        <h5 class="description-header">{{ $goalCompletions }}</h5>
                                        <span class="description-text">GOAL COMPLETIONS</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
        @include('layouts/footer')
    </div>

    @include('layouts/script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('message'))
                toastr.success('{{ session('message') }}');
            @endif
        });
    </script>
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.js"></script>

    <!-- PAGE PLUGINS -->
    <!-- jQuery Mapael -->
    <script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
    <script src="plugins/raphael/raphael.min.js"></script>
    <script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
    <script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
    <!-- ChartJS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
</body>

</html>
