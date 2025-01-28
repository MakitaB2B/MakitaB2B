/**
 * BTC Application State Manager with IndexedDB support
 */
const BTCStateManager = {
    STORAGE_KEY: 'btc_application_state',
    
    initialState: {
        startDateTime: null,
        endDateTime: null,
        visitedPlace: '',
        preApproved: 0,
        noOfDays: 0,
        purposeVisit: '',
        currentStep: 1,
        dayDetails: {},
        isSubmitted: false
    },

    async init() {
        try {
            await FileUploader.initDB();

            this.settings = {
                inputFormat: 'DD-MMM-YYYY HH:mm:ss'
            };

            const savedState = this.loadState();
            await this.initializeComponents(savedState);
            this.bindEvents();
        } catch (error) {
            console.error('Error initializing BTC State Manager:', error);
        }
    },

    async initializeComponents(savedState) {
        this.initializeDateTimePickers();
        this.initializePreApprovedDropdown();
        
        if (savedState) {
            await this.initializeFormWithSavedData(savedState);
        }
    },

    initializeDateTimePickers() {
        const dateConfig = {
            format: this.settings.inputFormat,
            icons: {
                time: 'far fa-clock',
                date: 'far fa-calendar',
                up: 'fas fa-chevron-up',
                down: 'fas fa-chevron-down',
                previous: 'fas fa-chevron-left',
                next: 'fas fa-chevron-right',
                today: 'far fa-calendar-check',
                clear: 'fas fa-trash',
                close: 'fas fa-times'
            }
        };
    
        try {
            // Initialize the datepickers
            const $startDate = $('#startDateTime');
            const $endDate = $('#endDateTime');
    
            $startDate.datetimepicker({
                ...dateConfig,
                useCurrent: false,
                minDate: moment().subtract(1, 'month'),
                maxDate: moment()
            });
    
            $endDate.datetimepicker({
                ...dateConfig,
                useCurrent: false,
                minDate: moment(),
                maxDate: moment()
            });
    
            // Bind change events after initialization
            $startDate.off('change.datetimepicker').on('change.datetimepicker', (e) => {
                if (e.date) {
                    $endDate.datetimepicker('minDate', e.date);
                    this.calculateAndUpdateDays();
                    this.saveCurrentState();
                }
            });
    
            $endDate.off('change.datetimepicker').on('change.datetimepicker', (e) => {
                if (e.date) {
                    $startDate.datetimepicker('maxDate', e.date);
                    this.calculateAndUpdateDays();
                    this.saveCurrentState();
                }
            });
        } catch (error) {
            console.error('Error initializing date pickers:', error);
        }
    },

    initializePreApprovedDropdown() {
        CustomDropdown.init({
            container: '.pre-approved',
            data: [
                { value: 1, text: 'Yes' },
                { value: 0, text: 'No' }
            ],
            placeholder: 'Select Option',
            onChange: () => this.saveCurrentState()
        });
    },

    validateDateRange(startDate, endDate) {
        const now = moment();
        const oneMonthAgo = moment().subtract(1, 'month');
        
        if (startDate.isBefore(oneMonthAgo)) {
            return {
                isValid: false,
                message: 'Start date cannot be more than 1 month in the past'
            };
        }

        if (endDate.isAfter(now)) {
            return {
                isValid: false,
                message: 'End date cannot be in the future'
            };
        }

        if (endDate.isBefore(startDate)) {
            return {
                isValid: false,
                message: 'End date must be after start date'
            };
        }

        return { isValid: true };
    },

    calculateAndUpdateDays() {
        const startDate = moment($('input[name="starting_date_time"]').val(), this.settings.inputFormat);
        const endDate = moment($('input[name="bta_ending_datetime"]').val(), this.settings.inputFormat);
        
        if (!startDate.isValid() || !endDate.isValid()) {
            return 0;
        }

        const validation = this.validateDateRange(startDate, endDate);
        if (!validation.isValid) {
            this.showError(validation.message);
            return 0;
        }

        let days = 0;
        
        if (startDate.hour() < 21) {
            days += 1;
        }
        
        days += endDate.startOf('day').diff(startDate.startOf('day'), 'days');
        
        if (endDate.hour() >= 6) {
            days += 1;
        }

        $('input[name="noOfDays"]').val(days);
        return days;
    },

    async initializeFormWithSavedData(savedState) {
        try {
            if (savedState.startDateTime && savedState.endDateTime) {
                const startDate = moment(savedState.startDateTime, 'DD-MMM-YYYY HH:mm:ss');
                const endDate = moment(savedState.endDateTime, 'DD-MMM-YYYY HH:mm:ss');
                
                $('#startDateTime').datetimepicker('date', startDate);
                $('#endDateTime').datetimepicker('date', endDate);
                
                $('input[name="starting_date_time"]').val(startDate.format('DD-MMM-YYYY HH:mm:ss'));
                $('input[name="bta_ending_datetime"]').val(endDate.format('DD-MMM-YYYY HH:mm:ss'));
            }
    
            $('input[name="visitedPlace"]').val(savedState.visitedPlace || '');
            CustomDropdown.setValue('.pre-approved', savedState.preApproved);
            $('input[name="noOfDays"]').val(savedState.noOfDays || '');
            $('textarea[name="purposeVisit"]').val(savedState.purposeVisit || '');
    
            if (savedState.dayDetails) {
                for (const [day, details] of Object.entries(savedState.dayDetails)) {
                    await this.loadDayDetails(day, details);
                }
            }
        } catch (error) {
            console.error('Error loading saved data:', error);
        }
    },

    async loadDayDetails(day, details) {
        try {
            const expenseTypes = ['food', 'travel', 'misc'];
            
            for (const type of expenseTypes) {
                const expenses = details[`${type}Expenses`] || [];
                for (const expense of expenses) {
                    if (expense.files?.length && expense.fileId) {
                        await FileUploader.saveFiles(
                            expense.fileId,
                            expense.fileId,
                            expense.files
                        );
                    }
                }
            }
        } catch (error) {
            console.error(`Error loading day ${day} details:`, error);
        }
    },

    bindEvents() {
        $('input, textarea').on('change', () => this.saveCurrentState());
        $('.custom-select').on('change', '.dropdown-value', () => this.saveCurrentState());
        $('.add-expense').on('click', () => this.saveCurrentState());
        $(document).on('click', '.remove-expense', () => this.saveCurrentState());
        $(document).on('click', '.day-button', () => this.saveCurrentState());
    },

    async saveCurrentState(state = "collectCurrentState") {
        try {
            let currentState;
            if(state=="collectCurrentState"){
                currentState = await this.collectCurrentState();
            } else{
                currentState = state
            }
            localStorage.setItem(this.STORAGE_KEY, JSON.stringify(currentState));
        } catch (error) {
            console.error('Error saving BTC state:', error);
        }
    },

    loadState() {
        const savedState = localStorage.getItem(this.STORAGE_KEY);
        return savedState ? JSON.parse(savedState) : this.initialState;
    },

    async collectCurrentState() {
        const currentState = this.loadState();
    
        try {
            return {
                ...currentState,
                startDateTime: $('input[name="starting_date_time"]').val(),
                endDateTime: $('input[name="bta_ending_datetime"]').val(),
                visitedPlace: $('input[name="visitedPlace"]').val(),
                preApproved: $('.pre-approved .dropdown-value').val(),
                noOfDays: parseInt($('input[name="noOfDays"]').val()) || 0,
                purposeVisit: $('textarea[name="purposeVisit"]').val()
            };
        } catch (error) {
            console.error('Error collecting current state:', error);
            return currentState;
        }
    },

    async collectDayDetails(day) {
        try {
            return {
                foodExpenses: await this.collectExpenses('food', day),
                travelExpenses: await this.collectExpenses('travel', day),
                miscExpenses: await this.collectExpenses('misc', day)
            };
        } catch (error) {
            console.error(`Error collecting ${day} details:`, error);
            return {};
        }
    },

    async collectExpenses(type, day) {
        try {
            const currentState = this.loadState();
            const typeKey = `${type}Expenses`;
            
            // Return existing expenses from current state if they exist
            if (currentState.dayDetails?.[day]?.[typeKey]) {
                return currentState.dayDetails[day][typeKey];
            }
    
            return [];
        } catch (error) {
            console.error(`Error collecting ${type} expenses for ${day}:`, error);
            return [];
        }
    },

    showError(message) {
        const $error = $(`
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `);
        
        $('.btc-details-section').prepend($error);
        
        setTimeout(() => {
            $error.alert('close');
        }, 5000);
    },

    async clearAllData() {
        try {
            localStorage.removeItem(this.STORAGE_KEY);
            await FileUploader.clearAllFiles();
        } catch (error) {
            console.error('Error clearing BTC data:', error);
        }
    },

    getDayDetails(day) {
        const state = this.loadState();
        return state.dayDetails?.[day] || null;
    },

    async updateDayDetails(day, details) {
        const state = this.loadState();
        state.dayDetails[day] = details;
        await this.saveCurrentState();
    },

    validateState() {
        const state = this.loadState();
        const errors = [];

        if (!state.startDateTime) errors.push('Start date is required');
        if (!state.endDateTime) errors.push('End date is required');
        if (!state.visitedPlace) errors.push('Place of visit is required');
        if (!state.purposeVisit) errors.push('Purpose of visit is required');
        if (state.noOfDays <= 0) errors.push('Invalid number of days');

        return {
            isValid: errors.length === 0,
            errors
        };
    }
};

// Export for use in other modules
window.BTCStateManager = BTCStateManager;