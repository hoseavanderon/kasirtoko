
    <div class="col-lg-2 col-md-3">
        <div class="sidebar p-3">
            <h6 class="text-muted mb-3 fw-bold">PRODUCT CATEGORIES</h6>
            <div class="d-grid gap-1" id="categories-list">
                <div class="d-grid gap-1" id="categories-list">
                    <button class="category-item">
                        <i class="bi bi-heart me-2"></i> 
                        Nama Kategori
                    </button>

                    <button class="category-item">
                        <i class="bi bi-heart me-2"></i> 
                        Nama Kategori
                    </button>

                    <button class="category-item">
                        <i class="bi bi-heart me-2"></i> 
                        Nama Kategori
                    </button>

                    <button class="category-item">
                        <i class="bi bi-heart me-2"></i> 
                        Nama Kategori
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-7 col-md-6">
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
                            placeholder="Scan barcode or enter product code..."
                            autocomplete="off"
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
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product-card fade-in" data-product-id="">
                        <div class="product-image">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <div class="card-body p-3">
                            <h6 class="card-title mb-2 fw-semibold">Nama Produk</h6>
                            <p class="card-text text-primary fw-bold mb-0">
                                Rp 10.000
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product-card fade-in" data-product-id="">
                        <div class="product-image">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <div class="card-body p-3">
                            <h6 class="card-title mb-2 fw-semibold">Nama Produk</h6>
                            <p class="card-text text-primary fw-bold mb-0">
                                Rp 10.000
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product-card fade-in" data-product-id="">
                        <div class="product-image">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <div class="card-body p-3">
                            <h6 class="card-title mb-2 fw-semibold">Nama Produk</h6>
                            <p class="card-text text-primary fw-bold mb-0">
                                Rp 10.000
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-3">
        <div class="cart-sidebar p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">SHOPPING CART</h6>
                <button class="btn btn-outline-danger btn-sm" id="clear-cart-btn">
                    <i class="bi bi-trash"></i>
                </button>
            </div>

            <div class="cart-items" style="max-height: 300px; overflow-y: auto;" id="cart-items">
                <div class="text-center py-4 text-muted" id="empty-cart">
                    <i class="bi bi-cart-x fs-1"></i>
                    <p class="mt-2">Cart is empty</p>
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
                    <label class="form-label fw-bold">Payment Amount</label>
                    <input
                        type="number"
                        class="form-control"
                        id="paid-amount"
                        placeholder="Enter amount..."
                    />
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Quick Denominations</label>
                    <div class="d-flex flex-wrap" id="denominations">
                        <button class="btn btn-outline-primary btn-sm denomination-btn" onclick="addDenomination(100000)">Rp100.000</button>
                        <button class="btn btn-outline-primary btn-sm denomination-btn" onclick="addDenomination(50000)">Rp50.000</button>
                        <button class="btn btn-outline-primary btn-sm denomination-btn" onclick="addDenomination(20000)">Rp20.000</button>
                        <button class="btn btn-outline-primary btn-sm denomination-btn" onclick="addDenomination(10000)">Rp10.000</button>
                        <button class="btn btn-outline-primary btn-sm denomination-btn" onclick="addDenomination(5000)">Rp5.000</button>
                        <button class="btn btn-outline-primary btn-sm denomination-btn" onclick="addDenomination(2000)">Rp2.000</button>
                        <button class="btn btn-outline-primary btn-sm denomination-btn" onclick="addDenomination(1000)">Rp1.000</button>
                    </div>
                    <button class="btn btn-warning btn-sm denomination-btn mt-2" id="exact-btn">
                        Exact
                    </button>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold">Change:</span>
                        <span class="fw-bold" id="change">Rp 0</span>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button class="btn btn-primary btn-lg" id="process-payment-btn" disabled>
                        <i class="bi bi-credit-card me-2"></i>
                        Process Payment
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="successModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-check-circle me-2"></i>
                        Payment Successful!
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <div class="mb-4">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                    </div>
                    <h6 class="mb-3">Transaction has been processed successfully.</h6>
                    <div class="bg-light p-3 rounded mb-3" id="transaction-details">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Amount:</span>
                            <span class="fw-bold" id="summary-total">Rp0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Paid:</span>
                            <span class="fw-bold" id="summary-paid">Rp0</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Change:</span>
                            <span class="fw-bold" id="summary-change">Rp0</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">
                        <i class="bi bi-printer me-2"></i>
                        Print Receipt
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                        Continue
                    </button>
                </div>
            </div>
        </div>
    </div>

   