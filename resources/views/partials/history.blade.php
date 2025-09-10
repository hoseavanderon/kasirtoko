
  <style>
    body {
      background: #f5f7fb;
      font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      color: #222;
    }

    .card-dashboard {
      border-radius: 14px;
      box-shadow: 0 8px 24px rgba(15,23,42,0.06);
      padding: 28px;
      background: #fff;
    }

    /* Top stat boxes */
    .stat-box {
      border-radius: 10px;
      background: #fff;
      padding: 18px 20px;
      box-shadow: 0 6px 18px rgba(15,23,42,0.03);
    }
    .stat-value {
      font-weight: 800;
      font-size: 2.1rem;
      line-height: 1;
    }

    /* List items */
    .history-item {
      padding: 14px 0;
      border-bottom: 1px solid rgba(0,0,0,0.06);
    }
    .history-item:last-child { border-bottom: none; }

    .history-title {
      font-weight: 700;
      font-size: 1.05rem;
      margin-bottom: 6px;
    }
    .history-meta {
      color: #6b7280; /* grey */
      font-size: 0.9rem;
    }

    /* price badges on right */
    .price {
      font-weight: 700;
      font-size: 1rem;
    }

    /* responsive spacing on small screens */
    @media (max-width: 576px) {
      .stat-value { font-size: 1.6rem; }
      .card-dashboard { padding: 18px; }
    }
  </style>
</head>
<body>

<div class="container py-4">
  <div class="row g-4">
    <div class="col-12 col-lg-6">
      <div class="row g-3 mb-3">
        <div class="col-6">
          <div class="stat-box">
            <div class="text-muted">Total Penjualan</div>
            <div class="stat-value text-success">
              Rp {{ number_format($totalPenjualan, 0, ',', '.') }}
            </div>
          </div>
        </div>
        <div class="col-6">
          <div class="stat-box">
            <div class="text-muted">Total Transaksi</div>
            <div class="stat-value text-primary">
              {{ $transactions->count() }}
            </div>
          </div>
        </div>
      </div>

      <div class="card-dashboard">
        <h5 class="mb-3">Riwayat Transaksi</h5>
        @forelse($transactions as $trx)
          @foreach($trx->detailTransactions as $detail)
            <div class="history-item d-flex justify-content-between align-items-center">
              <div>
                <div class="history-title">{{ $detail->product->nama_produk }}</div>
                <div class="history-meta">{{ $detail->qty }}x</div>
              </div>
              <div class="d-flex flex-column align-items-end">
                <div class="text-success price">
                  Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}
                </div>
                <small class="text-muted">{{ $trx->created_at->format('H:i') }}</small>
              </div>
            </div>
          @endforeach
        @empty
          <div class="text-center text-muted p-4">
            <i class="bi bi-receipt fs-1 d-block mb-2"></i>
            Belum ada transaksi hari ini
          </div>
        @endforelse
      </div>
    </div>

    <div class="col-12 col-lg-6">
      <div class="row g-3 mb-3">
        <div class="col-6">
          <div class="stat-box">
            <div class="text-muted">Total Penjualan Digital</div>
            <div class="stat-value text-success">Rp 155.000</div>
          </div>
        </div>
        <div class="col-6">
          <div class="stat-box">
            <div class="text-muted">Total Transaksi Digital</div>
            <div class="stat-value text-primary">3</div>
          </div>
        </div>
      </div>

      <div class="card-dashboard">
        <h5 class="mb-3">Riwayat</h5>
        <div class="history-item d-flex justify-content-between align-items-start">
          <div>
            <div class="history-title">Pulsa Telkomsel 50K</div>
            <div class="history-meta">1 pcs · 10/09 14:35</div>
          </div>
          <div class="text-primary price">Rp 55.000</div>
        </div>
        <div class="history-item d-flex justify-content-between align-items-start">
          <div>
            <div class="history-title">Paket Data 10GB</div>
            <div class="history-meta">1 pcs · 10/09 15:10</div>
          </div>
          <div class="text-primary price">Rp 100.000</div>
        </div>
      </div>
    </div>
  </div>
</div>
