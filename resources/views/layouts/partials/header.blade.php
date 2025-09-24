<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Professional POS System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/pos/pos.css') }}?v={{ filemtime(public_path('css/pos/pos.css')) }}">
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-shop me-3 fs-3"></i>
                        <div>
                            <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                            <small class="opacity-75">
                                <span class="status-dot bg-success me-1"></span>
                                Online
                            </small>
                        </div>
                        @yield('header-tab')
                    </div>
                </div>
                <div class="col-md-6 text-center position-relative">
                    <div class="d-flex align-items-center justify-content-center gap-2">

                        <div class="d-flex align-items-center justify-content-center gap-3">
                            <!-- Fullscreen tombol -->
                            <div>
                                <button class="fullscreen-btn" id="fullscreen-btn" title="Toggle Fullscreen">
                                    <i class="bi bi-arrows-fullscreen"></i>
                                </button>
                            </div>

                            <!-- Navbar navigasi -->
                            <div class="d-flex align-items-center gap-2">
                                <button class="navbar-btn {{ request()->routeIs('home') ? 'active' : '' }}" 
                                        title="Home" 
                                        onclick="window.location='{{ route('home') }}'"> 
                                        <i class="bi bi-house-door"></i> 
                                </button> 
                                
                                <button class="navbar-btn {{ request()->routeIs('history') ? 'active' : '' }}" 
                                        title="Transaction History" 
                                        onclick="window.location='{{ route('history') }}'"> 
                                        <i class="bi bi-clock-history"></i> 
                                </button>
                                
                                <button class="navbar-btn" title="Customer" data-page="customer">
                                    <i class="bi bi-person"></i>
                                </button>

                                <button class="navbar-btn" title="Inventory History" data-page="inventory-history">
                                    <i class="bi bi-box-seam"></i>
                                </button>

                                <button class="navbar-btn" title="Barang Masuk" data-page="barang-masuk">
                                    <i class="bi bi-box-arrow-in-down"></i>
                                </button>

                                <button class="navbar-btn {{ request()->routeIs('pembukuan.index') ? 'active' : '' }}" 
                                        title="Pembukuan" 
                                        onclick="window.location='{{ route('pembukuan.index') }}'">
                                    <i class="bi bi-journal-text"></i>
                                </button>

                                <button class="navbar-btn" title="Rincian Hari Ini">
                                    <i class="bi bi-clipboard-data"></i>
                                </button>
                            <!-- dst -->
                            </div>
                        </div>

                    </div>
                </div>
                <button 
                    id="refresh-btn"
                    title="Refresh Page"
                    class="position-absolute d-flex align-items-center justify-content-center"
                    style="
                        top: 5px;
                        right: 5px;
                        z-index: 999;
                        width: 36px;
                        height: 36px;
                        border-radius: 50%;
                        border: none;
                        background-color: #0d6efd; /* biru terang */
                        color: #fff;
                        box-shadow: 0 2px 6px rgba(0,0,0,0.3);
                        cursor: pointer;
                    "
                >
                    <i class="bi bi-arrow-clockwise fs-5"></i>
                </button>
            </div>
        </div>
    </div>