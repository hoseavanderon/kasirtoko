<div id="app">
      <!-- Header -->
      <div class="page-header">
        <div class="container-fluid">
          <div class="d-flex justify-content-between align-items-center py-3">
            <div class="d-flex align-items-center">
              <button class="btn btn-outline-secondary me-3" onclick="goBack()">
                <i class="fas fa-arrow-left me-2"></i>Back to Inventory
              </button>
              <div>
                <h4 class="mb-0 fw-bold">Add New Products</h4>
                <p class="text-muted mb-0">Add multiple products with custom attributes</p>
              </div>
            </div>
            <div class="d-flex gap-2">
              <button class="btn btn-outline-primary" onclick="clearForm()">
                <i class="fas fa-refresh me-2"></i>Clear All
              </button>
              <button class="btn btn-primary" onclick="saveProducts()">
                <i class="fas fa-save me-2"></i>Save Products
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <div class="container-fluid py-4">
        <div class="row justify-content-center">
          <div class="col-12 col-xl-10">
            <div class="add-product-container">
              <!-- Form Header -->
              <div class="form-header">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <h5 class="mb-1">Product Information</h5>
                    <p class="text-muted mb-0">Fill in the details for each product variant</p>
                  </div>
                  <button class="btn btn-success btn-add-row" onclick="addProductRow()">
                    <i class="fas fa-plus me-2"></i>Add Product Row
                  </button>
                </div>
              </div>

              <!-- Dynamic Form -->
              <div class="form-container">
                <div id="productRows">
                  <!-- Initial product row will be added by JavaScript -->
                </div>
              </div>

              <!-- Form Actions -->
              <div class="form-actions">
                <div class="d-flex justify-content-between align-items-center">
                  <div class="form-summary">
                    <span class="text-muted">Total products: </span>
                    <span class="fw-bold" id="productCount">0</span>
                  </div>
                  <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary" onclick="goBack()">
                      Cancel
                    </button>
                    <button class="btn btn-primary btn-lg" onclick="saveProducts()">
                      <i class="fas fa-save me-2"></i>Save All Products
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="confirmationModalLabel">
              <i class="fas fa-exclamation-triangle text-warning me-2"></i>
              Unsaved Changes
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p class="mb-0">You have unsaved changes. Are you sure you want to leave this page? All your changes will be lost.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Stay on Page</button>
            <button type="button" class="btn btn-danger" onclick="confirmExit()">Leave Page</button>
          </div>
        </div>
      </div>
    </div>
