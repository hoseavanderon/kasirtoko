
    <div class="col-lg-2 col-md-2">
        <div class="sidebar p-3">
            <h6 class="text-muted mb-3 fw-bold">Kategori Barang</h6>
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
                                <i class="bi bi-box-seam"></i> {{-- kamu bisa ganti dengan gambar produk --}}
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

                <!-- Payment Input + Quick Denominations + Custom Keypad -->
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

                <div class="d-grid gap-2">
                    <button class="btn btn-primary btn-lg" id="process-payment-btn" disabled>
                        <i class="bi bi-credit-card me-2"></i>
                        Bayar
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
                            <span>Kembalian :</span>
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

@push('scripts')
<script>
function initPageScripts() {
    // ====================== STATE ======================
    let cartItems   = {};
    let paidAmount  = 0;

    // ====================== ELEMENTS ======================
    const paidDisplay   = document.getElementById('paid-display');
    const changeDisplay = document.getElementById('change');
    const totalDisplay  = document.getElementById('total');
    const processBtn    = document.getElementById('process-payment-btn');

    // ====================== UTILS (FORMAT & PARSE) ======================
    const formatNumberID = (n) => (n ?? 0).toLocaleString('id-ID');              // 12.345
    const formatRupiah   = (n) => `Rp ${formatNumberID(n)}`;                      // Rp 12.345
    const parseRupiah    = (s) => parseInt((s || '').toString().replace(/[^0-9]/g, ''), 10) || 0;

    function getCartTotal() {
        let total = 0;
        Object.values(cartItems).forEach(item => {
            total += item.harga * item.quantity;
        });
        return total;
    }

    const exactBtn = document.getElementById('exact-btn');
    if (exactBtn) {
        exactBtn.addEventListener('click', () => {
            paidAmount = getCartTotal(); // isi state paidAmount
            updateDisplays();            // refresh tampilan
        });
    }

    // ====================== CATEGORY FILTER ======================
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

    // ====================== BARCODE SCAN ======================
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
            body: JSON.stringify({ barcode }),
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

    // ====================== CLEAR CART ======================
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
                showAlert('Keranjang dikosongkan!', 'success');
            }
        });
    });

    // ====================== CLICK PRODUCT CARD (DELEGATION) ======================
    document.getElementById('products-grid').addEventListener('click', function(e) {
        const card = e.target.closest('.product-card');
        if (!card) return;

        const productId = card.dataset.productId;

        fetch(`/products/get/${productId}`)
            .then(response => response.json())
            .then(product => {
                if (product.error) {
                    showAlert(product.error, 'danger');
                } else {
                    addToCart(product);
                    showAlert('Produk berhasil ditambahkan ke keranjang', 'success');
                }
            })
            .catch(err => {
                console.error(err);
                showAlert('Gagal menambahkan produk.', 'danger');
            });
    });

    // ====================== PAYMENT (DENOM + KEYPAD) ======================
    function getTotalAmount() {
        return parseRupiah(totalDisplay.textContent);
    }

    function updateDisplays() {
        paidDisplay.textContent = formatRupiah(paidAmount);

        const totalAmount = getTotalAmount();
        const change = paidAmount - totalAmount;

        changeDisplay.textContent = formatRupiah(Math.max(change, 0));

        // enable/disable Process Payment
        processBtn.disabled = (totalAmount === 0) || (paidAmount < totalAmount);
    }

    // Quick denominations (PASTIKAN tidak ada handler lama addDenomination)
    document.querySelectorAll('.denomination-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            paidAmount += parseInt(btn.dataset.amount, 10) || 0;
            updateDisplays();
        });
    });

    // Numpad custom
    document.querySelectorAll('.keypad-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const val = btn.textContent.trim();
            if (btn.id === "backspace") {
                paidAmount = Math.floor(paidAmount / 10);
            } else {
                paidAmount = parseInt(`${paidAmount}${val}`, 10) || 0;
            }
            updateDisplays();
        });
    });

    // ====================== ALERT HELPER ======================
    function showAlert(message, type = 'success') {
        let icon = 'success';

        if (type === 'danger') icon = 'error';
        else if (type === 'warning') icon = 'warning';
        else if (type === 'info') icon = 'info';

        Swal.fire({
            text: message,
            icon: icon,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });
    }

    // ====================== CART ======================
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

        // Reset container
        cartContainer.innerHTML = `
            <div class="text-center py-4 text-muted" id="empty-cart">
                <i class="bi bi-cart-x fs-1"></i>
                <p class="mt-2">Keranjang Kosong</p>
            </div>
        `;

        const items = Object.values(cartItems);
        if (items.length === 0) return;

        // Hapus "Keranjang Kosong"
        const emptyCart = document.getElementById('empty-cart');
        if (emptyCart) emptyCart.remove();

        // Render items
        items.forEach(item => {
            const itemEl = document.createElement('div');
            itemEl.className = 'cart-item mb-2';
            itemEl.innerHTML = `
                <div class="d-flex justify-content-between align-items-center py-1">
                    <!-- KIRI -->
                    <div class="flex-grow-1 text-start">
                        <span class="fw-semibold d-block">${item.nama_produk}</span>
                        <small class="text-muted">x${item.quantity}</small>
                    </div>

                    <!-- KANAN -->
                    <div class="text-end">
                        <span class="fw-bold d-block">${formatRupiah(item.harga * item.quantity)}</span>
                        <button class="btn btn-sm btn-link text-danger p-0 remove-item-btn" data-id="${item.id}" title="Hapus item">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </div>
                </div>
            `;
            cartContainer.appendChild(itemEl);
        });

        // Remove item handlers
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
                        showAlert('Produk dihapus!', 'success');
                    }
                });
            });
        });
    }

    function updateCartTotals() {
        let total = 0;
        Object.values(cartItems).forEach(item => {
            total += (item.harga * item.quantity);
        });

        document.getElementById('subtotal').innerText = formatRupiah(total);
        document.getElementById('total').innerText    = formatRupiah(total);

        // Setelah total berubah, update kembalian & tombol payment
        updateDisplays();
    }

    // ====================== INIT ======================
    updateDisplays();
}

document.addEventListener('DOMContentLoaded', initPageScripts);
</script>
@endpush