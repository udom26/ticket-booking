<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Ticket Booking')</title>

    <!-- CSS ของ AdminLTE, FontAwesome, Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" />

    <!-- Custom Style -->
    <style>
        .navbar .form-control {
            border-color: #ced4da !important;
            box-shadow: none;
        }

        .navbar .form-control:focus {
            border-color: #6c757d !important;
            box-shadow: none;
        }

        .navbar .btn-outline-primary {
            border-color: #ced4da !important;
            color: #6c757d !important;
        }

        .navbar .btn-outline-primary:hover {
            background-color: #e9ecef !important;
        }

        .navbar .btn-outline-primary i {
            color: #6c757d !important;
        }

        footer {
            text-align: center;
            padding: 15px;
            background-color: #f8f9fa;
            font-size: 14px;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <div class="container-fluid d-flex align-items-center justify-content-between">

            <!-- Site Name -->
            <span class="navbar-brand font-weight-bold"></span>

            <!-- Search -->
            <div class="flex-grow-1 d-flex justify-content-center">
                <form class="form-inline" action="/search" method="GET" style="max-width: 400px; width: 100%;">
                    <div class="input-group w-100">
                        <input
                            class="form-control"
                            type="search"
                            name="q"
                            placeholder="ค้นหา..."
                            aria-label="Search"
                            required
                        />
                        <div class="input-group-append">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Manage Account (Jetstream) -->
            <!-- ปุ่มล็อกอิน/สมัครสมาชิก ด้านขวา -->
<div class="ml-2 d-flex align-items-center">
    @if (Route::has('login'))
        @auth
            <a href="{{ url('/dashboard') }}" class="btn btn-sm p-0 mr-2" title="{{ Auth::user()->name }}">
                <img
                    src="{{ Auth::user()->profile_photo_url ?? asset('default-avatar.png') }}"
                    alt="Profile"
                    class="rounded-circle"
                    style="width: 32px; height: 32px; object-fit: cover;"
                >
            </a>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">ออกจากระบบ</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn btn-warning btn-sm mr-2">เข้าสู่ระบบ</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-sm">สมัครสมาชิก</a>
            @endif
        @endauth
    @endif
</div>

        </div>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="{{ url('/') }}" class="brand-link">
            <span class="brand-text font-weight-light ml-3">Ticket Booking</span>
        </a>

        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <li class="nav-item">
                        <a href="{{ url('/') }}" class="nav-link {{ Request::is('/') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-home"></i>
                            <p>หน้าหลัก</p>
                        </a>
                    </li>
                  
                  <li class="nav-item">
    <a href="{{ url('/about') }}" class="nav-link {{ Request::is('about*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-info-circle"></i>
        <p>เกี่ยวกับเรา</p>
    </a>
</li>

@auth
    <li class="nav-item">
        <a href="{{ url('/booking-history') }}" class="nav-link {{ Request::is('booking-history*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-history"></i>
            <p>ประวัติการจอง</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ url('/profile') }}" class="nav-link {{ Request::is('profile*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user-edit"></i>
            <p>แก้ไขโปรไฟล์</p>
        </a>
    </li>
@endauth


                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="content-wrapper">
        <div class="content pt-4 px-3">
            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    <footer>
        © 2025 Ticket Booking System
    </footer>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
