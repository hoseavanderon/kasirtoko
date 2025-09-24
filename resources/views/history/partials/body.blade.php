
<link rel="stylesheet" href="{{ asset('css/history/history.css') }}?v={{ filemtime(public_path('css/history/history.css')) }}">

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
                        <div class="history-item d-flex justify-content-between flex-wrap align-items-center">
                          <div>
                            <div class="history-title">{{ $detail->product->nama_produk }}</div>
                            <div class="history-meta">{{ $detail->qty }} x</div>
                          </div>

                          <div class="d-flex flex-column align-items-end">
                            <div class="text-success price">
                              Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </div>
                            <small class="text-muted">{{ $trx->created_at->format('H:i') }}</small>

                            <div class="dropdown mt-1">
                              <button class="btn btn-link text-muted p-0" type="button"
                                      id="dropdownMenuButton{{ $detail->id }}"
                                      data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                              </button>
                              <ul class="dropdown-menu dropdown-menu-end"
                                  aria-labelledby="dropdownMenuButton{{ $detail->id }}">
                                <li>
                                  <a href="#" 
                                    class="dropdown-item text-danger btn-delete-detail" 
                                    data-id="{{ $detail->id }}"
                                    data-product="{{ $detail->product->nama_produk }}">
                                    Delete
                                  </a>
                                </li>
                              </ul>
                            </div>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/history/history.js') }}"></script>