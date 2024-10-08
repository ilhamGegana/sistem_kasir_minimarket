<!-- resources/views/partials/sidebar.blade.php -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">HappyMart</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ url('/admin/kategori') }}"
                        class="nav-link {{ $activeMenu == 'kategori' ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-box"></i>
                        <p>Kategori Barang</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/admin/member') }}"
                        class="nav-link {{ $activeMenu == 'member' ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Data Member</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/admin/barang') }}"
                        class="nav-link {{ $activeMenu == 'data_barang' ? 'active' : '' }} "> <i
                            class="nav-icon fas fa-box"></i>
                        <p>Data Barang</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/admin/pengguna') }}"
                        class="nav-link {{ $activeMenu == 'pengguna' ? 'active' : '' }} "> <i
                            class="nav-icon fas fa-box"></i>
                        <p>Data Pengguna</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/admin/detailTransaksi') }}"
                        class="nav-link {{ $activeMenu == 'detailTransaksi' ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-file"></i>
                        <p>Laporan</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
