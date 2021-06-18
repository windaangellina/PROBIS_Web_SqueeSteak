<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                {{-- @if (session('role_aktif') == 1)
                    <div class="sb-sidenav-menu-heading">Core</div>
                    <a class="nav-link {{ (request()->is('/dashboard')) ? 'active' : '' }}" href="{{ route('admin.home') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                @endif --}}

                {{-- MENU PEGAWAI --}}
                <div class="sb-sidenav-menu-heading">Menu Pegawai</div>
                {{-- menu --}}
                @if (session('role_aktif') == 1)
                    <div>
                        <a id="nav-menu" class="nav-link nav-parent collapsed" href="#" data-toggle="collapse" data-target="#collapseLayoutsMenu" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Menu
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsMenu" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link menu-child {{ (request()->is('/menu')) ? 'active' : '' }}" href="{{ route('menu.list') }}">
                                    Daftar Menu
                                </a>
                                <a class="nav-link menu-child {{ (request()->is('/menu/add')) ? 'active' : '' }}" href="{{ route('menu.add.form') }}">Tambah Menu</a>
                            </nav>
                        </div>
                    </div>
                @endif

                {{-- food orders --}}
                @if (session('role_aktif') == 1 || session('role_aktif') == 3)
                    <div>
                        <a id="nav-food-order" class="nav-link nav-parent collapsed menu-parent" href="#" data-toggle="collapse" data-target="#collapseLayoutsFoodOrder" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-utensils"></i></div>
                            Pesanan Makanan
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsFoodOrder" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link menu-child {{ (request()->is('/food-order/ongoing')) ? 'active' : '' }}" href="{{ route('foodorder.list', ['status' => 'ongoing']) }}">Sedang diproses</a>
                                <a class="nav-link menu-child {{ (request()->is('/food-order/all')) ? 'active' : '' }}" href="{{ route('foodorder.list', ['status' => 'all']) }}">Semua Pesanan</a>
                            </nav>
                        </div>
                    </div>
                @endif

                {{-- customer orders --}}
                @if (session('role_aktif') == 1 || session('role_aktif') == 2)
                    <div>
                        <a id="nav-cust-order" class="nav-link nav-parent collapsed menu-parent" href="#" data-toggle="collapse" data-target="#collapseLayoutsCustOrder" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-invoice-dollar"></i></div>
                            Pesanan Pelanggan
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsCustOrder" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link menu-child {{ (request()->is('/customer-order/ongoing')) ? 'active' : '' }}" href="{{ route('custorder.list', ['status' => 'ongoing']) }}">Sedang berlangsung</a>
                                <a class="nav-link menu-child {{ (request()->is('/customer-order/done')) ? 'active' : '' }}" href="{{ route('custorder.list', ['status' => 'done']) }}">Sudah selesai</a>
                                <a class="nav-link menu-child {{ (request()->is('/customer-order/closed')) ? 'active' : '' }}" href="{{ route('custorder.list', ['status' => 'closed']) }}" href="#">Sudah dibayar</a>
                            </nav>
                        </div>
                    </div>
                @endif


                {{-- others --}}
                @if (session('role_aktif') == 1)
                <div class="sb-sidenav-menu-heading">Lainnya</div>
                {{-- <a class="nav-link" href="{{ route('admin.history') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-history"></i></div>
                    Log Aktivitas
                </a> --}}
                <a class="nav-link" href="{{ route('admin.setting.view') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-wrench"></i></div>
                    Ubah Password Aplikasi
                </a>
                @endif
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Masuk sebagai :</div>
            @if (session('role_aktif') == 1)
                (Admin) {{ strtolower(session('username_aktif')) }}
            @elseif(session('role_aktif') == 2)
                (Kasir) {{ strtolower(session('username_aktif')) }}
            @elseif(session('role_aktif') == 3)
                (Koki) {{ strtolower(session('username_aktif')) }}
            @endif
        </div>
    </nav>
</div>
