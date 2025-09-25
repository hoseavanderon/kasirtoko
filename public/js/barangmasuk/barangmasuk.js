class AddProductManager {
  constructor() {
    this.productCounter = 0;
    this.hasUnsavedChanges = false;
    this.confirmationModal = null;
    this.pendingNavigation = null;
    
    // Sample data for dropdowns
    this.products = [
      'Wireless Bluetooth Headphones',
      '4K Ultra HD Smart TV',
      'Gaming Laptop',
      'Wireless Mouse',
      'Smartphone',
      'Tablet',
      'Cotton T-Shirt',
      'Denim Jeans',
      'Leather Jacket',
      'Running Shoes'
    ];
    
    this.attributes = [
      'Color',
      'Size',
      'Material',
      'Brand',
      'Model',
      'Storage',
      'RAM',
      'Screen Size',
      'Weight',
      'Warranty'
    ];
    
    this.attributeValues = {
      'Color': ['Black', 'White', 'Red', 'Blue', 'Green', 'Gray', 'Silver', 'Gold'],
      'Size': ['XS', 'S', 'M', 'L', 'XL', 'XXL', '32', '34', '36', '38', '40', '42'],
      'Material': ['Cotton', 'Polyester', 'Leather', 'Plastic', 'Metal', 'Glass', 'Wood'],
      'Brand': ['Apple', 'Samsung', 'Sony', 'Nike', 'Adidas', 'Dell', 'HP', 'Lenovo'],
      'Model': ['Pro', 'Standard', 'Premium', 'Basic', 'Advanced', 'Elite'],
      'Storage': ['64GB', '128GB', '256GB', '512GB', '1TB', '2TB'],
      'RAM': ['4GB', '8GB', '16GB', '32GB', '64GB'],
      'Screen Size': ['13"', '15"', '17"', '21"', '24"', '27"', '32"', '43"', '55"', '65"'],
      'Weight': ['Light', 'Medium', 'Heavy'],
      'Warranty': ['1 Year', '2 Years', '3 Years', '5 Years', 'Lifetime']
    };
    
    this.init();
  }
  
  init() {
    this.setupEventListeners();
    this.addProductRow(); // Add initial row
    this.confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
  }
  
  setupEventListeners() {
    // Prevent accidental page exit
    window.addEventListener('beforeunload', (e) => {
      if (this.hasUnsavedChanges) {
        e.preventDefault();
        e.returnValue = '';
      }
    });
    
    // Track form changes
    document.addEventListener('input', () => {
      this.hasUnsavedChanges = true;
    });
    
    document.addEventListener('change', () => {
      this.hasUnsavedChanges = true;
    });
  }
  
  addProductRow() {
    this.productCounter++;
    const productRows = document.getElementById('productRows');
    
    const rowHtml = `
      <div class="product-row" data-row-id="${this.productCounter}">
        <div class="row-header">
          <div class="d-flex align-items-center">
            <div class="row-number">${this.productCounter}</div>
            <div class="row-title">
              <h6>Product #${this.productCounter}</h6>
              <small>Configure product details and attributes</small>
            </div>
          </div>
          <button class="btn btn-delete-row" onclick="removeProductRow(${this.productCounter})" ${this.productCounter === 1 ? 'style="display: none;"' : ''}>
            <i class="fas fa-trash me-2"></i>Remove
          </button>
        </div>
        
        <div class="row g-3">
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label">
                <i class="fas fa-box me-2"></i>Product Name
              </label>
              <select class="form-select" required>
                <option value="">Select a product...</option>
                ${this.products.map(product => `<option value="${product}">${product}</option>`).join('')}
              </select>
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label">
                <i class="fas fa-calculator me-2"></i>Quantity
              </label>
              <div class="quantity-input">
                <input type="number" class="form-control" min="1" placeholder="Enter quantity" required>
                <span class="quantity-unit">pcs</span>
              </div>
            </div>
          </div>
        </div>
        
        <div class="attribute-section">
          <div class="attribute-header">
            <h6>
              <i class="fas fa-tags"></i>
              Product Attributes
            </h6>
            <button type="button" class="btn btn-add-attribute" onclick="addAttributeRow(${this.productCounter})">
              <i class="fas fa-plus me-1"></i>Add Attribute
            </button>
          </div>
          
          <div class="attributes-container" id="attributes-${this.productCounter}">
            <div class="empty-attributes">
              <i class="fas fa-tag"></i>
              <p class="mb-0">No attributes added yet. Click "Add Attribute" to get started.</p>
            </div>
          </div>
        </div>
      </div>
    `;
    
    productRows.insertAdjacentHTML('beforeend', rowHtml);
    this.updateProductCount();
    this.updateRowNumbers();
  }
  
  removeProductRow(rowId) {
    const row = document.querySelector(`[data-row-id="${rowId}"]`);
    if (row) {
      row.classList.add('removing');
      setTimeout(() => {
        row.remove();
        this.updateProductCount();
        this.updateRowNumbers();
      }, 300);
    }
  }
  
  addAttributeRow(productRowId) {
    const container = document.getElementById(`attributes-${productRowId}`);
    const emptyState = container.querySelector('.empty-attributes');
    
    if (emptyState) {
      emptyState.remove();
    }
    
    const attributeId = Date.now();
    const attributeHtml = `
      <div class="attribute-row" data-attribute-id="${attributeId}">
        <div class="flex-fill">
          <label class="form-label">Attribute</label>
          <select class="form-select" onchange="updateAttributeValues(${attributeId})" required>
            <option value="">Select attribute...</option>
            ${this.attributes.map(attr => `<option value="${attr}">${attr}</option>`).join('')}
          </select>
        </div>
        
        <div class="flex-fill">
          <label class="form-label">Value</label>
          <select class="form-select" id="values-${attributeId}" disabled required>
            <option value="">Select attribute first...</option>
          </select>
        </div>
        
        <div>
          <button type="button" class="btn btn-remove-attribute" onclick="removeAttributeRow(${attributeId})" title="Remove attribute">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
    `;
    
    container.insertAdjacentHTML('beforeend', attributeHtml);
  }
  
  removeAttributeRow(attributeId) {
    const row = document.querySelector(`[data-attribute-id="${attributeId}"]`);
    if (row) {
      const container = row.parentElement;
      row.classList.add('removing');
      
      setTimeout(() => {
        row.remove();
        
        // Check if container is empty and add empty state
        if (container.children.length === 0) {
          container.innerHTML = `
            <div class="empty-attributes">
              <i class="fas fa-tag"></i>
              <p class="mb-0">No attributes added yet. Click "Add Attribute" to get started.</p>
            </div>
          `;
        }
      }, 300);
    }
  }
  
  updateAttributeValues(attributeId) {
    const attributeSelect = document.querySelector(`[data-attribute-id="${attributeId}"] .form-select`);
    const valuesSelect = document.getElementById(`values-${attributeId}`);
    
    const selectedAttribute = attributeSelect.value;
    
    if (selectedAttribute && this.attributeValues[selectedAttribute]) {
      valuesSelect.disabled = false;
      valuesSelect.innerHTML = `
        <option value="">Select value...</option>
        ${this.attributeValues[selectedAttribute].map(value => 
          `<option value="${value}">${value}</option>`
        ).join('')}
        <option value="custom">+ Add new value</option>
      `;
    } else {
      valuesSelect.disabled = true;
      valuesSelect.innerHTML = '<option value="">Select attribute first...</option>';
    }
  }
  
  updateProductCount() {
    const count = document.querySelectorAll('.product-row').length;
    document.getElementById('productCount').textContent = count;
    
    // Show/hide delete buttons
    const deleteButtons = document.querySelectorAll('.btn-delete-row');
    deleteButtons.forEach(btn => {
      btn.style.display = count > 1 ? 'inline-flex' : 'none';
    });
  }
  
  updateRowNumbers() {
    const rows = document.querySelectorAll('.product-row');
    rows.forEach((row, index) => {
      const number = index + 1;
      const numberElement = row.querySelector('.row-number');
      const titleElement = row.querySelector('.row-title h6');
      
      if (numberElement) numberElement.textContent = number;
      if (titleElement) titleElement.textContent = `Product #${number}`;
    });
  }
  
  clearForm() {
    if (this.hasUnsavedChanges) {
      if (confirm('Are you sure you want to clear all data? This action cannot be undone.')) {
        this.performClearForm();
      }
    } else {
      this.performClearForm();
    }
  }
  
  performClearForm() {
    document.getElementById('productRows').innerHTML = '';
    this.productCounter = 0;
    this.hasUnsavedChanges = false;
    this.addProductRow();
  }
  
  saveProducts() {
    const saveButton = document.querySelector('.btn-primary[onclick="saveProducts()"]');
    const rows = document.querySelectorAll('.product-row');
    
    // Validate form
    let isValid = true;
    const products = [];
    
    rows.forEach((row, index) => {
      const productSelect = row.querySelector('.form-select');
      const quantityInput = row.querySelector('input[type="number"]');
      
      if (!productSelect.value || !quantityInput.value) {
        isValid = false;
        return;
      }
      
      const attributes = [];
      const attributeRows = row.querySelectorAll('.attribute-row');
      
      attributeRows.forEach(attrRow => {
        const attrSelect = attrRow.querySelector('.form-select');
        const valueSelect = attrRow.querySelectorAll('.form-select')[1];
        
        if (attrSelect.value && valueSelect.value) {
          attributes.push({
            attribute: attrSelect.value,
            value: valueSelect.value
          });
        }
      });
      
      products.push({
        product: productSelect.value,
        quantity: parseInt(quantityInput.value),
        attributes: attributes
      });
    });
    
    if (!isValid) {
      alert('Please fill in all required fields (Product Name and Quantity).');
      return;
    }
    
    // Simulate saving
    saveButton.classList.add('loading');
    saveButton.disabled = true;
    
    setTimeout(() => {
      console.log('Products to save:', products);
      alert(`Successfully saved ${products.length} product(s)!`);
      
      this.hasUnsavedChanges = false;
      saveButton.classList.remove('loading');
      saveButton.disabled = false;
      
      // Optionally redirect back to inventory
      // window.location.href = 'index.html';
    }, 2000);
  }
  
  goBack() {
    if (this.hasUnsavedChanges) {
      this.pendingNavigation = () => window.location.href = 'index.html';
      this.confirmationModal.show();
    } else {
      window.location.href = 'index.html';
    }
  }
  
  confirmExit() {
    this.hasUnsavedChanges = false;
    this.confirmationModal.hide();
    if (this.pendingNavigation) {
      this.pendingNavigation();
    }
  }
}

