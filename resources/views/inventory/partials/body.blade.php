<div id="app">
  <!-- Main Content -->
  <div class="container-fluid">
    <div class="row g-0">
      <!-- Sidebar -->
      <div class="col-lg-3 col-md-4">
        <div class="sidebar bg-light h-100 shadow-sm">
          <div class="sidebar-header p-3 border-bottom">
            <h5 class="mb-0 text-secondary fw-semibold">Storage Racks</h5>
          </div>
          <div class="rack-list">
            @foreach ($shelves as $shelf)
              <div class="rack-item {{ $loop->first ? 'active' : '' }}" data-rack="{{ $shelf->id }}">
                <i class="fas {{ $shelf->icon ?? 'fa-box' }} rack-icon"></i>
                <div class="rack-info">
                  <span class="rack-name">{{ $shelf->name }}</span>
                  <small class="rack-count">{{ $shelf->products_count }} items</small>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>

      <!-- Main Content Area -->
      <div class="col-lg-9 col-md-8">
        <div class="main-content p-4">
          <!-- Content Header -->
          <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
              <h4 class="mb-1 fw-bold" id="rackTitle"></h4>
              <p class="text-muted mb-0" id="rackSubtitle"></p>
            </div>
            <div class="d-flex gap-2">
              <button class="btn btn-outline-primary">
                <i class="fas fa-filter me-2"></i>Filter
              </button>
              <div class="btn-group" role="group" aria-label="Grid layout options">
                <button type="button" class="btn btn-outline-secondary grid-toggle active" data-columns="3">
                  <i class="fas fa-th-large"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary grid-toggle" data-columns="4">
                  <i class="fas fa-th"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary grid-toggle" data-columns="6">
                  <i class="fas fa-grip"></i>
                </button>
              </div>
              <button type="button" class="btn btn-primary" onclick="window.location='{{ route('inventory.barangmasuk') }}'">
                  <i class="fas fa-plus me-2"></i>Add Item
              </button>
            </div>
          </div>

          <!-- Search Bar -->
          <div class="search-container mb-4">
            <div class="input-group">
              <span class="input-group-text bg-white border-end-0">
                <i class="fas fa-search text-muted"></i>
              </span>
              <input type="text" id="searchInput" class="form-control border-start-0" 
                      placeholder="Search items by name or SKU...">
            </div>
          </div>

          <!-- Items Grid -->
          <div class="row g-4" id="itemsGrid">
            <!-- Items will be populated by JavaScript -->
          </div>

          <!-- Loading Animation -->
          <div class="text-center py-5 d-none" id="loadingSpinner">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2 text-muted">Loading items...</p>
          </div>

          <!-- Empty State -->
          <div class="text-center py-5 d-none" id="emptyState">
            <i class="fas fa-box-open text-muted" style="font-size: 4rem;"></i>
            <h5 class="mt-3 text-muted">No items found</h5>
            <p class="text-muted">Try adjusting your search or filter criteria</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Stock History Modal -->
  <div class="modal fade" id="stockHistoryModal" tabindex="-1" aria-labelledby="stockHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content stock-modal">
        <div class="modal-header stock-modal-header">
          <div class="d-flex align-items-center">
            <div class="modal-product-initials me-3" id="modalProductInitials">
              LP
            </div>
            <div>
              <h5 class="modal-title mb-0" id="stockHistoryModalLabel">Product Name</h5>
              <small class="text-muted" id="modalProductSku">SKU: ABC-123</small>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-0">
          <!-- Stock Overview -->
          <div class="stock-overview">
            <div class="row g-0">
              <div class="col-4 stock-overview-item">
                <div class="stock-overview-label">Current Stock</div>
                <div class="stock-overview-value" id="modalCurrentStock">25</div>
              </div>
              <div class="col-4 stock-overview-item">
                <div class="stock-overview-label">Total In</div>
                <div class="stock-overview-value text-success" id="modalTotalIn">150</div>
              </div>
              <div class="col-4 stock-overview-item">
                <div class="stock-overview-label">Total Out</div>
                <div class="stock-overview-value text-warning" id="modalTotalOut">125</div>
              </div>
            </div>
          </div>

          <!-- History Tabs -->
          <div class="stock-history-tabs">
            <ul class="nav nav-pills nav-fill" id="historyTabs" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="stock-in-tab" data-bs-toggle="pill" data-bs-target="#stock-in" type="button" role="tab">
                  <i class="fas fa-arrow-down me-2"></i>Stock In
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="stock-out-tab" data-bs-toggle="pill" data-bs-target="#stock-out" type="button" role="tab">
                  <i class="fas fa-arrow-up me-2"></i>Stock Out
                </button>
              </li>
            </ul>
          </div>

          <!-- History Content -->
          <div class="tab-content stock-history-content" id="historyTabContent">
            <div class="tab-pane fade show active" id="stock-in" role="tabpanel">
              <div class="stock-history-list" id="stockInList">
                <!-- Stock in items will be populated by JavaScript -->
              </div>
            </div>
            <div class="tab-pane fade" id="stock-out" role="tabpanel">
              <div class="stock-history-list" id="stockOutList">
                <!-- Stock out items will be populated by JavaScript -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>