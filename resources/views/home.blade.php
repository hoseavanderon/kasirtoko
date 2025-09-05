<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <div class="header-left">
                <div class="menu-icon">☰</div>
                <div class="user-info">
                    @php
                        $initials = collect(explode(' ', Auth::user()->name))
                            ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                            ->join('');
                    @endphp

                    <div class="user-avatar">{{ $initials }}</div>

                    <div class="user-details">
                        <div class="user-name">{{ Auth::user()->name }}</div>
                        <div class="status">● Status: Online</div>
                    </div>
                </div>
            </div>
            <div class="header-center">
                <div class="logo">{{ Auth::user()->name }}</div>
            </div>
            <div class="header-right">
                <form action="{{ route('logout') }}" method="POST" style="margin-left: 10px;">
                    @csrf
                    <button type="submit"
                        style="
                background: #dc3545;
                border: none;
                color: white;
                padding: 6px 12px;
                border-radius: 6px;
                font-size: 14px;
                font-weight: 500;
                cursor: pointer;
                display: flex;
                align-items: center;
                gap: 6px;
            ">
                        <span style="font-size: 16px;">🔓</span>
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Left Panel -->
            <div class="left-panel">
                <!-- Sidebar -->
                <div class="sidebar">
                    <div class="sidebar-item active">
                        <span class="sidebar-icon">⚏</span>
                    </div>
                    <div class="sidebar-item">
                        <span class="sidebar-icon">⭐</span>
                    </div>
                    <div class="sidebar-item">
                        <span class="sidebar-icon">📦</span>
                    </div>
                    <div class="sidebar-item">
                        <span class="sidebar-icon">🏷️</span>
                    </div>
                    <div class="sidebar-item">
                        <span class="sidebar-icon">📋</span>
                    </div>
                    <div class="sidebar-bottom">
                        <span class="vc-text">VC</span>
                    </div>
                </div>

                <!-- Products Area -->
                <div class="products-area">
                    <!-- Search Bar -->
                    <div class="search-section">
                        <div class="search-bar">
                            <span class="search-icon">🔍</span>
                            <input type="text" id="barcodeInput"
                                placeholder="Ketik minimal 3 karakter untuk mulai mencari..." autocomplete="off"
                                autofocus>
                            <span class="barcode-icon">📷</span>
                        </div>
                    </div>

                    <!-- Products Grid -->
                    <div class="products-grid" id="productsGrid">
                        <!-- Products will be populated by JavaScript -->
                    </div>
                </div>
            </div>

            <!-- Right Panel -->
            <div class="right-panel">
                <!-- Cart Section -->
                <div class="cart-section">
                    <div class="cart-header">
                        <h3>asd</h3>
                        <button class="clear-cart" id="clearCartBtn">🗑️</button>
                    </div>
                    <div class="cart-items" id="cartItems">
                        <div class="empty-cart">
                            <p>Silakan masukkan pesanan dari pelanggan</p>
                        </div>
                    </div>
                </div>
                <!-- Bottom Actions -->
                <div class="bottom-actions">
                    <div class="total-section">
                        <div class="total-amount">
                            <span class="total-label">Total:</span>
                            <span class="total-value">Rp <span id="totalAmount">0</span></span>
                        </div>
                    </div>
                    <div class="action-buttons">
                        <button class="btn-delete">🗑️</button>
                        <button class="btn-save">✓</button>
                        <button class="btn-pay" id="checkoutBtn" disabled>
                            <span class="pay-icon">💳</span>
                            <span>Bayar</span>
                            <span class="pay-total">0</span>
                            <span class="arrow">›</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Popup -->
    <div class="success-popup" id="successPopup">
        <div class="success-popup-content">
            <div class="success-checkmark"></div>
            <div class="success-title">Pembayaran Berhasil!</div>
            <div class="success-message">Transaksi telah berhasil diproses</div>
            <div class="success-amount" id="successAmount">Rp 0</div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Sample product data matching the screenshot
        const products = [{
                code: '8991002121065',
                name: 'Vcr Simpati 1.5 gb',
                price: 10000,
                stock: 0
            },
            {
                code: '8886008101091',
                name: 'Vcr Axis 2 gb',
                price: 12500,
                stock: 2
            }
        ];

        // Cart state
        let cart = [];
        let transactions = [];

        // DOM elements
        const productsGrid = document.getElementById('productsGrid');
        const cartItems = document.getElementById('cartItems');
        const totalAmount = document.getElementById('totalAmount');
        const barcodeInput = document.getElementById('barcodeInput');
        const checkoutBtn = document.getElementById('checkoutBtn');
        const clearCartBtn = document.getElementById('clearCartBtn');
        const successPopup = document.getElementById('successPopup');
        const successAmount = document.getElementById('successAmount');

        // Initialize the application
        function init() {
            renderProducts();
            renderCart();
            setupEventListeners();

            setTimeout(() => {
                barcodeInput.focus();
            }, 100);
        }

        // Setup event listeners
        function setupEventListeners() {
            barcodeInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    handleBarcodeAdd();
                }
            });

            barcodeInput.addEventListener('input', (e) => {
                const value = e.target.value.trim();
                if (value.length >= 2) {
                    // Auto-add if exact match found
                    const product = products.find(p => p.code.toLowerCase() === value.toLowerCase());
                    if (product) {
                        addToCart(product.code);
                        e.target.value = '';
                    }
                }
            });

            checkoutBtn.addEventListener('click', handleCheckout);
            clearCartBtn.addEventListener('click', clearCart);
        }

        // Setup grid toggle functionality
        function setupGridToggle() {
            const gridBtns = document.querySelectorAll('.grid-btn');
            const productsGrid = document.getElementById('productsGrid');

            gridBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    // Remove active class from all buttons
                    gridBtns.forEach(b => b.classList.remove('active'));
                    // Add active class to clicked button
                    btn.classList.add('active');

                    // Update grid columns
                    const cols = btn.dataset.cols;
                    productsGrid.className = `products-grid cols-${cols}`;
                });
            });
        }

        // Render products grid
        function renderProducts() {
            productsGrid.innerHTML = products.map(product => `
        <div class="product-card" onclick="addToCart('${product.code}')">
            <div>
                <div class="product-stock">${product.stock}</div>
                <div class="product-code">${product.code}</div>
                <div class="product-name">${product.name}</div>
            </div>
            <div class="product-price">Rp ${formatPrice(product.price)}</div>
        </div>
    `).join('');
        }

        // Add product to cart
        function addToCart(productCode) {
            const product = products.find(p => p.code === productCode);
            if (!product) {
                showNotification('Produk tidak ditemukan!', 'error');
                return;
            }

            const existingItem = cart.find(item => item.code === productCode);
            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({
                    code: product.code,
                    name: product.name,
                    price: product.price,
                    quantity: 1
                });
            }

            renderCart();
            barcodeInput.value = '';
            barcodeInput.focus();

            // Show success feedback
            showNotification(`${product.name} ditambahkan ke keranjang`, 'success');
        }

        // Handle barcode input
        function handleBarcodeAdd() {
            const code = barcodeInput.value.trim().toUpperCase();
            if (code) {
                addToCart(code);
            }
        }

        // Update item quantity
        function updateQuantity(code, change) {
            const item = cart.find(item => item.code === code);
            if (item) {
                item.quantity += change;
                if (item.quantity <= 0) {
                    removeFromCart(code);
                } else {
                    renderCart();
                }
            }
        }

        // Remove item from cart
        function removeFromCart(code) {
            cart = cart.filter(item => item.code !== code);
            renderCart();
        }

        // Clear entire cart
        function clearCart() {
            if (cart.length === 0) return;

            cart = [];
            renderCart();
            showNotification('Keranjang dikosongkan', 'info');
        }

        // Render cart
        function renderCart() {
            if (cart.length === 0) {
                cartItems.innerHTML = '<div class="empty-cart"><p>Silakan masukkan pesanan dari pelanggan</p></div>';
                checkoutBtn.disabled = true;
                document.querySelector('.pay-total').textContent = '0';
            } else {
                cartItems.innerHTML = cart.map(item => `
            <div class="cart-item">
                <div class="item-info">
                    <div class="item-name">${item.name}</div>
                    <div class="item-price">Rp ${formatPrice(item.price)} x ${item.quantity}</div>
                </div>
                <div class="quantity-controls">
                    <button class="qty-btn" onclick="updateQuantity('${item.code}', -1)">-</button>
                    <span class="quantity">${item.quantity}</span>
                    <button class="qty-btn" onclick="updateQuantity('${item.code}', 1)">+</button>
                    <button class="remove-btn" onclick="removeFromCart('${item.code}')">×</button>
                </div>
            </div>
        `).join('');
                checkoutBtn.disabled = false;
            }

            updateTotal();
        }

        // Update total amount
        function updateTotal() {
            const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            totalAmount.textContent = formatPrice(total);
            document.querySelector('.pay-total').textContent = formatPrice(total);
        }

        function handleCheckout() {
            if (cart.length === 0) return;

            const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);

            Swal.fire({
                title: 'Konfirmasi Checkout',
                text: `Yakin ingin melakukan checkout dengan total Rp ${formatPrice(total)}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Bayar',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#00b894',
                cancelButtonColor: '#d63031',
            }).then((result) => {
                if (result.isConfirmed) {
                    showSuccessPopup(total);

                    const transaction = {
                        id: Date.now(),
                        date: new Date(),
                        items: [...cart],
                        total: total
                    };

                    transactions.unshift(transaction);
                    cart = [];

                    renderCart();
                    setTimeout(() => barcodeInput.focus(), 200);
                }
            });
        }

        // Show success popup
        function showSuccessPopup(total) {
            successAmount.textContent = `Rp ${formatPrice(total)}`;
            successPopup.classList.add('show');

            // Hide popup after 1.5 seconds
            setTimeout(() => {
                successPopup.classList.remove('show');
            }, 1500);
        }

        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.textContent = message;

            // Style the notification
            Object.assign(notification.style, {
                position: 'fixed',
                top: '90px',
                right: '20px',
                background: type === 'success' ? '#00d4aa' : type === 'error' ? '#dc3545' : '#6c757d',
                color: 'white',
                padding: '12px 20px',
                borderRadius: '8px',
                fontSize: '14px',
                fontWeight: '500',
                zIndex: '1000',
                boxShadow: '0 4px 12px rgba(0, 0, 0, 0.15)',
                transform: 'translateX(100%)',
                transition: 'transform 0.3s ease'
            });

            document.body.appendChild(notification);

            // Animate in
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 10);

            // Remove after 3 seconds
            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        // Utility functions
        function formatPrice(price) {
            return price.toLocaleString('id-ID');
        }

        function formatDate(date) {
            return date.toLocaleString('id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        // Initialize the app when DOM is loaded
        document.addEventListener('DOMContentLoaded', () => {
            init();
            setTimeout(() => barcodeInput.focus(), 100);
        });

        // Handle keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            // F1 - Focus on barcode input
            if (e.key === 'F1') {
                e.preventDefault();
                barcodeInput.focus();
            }

            // F2 - Checkout
            if (e.key === 'F2' && !checkoutBtn.disabled) {
                e.preventDefault();
                handleCheckout();
            }

            // F3 - Clear cart
            if (e.key === 'F3') {
                e.preventDefault();
                clearCart();
            }

            // Escape - Clear barcode input
            if (e.key === 'Escape') {
                barcodeInput.value = '';
                barcodeInput.focus();
            }
        });
    </script>
</body>

</html>
