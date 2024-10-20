<aside class="main-sidebar main-sidebar-custom sidebar-light-primary elevation-4">
    <a href="/" class="brand-link">
        <img src="{{ asset('img/Logo FrojenFuud.png') }}" alt="Logo FrojenFuud" class="brand-image img-circle elevation-2"
            style="opacity: .8">
        <span class="brand-text font-weight-light">FrojenFuud</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="/home" class="nav-link {{ request()->is('home') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p style="font-size: 14px">Beranda</p>
                    </a>
                </li>
                {{-- Manufacturing --}}
                <li
                    class="nav-item {{ request()->is('produk*') || request()->is('bahan-baku*') || request()->is('BillOfMaterial*') || request()->is('ManufacturingOrder*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->is('produk*') || request()->is('bahan-baku*') || request()->is('BillOfMaterial*') || request()->is('ManufacturingOrder*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-building"></i>
                        <p style="font-size: 14px">
                            Manufacturing
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/produk" class="nav-link {{ request()->is('produk*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="font-size: 14px"></i>
                                <p style="font-size: 14px">Produk</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/bahan-baku" class="nav-link {{ request()->is('bahan-baku*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="font-size: 14px"></i>
                                <p style="font-size: 14px">Bahan Baku</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/BillOfMaterial" class="nav-link {{ request()->is('BillOfMaterial*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="font-size: 14px"></i>
                                <p style="font-size: 14px">Daftar Material (BoM)</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/ManufacturingOrder" class="nav-link {{ request()->is('ManufacturingOrder*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="font-size: 14px"></i>
                                <p style="font-size: 14px">Produksi (MO)</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- Purchase --}}
                <li class="nav-item {{ request()->is('purchase*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('purchase*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-credit-card"></i>
                        <p style="font-size: 14px">
                            Purchase
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/vendor" class="nav-link {{ request()->is('vendor*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="font-size: 14px"></i>
                                <p style="font-size: 14px">Vendor</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/rfq" class="nav-link {{ request()->is('rfq*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="font-size: 14px"></i>
                                <p style="font-size: 14px">Permintaan Penawaran (RfQ)</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- Sales --}}
                <li class="nav-item {{ request()->is('sales*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('sales*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-eraser"></i>
                        <p style="font-size: 14px">
                            Sales
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/pelanggan" class="nav-link {{ request()->is('pelanggan*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="font-size: 14px"></i>
                                <p style="font-size: 14px">Pelanggan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/penjualan" class="nav-link {{ request()->is('penjualan*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="font-size: 14px"></i>
                                <p style="font-size: 14px">Penjualan</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- Accounting --}}
                <li class="nav-item {{ request()->is('accounting*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('accounting*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-percent"></i>
                        <p style="font-size: 14px">
                            Accounting
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/accounting/pembelian"
                                class="nav-link {{ request()->is('accounting/pembelian*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="font-size: 14px"></i>
                                <p style="font-size: 14px">Pembelian</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/accounting/penjualan"
                                class="nav-link {{ request()->is('accounting/penjualan*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="font-size: 14px"></i>
                                <p style="font-size: 14px">Penjualan</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- Employees --}}
                <li class="nav-item {{ request()->is('employees*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('employees*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p style="font-size: 14px">
                            Employees
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/employees/departemen"
                                class="nav-link {{ request()->is('employees/departemen*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="font-size: 14px"></i>
                                <p style="font-size: 14px">Departemen</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/employees/posisi-jabatan"
                                class="nav-link {{ request()->is('employees/posisi-jabatan*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="font-size: 14px"></i>
                                <p style="font-size: 14px">Posisi Jabatan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/employees/karyawan"
                                class="nav-link {{ request()->is('employees/karyawan*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="font-size: 14px"></i>
                                <p style="font-size: 14px">Karyawan</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- Inventory --}}
                <li class="nav-item {{ request()->is('inventory*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('inventory*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cubes"></i>
                        <p style="font-size: 14px">
                            Inventory
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/inventory/overview"
                                class="nav-link {{ request()->is('inventory/overview*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="font-size: 14px"></i>
                                <p style="font-size: 14px">Overview</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/inventory/transfer"
                                class="nav-link {{ request()->is('inventory/transfer*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p style="font-size: 14px">Transfer<i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/inventory/kuitansi"
                                        class="nav-link {{ request()->is('inventory/kuitansi*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-circle"></i>
                                        <p style="font-size: 14px">Kuitansi</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/inventory/pengiriman"
                                        class="nav-link {{ request()->is('inventory/pengiriman*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-circle"></i>
                                        <p style="font-size: 14px">Pengiriman</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/inventory/manufaktur"
                                        class="nav-link {{ request()->is('inventory/manufaktur*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-circle"></i>
                                        <p style="font-size: 14px">Manufaktur</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
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
</aside>
