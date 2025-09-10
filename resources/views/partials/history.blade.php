
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

    .today-date {
        font-size: 1.5rem;   /* lebih besar */
        font-weight: 700;    /* bold */
        color: #111827;      /* gelap */
    }

    @media (max-width: 576px) {
        .today-date {
            font-size: 1.2rem; /* lebih kecil di hp */
        }
    }
  </style>
</head>
<body>

<div class="container py-4">
    <div class="mb-4">
        <span class="today-date pl-3">
            {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
        </span>
    </div>
  <div class="row g-4">
    <div class="col-12 col-lg-6">
        <div class="row g-3 mb-3">
            <div class="col-6">
                <div class="stat-box">
                    <div class="text-muted">Total Penjualan</div>
                    <div class="stat-value text-success">
                        Rp {{ number_format($transactions->sum('subtotal'), 0, ',', '.') }}
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="stat-box">
                    <div class="text-muted">Total Transaksi</div>
                    <div class="stat-value text-primary">
                        {{ $transactions->flatMap->detailTransactions->count() }}
                    </div>
                </div>
            </div>
        </div>

        <div class="card-dashboard">
            <h5 class="mb-3">Riwayat Transaksi</h5>
            <div id="history-list" class="history-scroll">
                @foreach($transactions as $trx)
                    @foreach($trx->detailTransactions as $detail)
                        <div class="history-item d-flex justify-content-between align-items-center">
                            <div>
                                <div class="history-title">{{ $detail->product->nama_produk }}</div>
                                <div class="history-meta">{{ $detail->qty }} x</div>
                            </div>
                            <div class="d-flex flex-column align-items-end">
                                <div class="text-success price">
                                    Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                </div>
                                <small class="text-muted">{{ $trx->created_at->format('H:i') }}</small>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>

            @if($transactions->flatMap->detailTransactions->count() > 5)
                <div class="text-center mt-2">
                    <button id="load-more-btn" class="btn btn-outline-primary btn-sm">Load more</button>
                </div>
            @endif
        </div>
    </div>

    <div class="col-12 col-lg-6">
      <div class="row g-3 mb-3">
        <div class="col-6">
          <div class="stat-box">
            <div class="text-muted">Total Penjualan</div>
            <div class="stat-value text-success">Rp 155.000</div>
          </div>
        </div>
        <div class="col-6">
          <div class="stat-box">
            <div class="text-muted">Total Transaksi</div>
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

<script>
   let visible = 10; // default tampil 5 item
    const items = document.querySelectorAll('#history-list .history-item');
    const btn = document.getElementById('load-more-btn');

    function updateList() {
        items.forEach((item, i) => {
            item.style.display = i < visible ? 'flex' : 'none';
        });

        let remaining = items.length - visible;
        if (remaining > 0) {
            btn.style.display = 'inline-block';
            btn.textContent = `Load ${remaining} more`; // sesuai sisa
        } else {
            btn.style.display = 'none';
        }
    }

    btn.addEventListener('click', () => {
        visible += 5; // tiap klik tambah 5
        updateList();
    });

    // Inisialisasi pertama kali
    updateList();
</script>