// Global functions for onclick handlers
let addProductManager;

function addProductRow() {
  addProductManager.addProductRow();
}

function removeProductRow(rowId) {
  addProductManager.removeProductRow(rowId);
}

function addAttributeRow(productRowId) {
  addProductManager.addAttributeRow(productRowId);
}

function removeAttributeRow(attributeId) {
  addProductManager.removeAttributeRow(attributeId);
}

function updateAttributeValues(attributeId) {
  addProductManager.updateAttributeValues(attributeId);
}

function clearForm() {
  addProductManager.clearForm();
}

function saveProducts() {
  addProductManager.saveProducts();
}

function goBack() {
  addProductManager.goBack();
}

function confirmExit() {
  addProductManager.confirmExit();
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
  addProductManager = new AddProductManager();
});

// Handle custom attribute values
document.addEventListener('change', (e) => {
  if (e.target.matches('select[id^="values-"]') && e.target.value === 'custom') {
    const customValue = prompt('Enter custom attribute value:');
    if (customValue && customValue.trim()) {
      const option = document.createElement('option');
      option.value = customValue.trim();
      option.textContent = customValue.trim();
      option.selected = true;
      
      // Insert before the "Add new value" option
      const addNewOption = e.target.querySelector('option[value="custom"]');
      e.target.insertBefore(option, addNewOption);
    } else {
      e.target.value = '';
    }
  }
});