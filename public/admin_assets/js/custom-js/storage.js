/**
 * State Manager for Expense Form
 * Handles state persistence and management
 */
const StateManager = {
    storageKey: 'expense_form_state',
    
    // Default state structure
    defaultState: {
        currentStep: 1,
        timeInfo: {
            date: null,
            dayType: null,
            inTime: { hours: '00', minutes: '00' },
            outTime: { hours: '00', minutes: '00' }
        },
        foodExpenses: {
            breakfast: { amount: '0.00', files: [] },
            lunch: { amount: '0.00', files: [] },
            dinner: { amount: '0.00', files: [] }
        },
        travelExpenses: [],
        miscExpenses: []
    },

    // Initialize state
    init() {
        try {
            const savedState = this.getState();
            if (!savedState) {
                this.setState(this.defaultState);
                return this.defaultState;
            }
            
            // Validate saved state structure
            const validatedState = this.validateState(savedState);
            if (validatedState !== savedState) {
                this.setState(validatedState);
            }
            return validatedState;
        } catch (error) {
            console.error('Error initializing state:', error);
            this.setState(this.defaultState);
            return this.defaultState;
        }
    },

    // Validate and repair state if needed
    validateState(state) {
        const validated = { ...this.defaultState };
        
        try {
            // Validate and merge each section
            if (state.currentStep && typeof state.currentStep === 'number') {
                validated.currentStep = Math.min(Math.max(1, state.currentStep), 4);
            }

            if (state.timeInfo) {
                validated.timeInfo = {
                    ...validated.timeInfo,
                    ...state.timeInfo
                };
            }

            if (state.foodExpenses) {
                ['breakfast', 'lunch', 'dinner'].forEach(meal => {
                    if (state.foodExpenses[meal]) {
                        validated.foodExpenses[meal] = {
                            amount: state.foodExpenses[meal].amount || '0.00',
                            files: Array.isArray(state.foodExpenses[meal].files) 
                                ? state.foodExpenses[meal].files 
                                : []
                        };
                    }
                });
            }

            if (Array.isArray(state.travelExpenses)) {
                validated.travelExpenses = state.travelExpenses;
            }

            if (Array.isArray(state.miscExpenses)) {
                validated.miscExpenses = state.miscExpenses;
            }

            return validated;
        } catch (error) {
            console.error('Error validating state:', error);
            return this.defaultState;
        }
    },

    // Get current state
    getState() {
        try {
            const state = localStorage.getItem(this.storageKey);
            return state ? JSON.parse(state) : null;
        } catch (error) {
            console.error('Error reading state:', error);
            return null;
        }
    },

    // Update state
    setState(newState) {
        try {
            localStorage.setItem(this.storageKey, JSON.stringify(newState));
            this.notifyStateChange(newState);
        } catch (error) {
            console.error('Error saving state:', error);
            // Handle storage errors (e.g., quota exceeded)
            if (error.name === 'QuotaExceededError') {
                this.handleStorageError();
            }
        }
    },

    // Update specific step data
    updateStepData(step, data) {
        const currentState = this.getState();
        const updatedState = { ...currentState };

        switch(step) {
            case 1: // Time Info
                updatedState.timeInfo = { ...updatedState.timeInfo, ...data };
                break;
            case 2: // Food Expenses
                updatedState.foodExpenses = { ...updatedState.foodExpenses, ...data };
                break;
            case 3: // Travel Expenses
                updatedState.travelExpenses = Array.isArray(data) ? data : updatedState.travelExpenses;
                break;
            case 4: // Misc Expenses
                updatedState.miscExpenses = Array.isArray(data) ? data : updatedState.miscExpenses;
                break;
        }

        this.setState(updatedState);
    },

    // Update current step
    updateCurrentStep(step) {
        const currentState = this.getState();
        this.setState({ ...currentState, currentStep: step });
    },

    // Clear state
    clearState() {
        localStorage.removeItem(this.storageKey);
    },

    // Handle storage errors
    handleStorageError() {
        // Remove old data or implement cleanup strategy
        const state = this.getState();
        if (state) {
            // Remove old file data to free up space
            if (state.foodExpenses) {
                Object.keys(state.foodExpenses).forEach(meal => {
                    state.foodExpenses[meal].files = [];
                });
            }
            state.travelExpenses.forEach(expense => {
                expense.files = [];
            });
            state.miscExpenses.forEach(expense => {
                expense.files = [];
            });
            this.setState(state);
        }
    },

    // State change notification
    notifyStateChange(newState) {
        // Dispatch custom event for state changes
        window.dispatchEvent(new CustomEvent('expenseFormStateChange', {
            detail: { state: newState }
        }));
    }
};

// Export the module
window.StateManager = StateManager;