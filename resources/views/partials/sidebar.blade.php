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
                    <a href="{{ route('kasir.index') }}" class="nav-link {{ Route::currentRouteName() == 'kasir.index' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box"></i>
                        <p>Menu Barang</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('kasir.bayar') }}" class="nav-link {{ Route::currentRouteName() == 'kasir.bayar' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cash-register"></i>
                        <p>Pembayaran</p>
                    </a>
                </li>
                
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
