/**
 * LTC Application State Manager with IndexedDB support
 * Handles state persistence and file storage
 */
const LTCStateManager = {
    // Storage keys and DB config
    STORAGE_KEY: 'ltc_application_state',
    
    // Initial state structure
    initialState: {
        currentStep: 1,
        timeInfo: {
            date: '',
            inTime: {
                hours: '00',
                minutes: '00'
            },
            outTime: {
                hours: '00',
                minutes: '00'
            },
            dayType: ''
        },
        foodExpense: {
            breakfast: { amount: '0.00'}
        },
        travelEntries: [],
        miscExpense: [],
        isSubmitted: false
    },

    // Initialize state management
    async init() {
        try {
            console.log('Initializing LTC State Manager...');
            
            this.settings = {
                inputSelector: '.datepicker',
                calendarSelector: '#calendarBody'
            };

            // Override Calendar's date selection to save state
            const originalCalendarInit = Calendar.init;
            Calendar.init = (options) => {
                const newOptions = {
                    ...options,
                    onChange: async (date) => {
                        console.log('Calendar date changed:', date);
                        if (options.onChange) options.onChange(date);
                        await this.saveCurrentState();
                    }
                };
                return originalCalendarInit.call(Calendar, newOptions);
            };

            // Load state and initialize
            const savedState = this.loadState();
            console.log('Loaded saved state:', savedState);
            
            await this.initializeComponents(savedState);
        } catch (error) {
            console.error('Error initializing LTC State Manager:', error);
        }
    },

    async initializeComponents(savedState) {
        // Initialize dropdowns
        this.initializeDropdowns();
        
        // Override FileUploader's file saving
        if (window.FileUploader) {
            const originalSaveFiles = FileUploader.saveFiles;
            FileUploader.saveFiles = async function(moduleId, sectionId, files) {
                console.log('Saving files:', moduleId, sectionId);
                
                // Save to FileUploader's state
                const result = await originalSaveFiles.call(this, moduleId, sectionId, files);
                
                // Force preview update
                const $uploader = FileUploader.getInstance(moduleId, sectionId);
                if ($uploader?.length) {
                    setTimeout(() => {
                        this.updateFilePreviews($uploader);
                    }, 100);
                }
                
                return result;
            };
        }

        // Bind all change events
        this.bindChangeEvents();
        
        // Load saved data
        await this.initializeFormWithSavedData(savedState);
        
        if (savedState.timeInfo) {
            ExpenseApp.timeManager.validateAndUpdate();
        }
    },

    // Load state from localStorage
    loadState() {
        const savedState = localStorage.getItem(this.STORAGE_KEY);
        return savedState ? JSON.parse(savedState) : this.initialState;
    },

    // Initialize dropdowns
    initializeDropdowns() {
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

        ['in', 'out'].forEach(type => {
            CustomDropdown.init({
                container: `#${type}HoursDropdown`,
                data: timeConfig.hours,
                placeholder: '00',
                onChange: () => this.saveCurrentState()
            });
            CustomDropdown.init({
                container: `#${type}MinutesDropdown`,
                data: timeConfig.minutes,
                placeholder: '00',
                onChange: () => this.saveCurrentState()
            });
        });
    },

    // Bind change events
    bindChangeEvents() {
        // Form fields
        $('input, textarea, select').on('change', () => this.saveCurrentState());

        // Custom dropdowns
        $('.custom-select').on('change', '.dropdown-value', () => this.saveCurrentState());

        // File uploads
        FileUploader.onChange = () => this.saveCurrentState();

        // Navigation
        $('.next-step, .prev-step').on('click', () => this.saveCurrentState());

        // Handle travel entries add/remove
        $('#addTravelEntry').on('click', () => {
            setTimeout(() => this.saveCurrentState(), 100);
        });

        $(document).on('click', '.remove-entry', () => this.saveCurrentState());

        // Handle misc entries add/remove
        $('#addMiscExpense').on('click', () => {
            setTimeout(() => this.saveCurrentState(), 100);
        });

        $(document).on('click', '.remove-misc-entry', () => this.saveCurrentState());
    },

    // Save current state immediately
    async saveCurrentState() {
        console.log('Saving current state...');
        const currentState = await this.collectCurrentState();
        console.log('State to save:', currentState);
        try {
            localStorage.setItem(this.STORAGE_KEY, JSON.stringify(currentState));
            console.log('State saved successfully');
        } catch (error) {
            console.error('Error saving state:', error);
        }
    },

    // Initialize form with saved data
    async initializeFormWithSavedData(savedState) {
        if (!savedState) return;

        try {
            // Populate Time Info
            if (savedState.timeInfo) {
                $(this.settings.inputSelector).val(savedState.timeInfo.date);
                
                // Set calendar date with a delay
                setTimeout(() => {
                    Calendar.setDate('#calendarBody', savedState.timeInfo.date);
                }, 200);
                
                // Set dropdowns
                CustomDropdown.setValue('#dayTypeDropdown', savedState.timeInfo.dayType);
                
                const { inTime, outTime } = savedState.timeInfo;
                if (inTime) {
                    CustomDropdown.setValue('#inHoursDropdown', inTime.hours);
                    CustomDropdown.setValue('#inMinutesDropdown', inTime.minutes);
                }
                if (outTime) {
                    CustomDropdown.setValue('#outHoursDropdown', outTime.hours);
                    CustomDropdown.setValue('#outMinutesDropdown', outTime.minutes);
                }
            }

            // Load files before updating UI
            if (savedState.foodExpense?.breakfast?.files?.length) {
                await FileUploader.saveFiles(
                    'food-expenses', 
                    'breakfast',
                    savedState.foodExpense.breakfast.files
                );
                $('#breakfastClaim').val(savedState.foodExpense.breakfast.amount || '0.00');
            }

            // Handle travel entries
            if (savedState.travelEntries?.length) {
                for (const [index, entry] of savedState.travelEntries.entries()) {
                    if (index > 0) {
                        await new Promise(resolve => {
                            ExpenseApp.travelManager.addTravelEntry();
                            setTimeout(resolve, 100);
                        });
                    }
                    await this.populateEntry('travel', $('.travel-entry').eq(index), entry);
                }
            }

            // Handle misc entries
            if (savedState.miscExpense?.length) {
                for (const [index, expense] of savedState.miscExpense.entries()) {
                    if (index > 0) {
                        await new Promise(resolve => {
                            ExpenseApp.miscManager.addMiscEntry();
                            setTimeout(resolve, 100);
                        });
                    }
                    await this.populateEntry('misc', $('.misc-entry').eq(index), expense);
                }
            }
        } catch (error) {
            console.error('Error loading saved data:', error);
        }
    },

    // Populate entry with saved data
    async populateEntry(type, $entry, data) {
        if (!$entry?.length) return;
        
        try {
            if (type === 'travel') {
                // For travel entries, handle dependent dropdowns
                const $modeContainer = $entry.find('.mode-transport-container');
                const $typeContainer = $entry.find('.type-transport-container');
                
                // First set the mode of transport
                CustomDropdown.setValue($modeContainer, data.modeOfTransport);
                $modeContainer.find(`.select-option[data-value="${data.modeOfTransport}"]`).click()
                $typeContainer.find(`.select-option[data-value="${data.typeOfTransport}"]`).click()

                
                // Set other travel entry fields
                $entry.find('.starting-meter').val(data.startingMeter || '0');
                $entry.find('.closing-meter').val(data.closingMeter || '0');
                $entry.find('.total-kms').val(data.totalKms || '0');
                $entry.find('.toll-charges').val(data.tollCharges || '0');
                $entry.find('.fuel-charges').val(data.fuelCharges || '0');
                $entry.find('.places-visited').val(data.placesVisited || '');
            } else {
                // Handle misc entries
                CustomDropdown.setValue($entry.find('.expense-type-container'), data.type);
                $entry.find('.claim-amount').val(data.amount || '0');
            }
    
            // Handle file preview
            const entryNumber = $entry.find('.entry-number').text();
            const moduleId = type === 'travel' ? 'travel-expenses' : 'misc-expenses';
            const sectionId = `${type}-${entryNumber}`;
            
            if (data.files?.length) {
                await FileUploader.saveFiles(moduleId, sectionId, data.files);
            }
        } catch (error) {
            console.error(`Error populating ${type} entry:`, error);
        }
    },

    // Collect current state
    async collectCurrentState() {
        const currentStep = $('.step-container.active').data('step');
        let state = { ...this.initialState };

        try {
            // Time Info
            state.timeInfo = {
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

            // Food Expenses
            const foodFiles = await FileUploader.getFiles('food-expenses', 'breakfast');
            state.foodExpense = {
                breakfast: {
                    amount: $('#breakfastClaim').val() || '0.00',
                    files: foodFiles
                }
            };

            // Travel Entries
            state.travelEntries = await this.collectTravelEntries();

            // Misc Expenses
            state.miscExpense = await this.collectMiscExpenses();

            return state;
        } catch (error) {
            console.error('Error collecting state:', error);
            return state;
        }
    },

    // Collect travel entries
    async collectTravelEntries() {
        const entries = [];
        for (const entry of $('.travel-entry').toArray()) {
            const $entry = $(entry);
            const entryNumber = $entry.find('.entry-number').text();
            const files = await FileUploader.getFiles('travel-expenses', `travel-${entryNumber}`);
            
            entries.push({
                modeOfTransport: CustomDropdown.getValue($entry.find('.mode-transport-container')),
                typeOfTransport: CustomDropdown.getValue($entry.find('.type-transport-container')),
                startingMeter: $entry.find('.starting-meter').val(),
                closingMeter: $entry.find('.closing-meter').val(),
                totalKms: $entry.find('.total-kms').val(),
                tollCharges: $entry.find('.toll-charges').val(),
                fuelCharges: $entry.find('.fuel-charges').val(),
                placesVisited: $entry.find('.places-visited').val(),
                files: files
            });
        }
        return entries;
    },

    // Collect misc expenses
    async collectMiscExpenses() {
        const expenses = [];
        for (const entry of $('.misc-entry').toArray()) {
            const $entry = $(entry);
            const entryNumber = $entry.find('.entry-number').text();
            const files = await FileUploader.getFiles('misc-expenses', `misc-${entryNumber}`);
            
            expenses.push({
                type: CustomDropdown.getValue($entry.find('.expense-type-container')),
                amount: $entry.find('.claim-amount').val(),
                files: files
            });
        }
        return expenses;
    },

    // Clear all data
    async clearAllData() {
        try {
            // Clear localStorage
            localStorage.removeItem(this.STORAGE_KEY);
            
            // Clear all file storage
            await FileUploader.clearAllFiles();
            
            console.log('All data cleared successfully');
        } catch (error) {
            console.error('Error clearing data:', error);
        }
    }
};

// Initialize when document is ready
$(document).ready(() => {
    // Wait for other components to initialize first
    setTimeout(() => {
        LTCStateManager.init();
    }, 500);
});

// Export for use in other modules
window.LTCStateManager = LTCStateManager;