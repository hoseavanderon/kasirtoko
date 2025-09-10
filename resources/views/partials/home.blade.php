<div class="col-lg-2 col-md-2">
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
    
@push('scripts')
<script>
    function initPageScripts() {
        // ====================== STATE ======================
        let cartItems   = {};
        let paidAmount  = 0;

        const routeSaveTransaction = "{{ route('transactions.save') }}";

        // ====================== ELEMENTS ======================
        const paidDisplay   = document.getElementById('paid-display');
        const changeDisplay = document.getElementById('change');
        const totalDisplay  = document.getElementById('total');
        const processBtn    = document.getElementById('process-payment-btn');

        const barcodeInput = document.getElementById('barcode-input');
        const barcodeForm = document.getElementById('barcode-form');

        // Hanya jalankan jika elemen ada
        if (barcodeInput && barcodeForm) {
            barcodeInput.focus();

            // ====================== BARCODE SCAN FORM SUBMIT ======================
            barcodeForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const barcode = barcodeInput.value.trim();
                if (!barcode) return;
                processBarcode(barcode);
                barcodeInput.value = '';
                barcodeInput.focus({ preventScroll: true });
            });

            // ====================== PROCESS BARCODE FUNCTION ======================
            function processBarcode(barcode) {
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
                        showAlert(data.error, 'error');
                    } else {
                        addToCart(data);
                        showAlert('Produk berhasil ditambahkan ke keranjang', 'success');

                        // === Fokus kembali ke input barcode setelah produk masuk ===
                        barcodeInput.value = '';
                        barcodeInput.focus({ preventScroll: true });
                    }
                })
                .catch(err => {
                    showAlert('Terjadi kesalahan saat mencari produk.', 'error');
                    console.error(err);
                });
            }
        }

        // ====================== UTILS (FORMAT & PARSE) ======================
        const formatNumberID = (n) => (n ?? 0).toLocaleString('id-ID');              
        const formatRupiah   = (n) => `Rp ${formatNumberID(n)}`;                      
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
                paidAmount = getCartTotal();
                updateDisplays();
            });
        }

        // Event delegation untuk tombol +/- dan hapus
        let lastManualClick = 0;
        const cartContainer = document.getElementById('cart-items');
        if (cartContainer) {
            cartContainer.addEventListener('click', function(e) {
                if (Date.now() - lastManualClick < 200) return; // mencegah double click
                lastManualClick = Date.now();
                const qtyBtn = e.target.closest('.qty-btn');
                if (qtyBtn && qtyBtn.dataset.id && cartItems[qtyBtn.dataset.id]) {
                    const id = qtyBtn.dataset.id;
                    const action = qtyBtn.dataset.action;
                    if (!cartItems[id]) return;
    
                    if (action === 'increase') {
                        cartItems[id].quantity += 1;
                        renderCartItems();
                        updateCartTotals();
                    } else if (action === 'decrease') {
                        if (cartItems[id].quantity <= 1) {
                            Swal.fire({
                                title: 'Hapus Produk?',
                                text: 'Jumlah akan menjadi 0. Hapus produk dari keranjang?',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#6c757d',
                                confirmButtonText: 'Ya, hapus',
                                cancelButtonText: 'Batal'
                            }).then(result => {
                                if (result.isConfirmed) {
                                    delete cartItems[id];
                                    renderCartItems();
                                    updateCartTotals();
                                    if (Object.keys(cartItems).length === 0) {
                                        paidAmount = 0;
                                        updateDisplays();
                                    }
                                    showAlert('Produk dihapus!', 'success');
                                }
                            });
                        } else {
                            cartItems[id].quantity -= 1;
                            renderCartItems();
                            updateCartTotals();
                        }
                    }
                    return;
                }
    
                const rmBtn = e.target.closest('.remove-item-btn');
                if (rmBtn && rmBtn.dataset.id && cartItems[rmBtn.dataset.id]) {
                    const id = rmBtn.dataset.id;
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
                            if (Object.keys(cartItems).length === 0) {
                                paidAmount = 0;
                                updateDisplays();
                            }
                            showAlert('Produk dihapus!', 'success');
                        }
                    });
                }
            });
        }

        // ====================== BAYAR ======================
        const reviewModalEl   = document.getElementById("reviewModal");
        const reviewModal     = new bootstrap.Modal(reviewModalEl, { backdrop: 'static', keyboard: false });
        const successModal    = new bootstrap.Modal(document.getElementById("successModal"), { backdrop: 'static', keyboard: false });

        const reviewItems     = document.getElementById("review-items");
        const reviewSubtotal  = document.getElementById("review-subtotal");
        const reviewPaid      = document.getElementById("review-paid");
        const reviewChange    = document.getElementById("review-change");

        const successSubtotal = document.getElementById("success-subtotal");
        const successTotal    = document.getElementById("success-total");
        const successChange   = document.getElementById("success-change");

        const processPaymentBtn = document.getElementById("process-payment-btn");
        if (processPaymentBtn) {
            processPaymentBtn.addEventListener("click", () => {
                const items = Object.values(cartItems);
                if (items.length === 0) {
                    Swal.fire({ icon: 'warning', text: 'Keranjang kosong!', timer: 1500, showConfirmButton:false });
                    return;
                }

                let subtotal = 0;
                const reviewItemsEl = document.getElementById("review-items");
                reviewItemsEl.innerHTML = "";

                items.forEach(item => {
                    const sub = item.harga * item.quantity;
                    subtotal += sub;

                    const row = document.createElement("div");
                    row.classList.add("d-flex", "justify-content-between", "align-items-center", "mb-2");

                    row.innerHTML = `
                        <div style="display:flex;flex-direction:column">
                            <span style="font-weight:500">${item.nama_produk || item.name}</span>
                            <span style="font-size:0.85rem;color:#6c757d">${item.quantity}x</span>
                        </div>
                        <span style="font-weight:500">${formatRupiah(sub)}</span>
                    `;
                    reviewItemsEl.appendChild(row);
                });

                let dibayar = paidAmount || subtotal;
                let kembalian = dibayar - subtotal;

                reviewSubtotal.textContent = formatRupiah(subtotal);
                reviewPaid.textContent     = formatRupiah(dibayar);
                reviewChange.textContent   = formatRupiah(kembalian);

                // Simpan sementara di modal
                reviewModalEl._subtotal  = subtotal;
                reviewModalEl._dibayar   = dibayar;
                reviewModalEl._kembalian = kembalian;

                reviewModal.show();
            });
        }

        // Listener confirm di-bungkus di show.bs.modal
        reviewModalEl.addEventListener('show.bs.modal', () => {
            const confirmBtn = document.getElementById("confirm-payment-btn");
            if (!confirmBtn) return;

            // Hapus listener lama
            const newBtn = confirmBtn.cloneNode(true);
            confirmBtn.parentNode.replaceChild(newBtn, confirmBtn);

            newBtn.addEventListener("click", () => {
                const subtotal  = reviewModalEl._subtotal;
                const dibayar   = reviewModalEl._dibayar;
                const kembalian = reviewModalEl._kembalian;
                const items     = Object.values(cartItems);

                fetch(routeSaveTransaction, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        subtotal: subtotal,
                        dibayar: dibayar,
                        kembalian: kembalian,
                        items: items,
                        is_lunas: document.getElementById('is_lunas').checked ? 1 : 0,
                        customer_id: document.getElementById('selected-customer-id')?.value || null,
                    })
                })
                .then(res => res.json())
                .then(data => {
                    reviewModal.hide(); // tutup modal review

                    if (data.success) {
                        // Reset cart & total
                        cartItems = {};
                        renderCartItems();
                        updateCartTotals();
                        paidAmount = 0;
                        updateDisplays();

                        // Tampilkan modal sukses
                        const successSubtotal = document.getElementById("success-subtotal");
                        const successTotal    = document.getElementById("success-total");
                        const successChange   = document.getElementById("success-change");

                        if (successSubtotal) successSubtotal.textContent = formatRupiah(subtotal);
                        if (successTotal)    successTotal.textContent    = formatRupiah(subtotal);
                        if (successChange)   successChange.textContent   = formatRupiah(kembalian);

                        successModal.show();
                    } else {
                        Swal.fire({ icon:'error', text: 'Gagal simpan transaksi!' });
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire({ icon:'error', text: 'Terjadi kesalahan!' });
                });
            });
        });


        // ====================== UTANG ======================
        const isLunasCheckbox = document.getElementById("is_lunas");

        if(isLunasCheckbox){
            isLunasCheckbox.addEventListener("change", function () {
                if (!this.checked) {
                    Swal.fire({
                        title: "Cari Customer",
                        html: `
                            <input type="text" id="search-customer" class="swal2-input" placeholder="Ketik nama customer...">
                            <div id="customer-list" class="list-group mt-2" style="max-height:200px;overflow-y:auto;"></div>
                        `,
                        showConfirmButton: false,
                        allowOutsideClick: true,
                        allowEscapeKey: true,
                        backdrop: true,
                        didOpen: () => {
                            const popup = Swal.getPopup();
                            const input = popup.querySelector("#search-customer");
                            const list  = popup.querySelector("#customer-list");
    
                            input.focus();
    
                            input.addEventListener("input", function () {
                                let query = this.value;
    
                                if (query.length < 2) {
                                    list.innerHTML = "<div class='text-muted text-center'>Ketik minimal 2 huruf...</div>";
                                    return;
                                }
    
                                fetch(`/search-customer?q=${query}`)
                                    .then(res => res.json())
                                    .then(data => {
                                        let html = "";
                                        if (data.length > 0) {
                                            data.forEach(c => {
                                                html += `
                                                    <div class="list-group-item list-group-item-action customer-item" data-id="${c.id}">
                                                        ${c.customer_name}
                                                    </div>`;
                                            });
                                            list.innerHTML = html;
    
                                            list.querySelectorAll(".customer-item").forEach(item => {
                                                item.addEventListener("click", function () {
                                                    let id   = this.getAttribute("data-id");
                                                    let name = this.textContent;
    
                                                    document.getElementById("selected-customer-id")?.remove();
    
                                                    let hidden = document.createElement("input");
                                                    hidden.type = "hidden";
                                                    hidden.name = "customer_id";
                                                    hidden.id   = "selected-customer-id";
                                                    hidden.value = id;
                                                    document.querySelector("form")?.appendChild(hidden);
    
                                                    document.getElementById("selected-customer-name").textContent = name;
    
                                                    Swal.close();
    
                                                    Swal.fire({
                                                        icon: "success",
                                                        title: "Customer dipilih",
                                                        text: name,
                                                        timer: 1500,
                                                        showConfirmButton: false
                                                    });
                                                });
                                            });
                                        } else {
                                            list.innerHTML = "<div class='text-muted text-center'>Tidak ditemukan</div>";
                                        }
                                    });
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        title: "Konfirmasi",
                        text: "Apakah yakin customer dibersihkan dan transaksi dianggap tunai?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Ya, hapus customer",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById("selected-customer-id")?.remove();
                            document.getElementById("selected-customer-name").textContent = "Belum dipilih";
    
                            Swal.fire({
                                icon: "success",
                                title: "Customer dihapus",
                                timer: 1200,
                                showConfirmButton: false
                            });
                        } else {
                            isLunasCheckbox.checked = false;
                        }
                    });
                }
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

        // ====================== CLEAR CART ======================
        const cleatCartBtn = document.getElementById('clear-cart-btn');
        if(cleatCartBtn){
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
                        if (Object.keys(cartItems).length === 0) {
                            paidAmount = 0;
                            updateDisplays();
                        }
                        showAlert('Keranjang dikosongkan!', 'success');
                    }
                });
            });
        }

        // ====================== CLICK PRODUCT CARD (DELEGATION) ======================
        const productGrid = document.getElementById('products-grid');
        if(productGrid){
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
        }

        // ====================== PAYMENT (DENOM + KEYPAD) ======================
        function getTotalAmount() {
            return parseRupiah(totalDisplay.textContent);
        }

        function updateDisplays() {
            if (paidDisplay) paidDisplay.textContent = formatRupiah(paidAmount);
            const totalAmount = totalDisplay ? parseRupiah(totalDisplay.textContent) : 0;
            if (changeDisplay) changeDisplay.textContent = formatRupiah(Math.max(paidAmount - totalAmount, 0));
            if (processBtn) processBtn.disabled = (totalAmount === 0) || (paidAmount < totalAmount);
        }

        document.querySelectorAll('.denomination-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                paidAmount += parseInt(btn.dataset.amount, 10) || 0;
                updateDisplays();
            });
        });

        document.querySelectorAll('.keypad-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const val = btn.textContent.trim();
                if (btn.id === "backspace") {
                    paidAmount = Math.floor(paidAmount / 10);
                } else {
                    paidAmount = parseInt("" + paidAmount + val, 10);
                }
                updateDisplays();
            });
        });

        function addToCart(product) {
            const id = product.id;
            if (cartItems[id]) cartItems[id].quantity += 1;
            else cartItems[id] = { ...product, quantity: 1 };
            renderCartItems();
            updateCartTotals();
        }

        function renderCartItems() {
            const container = document.getElementById('cart-items');
            if (!container) return;
            container.innerHTML = "";
            Object.values(cartItems).forEach(item => {
                const row = document.createElement('div');
                row.className = "cart-item d-flex justify-content-between align-items-center mb-2";
                row.innerHTML = `
                    <div>
                        <strong>${item.name || item.nama_produk}</strong> <br>
                        <small>${item.quantity}x</small>
                    </div>
                    <div>
                        ${formatRupiah(item.harga * item.quantity)}
                        <button class="btn btn-sm btn-outline-danger remove-item-btn" data-id="${item.id}">×</button>
                    </div>
                `;
                container.appendChild(row);
            });
        }

        function updateCartTotals() {
            if (!totalDisplay) return;
            totalDisplay.textContent = formatRupiah(getCartTotal());
            updateDisplays();
        }

        function showAlert(msg, type='success') {
            Swal.fire({ toast:true, position:'top-end', icon:type, title:msg, showConfirmButton:false, timer:1200 });
        }
    }

    document.addEventListener("DOMContentLoaded", initPageScripts);
</script>
@endpush

