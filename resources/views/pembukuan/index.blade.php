@extends('layouts.pembukuan')
@section('content')    
    <div class="container">
        <div class="page-title">
            <h1>Riwayat Pembukuan</h1>

            <div class="page-actions">
                <a href="{{ route('home') }}" class="btn-icon" title="Home">
                    <i class="fas fa-home"></i>
                </a>

                <button class="btn-icon" title="Fullscreen" onclick="toggleFullscreen(this)">
                    <i class="fas fa-expand"></i>
                </button>
            </div>
        </div>

        <div class="balance-section">
            <div class="balance-card">
                <div class="balance-header">
                    <h3>Sisa Saldo</h3>
                    <div class="menu-dots" id="menuDots">⋯</div>
                    <div class="dropdown-menu" id="dropdownMenu">
                        <button id="showFormBtn">➕ Tambah Pembukuan</button>
                    </div>
                </div>
                <div class="balance-amount">
                    Rp {{ number_format($saldo, 0, ',', '.') }}
                </div>
                <div class="account-info">
                    Terakhir Di Update : {{ $lastUpdated ? \Carbon\Carbon::parse($lastUpdated)->format('d M Y H:i') : '-' }}
                </div>
            </div>

            <div class="form-card" id="formCard" style="display:none;">
                <div class="form-header">
                    <h3>Tambah Pembukuan</h3>
                    <button class="close-form" id="closeFormBtn">−</button>
                </div>
                <form id="pembukuanForm" data-url="{{ route('pembukuan.store') }}">
                    @csrf

                    <!-- Deskripsi -->
                    <div class="form-group">
                        <h5 class="mb-2">Deskripsi</h5>
                        <input type="text" id="deskripsi" name="deskripsi" required>
                    </div>

                    <!-- Nominal -->
                    <div class="form-group">
                        <h5 class="mb-2">Nominal</h5>
                        <input type="number" id="nominal" name="nominal" required>
                    </div>

                    <!-- Category Pembukuan -->
                    <div class="form-group">
                        <h5 class="mb-2">Kategori</h5>
                        <select id="category_pembukuan_id" name="category_pembukuan_id" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categoryPembukuans as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->category_pembukuan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Type (masuk / keluar) -->
                    <div class="form-group">
                        <h5 class="mb-2">Keluar / Masuk</h5>
                        <select id="type" name="type" required>
                            <option value="IN">Masuk</option>
                            <option value="OUT">Keluar</option>
                        </select>
                    </div>

                    <button type="submit" class="submit-btn">Simpan</button>
                </form>
            </div>
        </div>

        <!-- Transaction Card -->
        <div class="transaction-card">
            <!-- Header with Search -->
            <div class="transaction-header">
                <h3>Transaction History</h3>
                <button class="search-btn" id="searchBtn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                </button>
            </div>

            <!-- Search Input (Hidden by default) -->
            <div class="search-container" id="searchContainer">
                <input type="text" id="searchInput" placeholder="Search by description or amount...">
            </div>

            <!-- Month Selection -->
            <div class="month-selection">
                <div class="month-header">
                    <span>Select Month</span>
                    <button class="expand-btn" id="expandBtn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6,9 12,15 18,9"></polyline>
                        </svg>
                    </button>
                </div>

                <!-- Horizontal Month Slider -->
                <div class="month-slider" id="monthSlider">
                    <div class="month-slider-track">
                        <button class="month-btn active" data-month="0" data-year="0">Latest</button>
                        @foreach($monthsByYear as $year => $months)
                            @foreach($months as $month)
                                <button class="month-btn" data-month="{{ $month }}" data-year="{{ $year }}">
                                    {{ \Carbon\Carbon::create()->month($month)->translatedFormat('M') }}
                                </button>
                            @endforeach
                        @endforeach
                    </div>
                </div>

                <div class="expanded-selector" id="expandedSelector">
                    @forelse($monthsByYear as $year => $months)
                        <div class="year-section">
                            <h4>{{ $year }}</h4>
                            <div class="month-grid">
                                @foreach($months as $month)
                                    <button class="grid-month-btn" data-year="{{ $year }}" data-month="{{ $month }}">
                                        {{ \Carbon\Carbon::create()->month($month)->format('M') }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="no-data">
                            <p>Tidak ada data pembukuan.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Transaction List -->
            <div class="transaction-list">
                <div class="transaction-list-header">
                    <h4 id="currentMonthTitle">Latest</h4>
                    <span class="transaction-count" id="transactionCount">8 transactions</span>
                </div>
                <div class="transactions" id="transactionsList">
                    <!-- Transactions will be populated by JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <script>
        window.transactions = @json($riwayat);
    </script>
@endsection

