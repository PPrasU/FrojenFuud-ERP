<aside class="main-sidebar main-sidebar-custom sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="{{ asset('img/Logo FrojenFuud.png') }}" alt="Logo FrojenFuud" class="brand-image img-circle elevation-2"
            style="opacity: .8">
        <span class="brand-text font-weight-light">FrojenFuud</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                {{-- Sidebar Beranda --}}
                <li class="nav-item">
                    <a href="/home" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p style="font-size: 14px">Beranda</p>
                    </a>
                </li>
                {{-- <li class="nav-header">PROGRAM ERP</li> --}}
                {{-- Sidebar Manufacturing --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-building"></i>
                        <p style="font-size: 14px">
                            Manufacturing
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/produk" class="nav-link">
                                <i class="far fa-circle nav-icon" style="font-size: 14px"></i>
                                <p style="font-size: 14px">Produk</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/bahan-baku" class="nav-link">
                                <i class="far fa-circle nav-icon" style="font-size: 14px"></i>
                                <p style="font-size: 14px">Bahan Baku</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon" style="font-size: 14px"></i>
                                <p style="font-size: 14px">Daftar Material (BoM)</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon" style="font-size: 14px"></i>
                                <p style="font-size: 14px">Pesanan Produksi (MO)</p>
                            </a>
                        </li>

                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <div class="sidebar-custom">
        <a class="btn btn-danger hide-on-collapse pos-right" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
    <!-- /.sidebar -->
</aside>
