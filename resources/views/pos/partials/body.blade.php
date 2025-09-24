<div class="tab-content">
    <div class="tab-pane fade show active" id="barang-pane" role="tabpanel">
        <div class="row">
        <div class="col-lg-2">
            <div class="sidebar p-3">
                <h6 class="text-muted mb-3 fw-bold">Kategori Barang</h6>
                <div class="d-grid gap-2" id="categories-list">
                    @foreach ($categories as $category)
                        <div class="mb-2">
                            <button type="button"
                                class="category-item w-100 text-start fw-bold"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapse-{{ $category->id }}"
                                aria-expanded="false"
                                aria-controls="collapse-{{ $category->id }}">
                                <i class="bi bi-folder me-2"></i>
                                {{ $category->nama }}
                            </button>
        
                            <div class="collapse ms-2 mt-1" id="collapse-{{ $category->id }}">
                                @foreach ($category->subcategories as $sub)
                                    <button type="button"
                                        class="category-item w-100 text-start subcategory-btn"
                                        data-id="{{ $sub->id }}"
                                        data-type="subcategory" style="font-size:12px;">
                                        <i class="bi bi-chevron-right me-2"></i>
                                        {{ $sub->nama }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-5">
            <div class="p-4">
                <div class="mb-4">
                    <form id="barcode-form">
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white">
                                <i class="bi bi-upc-scan"></i>
                            </span>
                            <input
                                type="text"
                                class="form-control scanner-input"
                                id="barcode-input"
                                placeholder="Scan barcode..."
                                autocomplete="off"
                                inputmode="none"
                                autofocus
                            />
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0 fw-bold" id="category-title">All Categories</h5>
                </div>

                <div class="row g-3" id="products-grid">
                    @forelse ($products as $product)
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="product-card fade-in" data-product-id="{{ $product->id }}">
                                <div class="product-image">
                                    <i class="bi bi-box-seam"></i>
                                </div>
                                <div class="card-body p-3">
                                    <h6 class="card-title mb-2 fw-semibold text-truncate">{{ $product->nama_produk }}</h6>
                                    <p class="card-text text-primary fw-bold mb-0">
                                        Rp {{ number_format($product->jual, 0, ',', '.') }}
                                    </p>
                                    <p class="text-muted small pt-1 mb-0">
                                        {{ $product->barcode }}
                                    </p>
                                    <div class="mt-2">
                                        {!! DNS1D::getBarcodeHTML($product->barcode, 'C128', 1.5, 40) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p class="text-muted">Tidak ada produk ditemukan.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <div class="col-lg-4 col-md-5">
            <div class="cart-sidebar p-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0">Keranjang Belanja</h6>
                    <button class="btn btn-outline-danger btn-sm" id="clear-cart-btn">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>

                <div class="cart-items" style="max-height: 300px; overflow-y: auto;" id="cart-items">
                    <div class="text-center py-4 text-muted" id="empty-cart">
                        <i class="bi bi-cart-x fs-1"></i>
                        <p class="mt-2">Keranjang Kosong</p>
                    </div>
                </div>

                <div class="total-section">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span class="fw-bold" id="subtotal">Rp 0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="fw-bold">Total:</span>
                        <span class="fw-bold text-primary fs-5" id="total">Rp 0</span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Total Bayar</label>
                        <div class="text-center border rounded p-2 mb-2 bg-light fs-4 fw-bold" id="paid-display">Rp 0</div>

                        <!-- Quick Denominations -->
                        <div class="row g-2">
                            <div class="col-6">
                                <button class="btn btn-outline-primary w-100 denomination-btn" data-amount="1000">Rp 1.000</button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-outline-primary w-100 denomination-btn" data-amount="2000">Rp 2.000</button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-outline-primary w-100 denomination-btn" data-amount="5000">Rp 5.000</button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-outline-primary w-100 denomination-btn" data-amount="10000">Rp 10.000</button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-outline-primary w-100 denomination-btn" data-amount="20000">Rp 20.000</button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-outline-primary w-100 denomination-btn" data-amount="50000">Rp 50.000</button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-outline-primary w-100 denomination-btn" data-amount="100000">Rp 100.000</button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-success w-100" id="exact-btn">UANG PAS</button>
                            </div>
                        </div>

                        <!-- Custom Keypad -->
                        <div class="keypad text-center pt-3">
                            <div class="d-grid gap-2" style="grid-template-columns: repeat(3, 1fr); display: grid;">
                                <button class="btn btn-outline-dark keypad-btn">1</button>
                                <button class="btn btn-outline-dark keypad-btn">2</button>
                                <button class="btn btn-outline-dark keypad-btn">3</button>
                                <button class="btn btn-outline-dark keypad-btn">4</button>
                                <button class="btn btn-outline-dark keypad-btn">5</button>
                                <button class="btn btn-outline-dark keypad-btn">6</button>
                                <button class="btn btn-outline-dark keypad-btn">7</button>
                                <button class="btn btn-outline-dark keypad-btn">8</button>
                                <button class="btn btn-outline-dark keypad-btn">9</button>
                                <button class="btn btn-outline-dark keypad-btn">00</button>
                                <button class="btn btn-outline-dark keypad-btn">0</button>
                                <button class="btn btn-outline-danger keypad-btn" id="backspace">⌫</button>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold">Kembalian:</span>
                            <span class="fw-bold" id="change">Rp 0</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <!-- Kiri: Checkbox Lunas -->
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="is_lunas" checked>
                            <label class="form-check-label fw-bold" for="is_lunas">Lunas</label>
                        </div>

                        <!-- Kanan: Customer -->
                        <div class="d-flex flex-column" style="min-width:150px;">
                            <label class="fw-bold mb-1">Customer:</label>
                            <span id="selected-customer-name" class="form-control bg-light">
                                Belum dipilih
                            </span>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-primary btn-lg" id="process-payment-btn" disabled>
                            <i class="bi bi-credit-card me-2"></i>
                            Bayar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="tab-pane fade" id="digital-pane" role="tabpanel">
        <h5>Produk Digital</h5>
        <p>Konten untuk tab Digital...</p>
    </div>
</div>

<script src="{{ asset('js/pos/detailpos.js') }}"></script>

