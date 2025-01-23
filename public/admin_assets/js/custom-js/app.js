/**
 * Expense Application
 * Main application that integrates all modules and manages the expense form
 */
const ExpenseApp = {
    // Application configuration
    config: {
        primaryColor: '#008290',
        transportTypes: {
            company: [
                { value: 'car', text: 'Car' },
                { value: 'van', text: 'Van' }
            ],
            private: [
                { value: 'car', text: 'Car' },
                { value: 'motorcycle', text: 'Bike' }
            ],
            public: [
                { value: 'bus', text: 'Bus' },
                { value: 'bike', text: 'Two Wheeler' },
                { value: 'train', text: 'Train' },
                { value: 'taxi', text: 'Taxi' },
                { value: 'metro', text: 'Metro' }
            ]
        },
        expenseTypes: [
            { value: 'parking', text: 'Parking' },
            { value: 'internet', text: 'Internet' },
            { value: 'phone', text: 'Phone' },
            { value: 'other', text: 'Other' }
        ],
        dayTypes: [
            { value: 'L', text: 'On Leave' },
            { value: 'H', text: 'Holiday' },
            { value: 'W', text: 'Working Day' },
            { value: 'WH', text: 'Working on Holiday' }
        ]
    },

    // Application state
    state: {
        travelEntryCount: 0,
        miscEntryCount: 0
    },

    /**
     * Time Management Module
     */
    timeManager: {
        initialize: function() {
            // Initialize calendar with 2 months restriction
            const today = new Date();
            const twoMonthsAgo = new Date(today.getFullYear(), today.getMonth() - 2, 1);

            Calendar.init({
                container: '#calendarBody',
                minDate: twoMonthsAgo,
                maxDate: today,
                inputSelector: '.datepicker',
                wrapperSelector: '.calendar-wrapper',
                onChange: (date) => {
                    this.validateAndUpdate();
                }
            });

            // Initialize time dropdowns
            this.initializeTimeDropdowns();
            // Initialize day type dropdown
            this.initializeDayTypeDropdown();
        },

        initializeDayTypeDropdown: function() {
            CustomDropdown.init({
                container: '#dayTypeDropdown',
                data: ExpenseApp.config.dayTypes,
                placeholder: 'Select Day Type',
                required: true,
                onChange: () => {
                    this.validateAndUpdate();
                }
            });
        },

        initializeTimeDropdowns: function() {
            const timeConfig = {
                hours: Array.from({length: 24}, (_, i) => ({
                    value: i.toString().padStart(2, '0'),
                    text: i.toString().padStart(2, '0')
                })),
                minutes: Array.from({length: 60}, (_, i) => ({
                    value: i.toString().padStart(2, '0'),
                    text: i.toString().padStart(2, '0')
                }))
            };

            // Initialize In Time
            CustomDropdown.init({
                container: '#inHoursDropdown',
                data: timeConfig.hours,
                placeholder: '00',
                onChange: () => this.validateAndUpdate()
            });

            CustomDropdown.init({
                container: '#inMinutesDropdown',
                data: timeConfig.minutes,
                placeholder: '00',
                onChange: () => this.validateAndUpdate()
            });

            // Initialize Out Time
            CustomDropdown.init({
                container: '#outHoursDropdown',
                data: timeConfig.hours,
                placeholder: '00',
                onChange: () => this.validateAndUpdate()
            });

            CustomDropdown.init({
                container: '#outMinutesDropdown',
                data: timeConfig.minutes,
                placeholder: '00',
                onChange: () => this.validateAndUpdate()
            });
        },

        validateAndUpdate: function() {
            const times = this.getTimeValues();
            const dayType = this.getDayType();
            const selectedDate = Calendar.getDate('#calendarBody');
            
            // Validate all required inputs
            const isDateValid = !!selectedDate;
            const inTime = parseInt(times.inHours) * 60 + parseInt(times.inMinutes);
            const outTime = parseInt(times.outHours) * 60 + parseInt(times.outMinutes);
            const isTimeValid = inTime < outTime;
            const isDayTypeValid = !!dayType;

            // Apply error states
            $('.datepicker').toggleClass('error', !isDateValid);
            ['in', 'out'].forEach(type => {
                CustomDropdown.setError(`#${type}HoursDropdown`, !isTimeValid);
                CustomDropdown.setError(`#${type}MinutesDropdown`, !isTimeValid);
            });

            CustomDropdown.setError('#dayTypeDropdown', !isDayTypeValid);
            $('.time-error-message').toggle(!isTimeValid);

            const isValid = isDateValid && isTimeValid && isDayTypeValid;

            if (isValid) {
                ExpenseApp.expenseManager.validateTimeAndExpenses();
            }            

            return isValid;
        },

        getTimeValues: function() {
            return {
                inHours: CustomDropdown.getValue('#inHoursDropdown') || '00',
                inMinutes: CustomDropdown.getValue('#inMinutesDropdown') || '00',
                outHours: CustomDropdown.getValue('#outHoursDropdown') || '00',
                outMinutes: CustomDropdown.getValue('#outMinutesDropdown') || '00'
            };
        },

        getDayType: function() {
            return CustomDropdown.getValue('#dayTypeDropdown');
        }
    },

    /**
     * Expense Management Module
     */
    expenseManager: {
        validateTimeAndExpenses: function() {
            const times = ExpenseApp.timeManager.getTimeValues();
            const inHours = parseInt(times.inHours);
            const outHours = parseInt(times.outHours);
            
            // Update meal access based on time
            this.updateMealAccess('breakfast', inHours < 7);
            this.updateMealAccess('lunch', outHours >= 12);
            this.updateMealAccess('dinner', outHours >= 20);
            
            this.updateTotalFoodExpenses();
        },

        updateMealAccess: function(meal, hasAccess) {
            const $container = $(`#${meal}Row`);
            const $input = $(`#${meal}Claim`);
            const $uploader = FileUploader.getInstance('food-expenses', meal);

            $container.toggleClass('show', hasAccess);
            $input.prop('disabled', !hasAccess);

            if (hasAccess) {
                FileUploader.enable($uploader);
                $container.find('.expense-message')
                    .text('')
                    .removeClass('text-danger')
                    .addClass('text-muted');
            } else {
                $input.val('0.00');
                FileUploader.disable($uploader);
                FileUploader.clearFiles('food-expenses', meal);
                $container.find('.expense-message')
                    .text(`Not eligible for ${meal} claim`)
                    .removeClass('text-muted')
                    .addClass('text-danger');
            }
        },

        initializeFileUploaders: function() {
            // Initialize food expense uploaders
            ['breakfast','food'].forEach(meal => {
                FileUploader.init({
                    container: `#${meal}-attachments`,
                    moduleId: 'food-expenses',
                    sectionId: meal,
                    maxFiles: meal=='food'?5:1,
                    buttonText: 'Add Receipt',
                    uploadIcon: 'bi-receipt',
                    onChange: () => {
                        this.validateMealExpense(meal);
                    }
                });
            });
        },

        validateMealExpense: async function(meal) {
            const $input = $(`#${meal}Claim`);
            const value = parseFloat($input.val()) || 0;
            // Fetch files from IndexedDB
            const files = await FileUploader.getFiles('food-expenses', meal);

            // Validation logic
            const isValid = value === 0 || (value <= 100) || (value > 100 && files.length > 0);

            const $row = $(`#${meal}Row`);
            $row.find('.expense-message')
                .text(!isValid ? 'Please attach receipt for the expense claim' : '')
                .toggleClass('text-danger', !isValid)
                .toggleClass('text-muted', isValid);

            return isValid;
        },
    
        updateTotalFoodExpenses: function() {
            let total = 0;            
            ['breakfast'].forEach(meal => {
                const value = parseFloat($(`#${meal}Claim`).val()) || 0;
                total += value;
            });
            $('#totalFoodExpenses').text(`₹${total.toFixed(2)}`);            
        },

        validateAllExpenses: function() {
            return ['breakfast'].every(meal => 
                this.validateMealExpense(meal)
            );
        },
        validateLTCExpenses: function(){
            const $input = $(`#${meal}Claim`);
            const value = $input.val();
        }
    },

    /**
     * Travel Management Module
     */
    travelManager: {
        addTravelEntry: function(data = null) {
            const template = document.getElementById('travel-entry-template')
                                   .content.cloneNode(true);
            const $newEntry = $(template);
            
            const entryNumber = ++ExpenseApp.state.travelEntryCount;

            FileUploader.init({
                container: $newEntry.find('.travel-documents-uploader')[0],
                moduleId: 'travel-expenses',
                sectionId: `travel-${entryNumber}`,
                maxFiles: 5,
                required: true,
                buttonText: 'Add Documents',
                uploadIcon: 'bi-file-earmark-text',
                onChange: () => this.validateEntry($newEntry)
            });
            
            $newEntry.find('.entry-number').text(entryNumber);
            
            this.initializeTransportDropdowns($newEntry);
            
            // Add to container
            $('#travelEntriesContainer').append($newEntry);
            
            // Initialize file uploader for this section
            const $container = $('.file-upload-container');
            if ($container.length > 0) {
                this.initializeFileUploader($container, entryNumber);
            }
            
            if (data) {
                this.populateEntryData($newEntry, data);
            }
            
            this.updateRemoveButtons();
            
            return $newEntry;
        },

        initializeTransportDropdowns: function($entry) {
            const transportData = {
                parentData: Object.keys(ExpenseApp.config.transportTypes)
                    .map(key => ({ value: key, text: key.charAt(0).toUpperCase() + key.slice(1) })),
                childData: ExpenseApp.config.transportTypes
            };
            const parentContainer = $entry.find('.mode-transport-container')[0];  // Store reference
            const childContainer = $entry.find('.type-transport-container')[0];   // Store reference
            
        

            DependentDropdown.init({
                parentContainer: $entry.find('.mode-transport-container')[0],
                childContainer: $entry.find('.type-transport-container')[0],
                parentData: transportData.parentData,
                childData: transportData.childData,
                required: true,
                onChange: (parentValue, childValue) => {
                    const $entry = $(parentContainer).closest('.travel-entry');
                    this.toggleMeterFields($entry, parentValue === 'private');
                    this.toggleApprovalUploader($entry, parentValue === 'private' && childValue === 'car');
                    this.validateEntry($entry);
                }
            });
            FileUploader.init({
                container: $entry.find('.approval-documents-uploader')[0],
                moduleId: 'travel-expenses',
                sectionId: `travel-approval-${$entry.find('.entry-number').text()}`,
                maxFiles: 1,
                required: true,
                buttonText: 'Add Approval Document',
                uploadIcon: 'bi-file-earmark-text',
                onChange: () => this.validateEntry($entry)
            });
        },
        // Add this new function
        toggleApprovalUploader: function($entry, show) {
            const $approvalSection = $entry.find('.approval-documents-section');
            if (show) {
                $approvalSection.show();
                $approvalSection.find('input').prop('required', true);
            } else {
                $approvalSection.hide();
                $approvalSection.find('input').prop('required', false);
            }
        },
        toggleMeterFields: function($entry, show) {
            // Use find to get to the card from the mode-transport-container
            const $travelEntry = $($entry.find('.mode-transport-container')).closest('.card.travel-entry');
            // Or start from the mode-transport-container and go up
            if (!$travelEntry.length) {
                const $container = $entry.find('.mode-transport-container');
                const $cardEntry = $container.closest('.card.travel-entry');
                if ($cardEntry.length) {
                    $travelEntry = $cardEntry;
                }
            }
            console.log("Travel Entry found:", $travelEntry.length);
            
            const $meterRow = $travelEntry.find('.meter-fields-row');
            console.log("Meter Row found:", $meterRow.length);
        
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

        validateEntry: async function($entry) {
            let isValid = true;
            
            // Reset previous error states
            $entry.find('.is-invalid').removeClass('is-invalid');
            $entry.find('.invalid-feedback').remove();
            console.log("Validating Travel Entry...");
            
            // Validate transport selections
            const modeValue = CustomDropdown.getValue($entry.find('.mode-transport-container'));
            const typeValue = CustomDropdown.getValue($entry.find('.type-transport-container'));
            console.log("Mode:", modeValue, "Type:", typeValue);
        
            if (!modeValue || !typeValue) {
                isValid = false;
                if (!modeValue) {
                    CustomDropdown.setError($entry.find('.mode-transport-container'), true);
                }
                if (!typeValue) {
                    CustomDropdown.setError($entry.find('.type-transport-container'), true);
                }
            }
        
            // Validate meters if transport mode is private
            if (modeValue === 'private') {
                const start = parseFloat($entry.find('.starting-meter').val()) || 0;
                const end = parseFloat($entry.find('.closing-meter').val()) || 0;
                console.log("Meter values - Start:", start, "End:", end);
                
                if (end <= start) {
                    isValid = false;
                    $entry.find('.starting-meter, .closing-meter').addClass('is-invalid');
                    if (!$entry.find('.meter-error').length) {
                        $entry.find('.closing-meter').after(
                            '<div class="invalid-feedback meter-error">Closing meter must be greater than starting meter</div>'
                        );
                    }
                }
            }
        
            // Validate places visited - Safe check for null/undefined
            const placesVisitedValue = $entry.find('.places-visited').val();
            console.log("Places visited:", placesVisitedValue);
            if (!placesVisitedValue || !placesVisitedValue.trim()) {
                isValid = false;
                $entry.find('.places-visited').addClass('is-invalid');
                if (!$entry.find('.places-error').length) {
                    $entry.find('.places-visited').after(
                        '<div class="invalid-feedback places-error">Please enter places visited</div>'
                    );
                }
            }
        
            // Validate file attachments
            const entryNumber = $entry.find('.entry-number').text();
            const files = await FileUploader.getFiles('travel-expenses', `travel-${entryNumber}`);
        
            if (!files || files.length === 0) {
                isValid = false;
                $entry.find('.travel-documents-uploader').addClass('has-error');
                if (!$entry.find('.documents-error').length) {
                    $entry.find('.travel-documents-uploader').after(
                        '<div class="invalid-feedback documents-error">Supporting documents are required</div>'
                    );
                }
            } else {
                // Clear error state if files exist
                $entry.find('.travel-documents-uploader').removeClass('has-error');
                $entry.find('.documents-error').remove();
            }
            console.log("Validation result:", isValid);
            return isValid;
        },

        calculateTotalKms: function($entry) {
            const start = parseFloat($entry.find('.starting-meter').val()) || 0;
            const end = parseFloat($entry.find('.closing-meter').val()) || 0;
            const total = Math.max(0, end - start);
            const transportMode = $(".mode-transport-container .dropdown-value").val();
            const transportType = $(".type-transport-container .dropdown-value").val();
            let fuelCharge=0;
         
            $entry.find('.total-kms').val(total.toFixed(2));
           
            if(total > 0 && transportMode == 'private' && transportType == 'car'){
                fuelCharge = total * 8;
            }
            if(total > 0 && transportMode == 'private' && transportType == 'motorcycle'){
                fuelCharge = total * 6;
            }
            $entry.find('.fuel-charges').val(fuelCharge.toFixed(2));

            this.validateEntry($entry);
            $entry.find('.starting-meter, .closing-meter')
                  .toggleClass('is-invalid', end <= start);
        },

        calculateTotalClaim: function($entry) {
            const tollCharges = parseFloat($entry.find('.toll-charges').val()) || 0;
            const fuelCharges = parseFloat($entry.find('.fuel-charges').val()) || 0;
            return tollCharges + fuelCharges;
        },

        updateRemoveButtons: function() {
            $('.travel-entry').each(function(index) {
                $(this).find('.remove-entry').toggle(index > 0);
            });
        },

        removeEntry: function($entry) {
            const entryNumber = $entry.find('.entry-number').text();
            FileUploader.clearFiles('travel-expenses', `travel-${entryNumber}`);
            $entry.remove();
            this.updateRemoveButtons();
        }
    },

    miscManager: {
        addMiscEntry: function(data = null) {
            const template = document.getElementById('misc-entry-template')
                                   .content.cloneNode(true);
            const $newEntry = $(template);
            
            const entryNumber = ++ExpenseApp.state.miscEntryCount;
    
            // Initialize file uploader
            FileUploader.init({
                container: $newEntry.find('.misc-documents-uploader')[0],
                moduleId: 'misc-expenses',
                sectionId: `misc-${entryNumber}`,
                maxFiles: 5,
                required: false,
                buttonText: 'Add Documents',
                uploadIcon: 'bi-file-earmark-text',
                onChange: () => this.validateEntry($newEntry)
            });
            
            $newEntry.find('.entry-number').text(entryNumber);
            
            // Initialize expense type dropdown
            this.initializeExpenseTypeDropdown($newEntry);
            
            // Add to container
            $('#miscExpensesContainer').append($newEntry);
            
            if (data) {
                this.populateEntryData($newEntry, data);
            }
            
            this.updateRemoveButtons();
            
            return $newEntry;
        },
    
        initializeExpenseTypeDropdown: function($entry) {
            CustomDropdown.init({
                container: $entry.find('.expense-type-container')[0],
                data: ExpenseApp.config.expenseTypes,
                placeholder: 'Select Type',
                required: true,
                onChange: () => {
                    this.validateEntry($entry);
                }
            });
        },
    
        validateEntry: async function($entry) {
            let isValid = true;
            
            // Reset previous error states
            $entry.find('.is-invalid').removeClass('is-invalid');
            $entry.find('.invalid-feedback').remove();
            
            // Validate expense type selection
            const typeValue = CustomDropdown.getValue($entry.find('.expense-type-container'));
            if (!typeValue) {
                isValid = false;
                CustomDropdown.setError($entry.find('.expense-type-container'), true);
            }
    
            // Validate amount
            const amount = parseFloat($entry.find('.claim-amount').val()) || 0;
            if (amount <= 0) {
                isValid = false;
                $entry.find('.claim-amount').addClass('is-invalid');
                if (!$entry.find('.amount-error').length) {
                    $entry.find('.claim-amount').after(
                        '<div class="invalid-feedback amount-error">Please enter a valid amount</div>'
                    );
                }
            }
    
            // Validate file attachments
            const entryNumber = $entry.find('.entry-number').text();
            const files = await FileUploader.getFiles('misc-expenses', `misc-${entryNumber}`);
        
            if (!files || files.length === 0) {
                isValid = false;
                $entry.find('.misc-documents-uploader').addClass('has-error');
                if (!$entry.find('.documents-error').length) {
                    $entry.find('.misc-documents-uploader').after(
                        '<div class="invalid-feedback documents-error">Supporting documents are required</div>'
                    );
                }
            } else {
                // Clear error state if files exist
                $entry.find('.misc-documents-uploader').removeClass('has-error');
                $entry.find('.documents-error').remove();
            }
    
            return isValid;
        },
    
        updateRemoveButtons: function() {
            $('.misc-entry').each(function(index) {
                $(this).find('.remove-misc-entry').toggle(index > 0);
            });
        },
    
        removeEntry: function($entry) {
            const entryNumber = $entry.find('.entry-number').text();
            FileUploader.clearFiles('misc-expenses', `misc-${entryNumber}`);
            $entry.remove();
            this.updateRemoveButtons();
        }
    },
    collectCurrentStepData : function(step) {
        switch(step) {
            case 1: // Time Info
                return {
                    date: Calendar.getDate('#calendarBody'),
                    dayType: CustomDropdown.getValue('#dayTypeDropdown'),
                    inTime: {
                        hours: CustomDropdown.getValue('#inHoursDropdown') || '00',
                        minutes: CustomDropdown.getValue('#inMinutesDropdown') || '00'
                    },
                    outTime: {
                        hours: CustomDropdown.getValue('#outHoursDropdown') || '00',
                        minutes: CustomDropdown.getValue('#outMinutesDropdown') || '00'
                    }
                };
    
            case 2: // Food Expenses
                return {
                    breakfast: {
                        amount: $('#breakfastClaim').val() || '0.00',
                        files: FileUploader.getFiles('food-expenses', 'breakfast') || []
                    },
                    lunch: {
                        amount: $('#lunchClaim').val() || '0.00',
                        files: FileUploader.getFiles('food-expenses', 'lunch') || []
                    },
                    dinner: {
                        amount: $('#dinnerClaim').val() || '0.00',
                        files: FileUploader.getFiles('food-expenses', 'dinner') || []
                    }
                };
    
            case 3: // Travel Expenses
                const travelExpenses = [];
                $('.travel-entry').each(function() {
                    const $entry = $(this);
                    const entryNumber = $entry.find('.entry-number').text();
                    travelExpenses.push({
                        modeOfTransport: CustomDropdown.getValue($entry.find('.mode-transport-container')),
                        typeOfTransport: CustomDropdown.getValue($entry.find('.type-transport-container')),
                        startingMeter: $entry.find('.starting-meter').val(),
                        closingMeter: $entry.find('.closing-meter').val(),
                        totalKms: $entry.find('.total-kms').val(),
                        tollCharges: $entry.find('.toll-charges').val(),
                        fuelCharges: $entry.find('.fuel-charges').val(),
                        placesVisited: $entry.find('.places-visited').val(),
                        files: FileUploader.getFiles('travel-expenses', `travel-${entryNumber}`) || []
                    });
                });
                return travelExpenses;
    
            case 4: // Misc Expenses
                const miscExpenses = [];
                $('.misc-entry').each(function() {
                    const $entry = $(this);
                    const entryNumber = $entry.find('.entry-number').text();
                    miscExpenses.push({
                        type: CustomDropdown.getValue($entry.find('.expense-type-container')),
                        amount: $entry.find('.claim-amount').val(),
                        files: FileUploader.getFiles('misc-expenses', `misc-${entryNumber}`) || []
                    });
                });
                return miscExpenses;
    
            default:
                return null;
        }
    },
    
    /**
     * Event Handlers and Initialization (continued)
     */
    initializeEventHandlers: function() {
        // Initialize components
        this.timeManager.initialize();
        this.expenseManager.initializeFileUploaders();


        // In app.js, update the step navigation handlers
        $('.next-step, .prev-step').click(async function(e) {
            const $currentStep = $(this).closest('.step-container');
            const currentStepNumber = parseInt($currentStep.data('step'));
            const isNext = $(this).hasClass('next-step');
            
            // Validate current step if moving forward
            if (isNext) {
                let isValid = true;
                switch(currentStepNumber) {
                    case 1: // Time Info
                        isValid = ExpenseApp.timeManager.validateAndUpdate();
                        if (!isValid) {
                            showToast('Please fix the errors', 'danger');
                            return;
                        }
                        break;
                        
                    case 2: // Food Expenses
                        const meals = ['breakfast'];
                        for (const meal of meals) {
                            const result = await ExpenseApp.expenseManager.validateMealExpense(meal);
                            isValid = isValid && result;
                        }
                        if (!isValid) {
                            showToast('Please attach receipts for all expense claims', 'danger');
                            return;
                        }
                        break;
                        
                    case 3: // Travel Expenses
                        const $entries = $('.travel-entry');
                        for (const entry of $entries) {
                            const result = await ExpenseApp.travelManager.validateEntry($(entry));
                            isValid = isValid && result;
                        }
                        if (!isValid) {
                            showToast('Please complete all travel entry details', 'danger');
                            return;
                        }
                        break;
                }
            }

            // Save current step data
            const stepData = ExpenseApp.collectCurrentStepData(currentStepNumber);
            await LTCStateManager.saveCurrentState();

            // Calculate next/previous step number
            const nextStepNumber = isNext ? currentStepNumber + 1 : currentStepNumber - 1;

            // Update UI based on viewport
            if ($(window).width() <= 768) {
                // Mobile View
                $('.mobile-accordion .accordion-header').removeClass('active');
                $(`.mobile-accordion .accordion-section[data-step="${currentStepNumber}"] .accordion-header`)
                    .removeClass('active')
                    .toggleClass('completed', isNext);
                $(`.mobile-accordion .accordion-section[data-step="${nextStepNumber}"] .accordion-header`)
                    .addClass('active');
                    
                $('.mobile-accordion .step-container').hide();
                const $nextStep = $(`.mobile-accordion .step-container[data-step="${nextStepNumber}"]`);
                $nextStep.show();
                
                // Populate next step data if needed
                if (nextStepNumber === 3) { // Travel step
                    const savedState = LTCStateManager.loadState();
                    if (savedState.travelEntries?.length) {
                        savedState.travelEntries.forEach((entryData, index) => {
                            const $entry = $('.travel-entry').eq(index);
                            if ($entry.length) {
                                LTCStateManager.populateEntry('travel', $entry, entryData);
                            }
                        });
                    }
                }
            } else {
                // Desktop View
                $(`.step[data-step="${currentStepNumber}"]`)
                    .removeClass('active')
                    .toggleClass('completed', isNext);
                $(`.step[data-step="${nextStepNumber}"]`).addClass('active');
                
                $currentStep.removeClass('active');
                const $nextStep = $(`.step-container[data-step="${nextStepNumber}"]`);
                $nextStep.addClass('active');
                
                // Populate next step data if needed
                if (nextStepNumber === 3) { // Travel step
                    const savedState = LTCStateManager.loadState();
                    if (savedState.travelEntries?.length) {
                        savedState.travelEntries.forEach((entryData, index) => {
                            const $entry = $('.travel-entry').eq(index);
                            if ($entry.length) {
                                LTCStateManager.populateEntry('travel', $entry, entryData);
                            }
                        });
                    }
                }
            }
        });


        // Travel entry handlers
        $('#addTravelEntry').click(() => {
            this.travelManager.addTravelEntry();
        });

        $(document).on('click', '.remove-entry', function() {
            ExpenseApp.travelManager.removeEntry($(this).closest('.travel-entry'));
        });

        $(document).on('input', '.starting-meter, .closing-meter', function() {
            const $entry = $(this).closest('.travel-entry');
            ExpenseApp.travelManager.calculateTotalKms($entry);
        });

        // Initialize with a default misc entry
        if ($('#miscExpensesContainer').children().length === 0) {
            this.miscManager.addMiscEntry();
        }

        // Add Misc Entry handler
        $('#addMiscExpense').click(() => {
            this.miscManager.addMiscEntry();
        });
        $(document).on('click', '.remove-misc-entry', function() {
            ExpenseApp.miscManager.removeEntry($(this).closest('.misc-entry'));
        });

        // // Form submission
        // $('#submit-form').click(function() {
        //     if (ExpenseApp.validateForm()) {
        //         const formData = ExpenseApp.collectFormData();
        //         ExpenseApp.submitForm(formData);
        //     }
        // });
    },

    /**
     * Form Validation and Submission
     */
    validateForm: function() {
        let isValid = true;

        // Validate time
        if (!this.timeManager.validateAndUpdate()) {
            isValid = false;
            showToast('Please fix the time validation errors', 'danger');
            return false;
        }

        // Validate food expenses
        if (!this.expenseManager.validateAllExpenses()) {
            isValid = false;
            showToast('Please attach receipts for all expense claims', 'danger');
            return false;
        }

        // Validate travel entries
        $('.travel-entry').each(function() {
            if (!ExpenseApp.travelManager.validateEntry($(this))) {
                isValid = false;
            }
        });

        if (!isValid) {
            showToast('Please complete all required fields', 'danger');
            return false;
        }

        return true;
    },

    collectFormData: function() {
        const times = this.timeManager.getTimeValues();
        return {
            date: Calendar.getDate('#dateCalendar'),
            time: times,
            foodExpenses: {
                breakfast: {
                    amount: $('#breakfastClaim').val(),
                    files: FileUploader.getFiles('food-expenses', 'breakfast') || []
                },
                lunch: {
                    amount: $('#lunchClaim').val(),
                    files: FileUploader.getFiles('food-expenses', 'lunch') || []
                },
                dinner: {
                    amount: $('#dinnerClaim').val(),
                    files: FileUploader.getFiles('food-expenses', 'dinner') || []
                }
            },
            travelExpenses: this.collectTravelExpenses()
        };
    },

    collectTravelExpenses: function() {
        const entries = [];
        $('.travel-entry').each(function() {
            const $entry = $(this);
            const entryNumber = $entry.find('.entry-number').text();
            
            entries.push({
                modeOfTransport: CustomDropdown.getValue($entry.find('.mode-transport-container')),
                typeOfTransport: CustomDropdown.getValue($entry.find('.type-transport-container')),
                startingMeter: $entry.find('.starting-meter').val(),
                closingMeter: $entry.find('.closing-meter').val(),
                totalKms: $entry.find('.total-kms').val(),
                tollCharges: $entry.find('.toll-charges').val(),
                fuelCharges: $entry.find('.fuel-charges').val(),
                placesVisited: $entry.find('.places-visited').val(),
                files: FileUploader.getFiles('travel-expenses', `travel-${entryNumber}`)
            });
        });
        
        return entries;
    },


    /**
     * Utility Functions
     */
    formatMoney: function(amount) {
        return parseFloat(amount).toFixed(2);
    },

    formatDate: function(date) {
        return new Date(date).toLocaleDateString();
    },

    calculateDuration: function(inTime, outTime) {
        const inMinutes = parseInt(inTime.inHours) * 60 + parseInt(inTime.inMinutes);
        const outMinutes = parseInt(outTime.outHours) * 60 + parseInt(outTime.outMinutes);
        const diff = outMinutes - inMinutes;
        
        const hours = Math.floor(diff / 60);
        const minutes = diff % 60;
        
        return `${hours}h ${minutes}m`;
    }
};

/**
 * Toast Notification Helper
 */
function showToast(message, type = 'success') {
    const toastEl = $(`
        <div class="toast align-items-center text-white bg-${type} border-0" 
             role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" 
                        data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    `);
    
    $('body').append(toastEl);
    const toast = new bootstrap.Toast(toastEl[0], { delay: 3000 });
    toast.show();
    
    toastEl.on('hidden.bs.toast', function() {
        $(this).remove();
    });
}

$(document).ready(function() {    
    ExpenseApp.timeManager.initialize();
    ExpenseApp.initializeEventHandlers();

    $('.next-step, .prev-step').click(function() {
        const $currentStep = $(this).closest('.step-container');
        const currentStep = parseInt($currentStep.data('step'));
        
        // Save current step data
        const stepData = ExpenseApp.collectCurrentStepData(currentStep);
        
        // Update current step in state
        const nextStep = $(this).hasClass('next-step') ? currentStep + 1 : currentStep - 1;
    });

    // Initialize with a default travel entry
    if ($('#travelEntriesContainer').children().length === 0) {
        ExpenseApp.travelManager.addTravelEntry();
    }

    // Expense input handlers
    $('.expense-container .input-group input').on('input', function(e) {
        const input = this;
        const start = input.selectionStart;
        const end = input.selectionEnd;
        let value = $(input).val();
        const beforeValue = value;
        
        // Remove non-numeric characters except decimal
        value = value.replace(/[^\d.]/g, '');
        
        // Handle decimal points
        const decimalParts = value.split('.');
        if (decimalParts.length > 2) {
            value = decimalParts[0] + '.' + decimalParts[1];
        }
    
        // Limit to two decimal places
        if (value.includes('.')) {
            const parts = value.split('.');
            value = parts[0] + '.' + (parts[1] || '').slice(0, 2);
        }
    
        // Convert to number and check max value
        let numValue = parseFloat(value) || 0;
        if (numValue > 150) {
            numValue = 150;
            value = "150.00";
        }
    
        // Only update if value has changed
        if (value !== beforeValue) {
            $(input).val(value);
            
            // Calculate new cursor position
            const cursorPos = start - (beforeValue.length - value.length);
            // Restore cursor position after update
            input.setSelectionRange(cursorPos, cursorPos);
        }
    
        // Handle expense validations
        const meal = $(this).attr('id').replace('Claim', '').toLowerCase();
        ExpenseApp.expenseManager.validateMealExpense(meal);
        ExpenseApp.expenseManager.updateTotalFoodExpenses();
    });
    
    // Handle blur event for final formatting
    $('.expense-container .input-group input').on('blur', function() {
        let value = $(this).val();
        
        // Format to 2 decimal places when leaving the field
        const numValue = parseFloat(value) || 0;
        $(this).val(numValue.toFixed(2));
    });
    
    // Handle focus event to make editing easier
    $('.expense-container .input-group input').on('focus', function() {
        let value = $(this).val();
        if (value === '0.00') {
            $(this).val('');
        }
    });



    function initializeMobileView() {
        if ($(window).width() <= 768 && $('.mobile-accordion').length === 0) {
            // Create accordion structure
            const $accordion = $('<div class="mobile-accordion"></div>');
            
            // For each step, create an accordion section
            $('.step').each(function() {
                const stepNumber = $(this).data('step');
                const stepTitle = $(this).find('.step-title').html();
                const $stepContent = $(`.step-container[data-step="${stepNumber}"]`);
                
                const $section = $(`
                    <div class="accordion-section" data-step="${stepNumber}">
                        <div class="accordion-header ${stepNumber === 1 ? 'active' : ''}">
                            ${stepTitle}
                            <i class="bi bi-chevron-down"></i>
                        </div>
                    </div>
                `);
                
                // Move the actual step container into the accordion section
                $section.append($stepContent);
                $accordion.append($section);
            });
            
            // Insert accordion after stepper
            $('.stepper').after($accordion);
            
            // Show first step
            $('.step-container[data-step="1"]').show();
        }
    }

    function cleanupMobileView() {
        // Find active step before cleanup
        const activeStepNumber = $('.step.active').data('step');
        
        // Move step containers back
        $('.mobile-accordion .step-container').each(function() {
            const $container = $(this);
            // Hide container first
            $container.hide().removeClass('active');
            // Move back to original position
            $('.custom-container').append($container);
        });
    
        // Show only the active step
        $(`.step-container[data-step="${activeStepNumber}"]`).show().addClass('active');
        
        // Remove mobile accordion
        $('.mobile-accordion').remove();
    }

    // Initialize on page load
    if ($(window).width() <= 768) {
        initializeMobileView();
    }

    // Handle window resize
    let resizeTimer;
    $(window).resize(function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if ($(window).width() <= 768) {
                initializeMobileView();
            } else {
                cleanupMobileView();
            }
        }, 250);
    });

    

    // Add this to your document ready handler or where you initialize event handlers
