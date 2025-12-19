<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ asset('sbadmin/index.html') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Data Master
    </div>

    <!-- Nav Item - Data Barang -->
    <li class="nav-item {{ request()->routeIs('admin.barang.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.barang.index') }}">
            <i class="fas fa-fw fa-box"></i>
            <span>Data Barang</span></a>
    </li>

    <!-- Nav Item - Data Dokter -->
    <li class="nav-item {{ request()->routeIs('admin.dokter.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dokter.index') }}">
            <i class="fas fa-fw fa-user-md"></i>
            <span>Data Dokter</span></a>
    </li>

    <!-- Nav Item - Data Pelanggan -->
    <li class="nav-item {{ request()->routeIs('admin.pelanggan.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.pelanggan.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Data Pelanggan</span></a>
    </li>

    <!-- Nav Item - Data Hewan -->
    <li class="nav-item {{ request()->routeIs('admin.hewan.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.hewan.index') }}">
            <i class="fas fa-fw fa-paw"></i>
            <span>Data Hewan</span></a>
    </li>

    <!-- Nav Item - Jadwal Praktek -->
    <li class="nav-item {{ request()->routeIs('admin.jadwal.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.jadwal.index') }}">
            <i class="fas fa-fw fa-calendar-alt"></i>
            <span>Jadwal Praktek</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Layanan
    </div>

    <!-- Nav Item - Booking -->
    <li class="nav-item {{ request()->routeIs('admin.booking.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.booking.index') }}">
            <i class="fas fa-fw fa-clipboard-list"></i>
            <span>Data Booking</span></a>
    </li>

    <!-- Nav Item - Rekam Medis -->
    <li class="nav-item {{ request()->routeIs('admin.rekam-medis.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.rekam-medis.index') }}">
            <i class="fas fa-fw fa-notes-medical"></i>
            <span>Rekam Medis</span></a>
    </li>

    <!-- Nav Item - Transaksi -->
    <li class="nav-item {{ request()->routeIs('admin.transaksi.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.transaksi.index') }}">
            <i class="fas fa-fw fa-cash-register"></i>
            <span>Transaksi / Kasir</span></a>
    </li>

    <!-- Divider -->
    {{-- <hr class="sidebar-divider"> --}}

    <!-- Heading -->
    {{-- <div class="sidebar-heading">
        Interface
    </div> --}}

    <!-- Nav Item - Pages Collapse Menu -->
    {{-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Components</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Components:</h6>
                <a class="collapse-item" href="{{ asset('sbadmin/buttons.html') }}">Buttons</a>
                <a class="collapse-item" href="{{ asset('sbadmin/cards.html') }}">Cards</a>
            </div>
        </div>
    </li> --}}

    <!-- Nav Item - Utilities Collapse Menu -->
    {{-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Utilities</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Utilities:</h6>
                <a class="collapse-item" href="{{ asset('sbadmin/utilities-color.html') }}">Colors</a>
                <a class="collapse-item" href="{{ asset('sbadmin/utilities-border.') }}">Borders</a>
                <a class="collapse-item" href="{{ asset('sbadmin/utilities-animation.') }}">Animations</a>
                <a class="collapse-item" href="{{ asset('sbadmin/utilities-other.') }}">Other</a>
            </div>
        </div>
    </li> --}}

    <!-- Divider -->
    {{-- <hr class="sidebar-divider"> --}}

    <!-- Heading -->
    {{-- <div class="sidebar-heading">
        Addons
    </div> --}}

    <!-- Nav Item - Pages Collapse Menu -->
    {{-- <li class="nav-item active">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
            aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Pages</span>
        </a>
        <div id="collapsePages" class="collapse show" aria-labelledby="headingPages"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Login Screens:</h6>
                <a class="collapse-item" href="{{ asset('sbadmin/login.html')}}">Login</a>
                <a class="collapse-item" href="{{ asset('sbadmin/register.html')}}">Register</a>
                <a class="collapse-item" href="{{ asset('sbadmin/forgot-password.html')}}">Forgot Password</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Other Pages:</h6>
                <a class="collapse-item" href="{{ asset('sbadmin/404.html')}}">404 Page</a>
                <a class="collapse-item active" href="{{ asset('sbadmin/blank.html')}}">Blank Page</a>
            </div>
        </div>
    </li> --}}

    <!-- Nav Item - Charts -->
    {{-- <li class="nav-item">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Charts</span></a>
    </li> --}}

    <!-- Nav Item - Tables -->
    {{-- <li class="nav-item">
        <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span></a>
    </li> --}}

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
