/**
 * Expense Management System
 */
const ExpenseAppBTC = {
    // Main configuration object
    config: {
        maxFoodAmount: 1500,
        templates: {
            food: 'food-expense-template',
            travel: 'travel-entry-template',
            misc: 'misc-entry-template'
        },
        expenseTypes: {
            food: 'foodExpenses',
            travel: 'travelExpenses',
            misc: 'miscExpense'
        }
    },

    // Initialize the application
    // Configuration for boolean dropdowns
    booleanOptions: [
        {value: 1, text: 'Pre Approved'},
        {value: 0, text: 'Need Approval'}
    ],

    init() {
        this.state = {
            currentDay: null,
            currentDate: null,
            editing: null
        };

        this.setupDateTimePickers();
        this.initializePreApprovedDropdown();
        this.bindEvents();
        this.loadInitialData();
    },

    // Initialize Pre-Approved dropdown
    initializePreApprovedDropdown() {
        CustomDropdown.init({
            container: '.pre-approved',
            data: this.booleanOptions,
            placeholder: 'Select One'
        });
    },

    // Set up date time pickers
    setupDateTimePickers() {
        const dateConfig = {
            format: 'DD-MMM-YYYY HH:mm:ss',
            useCurrent: false,
            maxDate: moment(),
            icons: { time: 'far fa-clock' }
        };

        $('#startDateTime, #endDateTime').datetimepicker(dateConfig);

        $("#startDateTime").on("change.datetimepicker", (e) => {
            $('#endDateTime').datetimepicker('minDate', e.date);
            this.calculateDays();
        });

        $("#endDateTime").on("change.datetimepicker", (e) => {
            $('#startDateTime').datetimepicker('maxDate', e.date || moment());
            this.calculateDays();
        });
    },

    // Bind all event listeners
    bindEvents() {
        // Navigation events
        $('.go-next-step').on('click', () => this.handleNextStep());
        $('.show-date-list').on('click', () => this.toggleDateList(true));
        $('.submit-day-form').on('click', () => this.submitDayForm());

        // Expense type buttons
        $('.f-expense, .t-expense, .m-expense').on('click', (e) => this.handleExpenseClick(e));

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
    },

    // Load initial data from storage
    loadInitialData() {
        const data = this.getStoredData();
        if (data?.startingDT) {
            this.generateDays();
        }
    },

    // Calculate number of days between start and end dates
    calculateDays() {
        const startingDT = new Date($('input[name="starting_date_time"]').val());
        const endingDT = new Date($('input[name="bta_ending_datetime"]').val());
        
        if (isNaN(startingDT.getTime()) || isNaN(endingDT.getTime())) {
            return;
        }

        // Calculate the total difference in days
        let noOfDays = Math.floor((endingDT - startingDT) / (1000 * 60 * 60 * 24));

        // Check if the start time is before 9 PM
        const startHour = startingDT.getHours();
        const startMinutes = startingDT.getMinutes();
        if (startHour < 21 || (startHour === 21 && startMinutes === 0)) {
            noOfDays += 1; // Count start day
        }

        // Check if the end time is exactly 6 AM
        const endHour = endingDT.getHours();
        const endMinutes = endingDT.getMinutes();
        if (endHour === 6 && endMinutes === 0) {
            noOfDays += 1; // Count end day
        }

        $(".no-of-days").val(noOfDays);
        return noOfDays;
    },

    // Handle next step button click
    handleNextStep() {
        if (!this.validateRequiredFields()) {
            return;
        }

        const expenseDetails = {
            startingDT: new Date($('input[name="starting_date_time"]').val()),
            endingDT: new Date($('input[name="bta_ending_datetime"]').val()),
            visitedPlace: $('input[name="visitedPlace"]').val() || 'NA',
            preApproved: $('.pre-approved .dropdown-value').val() || '0',
            noOfDays: parseInt($(".no-of-days").val()) || 0,
            purposeVisit: $('textarea[name="purposeVisit"]').val() || 'NA',
            claimData: {}
        };

        this.saveData(expenseDetails);
        this.generateDays();
        this.moveToNextStep();
    },

    // Validate required fields
    validateRequiredFields() {
        let isValid = true;
        $('.expense-message').remove();

        $('input[required], textarea[required]').each(function() {
            if (!$(this).val()) {
                isValid = false;
                $(this).closest('.e-grp')
                    .append('<small class="text-danger expense-message">This field is required!</small>');
            }
        });

        return isValid;
    },

    // Handle expense type button click
    handleExpenseClick(e) {
        const $target = $(e.currentTarget);
        let type;

        if ($target.hasClass('f-expense') || $target.parent().hasClass('f-expense')) {
            type = 'food';
        } else if ($target.hasClass('t-expense') || $target.parent().hasClass('t-expense')) {
            type = 'travel';
        } else if ($target.hasClass('m-expense') || $target.parent().hasClass('m-expense')) {
            type = 'misc';
        }

        if (type) {
            this.showExpenseModal(type);
        }
    },

    // Show expense modal
    showExpenseModal(type) {
        const template = document.getElementById(this.config.templates[type]).content.cloneNode(true);
        const $modal = $('#expenseModal');
        
        $modal.find('.modal-title').text(this.getModalTitle(type));
        $modal.find('.modal-body').html(template);
        $modal.find('.selected-date').val(this.state.currentDate);
        $modal.find('.selected-day').val(this.state.currentDay);
        
        this.initializeModalComponents(type);
        $modal.modal('show');
    },

    // Get modal title based on expense type
    getModalTitle(type) {
        const titles = {
            food: 'Food Expense Form',
            travel: 'Travel Expense Form',
            misc: 'Miscellaneous Expense Form'
        };
        return titles[type];
    },

    // Initialize modal components
    initializeModalComponents(type) {
        const config = {
            maxFiles: type === 'food' ? 3 : 5,
            buttonText: 'Add Receipt',
            uploadIcon: 'bi-receipt'
        };

        const containers = {
            food: '#food-attachments',
            travel: '.travel-documents-uploader',
            misc: '.misc-documents-uploader'
        };

        FileUploader.init({
            ...config,
            container: containers[type]
        });

        if (type === 'travel') {
            this.initializeTransportDropdowns();
        } else if (type === 'misc') {
            this.initializeMiscDropdown();
        }
    },

    // Initialize transport dropdowns
    initializeTransportDropdowns() {
        const modeData = [
            { value: 'private', text: 'Private Vehicle' },
            { value: 'public', text: 'Public Transport' },
            { value: 'rental', text: 'Rental Vehicle' }
        ];

        const typeData = {
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
        };

        CustomDropdown.init({
            container: '.mode-transport-container',
            data: modeData,
            placeholder: 'Select Mode'
        });

        $('.mode-transport-container').on('change', '.dropdown-value', function() {
            const selectedMode = $(this).val();
            CustomDropdown.init({
                container: '.type-transport-container',
                data: typeData[selectedMode] || [],
                placeholder: 'Select Type'
            });
        });
    },

    // Initialize miscellaneous expense dropdown
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
            placeholder: 'Select Type'
        });
    },

    // Handle day selection
    handleDaySelect(e) {
        const $button = $(e.currentTarget);
        $('.day-button').removeClass('selected');
        $button.addClass('selected');

        const dayText = $button.find('.day-number').text();
        const dateText = $button.find('.day-date').text();

        this.state.currentDay = dayText;
        this.state.currentDate = dateText;

        this.loadDayExpenses();
    },

    // Load expenses for selected day
    loadDayExpenses() {
        const data = this.getStoredData();
        this.toggleDateList(false);

        if (data?.claimData?.[this.state.currentDay]) {
            this.displayExpenses(data.claimData[this.state.currentDay]);
        } else {
            $('.exp-wrapper').hide();
        }
    },

    // Display expenses
    displayExpenses(dayData) {
        const $wrapper = $('.exp-wrapper').show();
        $wrapper.find('.exp-card-title').html(`${this.state.currentDay} : ${dayData.date}`);
        
        // Make sure state is updated
        $('.selected-date').val(dayData.date);
        $('.selected-day').val(this.state.currentDay);
        
        // Update each expense type
        this.updateExpenseSection('food', dayData.foodExpenses);
        this.updateExpenseSection('travel', dayData.travelExpenses);
        this.updateExpenseSection('misc', dayData.miscExpense);
        
        // Show expense details box
        $('.exp-details-box').show();
    },

    // Update expense section
    updateExpenseSection(type, expenses) {
        const $section = $(`.${type}-exp-data`);
        const $button = $(`.${type[0]}-expense`);
        const $content = type === 'travel' ? 
            $section.find('.row-body') : 
            $section.find('.exp-data-container');

        if (!expenses?.length) {
            $section.removeClass('display-block');
            $button.closest('.expense-details-g').removeClass('extended');
            $button.find('.icon').html('<i class="fa-solid fa-plus"></i>');
            $button.find('.btn-txt').html(`Add ${type.charAt(0).toUpperCase() + type.slice(1)} Expense`);
            return;
        }

        $section.addClass('display-block');
        $button.closest('.expense-details-g').addClass('extended');
        $button.find('.icon').html('<i class="fa-solid fa-check-double"></i>');
        $button.find('.btn-txt').html(`Add More ${type.charAt(0).toUpperCase() + type.slice(1)} Expense`);

        $content.empty();
        expenses.forEach((expense, index) => {
            let html;
            switch(type) {
                case 'food':
                    html = this.renderFoodExpense(expense, index);
                    break;
                case 'travel':
                    html = this.renderTravelExpense(expense, index);
                    break;
                case 'misc':
                    html = this.renderMiscExpense(expense, index);
                    break;
            }
            $content.append(html);
        });
    },

    // Render expense HTML
    renderExpense(type, expense, index) {
        const renderers = {
            food: this.renderFoodExpense,
            travel: this.renderTravelExpense,
            misc: this.renderMiscExpense
        };

        return renderers[type].call(this, expense, index);
    },

    // Render food expense
    renderFoodExpense(expense, index) {
        return `
            <div class="exp-data" data-index="${index}">
                <span class="exp-title">${expense.type || 'Food Expense'}</span>
                <span class="exp-value">₹${expense.amount}</span>
                <span class="exp-bill-copy">${this.renderFileLinks(expense.filesUploaded)}</span>
                ${this.renderActionButtons()}
            </div>
        `;
    },

    // Render travel expense
    renderTravelExpense(expense, index) {
        return `
            <div class="exp-row" data-index="${index}">
                <span class="exp-value">
                    <span class="exp-title">Transport Mode</span>
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
                    ${this.renderFileLinks(expense.filesUploaded)}
                </span>
                ${this.renderActionButtons()}
            </div>
        `;
    },

    // Render miscellaneous expense
    renderMiscExpense(expense, index) {
        return `
            <div class="exp-data" data-index="${index}">
                <span class="exp-title">${expense.type}</span>
                <span class="exp-value">₹${expense.claimAmount}</span>
                <span class="exp-bill-copy">${this.renderFileLinks(expense.filesUploaded)}</span>
                ${this.renderActionButtons()}
            </div>
        `;
    },

    // Render file links
    renderFileLinks(files) {
        return (files || [])
            .map(file => `
                <a href="http://localhost:3000/img/${file.name}">
                    <i class="fa-solid fa-file"></i>
                </a>`
            ).join('');
    },

    // Render action buttons
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

    // Handle modal save
    handleModalSave() {
        const $modal = $('#expenseModal');
        const type = this.getActiveExpenseType($modal);
        
        if (!this.validateExpenseForm(type)) {
            return;
        }

        const expenseData = this.collectExpenseData(type);
        this.saveExpenseData(type, expenseData);
        
        $modal.modal('hide');
        this.loadDayExpenses();
        this.showToast('Expense saved successfully', 'success');
    },

    // Get active expense type
    getActiveExpenseType($modal) {
        if ($modal.find('#foodRow').length) return 'food';
        if ($modal.find('.travel-entry').length) return 'travel';
        if ($modal.find('.misc-entry').length) return 'misc';
        return null;
    },

    // Validate expense form
    validateExpenseForm(type) {
        const validators = {
            food: () => this.validateFoodExpense(),
            travel: () => this.validateTravelExpense(),
            misc: () => this.validateMiscExpense()
        };

        return validators[type]();
    },

    // Validate food expense
    validateFoodExpense() {
        const amount = parseFloat($('#foodClaim').val());
        const files = this.getUploadedFiles();

        if (!amount || amount <= 0) {
            this.showValidationError('#foodClaim', 'Please enter a valid amount');
            return false;
        }

        if (amount > this.config.maxFoodAmount) {
            this.showValidationError('#foodClaim', `Amount cannot exceed ₹${this.config.maxFoodAmount}`);
            return false;
        }

        if (amount > 0 && !files.length) {
            this.showValidationError('.file-upload-block', 'Please attach receipt for the expense claim');
            return false;
        }

        return true;
    },

    // Validate travel expense
    validateTravelExpense() {
        const required = [
            { selector: '.mode-transport-container', message: 'Please select transport mode' },
            { selector: '.type-transport-container', message: 'Please select transport type' },
            { selector: '.places-visited', message: 'Please enter places visited' }
        ];

        for (const field of required) {
            const $element = $(field.selector);
            const value = $element.find('input, textarea, .dropdown-value').val();
            
            if (!value) {
                this.showValidationError($element, field.message);
                return false;
            }
        }

        const startMeter = parseFloat($('.starting-meter').val());
        const closingMeter = parseFloat($('.closing-meter').val());
        
        if ($('.mode-transport-container .dropdown-value').val() === 'private' && closingMeter <= startMeter) {
            this.showValidationError('.closing-meter', 'Closing meter must be greater than starting meter');
            return false;
        }

        return true;
    },

    // Validate miscellaneous expense
    validateMiscExpense() {
        const type = $('.expense-type-container .dropdown-value').val();
        const amount = parseFloat($('.claim-amount').val());
        const files = this.getUploadedFiles();

        if (!type) {
            this.showValidationError('.expense-type-container', 'Please select expense type');
            return false;
        }

        if (!amount || amount <= 0) {
            this.showValidationError('.claim-amount', 'Please enter a valid amount');
            return false;
        }

        if (!files.length) {
            this.showValidationError('.misc-documents-uploader', 'Please attach supporting documents');
            return false;
        }

        return true;
    },

    // Show validation error
    showValidationError(selector, message) {
        const $element = $(selector);
        $element.addClass('is-invalid');
        $element.closest('.e-grp').append(
            `<div class="text-danger expense-message">${message}</div>`
        );
        this.showToast(message, 'danger');
    },

    // Collect expense data
    collectExpenseData(type) {
        const collectors = {
            food: () => ({
                type: 'Food',
                amount: parseFloat($('#foodClaim').val()),
                filesUploaded: this.getUploadedFiles()
            }),
            travel: () => ({
                modeOfTransport: $('.mode-transport-container .dropdown-value').val(),
                transportType: $('.type-transport-container .dropdown-value').val(),
                startingMeter: parseFloat($('.starting-meter').val()) || 0,
                closingMeter: parseFloat($('.closing-meter').val()) || 0,
                tollCharges: parseFloat($('.toll-charges').val()) || 0,
                fuelCharges: parseFloat($('.fuel-charges').val()) || 0,
                placesVisited: $('.places-visited').val(),
                filesUploaded: this.getUploadedFiles()
            }),
            misc: () => ({
                type: $('.expense-type-container .dropdown-value').val(),
                claimAmount: parseFloat($('.claim-amount').val()),
                filesUploaded: this.getUploadedFiles()
            })
        };

        return collectors[type]();
    },

    // Save expense data
    saveExpenseData(type, data) {
        let expenseData = this.getStoredData();
        const typeKey = this.config.expenseTypes[type];
        
        if (!expenseData.claimData) {
            expenseData.claimData = {};
        }
        if (!expenseData.claimData[this.state.currentDay]) {
            expenseData.claimData[this.state.currentDay] = { 
                date: this.state.currentDate
            };
        }
        if (!Array.isArray(expenseData.claimData[this.state.currentDay][typeKey])) {
            expenseData.claimData[this.state.currentDay][typeKey] = [];
        }

        if (this.state.editing !== null) {
            expenseData.claimData[this.state.currentDay][typeKey][this.state.editing] = data;
        } else {
            expenseData.claimData[this.state.currentDay][typeKey].push(data);
        }

        this.saveData(expenseData);
    },

    // Get uploaded files
    getUploadedFiles() {
        const $uploader = $('.file-uploader');
        const modelID = $uploader.data('module');
        const sectionID = $uploader.data('section');
        return FileUploader.getFiles(modelID, sectionID) || [];
    },

    // Handle expense edit
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

    // Handle expense delete
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
        
        if (!type) return;
        
        let expenseData = this.getStoredData();
        const typeKey = this.config.expenseTypes[type];
        
        expenseData.claimData[this.state.currentDay][typeKey].splice(index, 1);
        this.saveData(expenseData);
        
        this.loadDayExpenses();
        this.showToast('Expense deleted successfully', 'success');
    },

    // Get expense type
    getExpenseType($element) {
        const $wrapper = $element.closest('.exp-data-wrapper');
        if ($wrapper.hasClass('food-exp-data')) return 'food';
        if ($wrapper.hasClass('travel-exp-data')) return 'travel';
        if ($wrapper.hasClass('misc-exp-data')) return 'misc';
        return null;
    },

    // Load expense for editing
    loadExpenseForEdit(type, index) {
        const expenseData = this.getStoredData();
        const typeKey = this.config.expenseTypes[type];
        const expense = expenseData.claimData[this.state.currentDay][typeKey][index];

        this.state.editing = index;
        this.showExpenseModal(type);

        setTimeout(() => {
            this.populateExpenseForm(type, expense);
        }, 100);
    },

    // Populate expense form
    populateExpenseForm(type, expense) {
        const populators = {
            food: () => {
                $('#foodClaim').val(expense.amount);
            },
            travel: () => {
                $('.starting-meter').val(expense.startingMeter || 0);
                $('.closing-meter').val(expense.closingMeter || 0);
                $('.toll-charges').val(expense.tollCharges || 0);
                $('.fuel-charges').val(expense.fuelCharges || 0);
                $('.places-visited').val(expense.placesVisited || '');
                
                if (expense.modeOfTransport) {
                    $('.mode-transport-container .select-trigger')
                        .text(expense.modeOfTransport)
                        .attr('data-value', expense.modeOfTransport);
                    $('.mode-transport-container .dropdown-value')
                        .val(expense.modeOfTransport)
                        .trigger('change');
                }
                if (expense.transportType) {
                    setTimeout(() => {
                        $('.type-transport-container .select-trigger')
                            .text(expense.transportType)
                            .attr('data-value', expense.transportType);
                        $('.type-transport-container .dropdown-value')
                            .val(expense.transportType);
                    }, 100);
                }
            },
            misc: () => {
                $('.claim-amount').val(expense.claimAmount || 0);
                
                if (expense.type) {
                    $('.expense-type-container .select-trigger')
                        .text(expense.type)
                        .attr('data-value', expense.type);
                    $('.expense-type-container .dropdown-value')
                        .val(expense.type);
                }
            }
        };

        populators[type]();

        // Load existing files
        if (expense.filesUploaded?.length) {
            const modelID = $('.file-uploader').data('module');
            const sectionID = $('.file-uploader').data('section');
            FileUploader.saveFiles(modelID, sectionID, expense.filesUploaded);
        }
    },

    // Submit day form
    submitDayForm() {
        if (!confirm('Are you sure you want to submit the data?')) {
            return;
        }

        let expenseData = this.getStoredData();
        if (expenseData?.claimData?.[this.state.currentDay]) {
            expenseData.claimData[this.state.currentDay].isSubmitted = 1;
            this.saveData(expenseData);
            this.toggleDateList(true);
            this.generateDays();
            this.showToast('Day expenses submitted successfully', 'success');
        }
    },

    // Generate days
    generateDays() {
        const expenseData = this.getStoredData();
        if (!expenseData?.startingDT) {
            $('#daysContainer').empty();
            return;
        }

        const startDate = new Date(expenseData.startingDT);
        const $container = $('#daysContainer').empty();

        for (let i = 0; i < expenseData.noOfDays; i++) {
            const currentDate = new Date(startDate);
            currentDate.setDate(startDate.getDate() + i);
            
            const formattedDate = this.formatDate(currentDate);
            const dayNo = `Day ${i + 1}`;
            const isSubmitted = expenseData.claimData?.[dayNo]?.isSubmitted;

            $container.append(this.createDayButton(dayNo, formattedDate, isSubmitted));
        }
    },

    // Format date
    formatDate(date) {
        const day = String(date.getDate()).padStart(2, '0');
        const month = date.toLocaleDateString('en-US', { month: 'short' });
        const year = date.getFullYear();
        return `${day}-${month}-${year}`;
    },

    // Create day button
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

    // Show toast message
    showToast(message, type = 'info') {
        const toast = `
            <div class="toast align-items-center text-white bg-${type} border-0">
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" 
                            data-bs-dismiss="toast" aria-label="Close"></button>
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

    // Toggle date list visibility
    toggleDateList(show) {
        $('.day-details-box').toggle(show);
        $('.exp-details-box').toggle(!show);
        if (show) {
            $('.exp-wrapper').hide();
        }
    },

    // Move to next step
    moveToNextStep() {
        const $current = $('.step-container.active');
        const currentStep = $current.data('step');
        const nextStep = currentStep + 1;

        $current.removeClass('active');
        $(`.step[data-step="${currentStep}"]`).removeClass('active');
        $(`.step-container[data-step="${nextStep}"], .step[data-step="${nextStep}"]`).addClass('active');
    },

    // Storage helpers
    getStoredData() {
        return JSON.parse(localStorage.getItem('expenseData')) || null;
    },

    saveData(data) {
        localStorage.setItem('expenseData', JSON.stringify(data));
    }
};

// Initialize when document is ready
$(document).ready(() => {
    ExpenseAppBTC.init();
});

// Export for use in other modules if needed
window.ExpenseAppBTC = ExpenseAppBTC;