// Add this to your document ready handler or where you initialize event handlers

$('#submit-form').click(async function(e) {
    e.preventDefault();

    // Validate all steps first
    let isValid = true;

    // 1. Validate Time Info
    if (!ExpenseApp.timeManager.validateAndUpdate()) {
        isValid = false;
        showToast('Please complete time information', 'danger');
        return;
    }

    // 2. Validate Food Expenses
    const meals = ['breakfast'];
    for (const meal of meals) {
        const result = await ExpenseApp.expenseManager.validateMealExpense(meal);
        if (!result) {
            isValid = false;
            showToast('Please complete food expenses', 'danger');
            return;
        }
    }

    // 3. Validate Travel Entries
    const $travelEntries = $('.travel-entry');
    for (const entry of $travelEntries) {
        const result = await ExpenseApp.travelManager.validateEntry($(entry));
        if (!result) {
            isValid = false;
            showToast('Please complete travel entries', 'danger');
            return;
        }
    }

    // 4. Validate Misc Expenses
    const $miscEntries = $('.misc-entry');
    let miscValid = true;
    for (const entry of $miscEntries) {
        const result = await ExpenseApp.miscManager.validateEntry($(entry));
        if (!result) {
            miscValid = false;
            break;
        }
    }
    
    if (!miscValid) {
        isValid = false;
        showToast('Please complete miscellaneous expenses', 'danger');
        return;
    }

    if (isValid) {
        if (confirm('Are you sure you want to submit this expense claim?')) {
            await ExpenseApp.formSubmission.submitForm();
        }
    }
});
});


