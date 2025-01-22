/**
 * FileUploader Module
 * Handles file uploads with preview and storage management
 */
const FileUploader = {
    // File storage
    db: null,
    dbName: 'file_uploader_db',
    storeName: 'files',
    dbVersion: 1,

    // Default settings
    defaults: {
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
    },

    // Initialize the module
    async init(options) {
        try {
            await this.initDB();
            
            const settings = { ...this.defaults, ...options };
            if (!settings.container) {
                console.error('Container element is required');
                return null;
            }

            await this.createUploader(settings);
            return this;
        } catch (error) {
            console.error('Error initializing FileUploader:', error);
            throw error;
        }
    },

    // Initialize IndexedDB
    async initDB() {
        return new Promise((resolve, reject) => {
            const request = indexedDB.open(this.dbName, this.dbVersion);
            
            request.onerror = () => reject(request.error);
            
            request.onsuccess = (event) => {
                this.db = event.target.result;
                resolve(this.db);
            };
            
            request.onupgradeneeded = (event) => {
                const db = event.target.result;
                if (!db.objectStoreNames.contains(this.storeName)) {
                    db.createObjectStore(this.storeName, { keyPath: 'key' });
                }
            };
        });
    },

    // Create uploader UI
    async createUploader(settings) {
        const $container = $(settings.container);
        const uploaderId = `${settings.moduleId}-${settings.sectionId}-uploader`;

        // Create uploader structure
        const $uploader = $(`
            <div class="file-uploader" data-module="${settings.moduleId}" data-section="${settings.sectionId}">
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
            </div>
        `);

        // Store settings and attach events
        $uploader.data('settings', settings);
        this.attachEvents($uploader);
        
        // Replace container contents
        $container.empty().append($uploader);

        // Load existing files if any
        const files = await this.getFiles(settings.moduleId, settings.sectionId);
        if (files?.length) {
            this.updateFilePreviews($uploader, files);
        }
    },

    // Attach event handlers
    attachEvents($uploader) {
        const self = this;
        const settings = $uploader.data('settings');
        const $fileInput = $uploader.find('.file-input');

        // Trigger file input when button is clicked
        $uploader.find('.upload-trigger').on('click', function() {
            if (!$(this).prop('disabled')) {
                $fileInput.click();
            }
        });

        // Handle file selection
        $fileInput.on('change', async function(e) {
            await self.handleFileSelect(e.target.files, $uploader);
            this.value = ''; // Reset file input
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
        }).on('drop', async function(e) {
            const files = e.originalEvent.dataTransfer.files;
            await self.handleFileSelect(files, $(this));
        });

        // Handle remove file clicks
        $uploader.on('click', '.remove-file', async function(e) {
            e.preventDefault();
            e.stopPropagation();
            const index = $(this).closest('.file-preview-item').index();
            await self.removeFileFromDB(settings.moduleId, settings.sectionId, index, $uploader);
        });
    },
    async removeFileFromDB(moduleId, sectionId, index, $uploader) {
        if (!this.db) {
            console.error('Database not initialized');
            return;
        }
    
        try {
            // Get the key for the files in the database
            const key = `${moduleId}-${sectionId}`;
            const transaction = this.db.transaction([this.storeName], 'readwrite');
            const store = transaction.objectStore(this.storeName);
    
            // Retrieve existing files
            const request = store.get(key);
            const record = await new Promise((resolve, reject) => {
                request.onsuccess = () => resolve(request.result || null);
                request.onerror = () => reject(request.error);
            });
    
            if (record?.files?.length > index) {
                // Remove the file at the specified index
                record.files.splice(index, 1);
    
                // Update the database
                const updateRequest = store.put(record);
                await new Promise((resolve, reject) => {
                    updateRequest.onsuccess = () => resolve();
                    updateRequest.onerror = () => reject(updateRequest.error);
                });
    
                console.log(`File removed from IndexedDB: Key=${key}, Index=${index}`);
            } else {
                console.warn(`No file found at index ${index} for Key=${key}`);
            }
    
            // Update the UI
            this.updateFilePreviews($uploader, record?.files || []);
        } catch (error) {
            console.error('Error removing file from IndexedDB:', error);
        }
    },    
    // Handle file selection
    async handleFileSelect(files, $uploader) {
        const settings = $uploader.data('settings');
        try {
            let existingFiles = await this.getFiles(settings.moduleId, settings.sectionId) || [];

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

            for (const file of Array.from(files)) {
                if (file.size > settings.maxFileSize * 1024 * 1024) {
                    this.showMessage(`File "${file.name}" exceeds ${settings.maxFileSize}MB limit`, 'warning', $uploader);
                    continue;
                }

                if (existingFiles.some(existing => existing.name === file.name)) {
                    this.showMessage(`File "${file.name}" already exists`, 'warning', $uploader);
                    continue;
                }

                if (file.type.match('image.*')) {
                    const data = await this.readFileAsDataURL(file);
                    existingFiles.push({
                        name: file.name,
                        type: file.type,
                        data: data,
                        size: file.size,
                        timestamp: Date.now()
                    });
                } else if (file.type === 'application/pdf') {
                    existingFiles.push({
                        name: file.name,
                        type: file.type,
                        size: file.size,
                        timestamp: Date.now()
                    });
                }
            }

            await this.saveFiles(settings.moduleId, settings.sectionId, existingFiles);
            this.updateFilePreviews($uploader, existingFiles);

            if (settings.onChange) {
                settings.onChange(existingFiles);
            }
        } catch (error) {
            console.error('Error handling file selection:', error);
            this.showMessage('Error uploading files', 'danger', $uploader);
        }
    },

    // Save files to storage
    async saveFiles(moduleId, sectionId, files) {
        if (!this.db) throw new Error('Database not initialized');
        
        const key = `${moduleId}-${sectionId}`;
        const transaction = this.db.transaction([this.storeName], 'readwrite');
        const store = transaction.objectStore(this.storeName);
        
        return new Promise((resolve, reject) => {
            const request = store.put({
                key,
                files: files.map(file => ({
                    ...file,
                    timestamp: file.timestamp || Date.now()
                }))
            });
            
            request.onsuccess = () => resolve();
            request.onerror = () => reject(request.error);
        });
    },

    // Get files from storage
    async getFiles(moduleId, sectionId) {
        if (!this.db) {
            console.error('Database not initialized');
            return [];
        }
    
        const key = `${moduleId}-${sectionId}`;
        const transaction = this.db.transaction([this.storeName], 'readonly');
        const store = transaction.objectStore(this.storeName);
    
        return new Promise((resolve, reject) => {
            const request = store.get(key);
            request.onsuccess = () => resolve(request.result?.files || []);
            request.onerror = () => reject(request.error);
        });
    },

    // Clear files from storage
    async clearFiles(moduleId, sectionId) {
        if (!this.db) return;
        
        const key = `${moduleId}-${sectionId}`;
        const transaction = this.db.transaction([this.storeName], 'readwrite');
        const store = transaction.objectStore(this.storeName);
        
        return new Promise((resolve, reject) => {
            const request = store.delete(key);
            request.onsuccess = () => resolve();
            request.onerror = () => reject(request.error);
        });
    },

    // Remove a single file
    // async removeFile(index, $uploader) {
    //     const settings = $uploader.data('settings');
    //     try {
    //         let files = await this.getFiles(settings.moduleId, settings.sectionId);
    //         if (files?.length > index) {
    //             files.splice(index, 1);
    //             await this.saveFiles(settings.moduleId, settings.sectionId, files);
    //             this.updateFilePreviews($uploader, files);

    //             if (settings.onChange) {
    //                 settings.onChange(files);
    //             }
    //         }
    //     } catch (error) {
    //         console.error('Error removing file:', error);
    //         this.showMessage('Error removing file', 'danger', $uploader);
    //     }
    // },

    // Update file previews
    async updateFilePreviews($uploader, files) {
        // Always fetch files from IndexedDB
        const settings = $uploader.data('settings');
        files = await this.getFiles(settings.moduleId, settings.sectionId);
        
        // Proceed with preview updates
        const $preview = $uploader.find('.file-preview');
        $preview.empty();
    
        files.forEach((file) => {
            const $item = $('<div>').addClass('file-preview-item');
            if (file.type.startsWith('image/')) {
                $item.append($('<img>').attr('src', file.data));
            } else if (file.type === 'application/pdf') {
                $item.addClass('pdf')
                    .append($('<i>').addClass('bi bi-file-pdf'))
                    .append($('<span>').addClass('file-name').text(file.name));
            }
            $item.append(
                $('<button>')
                    .addClass('remove-file')
                    .html('&times;')
            );
            $preview.append($item);
        });
    },
    

    // Get uploader instance
    getInstance(moduleId, sectionId) {
        return $(`.file-uploader[data-module="${moduleId}"][data-section="${sectionId}"]`);
    },

    // Enable uploader
    enable($uploader) {
        if (!$uploader || !$uploader.length) return;
        
        $uploader.removeClass('disabled')
                .find('.upload-trigger').prop('disabled', false);
        $uploader.find('.file-input').prop('disabled', false);
        $uploader.css({
            'opacity': '',
            'pointer-events': ''
        });
    },

    // Disable uploader
    disable($uploader) {
        if (!$uploader || !$uploader.length) return;
        
        $uploader.addClass('disabled')
                .find('.upload-trigger').prop('disabled', true);
        $uploader.find('.file-input').prop('disabled', true);
        $uploader.css({
            'opacity': '0.6',
            'pointer-events': 'none'
        });
    },

    // Show message
    showMessage(message, type, $uploader) {
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

    // Helper: Read file as data URL
    readFileAsDataURL(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = (e) => resolve(e.target.result);
            reader.onerror = () => reject(reader.error);
            reader.readAsDataURL(file);
        });
    },

    // Helper: Format file size
    formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    },

    // Helper: Clear all files
    async clearAllFiles() {
        if (!this.db) return;
        
        const transaction = this.db.transaction([this.storeName], 'readwrite');
        const store = transaction.objectStore(this.storeName);
        
        return new Promise((resolve, reject) => {
            const request = store.clear();
            request.onsuccess = () => resolve();
            request.onerror = () => reject(request.error);
        });
    }
};

