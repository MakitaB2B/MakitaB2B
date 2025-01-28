const ExpenseAppBTC = {
    config: {
        maxHotelAmount: 5000,
        templates: {
            hotel: 'hotel-expense-template',
            travel: 'travel-entry-template',
            misc: 'misc-entry-template'
        },
        expenseTypes: {
            hotel: 'hotelExpenses',
            travel: 'travelExpenses',
            misc: 'miscExpenses'
        }
    },
 
    init() {
        this.state = {
            currentDay: null,
            currentDate: null,
            editing: null
        };
 
        this.bindEvents();
        this.loadInitialData();
        this.updateMainSubmitButton();
        this.updateTripInfo();
    },
 
    bindEvents() {
        // Navigation events
        $('.go-next-step').on('click', () => this.handleNextStep());
        $('.show-date-list').on('click', () => this.toggleDateList(true));
        $('.submit-day-form').on('click', () => this.submitDayForm());
 
        // Expense type buttons
        $('.h-expense, .t-expense, .m-expense').on('click', (e) => this.handleExpenseClick(e));
 
        // Day selection
        $(document).on('click', '.day-button', (e) => this.handleDaySelect(e));
 
        // Modal actions
        const $modal = $('#expenseModal');
        $modal.on('click', '.btn-primary', () => this.handleModalSave());
        $modal.on('hidden.bs.modal', () => {
            this.state.editing = null;
            $modal.find('.modal-body').empty();
        });
 
        // Edit and delete expense events
        $(document).on('click', '.exp-card-btns .fa-pencil', (e) => this.handleExpenseEdit(e));
        $(document).on('click', '.exp-card-btns .fa-trash', (e) => this.handleExpenseDelete(e));

        $(() => {
            $('.main-submit-btn .btn-primary').on('click', async () => {
                if (confirm('Are you sure you want to submit this application?')) {
                    await ExpenseAppBTC.formSubmission.submitForm();
                }
            });
        });
        
        // Clear validation errors on input
        $('input, textarea').on('input', function() {
            $(this).removeClass('is-invalid');
            $(this).closest('.form-group').find('.expense-message').remove();
        });

        // Clear validation errors on datetime picker change
        $('.datetimepicker-input').on('change.datetimepicker', function(e) {
            if (e.date) {
                $(this).removeClass('is-invalid');
                $(this).closest('.form-group').find('.expense-message').remove();
            }
        });
    },
 
    loadInitialData() {
        const state = BTCStateManager.loadState();
        if (state?.dayDetails && Object.keys(state.dayDetails).length > 0) {
            $('.step-container[data-step="1"]').removeClass('active');
            $('.step-container[data-step="2"]').addClass('active');
        }
        if (state?.startDateTime) {
            this.generateDays();
        }
    },
 
    handleNextStep() {
        if (!this.validateRequiredFields()) return;
     
        const currentState = BTCStateManager.loadState();
        const startDate = moment($('input[name="starting_date_time"]').val(), 'DD-MMM-YYYY HH:mm:ss');
        
        const dayDetails = {};
        for(let i = 1; i <= parseInt($(".no-of-days").val()); i++) {
            dayDetails[`Day ${i}`] = {
                date: moment(startDate).add(i-1, 'days').format('DD-MMM-YYYY'),
                hotelExpenses: [],
                travelExpenses: [],
                miscExpenses: [],
                isSubmitted: false
            };
        }
     
        const newState = {
            ...currentState,
            startDateTime: $('input[name="starting_date_time"]').val(),
            endDateTime: $('input[name="bta_ending_datetime"]').val(),
            tripTo: $('input[name="tripTo"]').val(),
            foodExpense: $('.total-food-expense').val() || '0',
            noOfDays: parseInt($(".no-of-days").val()) || 0,
            purposeOfVisit: $('textarea[name="purposeOfVisit"]').val(),
            dayDetails
        };
     
        BTCStateManager.saveCurrentState(newState);
        this.generateDays();
        this.updateTripInfo();
        this.moveToNextStep();
     },
 
     validateRequiredFields() {
        let isValid = true;
        $('.expense-message').remove();
    
        // Store reference to 'this' for use inside jQuery each
        const self = this;
        $('.expense-message').remove();
        $('.is-invalid').removeClass('is-invalid');
    
        $('input[required], textarea[required]').each(function() {
            const $field = $(this);
            if (!$field.val()) {
                isValid = false;
                self.showValidationError($field, 'This field is required!');
            }
        });  
    
        if (!isValid) {
            this.showToast('Please fill in all required fields', 'danger');
        }
    
        return isValid;
    },
    updateTripInfo(){
        const state = BTCStateManager.loadState();
        if (!state) return;

        const $tripInfo = $('.exp-data-wrapper.trip-info');
        
        // Format dates for display
        const startDateTime = state.startDateTime ? moment(state.startDateTime, 'DD-MMM-YYYY HH:mm:ss').format('DD-MMM-YYYY hh:mm A') : '';
        const endDateTime = state.endDateTime ? moment(state.endDateTime, 'DD-MMM-YYYY HH:mm:ss').format('DD-MMM-YYYY hh:mm A') : '';
        const foodExpense = parseFloat(state.foodExpense) || 0;
        
        const tripInfoHTML = `
            <div class="exp-data">
                <span class="exp-title">Starting Date</span>
                <span class="exp-value">${startDateTime}</span>
            </div>
            <div class="exp-data">
                <span class="exp-title">Trip To</span>
                <span class="exp-value">${state.tripTo || 'N/A'}</span>
            </div>
            <div class="exp-data">
                <span class="exp-title">Number of Days</span>
                <span class="exp-value">${state.noOfDays || 0}</span>
            </div>
            <div class="exp-data">
                <span class="exp-title">Ending Date</span>
                <span class="exp-value">${endDateTime}</span>
            </div>
            <div class="exp-data">
                <span class="exp-title">Purpose of Visit</span>
                <span class="exp-value">${state.purposeOfVisit || 'N/A'}</span>
            </div>
            <div class="exp-data">
                <span class="exp-title">Food Expense</span>
                <span class="exp-value">₹${foodExpense.toFixed(2)}</span>
            </div>
        `;

        $tripInfo.html(tripInfoHTML);

    },
 
    handleExpenseClick(e) {
        const $target = $(e.currentTarget);
        let type = this.getExpenseTypeFromButton($target);
        
        if (type) {
            this.showExpenseModal(type);
        }
    },
 
    getExpenseTypeFromButton($target) {
        if ($target.hasClass('h-expense')) return 'hotel';
        if ($target.hasClass('t-expense')) return 'travel';
        if ($target.hasClass('m-expense')) return 'misc';
        return null;
    },
 
    showExpenseModal(type) {
        const state = BTCStateManager.loadState();
        const dayExpenses = state.dayDetails?.[this.state.currentDay]?.[`${type}Expenses`] || [];
        const expenseNumber = this.state.editing !== null ? 
                         parseInt(this.state.editing) + 1 : 
                         dayExpenses.length + 1;
     
        const template = document.getElementById(this.config.templates[type]).content.cloneNode(true);
        const $modal = $('#expenseModal');
        
        const baseTitle = type.charAt(0).toUpperCase() + type.slice(1);
        $modal.find('.modal-title').text(`${baseTitle} Expense #${expenseNumber}`);
        $(template).find('.card-title').text(`${baseTitle} Expense #${expenseNumber}`);
        
        $modal.find('.modal-body').html(template);
        $modal.find('.selected-date').val(this.state.currentDate);
        $modal.find('.selected-day').val(this.state.currentDay);
        
        const fileId = `${type}-expenses-${type}-Day ${this.state.currentDay.split(' ')[1]}-${expenseNumber}`;
        this.initializeModalComponents(type, fileId);
        $modal.modal('show');
     },
 
    initializeModalComponents(type, fileId) {
        this.initializeFileUploader(type, fileId);
        
        if (type === 'travel') {
            this.initializeTransportDropdowns();
            
            $('.starting-meter, .closing-meter').on('input', () => {
                this.calculateFuelCharges();
            });
            
            $('.type-transport-container').on('change', '.dropdown-value', () => {
                if ($('.mode-transport-container .dropdown-value').val() === 'private') {
                    this.calculateFuelCharges();
                }
            });
        } else if (type === 'misc') {
            this.initializeMiscDropdown();
        }
    },
 
    initializeFileUploader(type, fileId) {
        const fileUploaderConfig = {
            moduleId: fileId,
            sectionId: fileId,
            maxFiles: type === 'hotek' ? 3 : 5,
            buttonText: 'Add Receipt',
            uploadIcon: 'bi-receipt',
            acceptedTypes: '.pdf,.jpg,.jpeg,.png',
            container: type === 'hotel' ? '#hotel-attachments' : 
                      type === 'travel' ? '.travel-documents-uploader' : 
                      '.misc-documents-uploader'
        };
 
        FileUploader.init(fileUploaderConfig);
    },
 
    initializeTransportDropdowns() {
        const transportConfig = {
            modes: [
                { value: 'private', text: 'Private Vehicle' },
                { value: 'public', text: 'Public Transport' },
                { value: 'rental', text: 'Rental Vehicle' }
            ],
            types: {
                private: [
                    { value: 'car', text: 'Car' },
                    { value: 'bike', text: 'Bike' }
                ],
                public: [
                    { value: 'bus', text: 'Bus' },
                    { value: 'train', text: 'Train' },
                    { value: 'taxi', text: 'Taxi' }
                ],
                rental: [
                    { value: 'car', text: 'Car' },
                    { value: 'bike', text: 'Bike' }
                ]
            }
        };
 
        DependentDropdown.init({
            parentContainer: '.mode-transport-container',
            childContainer: '.type-transport-container',
            parentData: transportConfig.modes,
            childData: transportConfig.types,
            required: true,
            onChange: (parentValue, childValue) => {
                const $entry = $("#expenseModal .travel-entry");
                this.toggleMeterFields($entry, parentValue === 'private');
                this.toggleFuelChargesLabel($entry, parentValue, childValue);
                this.toggleApprovalUploader($entry, parentValue === 'private' && childValue === 'car');
                $(".expense-message").remove()
            }
        });
        const expenseNumber = parseInt($('.card-title').text().match(/\d+/)[0]);
        const approvalFileId = `travel-expenses-travel-approval-Day-${this.state.currentDay.split(' ')[1]}-${expenseNumber}`;
        
        FileUploader.init({
            container: $("#expenseModal .travel-entry").find('.approval-documents')[0],
            moduleId: 'travel-expenses',
            sectionId: approvalFileId,
            maxFiles: 1,
            required: true,
            buttonText: 'Add Approval Document',
            uploadIcon: 'bi-file-earmark-text'
        });
    },
    toggleFuelChargesLabel($entry, transportMode, transportType) {
        const $fuelLabel = $entry.find('.fuel-charges').prev('label');
        
        if (transportMode === 'public') {
            if (transportType === 'taxi') {
                $fuelLabel.text('Claim');
            } else {
                $fuelLabel.text('Ticket Fare');
            }
        } else {
            $fuelLabel.text('Fuel Charges');
        }
    },
 
    initializeMiscDropdown() {
        const miscTypes = [
            { value: 'parking', text: 'Parking' },
            { value: 'internet', text: 'Internet' },
            { value: 'telephone', text: 'Telephone' },
            { value: 'other', text: 'Other' }
        ];
 
        CustomDropdown.init({
            container: '.expense-type-container',
            data: miscTypes,
            placeholder: 'Select Type',
            required: true,
            onChange: (value) => {
                // Show/hide other text field based on selection
                const $miscEntry = $('.misc-entry');
                const $otherField = $miscEntry.find('.other-expense-field');
                $(".expense-message").remove()
                
                if (value === 'other') {
                    if (!$otherField.length) {
                        const otherField = `
                            <div class="row mb-3 other-expense-field">
                                <div class="col-12 e-grp">
                                    <label class="form-label">Specify Other Expense*</label>
                                    <input type="text" class="form-control other-expense-input" required>
                                </div>
                            </div>
                        `;
                        $miscEntry.find('.expense-type-container').closest('.row').after(otherField);
                    }
                } else {
                    $otherField.remove();
                }
            }
        });
    },
 
    async handleModalSave() {
        const $modal = $('#expenseModal');
        const type = this.getActiveExpenseType($modal);

        // Clear all existing error messages before validation
        $modal.find('.expense-message').remove();
        $modal.find('.is-invalid').removeClass('is-invalid');
        
        if (!await this.validateExpenseForm(type)) {
            return;
        }
    
        const expenseData = await this.collectExpenseData(type);
        await this.saveExpenseData(type, expenseData);
        await BTCStateManager.saveCurrentState();
        
        $modal.modal('hide');
        this.loadDayExpenses();
        this.showToast('Expense saved successfully', 'success');
    },
    validateExpenseForm(type) {
        const validators = {
            hotel: () => this.validateHotelExpense(),
            travel: () => this.validateTravelExpense(),
            misc: () => this.validateMiscExpense()
        };
        return validators[type]();
    },
 
    getActiveExpenseType($modal) {
        if ($modal.find('#hotelRow').length) return 'hotel';
        if ($modal.find('.travel-entry').length) return 'travel';
        if ($modal.find('.misc-entry').length) return 'misc';
        return null;
    },
 
    async validateExpense(type, expenseNumber) {
        const fileId = `${type}-expenses-${type}-Day ${this.state.currentDay.split(' ')[1]}-${expenseNumber}`;
        const status = await FileUploader.getFiles(fileId);
        const currentUploads = $(`.file-uploader[data-section="${fileId}"] .file-preview-item`).length;
    
        return {
            fileId,
            hasFiles: status?.length > 0 || currentUploads > 0,
            files: status || []
        };
    },
 
    async validateHotelExpense() {
        const amount = parseFloat($('#hotelClaim').val()) || 0;
        const expenseNumber = parseInt($('.card-title').text().match(/\d+/)[0]);
        const validation = await this.validateExpense('hotel', expenseNumber);
 
        if (amount <= 0) {
            this.showValidationError('#hotelClaim', 'Please enter a valid amount');
            return false;
        }
        if (amount > this.config.maxHotelAmount) {
            this.showValidationError('#hotelClaim', `Amount cannot exceed ₹${this.config.maxHotelAmount}`);
            return false;
        }
        if (amount > 0 && !validation.hasFiles) {
            this.showValidationError('#hotel-attachments', 'Please attach receipt');
            return false;
        }
        return true;
    },
 
    async validateTravelExpense() {
        const expenseNumber = parseInt($('.card-title').text().match(/\d+/)[0]);
        const validation = await this.validateExpense('travel', expenseNumber);
        const approvalFileId = `travel-expenses-travel-approval-Day-${this.state.currentDay.split(' ')[1]}-${expenseNumber}`;
        const amount = parseFloat($('.fuel-charges').val()) || 0;
        
        const modeOfTransport = $('.mode-transport-container .dropdown-value').val();
        const transportType = $('.type-transport-container .dropdown-value').val();
        
        
        if (!modeOfTransport) {
            this.showValidationError('.mode-transport-container', 'Select transport mode');
            return false;
        }
        if (!transportType) {
            this.showValidationError('.type-transport-container', 'Select transport type');
            return false;
        }
        if (modeOfTransport === 'private' && transportType === 'car') {
            const approvalStatus = await FileUploader.getFiles('travel-expenses', approvalFileId);
            const hasApprovalDoc = approvalStatus?.length > 0 || 
                $(`.file-uploader[data-section="${approvalFileId}"] .file-preview-item`).length > 0;
            
            if (!hasApprovalDoc || approvalStatus?.length === 0) {
                this.showValidationError('.approval-documents', 'Vehicle approval document required');
                return false;
            }

        }
        if (modeOfTransport === 'private' && !this.validateMeterReadings()) {
            return false;
        }
        
        if (modeOfTransport === 'private' && (!parseFloat($('.fuel-charges').val()) || parseFloat($('.fuel-charges').val()) <= 0)) {
            this.showValidationError('.fuel-charges', 'This field is required!');
            return false;
        }
       
        if (!$('#expenseModal .places-visited').val()) {
            this.showValidationError('.places-visited-container', 'Enter places visited');
            return false;
        }

        if (amount > 0 && !validation.hasFiles) {
            this.showValidationError('.file-uploader', 'Please attach receipt');
            return false;
        }      
        
        return true;
    },
 
    async validateMiscExpense() {
        const expenseNumber = parseInt($('.card-title').text().match(/\d+/)[0]);
        const validation = await this.validateExpense('misc', expenseNumber);
 
        const type = $('.expense-type-container .dropdown-value').val();
        const amount = parseFloat($('.claim-amount').val()) || 0;
 
        if (!type) {
            this.showValidationError('.dropdown-value', 'Select expense type');
            return false;
        }
        if (type && amount == 0) {
            this.showValidationError('.claim-amount', 'Enter valid amount');
            return false;
        }
        if (amount > 0 && !validation.hasFiles) {
            this.showValidationError('.file-uploader', 'Attach documents');
            return false;
        }
        return true;
    },
 
    validateMeterReadings() {
        const start = parseFloat($('.starting-meter').val());
        const end = parseFloat($('.closing-meter').val());
        const self = this;
        $('.expense-message').remove();
        $('.is-invalid').removeClass('is-invalid');
    
        $('.starting-meter, .closing-meter,.total-kms').each(function() {
            const $field = $(this);
            if ($field.val() <=0) {
                isValid = false;
                self.showValidationError($field, 'This field is required!');
            }
        }); 

        return true;
    },
    showValidationError(selector, message) {
        const $element = $(selector);
        this.clearValidationError($element);
        $element.addClass('is-invalid');
        // For datetime picker fields
        if ($element.hasClass('datetimepicker-input')) {
            $element.closest('.form-group, .input-group').append(
                `<div class="text-danger expense-message">${message}</div>`
            );
        } 
        // For all other fields
        else {
            $element.closest('.form-group, .e-grp').append(
                `<div class="text-danger expense-message">${message}</div>`
            );
        }
    },
    clearValidationError($element) {
        // Remove invalid class
        $element.removeClass('is-invalid');
        
        // Remove any existing error messages
        $element.closest('.e-grp').find('.expense-message').remove();
    },
 
    async collectExpenseData(type) {
        const expenseNumber = parseInt($('.card-title').text().match(/\d+/)[0]);
        const fileId = `${type}-expenses-${type}-Day ${this.state.currentDay.split(' ')[1]}-${expenseNumber}`;
        const validation = await this.validateExpense(type, expenseNumber);
        let miscType = $('.expense-type-container .dropdown-value').val();
        let otherType = $(".other-expense-input").val() || 0;
 
        const collectors = {
            hotel: async () => ({
                number: expenseNumber,
                amount: parseFloat($('#hotelClaim').val() || 0).toString(),
                files: validation.files,
                fileId
            }),
            travel: async () => ({
                number: expenseNumber,
                modeOfTransport: $('.mode-transport-container .dropdown-value').val(),
                transportType: $('.type-transport-container .dropdown-value').val(),
                startingMeter: $('.starting-meter').val(),  
                closingMeter: $('.closing-meter').val(),
                totalKms: $('.total-kms').val(),
                tollCharges: $('.toll-charges').val(),
                fuelCharges: $('.fuel-charges').val(),
                placesVisited: $('#expenseModal .places-visited').val() || '',
                files: validation.files,
                fileId
            }),
            misc: async () => ({
                number: expenseNumber,
                type: miscType!='other'?miscType:otherType,
                amount: parseFloat($('.claim-amount').val() || 0).toString(),
                files: validation.files,
                fileId
            })
        };
 
        return collectors[type]();
    },
 
    saveExpenseData(type, data) {
        const state = BTCStateManager.loadState();
        const typeKey = this.config.expenseTypes[type];
        const dayKey = `Day ${this.state.currentDay.split(' ')[1]}`;
     
        if (!state.dayDetails) {
            state.dayDetails = {};
        }
     
        if (!state.dayDetails[dayKey]) {
            state.dayDetails[dayKey] = {
                date: this.state.currentDate,
                hotelExpenses: [],
                travelExpenses: [],
                miscExpenses: [],
                isSubmitted: false
            };
        }
     
        if (!Array.isArray(state.dayDetails[dayKey][typeKey])) {
            state.dayDetails[dayKey][typeKey] = [];
        }
     
        if (this.state.editing !== null) {
            state.dayDetails[dayKey][typeKey][this.state.editing] = data;
        } else {
            state.dayDetails[dayKey][typeKey].push(data);
        }
     
        BTCStateManager.saveCurrentState(state);
    },

    handleDaySelect(e) {
        const $button = $(e.currentTarget);
        $('.day-button').removeClass('selected');
        $button.addClass('selected');

        this.state.currentDay = $button.find('.day-number').text();
        this.state.currentDate = $button.find('.day-date').text();

        this.clearExpenseForm(); 
        this.loadDayExpenses();
        this.updateMainSubmitButton();
    },

    loadDayExpenses() {
        const state = BTCStateManager.loadState();
        this.toggleDateList(false);
        this.updateTripInfo();

        if (state?.dayDetails?.[this.state.currentDay]) {
            this.displayExpenses(state.dayDetails[this.state.currentDay]);
        } else {
            $('.exp-wrapper').hide();
            $('.hotel-exp-data, .misc-exp-data, .travel-exp-data').hide();
        }
    },

    displayExpenses(dayData) {
        const $wrapper = $('.exp-wrapper').show();
        $('.exp-wrapper > .exp-card-title').html(`${this.state.currentDay} : ${this.state.currentDate}`);
        
        // Show/hide expense sections based on data
        const hotelHasData = this.toggleExpenseSection('hotel', dayData.hotelExpenses);
        const travelHasData = this.toggleExpenseSection('travel', dayData.travelExpenses);
        const miscHasData = this.toggleExpenseSection('misc', dayData.miscExpenses);
        if (hotelHasData || travelHasData || miscHasData) {
            $wrapper.show();
            $(".top-header-section").removeClass("simple-header")
        } else {
            $wrapper.hide();
            $(".top-header-section").addClass("simple-header")
        }
        
        
        $('.exp-details-box').show();
    },

    toggleExpenseSection(type, expenses) {
        const $section = $(`.${type}-exp-data`);
        const $button = $(`.${type[0]}-expense`);
        
        if (!expenses?.length) {
            $section.hide();
            $(".top-header-section").addClass("simple-header")
            $button.closest('.expense-details-g').removeClass('extended');
            $button.find('.icon').html('<i class="fa-solid fa-plus"></i>');
            $button.find('.btn-txt').html(`Add ${type.charAt(0).toUpperCase() + type.slice(1)} Expense`);
            return false;
        }
        $section.show();
        this.updateExpenseSection(type, expenses);
        return true;
    },

    updateExpenseSection(type, expenses) {
        
        const $section = $(`.${type}-exp-data`);
        const $button = $(`.${type[0]}-expense`);
        const $content = type === 'travel' ? 
            $section.find('.row-body') : 
            $section.find('.exp-data-container');

        if (!expenses?.length) {
            $section.hide();
            $button.closest('.expense-details-g').removeClass('extended');
            $button.find('.icon').html('<i class="fa-solid fa-plus"></i>');
            $button.find('.btn-txt').html(`Add ${type.charAt(0).toUpperCase() + type.slice(1)} Expense`);
            return;
        }

        $section.show();
        $button.closest('.expense-details-g').addClass('extended');
        $button.find('.icon').html('<i class="fa-solid fa-check-double"></i>');
        $button.find('.btn-txt').html(`Add More ${type.charAt(0).toUpperCase() + type.slice(1)} Expense`);

        $content.empty();
        expenses.forEach((expense, index) => this.renderExpense(type, expense, index, $content));
    },

    async loadExpenseForEdit(type, index) {
        const state = BTCStateManager.loadState();
        const typeKey = this.config.expenseTypes[type];
        const expense = state.dayDetails[this.state.currentDay][typeKey][index];

        this.state.editing = index;
        this.showExpenseModal(type);

        setTimeout(() => {
            this.populateExpenseForm(type, expense);
        }, 100);
    },

    renderExpense(type, expense, index, $container) {
        const templates = {
            hotel: (expense, index) => `
                <div class="exp-data" data-index="${index}" data-fileid="${expense.fileId}">
                    <span class="exp-value">Hotel Fare</span>
                    <span class="exp-value">₹${expense.amount}</span>
                    <span class="exp-bill-copy"><a href="javascript:;" title="test">
                <i class="fa-solid fa-file"></i>
            </a></span>
                    ${this.renderActionButtons()}
                </div>
            `,
            travel: (expense, index) => `
                <div class="exp-row" data-index="${index}" data-fileid="${expense.fileId}">
                    <span class="exp-value">
                        <span class="exp-title">Travel Expense #${expense.number}</span>
                        ${expense.modeOfTransport} - ${expense.transportType}
                    </span>
                    <span class="exp-value">
                        <span class="exp-title">Starting Meter</span>
                        ${expense.startingMeter || 0}
                    </span>
                    <span class="exp-value">
                        <span class="exp-title">Closing Meter</span>
                        ${expense.closingMeter || 0}
                    </span>
                    <span class="exp-value">
                        <span class="exp-title">Places Visited</span>
                        ${expense.placesVisited || 'N/A'}
                    </span>
                    <span class="exp-value">
                        <span class="exp-title">Fuel Charges</span>
                        ₹${expense.fuelCharges || 0}
                    </span>
                    <span class="exp-value">    
                        <span class="exp-title">Toll Charges</span>
                        ₹${expense.tollCharges || 0}
                    </span>
                    <span class="exp-bill-copy">
                        <a href="javascript:;" title="test">
                <i class="fa-solid fa-file"></i>
            </a>
                    </span>
                    ${this.renderActionButtons()}
                </div>
            `,
            misc: (expense, index) => `
                <div class="exp-data" data-index="${index}" data-fileid="${expense.fileId}">
                    <span class="exp-title">${expense.type!='other'?expense.type:expense.otherType}</span>
                    <span class="exp-value">₹${expense.amount}</span>
                    <span class="exp-bill-copy"><a href="javascript:;" title="test">
                <i class="fa-solid fa-file"></i>
            </a></span>
                    ${this.renderActionButtons()}
                </div>
            `
        };

        $container.append(templates[type](expense, index));
    },
    renderFileLinks(files) {
        return (files || [])
            .map(file => `
                <a href="javascript:;" title="${file.name}">
                    <i class="fa-solid fa-file"></i>
                </a>
            `).join('');
    },

    renderActionButtons() {
        return `
            <span class="exp-card-btns">
                <span class="o-icons">
                    <a href="javascript:;"><i class="fa-solid fa-pencil"></i></a>
                    <a href="javascript:;"><i class="fa-solid fa-trash"></i></a>
                </span>
                <span class="a-icons">
                    <a href="javascript:;"><i class="fa-solid fa-check-double"></i></a>
                    <a href="javascript:;"><i class="fa-solid fa-close"></i></a>
                </span>
            </span>
        `;
    },
    handleExpenseEdit(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const $target = $(e.target);
        const $expenseElement = $target.closest('.exp-data, .exp-row');
        const index = $expenseElement.data('index');
        const type = this.getExpenseType($expenseElement);
        
        if (type) {
            this.loadExpenseForEdit(type, index);
        }
    },

    handleExpenseDelete(e) {
        e.preventDefault();
        e.stopPropagation();

        if (!confirm('Are you sure you want to delete this expense?')) {
            return;
        }
        
        const $target = $(e.target);
        const $expenseElement = $target.closest('.exp-data, .exp-row');
        const index = $expenseElement.data('index');
        const type = this.getExpenseType($expenseElement);
        
        if (type) {
            this.deleteExpense(type, index);
        }
    },

    getExpenseType($element) {
        const $wrapper = $element.closest('.exp-data-wrapper');
        if ($wrapper.hasClass('hotel-exp-data')) return 'hotel';
        if ($wrapper.hasClass('travel-exp-data')) return 'travel';
        if ($wrapper.hasClass('misc-exp-data')) return 'misc';
        return null;
    },

    deleteExpense(type, index) {
        const state = BTCStateManager.loadState();
        const typeKey = this.config.expenseTypes[type];
        
        if (state.dayDetails?.[this.state.currentDay]?.[typeKey]) {
            state.dayDetails[this.state.currentDay][typeKey].splice(index, 1);
            BTCStateManager.saveCurrentState(state);
            
            this.loadDayExpenses();
            this.showToast('Expense deleted successfully', 'success');
        }
    },
    populateExpenseForm(type, expense) {
        const populators = {
            hotel: () => $('#hotelClaim').val(expense.amount),
            travel: () => {           
                $(`.mode-transport-container .select-option[data-value="${expense.modeOfTransport}"]`).click();
                $(`.type-transport-container .select-option[data-value="${expense.transportType}"]`).click();
                $('.starting-meter').val(expense.startingMeter || 0);
                $('.closing-meter').val(expense.closingMeter || 0);
                $('.total-kms').val(expense.totalKms || 0);
                $('.toll-charges').val(expense.tollCharges || 0);
                $('.fuel-charges').val(expense.fuelCharges || 0);
                $('.places-visited').val(expense.placesVisited || '');
            },
            misc: () => {
                $('.claim-amount').val(expense.amount || 0);
                CustomDropdown.setValue('.expense-type-container', expense.type);
            }
        };

        populators[type]();
        
        if (expense.files?.length) {
            const config = {
                moduleId: expense.fileId,
                sectionId: expense.fileId,
                maxFiles: type === 'hotel' ? 3 : 5,
                buttonText: 'Add Receipt',
                uploadIcon: 'bi-receipt',
                acceptedTypes: '.pdf,.jpg,.jpeg,.png',
                container: type === 'hotel' ? '#hotel-attachments' : 
                        type === 'travel' ? '.travel-documents-uploader' : 
                        '.misc-documents-uploader'
            };
            
            FileUploader.init(config);
            setTimeout(() => {
                FileUploader.saveFiles(expense.fileId, expense.fileId, expense.files);
            }, 200);
        }
    },

    toggleApprovalUploader($entry, show) {
        const $approvalSection = $entry.find('.approval-documents-section');
        if (show) {
            $approvalSection.show();
            $approvalSection.find('input').prop('required', true);
        } else {
            $approvalSection.hide();
            $approvalSection.find('input').prop('required', false);
        }
    },

    toggleMeterFields($entry, show) {
        const $meterRow = $entry.find('.meter-fields-row');
        if (show) {
            $meterRow.css("display","flex");
            $meterRow.find('.starting-meter').val('0');
            $meterRow.find('.closing-meter').val('0');
            $meterRow.find('.total-kms').val('0');
        } else {
            $meterRow.hide();
            $meterRow.find('.starting-meter').val('');
            $meterRow.find('.closing-meter').val('');
            $meterRow.find('.total-kms').val('');
        }
    },

    calculateFuelCharges() {
        const modeOfTransport = $('.mode-transport-container .dropdown-value').val();
        if (modeOfTransport === 'private') {
            const transportType = $('.type-transport-container .dropdown-value').val();
            const startingMeter = parseFloat($('.starting-meter').val()) || 0;
            const closingMeter = parseFloat($('.closing-meter').val()) || 0;
            let totalKms, ratePerKm ;

            if(closingMeter > startingMeter){
                totalKms = closingMeter - startingMeter;
                ratePerKm = transportType === 'car' ? 8 : 6;
                $('.closing-meter').removeClass('is-invalid')
                $('.closing-meter').closest('.e-grp').find('.expense-message').remove();
            } else{
                totalKms = 0;
                this.showValidationError('.closing-meter', 'Closing meter should be greater than starting meter');
            }
            
            $('.total-kms').val(totalKms).removeClass('is-invalid');
            $('.total-kms').closest('.e-grp').find('.expense-message').remove();
            $('.fuel-charges').val(totalKms * ratePerKm).removeClass('is-invalid');
        }
    },

    clearExpenseForm() {
        $('#hotelClaim').val('');
        $('.claim-amount').val('');
        $('.starting-meter, .closing-meter, .total-kms, .toll-charges, .fuel-charges').val('0');
        $('.places-visited').val('');
        $('.dropdown-value').val('');
        $('.select-trigger').text('Select');
    },

    submitDayForm() {
        if (!confirm('Are you sure you want to submit this day\'s expenses?')) {
            return;
        }

        const state = BTCStateManager.loadState();
        if (state?.dayDetails?.[this.state.currentDay]) {
            state.dayDetails[this.state.currentDay].isSubmitted = true;
            BTCStateManager.saveCurrentState(state);
            this.toggleDateList(true);
            this.generateDays();
            this.showToast('Day expenses submitted successfully', 'success');
            this.updateMainSubmitButton();
        }
    },

    updateMainSubmitButton() {
        const state = BTCStateManager.loadState();
        const allDaysSubmitted = Object.values(state.dayDetails).every(day => day.isSubmitted);
        
        $('.main-submit-btn').toggle(allDaysSubmitted);
    },

    validateAllDaysHaveExpenses() {
        const state = BTCStateManager.loadState();
        const { dayDetails, noOfDays } = state;

        for (let i = 1; i <= noOfDays; i++) {
            const day = `Day ${i}`;
            const details = dayDetails[day];
            
            if (!details) {
                this.showToast(`${day} has no expenses recorded`, 'error');
                return false;
            }

            const hasExpenses = (details.hotelExpenses?.length > 0) ||
                                (details.travelExpenses?.length > 0) ||
                                (details.miscExpenses?.length > 0);

            if (!hasExpenses) {
                this.showToast(`${day} has no expenses recorded`, 'error');
                return false;
            }

            if (!details.isSubmitted) {
                this.showToast(`${day} expenses not yet submitted`, 'error');
                return false;
            }
        }

        return true;
    },





    showToast(message, type = 'info') {
        const toast = `
            <div class="toast align-items-center text-white bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;

        const $toast = $(toast).appendTo('.toast-container');
        const bsToast = new bootstrap.Toast($toast, {
            autohide: true,
            delay: 3000
        });
        
        bsToast.show();
        $toast.on('hidden.bs.toast', function() {
            $(this).remove();
        });
    },

    generateDays() {
        const state = BTCStateManager.loadState();
        if (!state?.startDateTime) {
            $('#daysContainer').empty();
            return;
        }

        const startDate = moment(state.startDateTime, 'DD-MMM-YYYY HH:mm:ss');
        const $container = $('#daysContainer').empty();

        for (let i = 0; i < state.noOfDays; i++) {
            const currentDate = moment(startDate).add(i, 'days');
            const formattedDate = currentDate.format('DD-MMM-YYYY');
            const dayNo = `Day ${i + 1}`;
            const isSubmitted = state.dayDetails?.[dayNo]?.isSubmitted;

            $container.append(this.createDayButton(dayNo, formattedDate, isSubmitted));
        }
    },

    createDayButton(dayNo, formattedDate, isSubmitted) {
        return `
            <button class="day-button date-card ${isSubmitted ? 'selected' : ''}">
                <div class="icon-wrapper">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </div>
                <div class="content">
                    <div class="day day-number">${dayNo}</div>
                    <div class="date day-date">${formattedDate}</div>
                </div>
                <div class="status-icon" style="display:${isSubmitted ? '' : 'none'}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </div>
            </button>
        `;
    },

    toggleDateList(show) {
        $('.day-details-box').toggle(show);
        $('.exp-details-box').toggle(!show);
        if (show) {
            $('.exp-wrapper').hide();
        }
    },

    moveToNextStep() {
        const $current = $('.step-container.active');
        const currentStep = $current.data('step');
        const nextStep = currentStep + 1;

        $current.removeClass('active');
        $(`.step[data-step="${currentStep}"]`).removeClass('active');
        $(`.step-container[data-step="${nextStep}"], .step[data-step="${nextStep}"]`).addClass('active');
    },

    getModalTitle(type) {
        const titles = {
            hotel: 'Add Hotel Expense',
            travel: 'Add Travel Expense',
            misc: 'Add Miscellaneous Expense'
        };
        return this.state.editing !== null ? 
            `Edit ${titles[type].substring(4)}` : 
            titles[type];
    },
    /**
     * Submission handler for ExpenseAppBTC
     */
    formSubmission: {
        async prepareFormData() {
            try {
                console.log('============ STARTING FORM DATA PREPARATION ============');
                const formData = new FormData();
                const state = BTCStateManager.loadState();
                console.log('Loaded state:', state);
    
                // Add basic form fields
                const basicFields = {
                    startDateTime: state.startDateTime,
                    endDateTime: state.endDateTime,
                    tripTo: state.tripTo,
                    foodExpense: state.foodExpense,
                    noOfDays: state.noOfDays,
                    purposeOfVisit: state.purposeOfVisit
                };
    
                // Add basic fields to formData
                Object.entries(basicFields).forEach(([key, value]) => {
                    formData.append(key, value || '');
                    console.log(`Added ${key}:`, value);
                });
    
                // Process each day's expenses
                console.log('\nDay Details:');
                for (const [day, details] of Object.entries(state.dayDetails)) {
                    console.log(`\n${day}:`);
                    // Add day details
                    console.log(`Date: ${details.date}`);
                    console.log(`Submitted: ${details.isSubmitted}`);
                    formData.append(`dayDetails[${day}]`, JSON.stringify({
                        date: details.date,
                        isSubmitted: details.isSubmitted
                    }));

                    // Handle hotel expenses
                    await this.appendExpenseFiles(formData, day, 'hotel', details.hotelExpenses);
    
                    // Handle travel expenses with special handling for approval docs
                    await this.appendTravelExpenses(formData, day, details.travelExpenses);
    
                    // Handle misc expenses
                    await this.appendExpenseFiles(formData, day, 'misc', details.miscExpenses);


                    // Hotel expenses
                    if (details.hotelExpenses?.length) {
                        console.log(`\nHotel Expenses (${details.hotelExpenses.length}):`);
                        details.hotelExpenses.forEach((exp, i) => {
                            console.log(`  Expense #${i + 1}:`);
                            console.log(`  - Amount: ${exp.amount}`);
                            console.log(`  - Number: ${exp.number}`);
                        });
                    }

                    // Travel expenses
                    if (details.travelExpenses?.length) {
                        console.log(`\nTravel Expenses (${details.travelExpenses.length}):`);
                        details.travelExpenses.forEach((exp, i) => {
                            console.log(`  Expense #${i + 1}:`);
                            console.log(`  - Mode: ${exp.modeOfTransport}`);
                            console.log(`  - Type: ${exp.transportType}`);
                            console.log(`  - Starting Meter: ${exp.startingMeter}`);
                            console.log(`  - Closing Meter: ${exp.closingMeter}`);
                            console.log(`  - Total KMs: ${exp.totalKms}`);
                            console.log(`  - Fuel Charges: ${exp.fuelCharges}`);
                            console.log(`  - Toll Charges: ${exp.tollCharges}`);
                            console.log(`  - Places: ${exp.placesVisited}`);
                        });
                    }

                    // Misc expenses
                    if (details.miscExpenses?.length) {
                        console.log(`\nMisc Expenses (${details.miscExpenses.length}):`);
                        details.miscExpenses.forEach((exp, i) => {
                            console.log(`  Expense #${i + 1}:`);
                            console.log(`  - Type: ${exp.type}`);
                            console.log(`  - Amount: ${exp.amount}`);
                        });
                    }             
    
                    
                }


                 // Log files being added
                console.log('\nFILES:');
                for (const [key, value] of formData.entries()) {
                    if (value instanceof File) {
                        console.log(`${key}: ${value.name} (${this.formatFileSize(value.size)})`);
                    }
                }

                console.log('\n========== FORM DATA PREPARATION COMPLETE ==========');
    
                return formData;
            } catch (error) {
                console.error('Error preparing form data:', error);
                throw error;
            }
        },

        async appendExpenseFiles(formData, day, type, expenses) {
            if (!expenses?.length) return;
    
            // Add expense data without file content
            formData.append(`${type}Expenses[${day}]`, JSON.stringify(
                expenses.map(exp => ({
                    ...exp,
                    files: undefined // Remove file data from JSON
                }))
            ));
    
            // Add files separately
            for (let i = 0; i < expenses.length; i++) {
                const expense = expenses[i];
                const files = await FileUploader.getFiles(`${type}-expenses`, expense.fileId);
                
                if (files?.length) {
                    files.forEach((file, j) => {
                        formData.append(
                            `${type}_files_${day}_${i + 1}[]`, 
                            file
                        );
                    });
                }
            }
        },

        async appendTravelExpenses(formData, day, expenses) {
            if (!expenses?.length) return;
    
            // Add travel expense data without file content
            formData.append(`travelExpenses[${day}]`, JSON.stringify(
                expenses.map(exp => ({
                    ...exp,
                    files: undefined,
                    approvalDoc: undefined
                }))
            ));
    
            // Add regular travel files and approval documents
            for (let i = 0; i < expenses.length; i++) {
                const expense = expenses[i];
                
                // Regular travel documents
                const files = await FileUploader.getFiles('travel-expenses', expense.fileId);
                if (files?.length) {
                    files.forEach(file => {
                        formData.append(
                            `travel_files_${day}_${i + 1}[]`, 
                            file
                        );
                    });
                }
    
                // Approval document if exists
                if (expense.modeOfTransport === 'private' && expense.transportType === 'car') {
                    const approvalFiles = await FileUploader.getFiles(
                        'travel-expenses',
                        `travel-approval-Day-${day.split(' ')[1]}-${i + 1}`
                    );
                    if (approvalFiles?.length) {
                        formData.append(
                            `travel_approval_${day}_${i + 1}`,
                            approvalFiles[0]
                        );
                    }
                }
            }
        },
        formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        },

        // Submit form
        async submitForm() {
            const submitBtn = $('.main-submit-btn .btn-primary');
            
            try {
                // Show loading state
                submitBtn.prop('disabled', true)
                        .html('<span class="spinner-border spinner-border-sm me-2"></span>Submitting...');
    
                const formData = await this.prepareFormData();
                
                // Get CSRF token from meta tag
                const token = $('meta[name="csrf-token"]').attr('content');
    
                // Make AJAX request
                const response = await $.ajax({
                    url: '/api/travel-expenses/submit',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    xhr: () => {
                        const xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener('progress', (evt) => {
                            if (evt.lengthComputable) {
                                const percent = Math.round((evt.loaded / evt.total) * 100);
                                submitBtn.html(
                                    `<span class="spinner-border spinner-border-sm me-2"></span>Uploading ${percent}%`
                                );
                            }
                        }, false);
                        return xhr;
                    }
                });
    
                ExpenseAppBTC.showToast('Application submitted successfully', 'success');
    
                // Clear application state
                await BTCStateManager.clearAllData();
                
                // Redirect to success page after short delay
                setTimeout(() => {
                    window.location.href = '/travel-claims';
                }, 2000);
    
            } catch (error) {
                console.error('Submission error:', error);
                ExpenseAppBTC.showToast(
                    error.responseJSON?.message || 'Error submitting application',
                    'danger'
                );
                
                // Reset button
                submitBtn.prop('disabled', false)
                        .html('Submit Application');
            }
        }
    }

};
const ExpenseFileHandler = {
    async getFileStatus(moduleId, sectionId) {
        const files = await FileUploader.getFiles(moduleId, sectionId) || [];
        const $uploader = $(`.file-uploader[data-module="${moduleId}"][data-section="${sectionId}"]`);
        const currentUploads = $uploader.find('.file-preview-item').length;
        
        return {
            saved: files,
            current: currentUploads,
            total: files.length + currentUploads,
            hasFiles: files.length > 0 || currentUploads > 0
        };
    },

    async validateFiles(type, data) {
        const fileId = `${type}-${data.dayNo}-${data.id || Date.now()}`;
        const status = await this.getFileStatus(`${type}-expenses`, fileId);
        
        if (data.requiresFiles && !status.hasFiles) {
            return { valid: false, message: 'Please attach receipt' };
        }
        
        return { valid: true, files: status.saved };
    }
};

// Export for use in other modules
window.ExpenseAppBTC = ExpenseAppBTC;