// Add this to ExpenseApp object

/**
 * Form submission handler
 */
ExpenseApp.formSubmission = {
    // In your form submission code
    prepareFormData: async function() {
        try {
            console.log('============ STARTING FORM DATA PREPARATION ============');
            const formData = new FormData();
            const savedState = LTCStateManager.loadState();
            console.log('Loaded saved state:', savedState);
    
            if (savedState.timeInfo) {
                formData.append('timeInfo', JSON.stringify(savedState.timeInfo));
            }
            if (savedState.foodExpense) {
                formData.append('foodExpense', JSON.stringify(savedState.foodExpense));
            }
            if (savedState.travelEntries) {
                formData.append('travelEntries', JSON.stringify(savedState.travelEntries));
            }
            if (savedState.miscExpenses) {
                formData.append('miscExpenses', JSON.stringify(savedState.miscExpenses));
            }
            
            // Food files
            console.log('\nProcessing Food Files:');
            const breakfastFiles = await FileUploader.getFiles('food-expenses', 'breakfast') || [];
            for (let i = 0; i < breakfastFiles.length; i++) {
                formData.append('breakfast_files[]', breakfastFiles[i]);
                console.log('Added breakfast file:', { name: breakfastFiles[i].name, type: breakfastFiles[i].type });
            }
    
            // Travel files
            if (savedState.travelEntries && savedState.travelEntries.length) {
                console.log('\nProcessing Travel Files:');
                for (let i = 0; i < savedState.travelEntries?.length || 0; i++) {
                    const entryNum = i + 1;
                    
                    const travelFiles = await FileUploader.getFiles('travel-expenses', `travel-${entryNum}`) || [];
                    for (const file of travelFiles) {
                        formData.append(`travel_files_${entryNum}[]`, file);
                        console.log(`Added travel file for entry ${entryNum}:`, { name: file.name, type: file.type });
                    }
        
                    const approvalFiles = await FileUploader.getFiles('travel-expenses', `travel-approval-${entryNum}`) || [];
                    if (approvalFiles.length) {
                        formData.append(`travel_approval_${entryNum}`, approvalFiles[0]);
                        console.log(`Added approval file for entry ${entryNum}:`, { name: approvalFiles[0].name, type: approvalFiles[0].type });
                    }
                }
            }
    
            // Misc files
            if (savedState.miscExpenses && savedState.miscExpenses.length) {
                console.log('\nProcessing Misc Files:');
                for (let i = 0; i < savedState.miscExpenses?.length || 0; i++) {
                    const entryNum = i + 1;
                    const miscFiles = await FileUploader.getFiles('misc-expenses', `misc-${entryNum}`) || [];
                    for (const file of miscFiles) {
                        formData.append(`misc_files_${entryNum}[]`, file);
                        console.log(`Added misc file for entry ${entryNum}:`, { name: file.name, type: file.type });
                    }
                }
            }
    
            // Log final FormData contents
            console.log('\n============ FINAL FORM DATA CONTENTS ============');
            for (const [key, value] of formData.entries()) {
                if (value instanceof File) {
                    console.log(`${key}:`, {
                        type: 'File',
                        name: value.name,
                        size: this.formatFileSize(value.size),
                        mimeType: value.type
                    });
                } else {
                    try {
                        console.log(`${key}:`, typeof value === 'string' ? JSON.parse(value) : value);
                    } catch (err) {
                        console.log(`${key}:`, value);
                    }
                }
            }
    
            console.log('============ FORM DATA PREPARATION COMPLETE ============');
            return formData;
        } catch (error) {
            console.error('============ ERROR IN FORM DATA PREPARATION ============');
            console.error('Error:', error);
            throw error;
        }
    },
    
    formatFileSize: function(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    },
    

    // Helper function to convert Data URL to File object
    dataURLtoFile: function(dataurl, filename) {
        if (!dataurl) return null;
        
        const arr = dataurl.split(',');
        const mime = arr[0].match(/:(.*?);/)[1];
        const bstr = atob(arr[1]);
        let n = bstr.length;
        const u8arr = new Uint8Array(n);
        
        while(n--) {
            u8arr[n] = bstr.charCodeAt(n);
        }
        
        return new File([u8arr], filename, {type: mime});
    },

    // Submit form data
    submitForm: async function() {
        try {
            const formData = await this.prepareFormData();
            
            // Show loading state
            $('#submit-form').prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm me-2"></span>Submitting...'
            );
            const token = $('#csrfToken').val();

            // Make AJAX request
            const response = await $.ajax({
                url: '/admin/travelmanagement/create-ltc-claim-application',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                xhr: function() {
                    const xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function(evt) {
                        if (evt.lengthComputable) {
                            const percentComplete = (evt.loaded / evt.total) * 100;
                            // Update progress if needed
                            console.log('Upload progress:', percentComplete + '%');
                        }
                    }, false);
                    return xhr;
                }
            });

            // Handle success
            showToast('Form submitted successfully!', 'success');
            
            // Clear form data
            // await LTCStateManager.clearAllData();
            
            // Redirect or reset form
            // setTimeout(() => {
            //     window.location.href = '/dashboard';  // Replace with your dashboard URL
            // }, 2000);

        } catch (error) {
            console.error('Error submitting form:', error);
            showToast('Error submitting form. Please try again.', 'danger');
            
            // Reset submit button
            $('#submit-form').prop('disabled', false).html(
                'Submit Claim<i class="bi bi-send ms-2"></i>'
            );
        }
    }
};