// Add CSS styles
const style = document.createElement('style');
style.textContent = `
    .file-uploader {
        border: 2px dashed #ccc;
        padding: 16px;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .file-uploader.drag-over {
        border-color: #0d6efd;
        background-color: rgba(13, 110, 253, 0.05);
    }
    
    .file-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 1rem;
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
   
    .preview-wrapper {
        display: flex;
        align-items: flex-end;
        gap: 0.5rem;
    }

    .upload-button-container {
        flex-shrink: 0;
    }

    .upload-info {
        margin-top: 0.5rem;
        color: #6c757d;
    }

    .file-uploader.disabled {
        opacity: 0.6;
        pointer-events: none;
    }

    .file-uploader.disabled .upload-trigger {
        opacity: 0.65;
        pointer-events: none;
    }

    .file-uploader.disabled .file-preview-item {
        opacity: 0.7;
    }

    .file-uploader.disabled .remove-file {
        display: none;
    }

    .required-indicator {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .file-uploader.has-error {
        border-color: #dc3545;
    }

    .file-uploader.has-error .upload-trigger {
        border-color: #dc3545;
        color: #dc3545;
    }

    .alert {
        margin-top: 1rem;
    }

    .alert-dismissible .btn-close {
        padding: 0.5rem;
    }
`;

document.head.appendChild(style);

// Export the module
window.FileUploader = FileUploader;