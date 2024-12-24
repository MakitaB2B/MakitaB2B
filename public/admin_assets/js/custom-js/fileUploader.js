/**
 * FileUploader Module
 * Handles file uploads with preview and storage management
 * Supports single/multiple files and multi-step uploads
 */
const FileUploader = {
    files: new Map(),
    stepHandlers: new Map(),
    
    init: function(options) {
        const defaults = {
            container: null,         // Container element (optional)
            moduleId: 'default',     // Default module identifier
            sectionId: 'default',    // Default section identifier
            maxFileSize: 5,          // Maximum file size in MB
            maxFiles: 5,             // Maximum number of files
            acceptedTypes: '.pdf,.jpg,.jpeg,.png',
            onChange: null,          // Callback when files change
            buttonText: 'Add Files', // Custom button text
            uploadIcon: 'bi-upload', // Bootstrap icon class
            multiple: true,          // Allow multiple files
            required: false,         // Is file upload required
            requiredMessage: 'Please upload required files', // Message for required validation
            steps: null,             // Array of step configurations
            stepValidation: null,    // Step validation function
            onStepComplete: null,    // Callback when step is completed
            showStepIndicator: true  // Show step indicator
        };

        const settings = { ...defaults, ...options };

        // More flexible container handling
        if (!settings.container) {
            console.warn('No container specified for FileUploader, creating a new one');
            settings.container = document.createElement('div');
            settings.container.className = 'file-upload-container';
            if (options && options.appendTo) {
                options.appendTo.appendChild(settings.container);
            } else {
                document.body.appendChild(settings.container);
            }
        }

        // Create unique identifiers if not provided
        if (settings.moduleId === 'default') {
            settings.moduleId = `module-${Math.random().toString(36).substr(2, 9)}`;
        }
        if (settings.sectionId === 'default') {
            settings.sectionId = `section-${Math.random().toString(36).substr(2, 9)}`;
        }

        // Store step handlers if provided
        if (settings.steps) {
            this.stepHandlers.set(`${settings.moduleId}-${settings.sectionId}`, settings.steps);
        }

        this.createUploader(settings);
        return this;
    },

    createUploader: function(settings) {
        const $container = $(settings.container);
        const uploaderId = `${settings.moduleId}-${settings.sectionId}-uploader`;

        // Create step indicator if steps are provided and indicator is enabled
        let stepIndicator = '';
        if (settings.steps && settings.showStepIndicator) {
            stepIndicator = this.createStepIndicator(settings.steps);
        }

        // Create uploader structure
        const $uploader = $(`
            <div class="file-uploader" data-module="${settings.moduleId}" data-section="${settings.sectionId}">
                ${stepIndicator}
                
                <input type="file" 
                       id="${uploaderId}" 
                       class="file-input" 
                       ${settings.multiple ? 'multiple' : ''} 
                       accept="${settings.acceptedTypes}"
                       style="display: none;">
                <div class="preview-wrapper">
                    
                    <div class="upload-button-container">
                        <button type="button" class="btn btn-outline-primary btn-sm upload-trigger">
                            <i class="bi ${settings.uploadIcon} me-2"></i>${settings.buttonText}
                        </button>
                    </div>                    
                </div>
                <div class="upload-info small text-muted">
                    ${settings.multiple ? 
                        `Maximum ${settings.maxFiles} files` : 
                        'Single file only'} (${settings.maxFileSize}MB each)
                </div>
                <div class="file-preview"></div>
                ${settings.required ? 
                    '<div class="required-indicator text-danger small mt-1">* Required</div>' : 
                    ''}
                ${settings.steps ? `
                    <div class="step-navigation mt-3">
                        <button class="btn btn-secondary btn-sm prev-step" style="display: none;">Previous</button>
                        <button class="btn btn-primary btn-sm next-step">Next</button>
                    </div>
                ` : ''}
            </div>
        `);

        $uploader.data('settings', settings);
        $uploader.data('currentStep', 1);
        this.attachEvents($uploader);
        $container.empty().append($uploader);

        // Load existing files if any
        const existingFiles = this.getFiles(settings.moduleId, settings.sectionId);
        if (existingFiles && existingFiles.length > 0) {
            this.updateFilePreviews($uploader);
        }

        // Initialize first step if steps are provided
        if (settings.steps) {
            this.initializeStep($uploader, 1);
        }
    },

    createStepIndicator: function(steps) {
        return `
            <div class="step-indicator mb-3">
                ${steps.map((step, index) => `
                    <div class="step ${index === 0 ? 'active' : ''}" data-step="${index + 1}">
                        <span class="step-number">${index + 1}</span>
                        <span class="step-title">${step.title}</span>
                    </div>
                `).join('')}
            </div>
        `;
    },

        attachEvents: function($uploader) {
        const fileUploader = this;
        const settings = $uploader.data('settings');
        const $fileInput = $uploader.find('.file-input');
        

        // Trigger file input when button is clicked
        $uploader.find('.upload-trigger').on('click', function() {
            $fileInput.click();
        });

        // Handle file selection
        $fileInput.on('change', (e) => {
            fileUploader.handleFileSelect(e.target.files, $uploader);
        });
    
        // Handle file input change
        $uploader.find('.file-input').on('change', function(e) {
            fileUploader.handleFileSelect(e.target.files, $uploader);
        });
        // Handle remove file click using event delegation
        $uploader.on('click', '.remove-file', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const $item = $(this).closest('.file-preview-item');
            const index = $item.index();
            
            fileUploader.removeFile(index, $uploader);
        });

        // Handle drag and drop
        $uploader.on('dragover dragenter', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).addClass('drag-over');
        }).on('dragleave dragend drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).removeClass('drag-over');
        }).on('drop', function(e) {
            const files = e.originalEvent.dataTransfer.files;
            FileUploader.handleFileSelect(files, $(this));
        });

        // Handle step navigation if steps are provided
        if (settings.steps) {
            $uploader.find('.next-step').on('click', () => this.handleNextStep($uploader));
            $uploader.find('.prev-step').on('click', () => this.handlePrevStep($uploader));
        }
    },

    handleFileSelect: function(files, $uploader) {
        const settings = $uploader.data('settings');
        const moduleId = settings.moduleId;
        const sectionId = settings.sectionId;

        let existingFiles = this.getFiles(moduleId, sectionId) || [];

        // Handle single file mode
        if (!settings.multiple) {
            existingFiles = [];
            if (files.length > 1) {
                this.showMessage('Only one file can be uploaded', 'warning', $uploader);
                return;
            }
        }

        const totalFiles = existingFiles.length + files.length;
        if (totalFiles > settings.maxFiles && settings.multiple) {
            this.showMessage(`Maximum ${settings.maxFiles} files allowed`, 'warning', $uploader);
            return;
        }

        Array.from(files).forEach(file => {
            if (file.size > settings.maxFileSize * 1024 * 1024) {
                this.showMessage(`File "${file.name}" exceeds ${settings.maxFileSize}MB limit`, 'warning', $uploader);
                return;
            }

            const isDuplicate = existingFiles.some(existing => existing.name === file.name);
            if (isDuplicate) {
                this.showMessage(`File "${file.name}" already exists`, 'warning', $uploader);
                return;
            }

            if (file.type.match('image.*')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    existingFiles.push({
                        name: file.name,
                        type: file.type,
                        data: e.target.result,
                        size: file.size,
                        timestamp: new Date().getTime()
                    });
                    this.saveFiles(moduleId, sectionId, existingFiles);
                    this.updateFilePreviews($uploader);
                    if (settings.onChange) settings.onChange(existingFiles);
                    this.validateStep($uploader);
                };
                reader.readAsDataURL(file);
            } else if (file.type === 'application/pdf') {
                existingFiles.push({
                    name: file.name,
                    type: file.type,
                    size: file.size,
                    timestamp: new Date().getTime()
                });
                this.saveFiles(moduleId, sectionId, existingFiles);
                this.updateFilePreviews($uploader);
                if (settings.onChange) settings.onChange(existingFiles);
                this.validateStep($uploader);
            }
        });

        $uploader.find('.file-input').val('');
    },
    loadExistingFiles: function($uploader) {
        const settings = $uploader.data('settings');
        const files = this.getFiles(settings.moduleId, settings.sectionId);
        
        if (files && files.length > 0) {
            this.updateFilePreviews($uploader);
            // Update file count or other UI elements if needed
        }
    },
    updateFilePreviews: function($uploader) {
        const settings = $uploader.data('settings');
        const files = this.getFiles(settings.moduleId, settings.sectionId) || [];
        const $preview = $uploader.find('.file-preview');
        
        $preview.empty();
        
        files.forEach((file, index) => {
            const $item = $('<div>').addClass('file-preview-item');
            
            if (file.type.startsWith('image/')) {
                $('<img>')
                    .attr('src', file.data)
                    .appendTo($item);
            } else if (file.type === 'application/pdf') {
                $item.addClass('pdf')
                    .append($('<i>').addClass('bi bi-file-pdf'))
                    .append($('<span>').addClass('file-name').text(file.name));
            }

            // Add remove button
            $('<button>')
                .addClass('remove-file')
                .html('&times;')
                .appendTo($item);

            const fileSize = this.formatFileSize(file.size);
            const uploadDate = new Date(file.timestamp).toLocaleDateString();
            $item.attr('title', `${file.name}\nSize: ${fileSize}\nUploaded: ${uploadDate}`);

            $preview.append($item);
        });

        // Update validation
        if (settings.onChange) {
            settings.onChange(files);
        }
    },

    createPreviewItem: function(file, index, $uploader) {
        const $item = $('<div>').addClass('file-preview-item');
        
        if (file.type.match('image.*')) {
            $item.append($('<img>').attr('src', file.data));
        } else if (file.type === 'application/pdf') {
            $item.addClass('pdf')
                .append($('<i>').addClass('bi bi-file-pdf'))
                .append($('<span>').addClass('file-name').text(file.name));
        }

        const fileSize = this.formatFileSize(file.size);
        const uploadDate = new Date(file.timestamp).toLocaleDateString();
        $item.attr('title', `${file.name}\nSize: ${fileSize}\nUploaded: ${uploadDate}`);
        
        $item.append(
            $('<button>')
                .addClass('remove-file')
                .text('×')
                .click(() => this.removeFile(index, $uploader))
        );
        
        return $item;
    },

    removeFile: function(index, $uploader) {
        const settings = $uploader.data('settings');
        const moduleId = settings.moduleId;
        const sectionId = settings.sectionId;
        const files = this.getFiles(moduleId, sectionId) || [];
        
        if (index >= 0 && index < files.length) {
            // Remove file from array
            files.splice(index, 1);
            
            // Update storage
            this.saveFiles(moduleId, sectionId, files);
            
            // Update UI
            this.updateFilePreviews($uploader);
            
            // Trigger change callback if exists
            if (settings.onChange) {
                settings.onChange(files);
            }
        }
    },

    initializeStep: function($uploader, stepNumber) {
        const settings = $uploader.data('settings');
        const steps = settings.steps;
        
        if (!steps || stepNumber > steps.length) return;

        const step = steps[stepNumber - 1];
        $uploader.find('.upload-trigger').text(step.buttonText || settings.buttonText);
        
        if (step.maxFiles !== undefined) {
            settings.maxFiles = step.maxFiles;
        }
        if (step.acceptedTypes !== undefined) {
            $uploader.find('.file-input').attr('accept', step.acceptedTypes);
        }
        if (step.required !== undefined) {
            settings.required = step.required;
            $uploader.find('.required-indicator').toggle(step.required);
        }

        // Update step indicator
        $uploader.find('.step').removeClass('active completed');
        $uploader.find(`.step[data-step="${stepNumber}"]`).addClass('active');
        for (let i = 1; i < stepNumber; i++) {
            $uploader.find(`.step[data-step="${i}"]`).addClass('completed');
        }

        // Update navigation buttons
        $uploader.find('.prev-step').toggle(stepNumber > 1);
        $uploader.find('.next-step').toggle(stepNumber < steps.length);
        if (stepNumber === steps.length) {
            $uploader.find('.next-step').text('Complete');
        }

        this.validateStep($uploader);
    },

    validateStep: function($uploader) {
        const settings = $uploader.data('settings');
        const currentStep = $uploader.data('currentStep');
        const files = this.getFiles(settings.moduleId, settings.sectionId) || [];

        let isValid = true;

        // Check required validation
        if (settings.required && files.length === 0) {
            isValid = false;
            this.showMessage(settings.requiredMessage, 'danger', $uploader);
        }

        // Check step-specific validation
        if (settings.steps) {
            const step = settings.steps[currentStep - 1];
            if (step.validate) {
                isValid = step.validate(files);
                if (!isValid && step.errorMessage) {
                    this.showMessage(step.errorMessage, 'danger', $uploader);
                }
            }
        }

        // Enable/disable next button if steps are present
        if (settings.steps) {
            $uploader.find('.next-step').prop('disabled', !isValid);
        }

        return isValid;
    },

    handleNextStep: function($uploader) {
        const settings = $uploader.data('settings');
        const currentStep = $uploader.data('currentStep');
        
        if (!this.validateStep($uploader)) {
            return;
        }

        if (settings.onStepComplete) {
            settings.onStepComplete(currentStep, this.getFiles(settings.moduleId, settings.sectionId));
        }

        const nextStep = currentStep + 1;
        if (nextStep <= settings.steps.length) {
            $uploader.data('currentStep', nextStep);
            this.initializeStep($uploader, nextStep);
            this.clearFiles(settings.moduleId, settings.sectionId);
        }
    },

    handlePrevStep: function($uploader) {
        const currentStep = $uploader.data('currentStep');
        const prevStep = currentStep - 1;
        
        if (prevStep >= 1) {
            $uploader.data('currentStep', prevStep);
            this.initializeStep($uploader, prevStep);
        }
    },

    // State management methods
    disable: function($uploader) {
        $uploader.addClass('disabled')
                .find('.upload-trigger').prop('disabled', true);
        $uploader.find('.file-input').prop('disabled', true);
        $uploader.css({
            'opacity': '0.6',
            'pointer-events': 'none'
        });
    },

    enable: function($uploader) {
        $uploader.removeClass('disabled')
                .find('.upload-trigger').prop('disabled', false);
        $uploader.find('.file-input').prop('disabled', false);
        $uploader.css({
            'opacity': '','pointer-events': ''
        });
    },

    // Storage methods
    getFiles: function(moduleId, sectionId) {
        const key = `${moduleId}-${sectionId}`;
        return this.files.get(key);
    },

    saveFiles: function(moduleId, sectionId, files) {
        const key = `${moduleId}-${sectionId}`;
        // Ensure each file has the necessary properties
        const processedFiles = files.map(file => ({
            name: file.name,
            type: file.type,
            size: file.size,
            data: file.data, // This might be base64 data for images
            timestamp: file.timestamp || new Date().getTime()
        }));
        this.files.set(key, processedFiles);
    },
    processStoredFiles: function(files) {
        return files.map(file => ({
            ...file,
            timestamp: file.timestamp || new Date().getTime()
        }));
    },

    clearFiles: function(moduleId, sectionId) {
        const key = `${moduleId}-${sectionId}`;
        this.files.delete(key);
    },

    getInstance: function(moduleId, sectionId) {
        return $(`.file-uploader[data-module="${moduleId}"][data-section="${sectionId}"]`);
    },

    // Message handling
    showMessage: function(message, type, $uploader) {
        const $message = $(`
            <div class="alert alert-${type} alert-dismissible fade show mt-2" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `);
        
        $uploader.find('.alert').remove();
        $uploader.append($message);
        
        setTimeout(() => {
            $message.alert('close');
        }, 3000);
    },

    // Utility methods
    formatFileSize: function(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
};

