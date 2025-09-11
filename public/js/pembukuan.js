// Sample transaction data with Indonesian amounts

const months = [
    'January', 'February', 'March', 'April', 'May', 'June',
    'July', 'August', 'September', 'October', 'November', 'December'
];

let currentYear = 2025;
let currentMonth = 0; // 0 for "Latest"
let searchTerm = '';
let isExpanded = false;
let isSearchVisible = false;
let expandedTransactions = new Set();

// DOM Elements
const searchBtn = document.getElementById('searchBtn');
const searchContainer = document.getElementById('searchContainer');
const searchInput = document.getElementById('searchInput');
const expandBtn = document.getElementById('expandBtn');
const monthSlider = document.getElementById('monthSlider');
const expandedSelector = document.getElementById('expandedSelector');
const currentMonthTitle = document.getElementById('currentMonthTitle');
const transactionCount = document.getElementById('transactionCount');
const transactionsList = document.getElementById('transactionsList');

// Initialize the app
function init() {
    setupEventListeners();
    updateTransactions();
}

// Setup event listeners
function setupEventListeners() {
    // Search button
    searchBtn.addEventListener('click', toggleSearch);
    
    // Search input
    searchInput.addEventListener('input', (e) => {
        searchTerm = e.target.value;
        updateTransactions();
    });
    
    // Expand button
    expandBtn.addEventListener('click', toggleExpanded);
    
    // Month slider buttons
    const monthBtns = document.querySelectorAll('.month-btn');
    monthBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const month = parseInt(e.target.dataset.month);
            selectMonth(month, currentYear);
        });
    });
    
    // Grid month buttons
    const gridMonthBtns = document.querySelectorAll('.grid-month-btn');
    gridMonthBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const year = parseInt(e.target.dataset.year);
            const month = parseInt(e.target.dataset.month);
            selectMonth(month, year);
            toggleExpanded(); // Close expanded view
        });
    });
}

// Toggle transaction details
function toggleTransactionDetails(transactionId) {
    const detailsElement = document.querySelector(`.transaction-details[data-id="${transactionId}"]`);
    const arrowElement = document.querySelector(`.transaction-arrow[data-id="${transactionId}"]`);
    
    if (expandedTransactions.has(transactionId)) {
        expandedTransactions.delete(transactionId);
        detailsElement.classList.remove('active');
        arrowElement.classList.remove('expanded');
    } else {
        expandedTransactions.add(transactionId);
        detailsElement.classList.add('active');
        arrowElement.classList.add('expanded');
    }
}

// Toggle search visibility
function toggleSearch() {
    isSearchVisible = !isSearchVisible;
    searchContainer.classList.toggle('active', isSearchVisible);
    
    if (isSearchVisible) {
        setTimeout(() => {
            searchInput.focus();
        }, 200);
    } else {
        searchInput.value = '';
        searchTerm = '';
        updateTransactions();
    }
}

// Toggle expanded month/year selector
function toggleExpanded() {
    isExpanded = !isExpanded;
    expandedSelector.classList.toggle('active', isExpanded);
    expandBtn.classList.toggle('expanded', isExpanded);
    
    if (isExpanded) {
        monthSlider.style.opacity = '0.3';
        monthSlider.style.pointerEvents = 'none';
    } else {
        monthSlider.style.opacity = '1';
        monthSlider.style.pointerEvents = 'auto';
    }
}

// Select month and year with smooth animation
function selectMonth(month, year) {
    currentMonth = month;
    currentYear = year;
    
    // Update active states with animation
    updateActiveStates();
    updateTransactions();
    
    // Add a smooth scrolling effect to the selected month button
    const activeBtn = document.querySelector('.month-btn.active');
    if (activeBtn) {
        activeBtn.scrollIntoView({ 
            behavior: 'smooth', 
            block: 'nearest',
            inline: 'center'
        });
    }
}

// Update active states for buttons with animations
function updateActiveStates() {
    // Update month slider buttons
    const monthBtns = document.querySelectorAll('.month-btn');
    monthBtns.forEach(btn => {
        const btnMonth = parseInt(btn.dataset.month);
        const isActive = btnMonth === currentMonth && currentYear === 2025;
        
        if (isActive && !btn.classList.contains('active')) {
            btn.classList.add('active');
        } else if (!isActive && btn.classList.contains('active')) {
            btn.classList.remove('active');
        }
    });
    
    // Update grid month buttons
    const gridMonthBtns = document.querySelectorAll('.grid-month-btn');
    gridMonthBtns.forEach(btn => {
        const btnYear = parseInt(btn.dataset.year);
        const btnMonth = parseInt(btn.dataset.month);
        const isActive = btnMonth === currentMonth && btnYear === currentYear;
        
        if (isActive && !btn.classList.contains('active')) {
            btn.classList.add('active');
        } else if (!isActive && btn.classList.contains('active')) {
            btn.classList.remove('active');
        }
    });
}

// Filter transactions based on current selection and search
let allTransactions = window.transactions || [];

