
/**
 * Product Details  Manager
 * Handles product form submissions, validation, storage, and UI updates
 */

// Initialize on document ready
$(document).ready(function() {
    const ProductFormManager = {
        // Constants
        STORAGE_KEY: 'purchaseFormData',
        
        // DOM Selectors
        selectors: {
            mainForm: '#purchaseForm',
            modal: '#product-modal',
            productList: '.submited-products tbody',
            addMoreBtn: '.addmore-btn-groups',
            submittedProducts: '.submited-products',
            productDetailPage: '#productForm',
            purchaseDateInput: 'input[name="purchaseDate"]'
        },

        // Initialize the module
        init: function() {
            this.loadStoredData();
            this.bindEvents();
            this.initializeStyles();
            this.initializeDateValidation();
        },

        // Load and display stored data
        loadStoredData: function() {
            const storedData = this.getStoredData();
            if (storedData.length > 0) {
                this.toggleMainForm(false);
                storedData.forEach(product => {
                    this.appendProductRow(product);
                });
                $(".steps-grid .step-card").hide();
                $(".steps-grid .step-card:nth-child(3)").addClass('active-card').show();
                
            } else {
                this.toggleMainForm(true);
            }
        },

        // Initialize date validation
        initializeDateValidation: function() {
            const today = new Date().toISOString().split('T')[0];
            $(this.selectors.purchaseDateInput).attr('max', today);
            this.bindDateValidationEvents();
        },

        // Bind date validation events
        bindDateValidationEvents: function() {
            $(this.selectors.purchaseDateInput).on('change', (e) => this.validatePurchaseDate(e));
        },

        // Bind all event handlers
        bindEvents: function() {
            // Main form submission
            $(this.selectors.mainForm).on('submit', (e) => this.handleFormSubmit(e));

            // Modal form submission
            $(`${this.selectors.modal} form`).off('submit').on('submit', (e) => this.handleModalSubmit(e));

            // Record actions
            $(document).on('click', '.view-record', (e) => this.handleViewRecord(e));
            $(document).on('click', '.modify-record', (e) => this.handleModifyRecord(e));
            $(document).on('click', '.delete-record', (e) => this.handleDeleteRecord(e));

            // Modal controls
            $('.open-add-modal').on('click', () => this.openModal());
            $('.modal-close, .modal-overlay').on('click', function(e) {
                if (e.target === this) {
                    ProductFormManager.closeModal();
                }
            });
        },

        // Initialize custom styles
        initializeStyles: function() {
            $('<style>')
                .text(`
                    .error-input { 
                        border-color: #dc2626 !important; 
                    }
                    .error-message { 
                        color: #dc2626; 
                        font-size: 0.875rem; 
                        margin-top: 0.25rem; 
                    }
                    #product-modal input[readonly], 
                    #product-modal textarea[readonly] {
                        background-color: #f3f4f6;
                        cursor: default;
                        color: #374151;
                    }
                    #product-modal input[type="radio"]:disabled {
                        cursor: default;
                        opacity: 0.7;
                        border:0;
                    }
                    #product-modal input[type="radio"]:disabled + .radio-checkmark {
                        cursor: default;
                    }
                    input[type="date"]::-webkit-calendar-picker-indicator {
                        cursor: pointer;
                    }
                    input[type="date"]::-webkit-calendar-picker-indicator:hover {
                        background-color: rgba(0, 130, 144, 0.1);
                    }
                `)
                .appendTo('head');
        },

        // Form Handling Methods
        handleFormSubmit: function(e) {
            e.preventDefault();
            const { isValid, formData } = this.validateAndSanitizeForm($(e.target));
            
            if (!isValid) return false;
            
            this.saveProduct(formData);
            this.toggleMainForm(false);
            $(".steps-grid .step-card").hide();
            $(".steps-grid .step-card:nth-child(3)").addClass('active-card').show();
            e.target.reset();
        },

        handleModalSubmit: function(e) {
            e.preventDefault();
            const $modal = $(this.selectors.modal);
            const { isValid, formData } = this.validateAndSanitizeForm($(e.target));
            
            if (!isValid) return false;

            if ($modal.data('edit-mode')) {
                this.updateProduct($modal.data('edit-id'), formData);
            } else {
                this.saveProduct(formData);
            }
            
            this.closeModal();
            e.target.reset();
        },

        // Validate purchase date
        validatePurchaseDate: function(e) {
            const $input = $(e.target);
            const selectedDate = new Date($input.val());
            const currentDate = new Date();
            
            // Remove existing error messages
            this.clearErrors($input);
            
            // Check if date is in future
            if (selectedDate > currentDate) {
                this.showError($input, 'Purchase date cannot be in future');
                $input.val(''); // Clear invalid date
                return false;
            }
            return true;
        },

        // Form validation
        validateAndSanitizeForm: function($form) {
            const formData = {};
            let isValid = true;
            
            // Clear all previous errors
            $form.find('.error-message').remove();
            $form.find('.error-input').removeClass('error-input');

            // Validate purchase mode
            const purchaseMode = $form.find('input[name="purchaseMode"]:checked').val();
            if (!purchaseMode) {
                this.showError($form.find('input[name="purchaseMode"]').first().parent(), 
                    'Please select a purchase mode');
                isValid = false;
            }
            formData.purchaseMode = purchaseMode;

            // Validate required fields
            [
                { name: 'purchaseFrom', label: 'Purchase From' },
                { name: 'placeOfPurchase', label: 'Place of Purchase' },
                { name: 'modelNumber', label: 'Model Number' },
                { name: 'invoiceNumber', label: 'Invoice Number' },
                { name: 'serialNumber', label: 'Serial Number' }
            ].forEach(field => {
                const $input = $form.find(`input[name="${field.name}"]`);
                const value = this.sanitizeInput($input.val());
                
                if (!value) {
                    this.showError($input, `${field.label} is required`);
                    isValid = false;
                }
                formData[field.name] = value;
            });

            // Enhanced date validation
            const $dateInput = $form.find('input[name="purchaseDate"]');
            const purchaseDate = $dateInput.val();
            
            if (!purchaseDate) {
                this.showError($dateInput, 'Purchase date is required');
                isValid = false;
            } else {
                const selectedDate = new Date(purchaseDate);
                const currentDate = new Date();
                
                if (selectedDate > currentDate) {
                    this.showError($dateInput, 'Purchase date cannot be in future');
                    isValid = false;
                }
            }
            formData.purchaseDate = purchaseDate;

            // Optional comment
            formData.comment = this.sanitizeInput($form.find('textarea[name="comment"]').val());

            // Check serial number uniqueness
            if (isValid && formData.serialNumber) {
                const currentProductId = $form.closest(this.selectors.modal).data('edit-id');
                if (!this.isSerialNumberUnique(formData.serialNumber, currentProductId)) {
                    this.showError(
                        $form.find('input[name="serialNumber"]'),
                        'This serial number already exists'
                    );
                    isValid = false;
                }
            }

            return { isValid, formData };
        },

        // Record Action Handlers
        handleViewRecord: function(e) {
            const row = $(e.target).closest('.table-row');
            this.openModal('view', this.getProductDataFromRow(row));
        },

        handleModifyRecord: function(e) {
            const row = $(e.target).closest('.table-row');
            this.openModal('edit', this.getProductDataFromRow(row));
        },

        handleDeleteRecord: function(e) {
            const row = $(e.target).closest('.table-row');
            const productId = row.data('id');
            
            if (confirm('Are you sure you want to delete this record?')) {
                this.deleteProduct(productId);
                row.remove();
                
                if (this.getStoredData().length === 0) {
                    this.toggleMainForm(true);
                }
            }
        },

        // UI Methods
        openModal: function(mode = 'add', productData = null) {
            const $modal = $(this.selectors.modal);
            $modal.removeData('edit-mode view-mode');
            
            if (productData) {
                this.populateModalForm($modal, productData);
            }

            if (mode === 'view') {
                this.setModalReadOnly($modal, true);
                $modal.data('view-mode', true);
            } else if (mode === 'edit') {
                this.setModalReadOnly($modal, false);
                $modal.data('edit-mode', true);
                $modal.data('edit-id', productData.id);
            }

            $modal.css('display', 'flex').hide().fadeIn(300);
        },

        closeModal: function() {
            const $modal = $(this.selectors.modal);
            $modal.fadeOut(300, function() {
                $(this).find('form')[0].reset();
                $(this).removeData('edit-mode edit-id view-mode');
                ProductFormManager.setModalReadOnly($(this), false);
            });
        },

        setModalReadOnly: function($modal, isReadOnly) {
            $modal.find('input:not([type="radio"]), textarea').prop('readonly', isReadOnly);
            $modal.find('input[type="radio"]').prop('disabled', isReadOnly);
            $modal.find('button[type="submit"]').toggle(!isReadOnly);
            
            if (isReadOnly) {
                $modal.find('input:not([type="radio"]), textarea').addClass('bg-gray-100');
                $modal.find('.modal-title').text('View Product Details');
            } else {
                $modal.find('input:not([type="radio"]), textarea').removeClass('bg-gray-100');
                $modal.find('.modal-title').text('Product Details Form');
            }
        },

        toggleMainForm: function(show) {
            
            $(this.selectors.productDetailPage).toggle(show);
            $(this.selectors.addMoreBtn).toggle(!show);
            $(this.selectors.submittedProducts).toggle(!show);
            if(show == true){
                $(".steps-grid .step-card").hide();
                $(".steps-grid .step-card:nth-child(1), .steps-grid .step-card:nth-child(2)").addClass("active-card").show();
            }else{
                $(".steps-grid .step-card").hide();
                $(".steps-grid .step-card:nth-child(3)").addClass('active-card').show();
            }
        },

        // Data Management Methods
        saveProduct: function(formData) {
            const storedData = this.getStoredData();
            const newProduct = {
                id: Date.now(),
                ...formData
            };
            
            storedData.push(newProduct);
            localStorage.setItem(this.STORAGE_KEY, JSON.stringify(storedData));
            this.appendProductRow(newProduct);
        },

        updateProduct: function(productId, formData) {
            const storedData = this.getStoredData();
            const index = storedData.findIndex(item => item.id === productId);
            
            if (index !== -1) {
                const updatedProduct = { id: productId, ...formData };
                storedData[index] = updatedProduct;
                localStorage.setItem(this.STORAGE_KEY, JSON.stringify(storedData));
                $(`.table-row[data-id="${productId}"]`).replaceWith(this.generateProductRow(updatedProduct));
            }
        },

        deleteProduct: function(productId) {
            const storedData = this.getStoredData().filter(item => item.id !== productId);
            localStorage.setItem(this.STORAGE_KEY, JSON.stringify(storedData));
        },

        // Helper Methods
        getStoredData: function() {
            return JSON.parse(localStorage.getItem(this.STORAGE_KEY)) || [];
        },

        sanitizeInput: function(input) {
            if (!input) return '';
            return input
                .replace(/[<>]/g, '')
                .trim()
                .replace(/\s+/g, ' ');
        },

        clearErrors: function($input) {
            $input.removeClass('error-input')
                  .siblings('.error-message').remove();
        },

        showError: function($element, message) {
            $element.addClass('error-input')
                   .after($('<div>')
                       .addClass('error-message')
                       .text(message));
        },

        isSerialNumberUnique: function(serialNumber, currentProductId = null) {
            return !this.getStoredData().some(product => 
                product.serialNumber === serialNumber && product.id !== currentProductId
            );
        },

        generateProductRow: function(product) {
            return `
            <tr class="table-row" style="cursor: pointer;" data-id="${product.id}" 
                    data-purchase-mode="${product.purchaseMode}"
                    data-purchase-from="${product.purchaseFrom}"
                    data-place="${product.placeOfPurchase}"
                    data-date="${product.purchaseDate}"
                    data-model="${product.modelNumber}"
                    data-invoice="${product.invoiceNumber}"
                    data-serial="${product.serialNumber}"
                    data-comment="${product.comment || ''}">
                                            <td>${product.purchaseFrom}</td>
                                            <td>${product.invoiceNumber}</td>
                                            <td class="mobile-hide">${product.serialNumber}</td>
                                            <td class="mobile-hide">${product.modelNumber}</td>
                                            <td class="mobile-hide">${product.purchaseDate}</td>
                                            <td>
                                                <a href="javascript:;" class="view-record" title="View"><i class="fas fa-eye"></i></a>
                                                <a href="javascript:;" class="modify-record" title="Edit"><i class="fas fa-edit"></i></a>
                                                <a href="javascript:;" class="delete-record" title="Delete"><i class="fas fa-trash"></i></a>
                                            </td>
                                      </tr>
            `;
        },

        // Continuing from appendProductRow...
        appendProductRow: function(product) {
            $(this.selectors.productList).append(this.generateProductRow(product));
        },

        getProductDataFromRow: function($row) {
            return {
                id: $row.data('id'),
                purchaseMode: $row.data('purchase-mode'),
                purchaseFrom: $row.data('purchase-from'),
                placeOfPurchase: $row.data('place'),
                purchaseDate: $row.data('date'),
                modelNumber: $row.data('model'),
                invoiceNumber: $row.data('invoice'),
                serialNumber: $row.data('serial'),
                comment: $row.data('comment')
            };
        },

        populateModalForm: function($modal, data) {
            $modal.find(`input[name="purchaseMode"][value="${data.purchaseMode}"]`).prop('checked', true);
            $modal.find('input[name="purchaseFrom"]').val(data.purchaseFrom);
            $modal.find('input[name="placeOfPurchase"]').val(data.placeOfPurchase);
            $modal.find('input[name="purchaseDate"]').val(data.purchaseDate);
            $modal.find('input[name="modelNumber"]').val(data.modelNumber);
            $modal.find('input[name="invoiceNumber"]').val(data.invoiceNumber);
            $modal.find('input[name="serialNumber"]').val(data.serialNumber);
            $modal.find('textarea[name="comment"]').val(data.comment);
        }
    };

    // Initialize the module
    ProductFormManager.init();
});