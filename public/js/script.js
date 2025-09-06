// Mock data
const categories = [
    { id: 'all', name: 'All Categories', icon: 'grid' },
    { id: 'favorit', name: 'Favorit', icon: 'star' },
    { id: 'breakfast', name: 'Breakfast', icon: 'sunrise' },
    { id: 'appetizer', name: 'Appetizer & Soup', icon: 'bowl' },
    { id: 'indonesian', name: 'Indonesian Food', icon: 'geo-alt' },
    { id: 'sandwiches', name: 'Sandwiches', icon: 'layers' },
    { id: 'western', name: 'Western', icon: 'cup' },
    { id: 'pizza', name: 'Pizza', icon: 'circle' },
    { id: 'beverages', name: 'Beverages', icon: 'droplet' },
    { id: 'desserts', name: 'Desserts', icon: 'heart' },
];

const products = [
    { id: '1', name: 'Americano', price: 35000, category: 'beverages' },
    { id: '2', name: 'Avocado Juice', price: 30000, category: 'beverages' },
    { id: '3', name: 'Avocado Toast', price: 55000, category: 'breakfast' },
    { id: '4', name: 'Bali Coffee', price: 15000, category: 'beverages' },
    { id: '5', name: 'Banana Berries', price: 75000, category: 'desserts' },
    { id: '6', name: 'Banana Juice', price: 30000, category: 'beverages' },
    { id: '7', name: 'Banana Milkshake', price: 35000, category: 'beverages' },
    { id: '8', name: 'BBQ Chicken', price: 85000, category: 'western' },
    { id: '9', name: 'Broccoli Soup', price: 45000, category: 'appetizer' },
    { id: '10', name: 'Burger Beef / Chicken', price: 80000, category: 'western' },
    { id: '11', name: 'Calamari', price: 45000, category: 'appetizer' },
    { id: '12', name: 'Cap Cay Chicken / Vege', price: 60000, category: 'indonesian' },
    { id: '13', name: 'Cappuccino', price: 40000, category: 'beverages' },
    { id: '14', name: 'Chicken Katsu', price: 70000, category: 'western' },
    { id: '15', name: 'Club Sandwich', price: 65000, category: 'sandwiches' },
    { id: '16', name: 'French Fries', price: 25000, category: 'western' },
];

const denominations = [100000, 50000, 20000, 10000, 5000, 2000, 1000];

// State
let activeCategory = 'all';
let cartItems = [];
let paidAmount = 0;

// Utility functions
function formatPrice(price) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
    }).format(price);
}

function showToast(message, type = 'success') {
    const toastContainer = document.getElementById('toast-container');
    const toastId = 'toast-' + Date.now();
    
    const bgClass = type === 'success' ? 'bg-success' : type === 'error' ? 'bg-danger' : 'bg-info';
    const icon = type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle';
    
    const toastHTML = `
        <div class="toast show" id="${toastId}" role="alert">
            <div class="toast-header ${bgClass} text-white">
                <i class="bi bi-${icon} me-2"></i>
                <strong class="me-auto">${type.charAt(0).toUpperCase() + type.slice(1)}</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        </div>
    `;
    
    toastContainer.insertAdjacentHTML('beforeend', toastHTML);
    
    setTimeout(() => {
        const toast = document.getElementById(toastId);
        if (toast) {
            toast.remove();
        }
    }, 3000);
}

// Cart functions
function addToCart(product) {
    const existingItem = cartItems.find(item => item.id === product.id);
    
    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cartItems.push({ ...product, quantity: 1 });
    }
    
    updateCartDisplay();
    showToast(`${product.name} added to cart!`);
}

function updateQuantity(productId, newQuantity) {
    if (newQuantity <= 0) {
        removeFromCart(productId);
        return;
    }
    
    const item = cartItems.find(item => item.id === productId);
    if (item) {
        item.quantity = newQuantity;
        updateCartDisplay();
    }
}

function removeFromCart(productId) {
    cartItems = cartItems.filter(item => item.id !== productId);
    updateCartDisplay();
}

function clearCart() {
    cartItems = [];
    paidAmount = 0;
    document.getElementById('paid-amount').value = '';
    updateCartDisplay();
    showToast('Cart cleared!', 'info');
}