function getFilteredTransactions() {
    let filtered = allTransactions;

    // Filter by month/year
    if (currentMonth > 0) {
        filtered = filtered.filter(transaction => {
            const transactionDate = new Date(transaction.created_at);
            return transactionDate.getMonth() + 1 === currentMonth &&
                   transactionDate.getFullYear() === currentYear;
        });
    } else if (currentMonth === 0) {
        // Latest = bulan sekarang
        const currentMonthIndex = new Date().getMonth() + 1;
        const currentYearIndex = new Date().getFullYear();
        filtered = filtered.filter(transaction => {
            const transactionDate = new Date(transaction.created_at);
            return transactionDate.getMonth() + 1 === currentMonthIndex &&
                   transactionDate.getFullYear() === currentYearIndex;
        });
    }

    if (searchTerm) {
        filtered = filtered.filter(transaction =>
            (transaction.category_pembukuan || '').toLowerCase().includes(searchTerm.toLowerCase()) ||
            transaction.nominal.toString().includes(searchTerm) ||
            (transaction.deskripsi || '').toLowerCase().includes(searchTerm.toLowerCase())
        );
    }

    return filtered.sort(
        (a, b) => new Date(b.created_at).getTime() - new Date(a.created_at).getTime()
    );
}

// Update transactions display with enhanced structure
function updateTransactions() {
    const filteredTransactions = getFilteredTransactions();
    
    // Update title
    updateTitle();
    
    // Update count
    transactionCount.textContent = `${filteredTransactions.length} transactions`;
    
    // Update transactions list
    if (filteredTransactions.length === 0) {
        transactionsList.innerHTML = `
            <div class="empty-state">
                <p>No transactions found</p>
                <small>Try adjusting your search or selecting a different month</small>
            </div>
        `;
    } else {
        transactionsList.innerHTML = filteredTransactions.map(transaction => `
            <div class="transaction-item">
                <div class="transaction-main-row" onclick="toggleTransactionDetails('${transaction.id}')">
                    <div class="transaction-info">
                        <div class="transaction-main">
                            <span class="transaction-date">${formatDate(transaction.created_at)}</span>
                            <span class="transaction-separator">-</span>
                            <span class="transaction-category">${transaction.category_pembukuan ?? '-'}</span>
                        </div>
                        <div class="transaction-description">${transaction.deskripsi}</div>
                    </div>
                    <div class="transaction-amount-row">
                        <div class="transaction-amount ${transaction.type === 'IN' ? 'positive' : 'negative'}">
                            ${formatCurrency(transaction.nominal * (transaction.type === 'IN' ? 1 : -1))}
                        </div>
                        <button class="transaction-arrow" data-id="${transaction.id}">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="6,9 12,15 18,9"></polyline>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="transaction-details" data-id="${transaction.id}">
                    <div class="detail-row">
                        <span class="detail-label">Created</span> 
                        <span class="detail-value">${formatTanggalIndonesia(transaction.created_at)}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Nominal</span> 
                        <span class="detail-value">${formatRupiah(transaction.nominal)}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Saldo Saat Itu</span> 
                        <span class="detail-value">${formatRupiah(transaction.saldo_saat_ini)}</span>
                    </div>
                </div>
            </div>
        `).join('');
        
        // Restore expanded states
        expandedTransactions.forEach(transactionId => {
            const detailsElement = document.querySelector(`.transaction-details[data-id="${transactionId}"]`);
            const arrowElement = document.querySelector(`.transaction-arrow[data-id="${transactionId}"]`);
            if (detailsElement && arrowElement) {
                detailsElement.classList.add('active');
                arrowElement.classList.add('expanded');
            }
        });
    }
}

// Update title based on current selection
function updateTitle() {
    if (currentMonth === 0) {
        currentMonthTitle.textContent = 'Latest';
    } else {
        const monthName = months[currentMonth - 1];
        if (currentYear !== new Date().getFullYear()) {
            currentMonthTitle.textContent = `${monthName} ${currentYear}`;
        } else {
            currentMonthTitle.textContent = monthName;
        }
    }
}

function formatTanggalIndonesia(dateString) {
    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, '0');
    const months = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    const monthName = months[date.getMonth()]; // getMonth() mulai dari 0
    const year = date.getFullYear();
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');
    const seconds = String(date.getSeconds()).padStart(2, '0');

    return `${day} ${monthName} ${year} ${hours}:${minutes}:${seconds}`;
}
function formatDate(dateString) {
    const date = new Date(dateString);
    return `${String(date.getMonth() + 1).padStart(2, '0')}/${String(date.getDate()).padStart(2, '0')}`;
}

function formatCurrency(amount) {
    const absAmount = Math.abs(amount);
    const formatted = absAmount.toLocaleString('id-ID');
    
    if (amount >= 0) {
        return `Rp +${formatted}`;
    } else {
        return `Rp –${formatted}`;
    }
}

function formatRupiah(amount) {
    return 'Rp ' + parseInt(amount).toLocaleString('id-ID');
}

// Get amount class for styling
function getAmountClass(transaction) {
    if (transaction.amount >= 0) return 'positive';
    if (transaction.type === 'transfer') return 'transfer';
    return 'negative';
}

window.initPageScripts = function() {
    if (document.getElementById('transactionsList')) {
        init(); // jalankan init hanya kalau elemen pembukuan ada
    }
};