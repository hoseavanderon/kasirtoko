class InventoryManager {
  constructor() {
    this.currentRack = 1; // default rak pertama (bisa diubah sesuai kebutuhan)
    this.filteredItems = [];
    this.currentColumns = 3;
    this.modal = null;
    this.init();
  }

  init() {
    this.setupEventListeners();
    this.loadRackItems(this.currentRack);
    this.modal = new bootstrap.Modal(document.getElementById('stockHistoryModal'));
  }

  setupEventListeners() {
    // Rack selection
    document.querySelectorAll('.rack-item').forEach(item => {
      item.addEventListener('click', (e) => {
        const rackId = e.currentTarget.dataset.rack;
        this.selectRack(rackId);
      });
    });

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('input', (e) => {
      this.searchItems(e.target.value);
    });

    // Grid toggle
    document.querySelectorAll('.grid-toggle').forEach(button => {
      button.addEventListener('click', (e) => {
        document.querySelectorAll('.grid-toggle').forEach(btn => btn.classList.remove('active'));
        e.currentTarget.classList.add('active');
        this.currentColumns = parseInt(e.currentTarget.dataset.columns, 10);
        this.renderItems(this.filteredItems);
      });
    });
  }

  selectRack(rackId) {
    // Update active state
    document.querySelectorAll('.rack-item').forEach(item => item.classList.remove('active'));
    document.querySelector(`[data-rack="${rackId}"]`).classList.add('active');

    this.currentRack = rackId;
    this.loadRackItems(rackId);
  }

  async loadRackItems(rackId) {
    const loadingSpinner = document.getElementById('loadingSpinner');
    const itemsGrid = document.getElementById('itemsGrid');
    const emptyState = document.getElementById('emptyState');

    loadingSpinner.classList.remove('d-none');
    itemsGrid.innerHTML = '';
    emptyState.classList.add('d-none');

    try {
      const res = await fetch(`/shelves/${rackId}/items`);
      const rackData = await res.json();

      document.getElementById('rackTitle').textContent = `${rackData.name} Rack`;
      document.getElementById('rackSubtitle').textContent = `${rackData.count} items in stock`;

      this.filteredItems = rackData.items;
      this.renderItems(this.filteredItems);
    } catch (err) {
      console.error('Error loading rack items:', err);
    } finally {
      loadingSpinner.classList.add('d-none');
    }
  }

  renderItems(items) {
    const itemsGrid = document.getElementById('itemsGrid');
    const emptyState = document.getElementById('emptyState');

    if (!items || items.length === 0) {
      emptyState.classList.remove('d-none');
      return;
    }

    emptyState.classList.add('d-none');
    itemsGrid.innerHTML = items.map(item => this.createItemCard(item)).join('');

    // Add click handlers for item cards
    document.querySelectorAll('.item-card').forEach(card => {
      card.addEventListener('click', (e) => {
        const itemId = parseInt(e.currentTarget.dataset.itemId);
        this.showStockHistory(itemId);
      });
    });
  }

  generateInitials(productName) {
    if (!productName) return "NA";

    const words = productName.toLowerCase().split(' ');
    const skipWords = ['the','a','an','and','or','in','on','at','to','for','of','with','by'];
    const significant = words.filter(w => w.length > 1 && !skipWords.includes(w));

    let initials = '';

    if (significant.length === 0) {
      // ambil huruf pertama dari 3 kata pertama (atau kurang)
      initials = words.slice(0,3).map(w => w.charAt(0)).join('');
    } else if (significant.length === 1) {
      // ambil maksimal 3 huruf dari kata pertama
      initials = significant[0].substring(0,3);
    } else {
      // ambil huruf pertama dari 3 kata pertama yang signifikan
      initials = significant.slice(0,3).map(w => w.charAt(0)).join('');
    }

    return initials.toUpperCase();
  }

  createItemCard(item) {
    const stockClass = this.getStockClass(item); // sebelumnya item.stock
    const stockText = this.getStockText(item);
    const initials = this.generateInitials(item.name);
    const colClass = this.currentColumns === 4 
      ? 'col-lg-3 col-md-6' 
      : this.currentColumns === 6 
        ? 'col-lg-2 col-md-4 col-sm-6' 
        : 'col-lg-4 col-md-6';

    return `
      <div class="${colClass}">
        <div class="item-card h-100" tabindex="0" role="button" aria-label="View ${item.name}" data-item-id="${item.id}">
          <div class="item-initials" title="${item.name}">
            ${initials}
          </div>
          <div class="item-body">
            <h6 class="item-name">${item.name}</h6>
            <div class="item-sku">SKU: ${item.sku}</div>
            <div class="item-details">
              <span class="item-price">Rp ${item.price.toLocaleString('id-ID')}</span>
              <span class="item-stock ${stockClass}">${stockText}</span>
            </div>
          </div>
        </div>
      </div>
    `;
  }

  getStockClass(item) {
    const minStock = item.minimal_stok ?? 10; // default 10 jika undefined
    if (item.stock > minStock * 2) return 'stock-high';
    if (item.stock > minStock) return 'stock-medium';
    return 'stock-low';
  }

  getStockText(item) {
    const minStock = item.minimal_stok ?? 10;
    if (item.stock > minStock * 2) return `${item.stock} pcs`;
    if (item.stock > minStock) return `${item.stock} pcs`;
    return `Low stock (${item.stock})`;
  }

  searchItems(query) {
    if (!query.trim()) {
      this.renderItems(this.filteredItems);
      return;
    }
    const filtered = this.filteredItems.filter(item =>
      item.name.toLowerCase().includes(query.toLowerCase()) ||
      item.sku.toLowerCase().includes(query.toLowerCase())
    );
    this.renderItems(filtered);
  }

  async showStockHistory(itemId) {
    try {
      const res = await fetch(`/inventory/history/${itemId}`);
      const historyData = await res.json();

      // ambil item yang diklik
      const item = this.filteredItems.find(i => i.id === itemId);

      // Update modal title & SKU
      document.getElementById('stockHistoryModalLabel').textContent = item.name;
      document.getElementById('modalProductSku').textContent = `SKU: ${item.sku}`;
      document.getElementById('modalCurrentStock').textContent = item.stock;

      // Update totals
      const totalIn = historyData.filter(h => h.type.toLowerCase() === 'in').reduce((sum,h)=>sum+h.pcs,0);
      const totalOut = historyData.filter(h => h.type.toLowerCase() === 'out').reduce((sum,h)=>sum+h.pcs,0);
      document.getElementById('modalTotalIn').textContent = totalIn;
      document.getElementById('modalTotalOut').textContent = totalOut;

      // Populate stock history lists
      this.populateStockInList(historyData.filter(h => h.type.toLowerCase() === 'in'));
      this.populateStockOutList(historyData.filter(h => h.type.toLowerCase() === 'out'));

      // Generate initials & background for modal
      const initialsEl = document.getElementById('modalProductInitials');
      initialsEl.textContent = this.generateInitials(item.name);

      // Optional: tambahkan warna gradient seperti item card
      initialsEl.style.background = 'linear-gradient(135deg, #3b82f6, #14b8a6)';

      this.modal.show();
    } catch (err) {
      console.error('Error loading stock history:', err);
    }
  }

  populateStockInList(data) {
    const container = document.getElementById('stockInList');
    if (!data.length) {
      container.innerHTML = `<div class="empty-history"><i class="fas fa-inbox text-muted"></i><p>No incoming stock recorded</p></div>`;
      return;
    }
    container.innerHTML = data.map(e => `
      <div class="stock-history-item stock-in-item">
        <div class="stock-history-icon"><i class="fas fa-arrow-down text-success"></i></div>
        <div class="stock-history-details">
          <span class="stock-history-quantity">+${e.pcs} units</span>
          <span class="stock-history-date">${this.formatDate(e.created_at)}</span>
          <div>${e.keterangan ?? '-'}</div>
        </div>
      </div>
    `).join('');
  }

  populateStockOutList(data) {
    const container = document.getElementById('stockOutList');
    if (!data.length) {
      container.innerHTML = `<div class="empty-history"><i class="fas fa-inbox text-muted"></i><p>No outgoing stock recorded</p></div>`;
      return;
    }
    container.innerHTML = data.map(e => `
      <div class="stock-history-item stock-out-item">
        <div class="stock-history-icon"><i class="fas fa-arrow-up text-warning"></i></div>
        <div class="stock-history-details">
          <span class="stock-history-quantity">-${e.pcs} units</span>
          <span class="stock-history-date">${this.formatDate(e.created_at)}</span>
          <div>${e.keterangan ?? '-'}</div>
        </div>
      </div>
    `).join('');
  }

  formatDate(dateString) {
    return new Date(dateString).toLocaleDateString('id-ID', {
      day: 'numeric', month: 'short', year: 'numeric'
    });
  }
}

document.addEventListener('DOMContentLoaded', () => {
  new InventoryManager();
});