function updateCartDisplay() {
    const cartItemsContainer = document.getElementById('cart-items');
    const emptyCart = document.getElementById('empty-cart');
    
    if (cartItems.length === 0) {
        emptyCart.style.display = 'block';
        cartItemsContainer.innerHTML = '';
        cartItemsContainer.appendChild(emptyCart);
    } else {
        emptyCart.style.display = 'none';
        cartItemsContainer.innerHTML = '';
        
        cartItems.forEach(item => {
            const cartItemHTML = `
                <div class="cart-item">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-semibold">${item.name}</h6>
                            <small class="text-primary">${formatPrice(item.price)}</small>
                        </div>
                        <button class="btn btn-outline-danger btn-sm" onclick="removeFromCart('${item.id}')">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                    <div class="qty-controls">
                        <button class="qty-btn" onclick="updateQuantity('${item.id}', ${item.quantity - 1})">
                            <i class="bi bi-dash"></i>
                        </button>
                        <span class="fw-bold px-2">${item.quantity}</span>
                        <button class="qty-btn" onclick="updateQuantity('${item.id}', ${item.quantity + 1})">
                            <i class="bi bi-plus"></i>
                        </button>
                        <span class="ms-auto fw-bold text-primary">
                            ${formatPrice(item.price * item.quantity)}
                        </span>
                    </div>
                </div>
            `;
            cartItemsContainer.insertAdjacentHTML('beforeend', cartItemHTML);
        });
    }
    
    updateTotals();
    updateOrderCount();
}

function updateTotals() {
    const subtotal = cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const total = subtotal;
    const change = paidAmount - total;
    
    document.getElementById('subtotal').textContent = formatPrice(subtotal);
    document.getElementById('total').textContent = formatPrice(total);
    
    const changeElement = document.getElementById('change');
    changeElement.textContent = formatPrice(change);
    changeElement.className = `fw-bold ${change >= 0 ? 'text-success' : 'text-danger'}`;
    
    // Update process payment button
    const processBtn = document.getElementById('process-payment-btn');
    processBtn.disabled = cartItems.length === 0 || paidAmount < total;
}

function updateOrderCount() {
    const orderCount = cartItems.reduce((sum, item) => sum + item.quantity, 0);
    document.getElementById('order-count').textContent = `Order (${orderCount})`;
}

// Initialize denominations
function initializeDenominations() {
    const denominationsContainer = document.getElementById('denominations');
    denominationsContainer.innerHTML = '';
    
    denominations.forEach(amount => {
        const button = document.createElement('button');
        button.className = 'btn btn-outline-primary btn-sm denomination-btn';
        button.textContent = formatPrice(amount);
        button.addEventListener('click', () => addDenomination(amount));
        denominationsContainer.appendChild(button);
    });
}

function addDenomination(amount) {
    paidAmount += amount;
    document.getElementById('paid-amount').value = paidAmount;
    updateTotals();
}

// Fullscreen functionality
function toggleFullscreen() {
    const fullscreenBtn = document.getElementById('fullscreen-btn');
    const fullscreenIcon = document.getElementById('fullscreen-icon');
    
    if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen().then(() => {
            fullscreenIcon.className = 'bi bi-fullscreen-exit';
            fullscreenBtn.title = 'Exit Fullscreen';
        }).catch(err => {
            console.error('Error attempting to enable fullscreen:', err);
        });
    } else {
        document.exitFullscreen().then(() => {
            fullscreenIcon.className = 'bi bi-arrows-fullscreen';
            fullscreenBtn.title = 'Enter Fullscreen';
        }).catch(err => {
            console.error('Error attempting to exit fullscreen:', err);
        });
    }
}

// Process payment
function processPayment() {
    if (cartItems.length === 0) {
        showToast('Cart is empty. Please add products first.', 'error');
        return;
    }
    
    const total = cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    
    if (paidAmount < total) {
        showToast('Insufficient payment amount.', 'error');
        return;
    }
    
    const change = paidAmount - total;
    
    // Update modal with transaction details
    const transactionDetails = document.getElementById('transaction-details');
    transactionDetails.innerHTML = `
        <div class="d-flex justify-content-between mb-2">
            <span>Total Amount:</span>
            <span class="fw-bold">${formatPrice(total)}</span>
        </div>
        <div class="d-flex justify-content-between">
            <span>Change:</span>
            <span class="fw-bold text-success">${formatPrice(change)}</span>
        </div>
    `;
    
    // Show success modal
    const successModal = new bootstrap.Modal(document.getElementById('successModal'));
    successModal.show();
    
    // Clear cart after showing modal
    setTimeout(() => {
        clearCart();
    }, 500);
}

