
    <div class="col-lg-2 col-md-3">
        <div class="sidebar p-3">
            <h6 class="text-muted mb-3 fw-bold">PRODUCT CATEGORIES</h6>
            <div class="d-grid gap-2" id="categories-list">
                @foreach ($categories as $category)
                    <div class="mb-2">
                        <!-- Tombol kategori -->
                        <button type="button"
                            class="category-item w-100 text-start fw-bold"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapse-{{ $category->id }}"
                            aria-expanded="false"
                            aria-controls="collapse-{{ $category->id }}">
                            <i class="bi bi-folder me-2"></i>
                            {{ $category->nama }}
                        </button>

                        <!-- Subkategori yang collapsible -->
                        <div class="collapse ms-3 mt-1" id="collapse-{{ $category->id }}">
                            <!-- Subkategori -->
                            @foreach ($category->subcategories as $sub)
                                <button type="button"
                                    class="category-item w-100 text-start subcategory-btn"
                                    data-id="{{ $sub->id }}"
                                    data-type="subcategory">
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
                @forelse ($products as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="product-card fade-in" data-product-id="{{ $product->id }}">
                            <div class="product-image">
                                <i class="bi bi-box-seam"></i> {{-- kamu bisa ganti dengan gambar produk --}}
                            </div>
                            <div class="card-body p-3">
                                <h6 class="card-title mb-2 fw-semibold">{{ $product->nama_produk }}</h6>
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
                    <label class="form-label fw-bold">Payment Amount</label>
                    <input
                        inputmode="numeric"
                        pattern="[0-9]*"
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    // ====================== HANDLE SUBCATEGORY FILTER ======================
    const subcategoryButtons = document.querySelectorAll('.subcategory-btn');

    function setActive(activeButton) {
        subcategoryButtons.forEach(btn => btn.classList.remove('active'));
        if (activeButton) activeButton.classList.add('active');
    }

    function loadProducts(id) {
        fetch(`/filter-products?type=subcategory&id=${id}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('products-grid').innerHTML = data.html;
                document.getElementById('category-title').textContent = data.title;
            });
    }

    subcategoryButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            setActive(btn);
            loadProducts(id);
        });
    });

    // ====================== HANDLE BARCODE SCAN & ADD TO CART ======================
    document.getElementById('barcode-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const barcode = document.getElementById('barcode-input').value.trim();
        if (!barcode) return;

        fetch("{{ route('products.searchByBarcode') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": '{{ csrf_token() }}',
            },
            body: JSON.stringify({ barcode: barcode }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                showAlert(data.error, 'danger');
            } else {
                addToCart(data);
                showAlert('Produk berhasil ditambahkan ke keranjang', 'success');
                document.getElementById('barcode-input').value = '';
            }
        })
        .catch(err => {
            showAlert('Terjadi kesalahan saat mencari produk.', 'danger');
            console.error(err);
        });
    });

    document.getElementById('clear-cart-btn').addEventListener('click', function () {
        Swal.fire({
            title: 'Hapus Semua Produk di Keranjang?',
            text: "Tindakan ini tidak bisa dibatalkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, kosongkan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                cartItems = {};
                renderCartItems();
                updateCartTotals();

                Swal.fire({
                    title: 'Keranjang dikosongkan!',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    });

    document.getElementById('paid-amount').addEventListener('touchstart', function () {
        this.focus();
    });

    // ====================== HELPER FUNCTIONS ======================
    function showAlert(message, type = 'success') {
        const alertBox = document.createElement('div');
        alertBox.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-4`;
        alertBox.style.zIndex = 9999;
        alertBox.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(alertBox);
        setTimeout(() => alertBox.remove(), 3000);
    }

    let cartItems = {};
    function addToCart(product) {
        if (cartItems[product.id]) {
            cartItems[product.id].quantity += 1;
        } else {
            cartItems[product.id] = {
                ...product,
                quantity: 1
            };
        }

        renderCartItems();
        updateCartTotals();
    }

    function renderCartItems() {
        const cartContainer = document.getElementById('cart-items');
        const emptyCartEl = document.getElementById('empty-cart');

        // Reset isi cart container (hapus semua item dulu)
        cartContainer.innerHTML = `
            <div class="text-center py-4 text-muted" id="empty-cart">
                <i class="bi bi-cart-x fs-1"></i>
                <p class="mt-2">Keranjang Kosong</p>
            </div>
        `;

        const items = Object.values(cartItems);

        // Jika tidak ada item, tampilkan kembali "Keranjang Kosong"
        if (items.length === 0) return;

        // Jika ada item, hapus elemen "empty-cart"
        const emptyCart = document.getElementById('empty-cart');
        if (emptyCart) emptyCart.remove();

        // Tampilkan item-item di keranjang
        items.forEach(item => {
            const itemEl = document.createElement('div');
            itemEl.className = 'cart-item mb-2';
            itemEl.innerHTML = `
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fw-semibold">${item.nama_produk}</div>
                        <small class="text-muted">x${item.quantity}</small>
                    </div>
                    <div class="text-end">
                        <div class="fw-bold">Rp ${formatRupiah(item.harga * item.quantity)}</div>
                        <button class="btn btn-sm btn-link text-danger p-0 remove-item-btn" data-id="${item.id}" title="Hapus item">
                            <i class="bi bi-x-circle-fill fs-5"></i>
                        </button>
                    </div>
                </div>
            `;
            cartContainer.appendChild(itemEl);
        });

        // Tambahkan event ke tombol hapus per item
        document.querySelectorAll('.remove-item-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.dataset.id;

                Swal.fire({
                    title: 'Hapus Produk Ini?',
                    text: "Produk akan dihapus dari keranjang.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        delete cartItems[id];
                        renderCartItems();
                        updateCartTotals();

                        Swal.fire({
                            title: 'Produk dihapus!',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                });
            });
        });
    }

    function updateCartTotals() {
        let total = 0;
        Object.values(cartItems).forEach(item => {
            total += item.harga * item.quantity;
        });

        document.getElementById('subtotal').innerText = formatRupiah(total);
        document.getElementById('total').innerText = formatRupiah(total);

        const paymentBtn = document.getElementById('process-payment-btn');
        paymentBtn.disabled = total === 0;
    }

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(number);
    }
});
</script>