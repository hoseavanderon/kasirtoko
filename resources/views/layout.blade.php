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
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">
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
                                <button class="navbar-btn active" title="Home" data-page="home">
                                    <i class="bi bi-house-door"></i>
                                </button>

                                <button class="navbar-btn" title="Transaction History" data-page="history">
                                    <i class="bi bi-clock-history"></i>
                                </button>

                                <button class="navbar-btn" title="History" data-page="historys">
                                    <i class="bi bi-clock-history"></i>
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

    <div class="pos-container">
        <div class="container-fluid p-0"> 
            <div class="row g-0" id="dynamic-page-container">
                @yield('content')
            </div>
        </div>
    </div>

    @yield('modals')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        document.querySelectorAll('.navbar-btn[data-page]').forEach(btn => {
            btn.addEventListener('click', async () => {
                const page = btn.getAttribute('data-page');

                try {
                    const response = await fetch(`/partial/${page}`);
                    if (!response.ok) throw new Error('Page not found');

                    const content = await response.text();
                    document.getElementById('dynamic-page-container').innerHTML = content;

                    // 🧠 Tambahkan baris ini
                    if (typeof initPageScripts === 'function') {
                        initPageScripts(); 
                    }

                    // ✅ Hapus 'active' dari semua tombol
                    document.querySelectorAll('.navbar-btn[data-page]').forEach(b => b.classList.remove('active'));

                    // ✅ Tambahkan 'active' ke tombol yang diklik
                    btn.classList.add('active');

                } catch (err) {
                    console.error(err);
                    document.getElementById('dynamic-page-container').innerHTML = `<div class="alert alert-danger">Failed to load content</div>`;
                }
            });
        });
    </script>
    @stack('scripts')

    
</body>
</html>