// Barcode scanning
function handleBarcodeSubmit(event) {
    event.preventDefault();
    const barcodeInput = document.getElementById('barcode-input');
    const barcode = barcodeInput.value.trim();
    
    if (barcode) {
        // In a real app, this would lookup the product by barcode
        const product = products.find(p => p.id === barcode);
        if (product) {
            addToCart(product);
            barcodeInput.value = '';
        } else {
            showToast('Product not found. Please try again.', 'error');
        }
    }
}

// Custom product
function addCustomProduct() {
    const name = document.getElementById('custom-name').value.trim();
    const price = parseInt(document.getElementById('custom-price').value);
    
    if (name && price > 0) {
        const customProduct = {
            id: 'custom-' + Date.now(),
            name: name,
            price: price,
            category: 'custom'
        };
        
        addToCart(customProduct);
        
        // Clear form and close modal
        document.getElementById('custom-product-form').reset();
        const modal = bootstrap.Modal.getInstance(document.getElementById('customProductModal'));
        modal.hide();
    } else {
        showToast('Please enter valid product name and price.', 'error');
    }
}

// Navigation
function handleNavigation(page) {
    const pageNames = {
        'daily-summary': 'Daily Transaction Summary',
        'transaction-history': 'Transaction History by Date',
        'store-cash': 'Store Cash',
        'customers': 'Customer Management',
        'inventory': 'Inventory History'
    };
    
    showToast(`Navigate to: ${pageNames[page]}`, 'info');
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    
    // Barcode form
    document.getElementById('barcode-form').addEventListener('submit', handleBarcodeSubmit);
    
    // Payment amount input
    document.getElementById('paid-amount').addEventListener('input', function() {
        paidAmount = parseInt(this.value) || 0;
        updateTotals();
    });
    
    // Exact amount button
    document.getElementById('exact-btn').addEventListener('click', function() {
        const total = cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        paidAmount = total;
        document.getElementById('paid-amount').value = total;
        updateTotals();
    });
    
    // Process payment button
    document.getElementById('process-payment-btn').addEventListener('click', processPayment);
    
    // Clear cart button
    document.getElementById('clear-cart-btn').addEventListener('click', clearCart);
    
    // Fullscreen button
    document.getElementById('fullscreen-btn').addEventListener('click', toggleFullscreen);
    
    // Custom product button
    document.getElementById('custom-product-btn').addEventListener('click', function() {
        const modal = new bootstrap.Modal(document.getElementById('customProductModal'));
        modal.show();
    });
    
    // Add custom product button
    document.getElementById('add-custom-product').addEventListener('click', addCustomProduct);
    
    // Navigation buttons
    document.querySelectorAll('.navbar-btn').forEach(btn => {
        if (btn.dataset.page) {
            btn.addEventListener('click', function() {
                const page = this.dataset.page;
                handleNavigation(page);
            });
        }
    });
    
    // Order type dropdown
    document.querySelectorAll('[data-order-type]').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const orderType = this.dataset.orderType;
            showToast(`Order type changed to: ${this.textContent}`, 'info');
        });
    });
    
    // Auto-focus barcode input when modal closes
    document.getElementById('successModal').addEventListener('hidden.bs.modal', function() {
        document.getElementById('barcode-input').focus();
    });
    
    document.getElementById('customProductModal').addEventListener('hidden.bs.modal', function() {
        document.getElementById('barcode-input').focus();
    });
    
    // Listen for fullscreen changes
    document.addEventListener('fullscreenchange', function() {
        const fullscreenIcon = document.getElementById('fullscreen-icon');
        const fullscreenBtn = document.getElementById('fullscreen-btn');
        
        if (document.fullscreenElement) {
            fullscreenIcon.className = 'bi bi-fullscreen-exit';
            fullscreenBtn.title = 'Exit Fullscreen';
        } else {
            fullscreenIcon.className = 'bi bi-arrows-fullscreen';
            fullscreenBtn.title = 'Enter Fullscreen';
        }
    });
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // F11 for fullscreen
        if (e.key === 'F11') {
            e.preventDefault();
            toggleFullscreen();
        }
        
        // Escape to clear barcode input
        if (e.key === 'Escape') {
            document.getElementById('barcode-input').value = '';
            document.getElementById('barcode-input').focus();
        }
    });
    
    // Keep barcode input focused
    setInterval(() => {
        const activeElement = document.activeElement;
        const barcodeInput = document.getElementById('barcode-input');
        
        // If no input is focused and no modal is open, focus barcode input
        if (activeElement === document.body && !document.querySelector('.modal.show')) {
            barcodeInput.focus();
        }
    }, 1000);
});

// Make functions globally available for onclick handlers
window.updateQuantity = updateQuantity;
window.removeFromCart = removeFromCart;