// Add CSS styles
const style = document.createElement('style');
style.textContent = `
    .file-uploader {
        border: 2px dashed #ccc;
        padding: 0 16px 10px;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
        padding:16px;
    }
    
    .file-uploader.drag-over {
        border-color: #0d6efd;
        background-color: rgba(13, 110, 253, 0.05);
    }
    
    .file-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .file-preview-item {
        position: relative;
        width: 60px;
        height: 60px;
        border: 1px solid #ddd;
        border-radius: 0.25rem;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
    }
    
    .file-preview-item img {
        max-width: 100%;
        max-height: 100%;
        object-fit: cover;
    }
    
    .file-preview-item.pdf {
        flex-direction: column;
        padding: 0.5rem;
    }
    
    .file-preview-item.pdf i {
        font-size: 1rem;
        color: #dc3545;
    }
    
    .file-preview-item.pdf .file-name {
        font-size: 0.75rem;
        text-align: center;
        word-break: break-word;
    }
    
    .file-preview-item .remove-file {
        position: absolute;
        top: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        width: 20px;
        height: 20px;
        border-radius: 0 0 0 0.25rem;
        padding: 0;
        line-height: 1;
        cursor: pointer;
    }
    
    .file-preview-item .remove-file:hover {
        background: rgba(0, 0, 0, 0.7);
    }
   
    /* Navigation styles */
    .step-navigation {
        display: flex;
        justify-content: space-between;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    /* Disabled state styles */
    .file-uploader.disabled {
        opacity: 0.6;
        pointer-events: none;
    }

    /* Required indicator styles */
    .required-indicator {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    /* Error state styles */
    .file-uploader.has-error {
        border-color: #dc3545;
    }

    .file-uploader.has-error .upload-trigger {
        border-color: #dc3545;
        color: #dc3545;
    }
`;

document.head.appendChild(style);

// Export the module
window.FileUploader = FileUploader;