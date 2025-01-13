/**
 * ExpenseHandler Module
 * Handles expense editing and deletion functionality
 */
const ExpenseHandler = {
    init: function() {
        this.attachEventListeners();
        return this;
    },

    attachEventListeners: function() {
        // Edit expense
        $(document).on('click', '.exp-card-btns .fa-pencil', function(e) {
            e.preventDefault();
            const expenseId = $(this).closest('.exp-data').data('expense-id');
            const expenseType = $(this).closest('.exp-data-wrapper').data('expense-type');
            ExpenseHandler.loadExpenseForEdit(expenseId, expenseType);
        });

        // Delete expense
        $(document).on('click', '.exp-card-btns .fa-trash', function(e) {
            e.preventDefault();
            const expenseId = $(this).closest('.exp-data').data('expense-id');
            const expenseType = $(this).closest('.exp-data-wrapper').data('expense-type');
            ExpenseHandler.deleteExpense(expenseId, expenseType);
        });

        // Save edited expense
        $(document).on('click', '#expenseModal .save-expense', function(e) {
            e.preventDefault();
            ExpenseHandler.saveEditedExpense();
        });
    },

    loadExpenseForEdit: function(expenseId, expenseType) {
        const storageKey = `${expenseType}_expenses`;
        const expenses = JSON.parse(localStorage.getItem(storageKey) || '[]');
        const expense = expenses.find(exp => exp.id === expenseId);

        if (!expense) {
            console.error('Expense not found');
            return;
        }

        // Populate modal fields based on expense type
        const $modal = $('#expenseModal');
        switch (expenseType) {
            case 'food':
                $modal.find('#foodExpenseDate').val(expense.date);
                $modal.find('#foodExpenseAmount').val(expense.amount);
                $modal.find('#foodExpenseDescription').val(expense.description);
                break;
            case 'travel':
                $modal.find('#travelExpenseDate').val(expense.date);
                $modal.find('#travelMode').val(expense.mode);
                $modal.find('#travelFrom').val(expense.from);
                $modal.find('#travelTo').val(expense.to);
                $modal.find('#travelAmount').val(expense.amount);
                break;
            case 'misc':
                $modal.find('#miscExpenseDate').val(expense.date);
                $modal.find('#miscExpenseType').val(expense.type);
                $modal.find('#miscExpenseAmount').val(expense.amount);
                $modal.find('#miscExpenseDescription').val(expense.description);
                break;
        }

        // Store current editing expense info
        $modal.data('editing', {
            id: expenseId,
            type: expenseType
        });

        // Show appropriate section in modal
        $modal.find('.expense-section').hide();
        $modal.find(`.${expenseType}-expense-section`).show();
        
        // Open modal
        $modal.modal('show');
    },

    saveEditedExpense: function() {
        const $modal = $('#expenseModal');
        const editingInfo = $modal.data('editing');

        if (!editingInfo) {
            console.error('No expense being edited');
            return;
        }

        const { id, type } = editingInfo;
        const storageKey = `${type}_expenses`;
        const expenses = JSON.parse(localStorage.getItem(storageKey) || '[]');
        const expenseIndex = expenses.findIndex(exp => exp.id === id);

        if (expenseIndex === -1) {
            console.error('Expense not found for editing');
            return;
        }

        // Get updated values based on expense type
        let updatedExpense = { id };
        switch (type) {
            case 'food':
                updatedExpense = {
                    ...updatedExpense,
                    date: $('#foodExpenseDate').val(),
                    amount: $('#foodExpenseAmount').val(),
                    description: $('#foodExpenseDescription').val()
                };
                break;
            case 'travel':
                updatedExpense = {
                    ...updatedExpense,
                    date: $('#travelExpenseDate').val(),
                    mode: $('#travelMode').val(),
                    from: $('#travelFrom').val(),
                    to: $('#travelTo').val(),
                    amount: $('#travelAmount').val()
                };
                break;
            case 'misc':
                updatedExpense = {
                    ...updatedExpense,
                    date: $('#miscExpenseDate').val(),
                    type: $('#miscExpenseType').val(),
                    amount: $('#miscExpenseAmount').val(),
                    description: $('#miscExpenseDescription').val()
                };
                break;
        }

        // Update expense in storage
        expenses[expenseIndex] = updatedExpense;
        localStorage.setItem(storageKey, JSON.stringify(expenses));

        // Update UI
        this.updateExpenseDisplay(updatedExpense, type);

        // Close modal
        $modal.modal('hide');
        
        // Show success message
        this.showToast('Expense updated successfully', 'success');
    },

    deleteExpense: function(expenseId, expenseType) {
        if (!confirm('Are you sure you want to delete this expense?')) {
            return;
        }

        const storageKey = `${expenseType}_expenses`;
        const expenses = JSON.parse(localStorage.getItem(storageKey) || '[]');
        const updatedExpenses = expenses.filter(exp => exp.id !== expenseId);
        
        // Update storage
        localStorage.setItem(storageKey, JSON.stringify(updatedExpenses));

        // Remove from UI
        $(`.exp-data[data-expense-id="${expenseId}"]`).fadeOut(300, function() {
            $(this).remove();
            ExpenseHandler.updateTotalAmount(expenseType);
        });

        this.showToast('Expense deleted successfully', 'success');
    },

    updateExpenseDisplay: function(expense, type) {
        const $expenseElement = $(`.exp-data[data-expense-id="${expense.id}"]`);
        
        // Update display based on expense type
        switch (type) {
            case 'food':
                $expenseElement.find('.exp-date').text(expense.date);
                $expenseElement.find('.exp-amount').text(expense.amount);
                $expenseElement.find('.exp-description').text(expense.description);
                break;
            case 'travel':
                $expenseElement.find('.exp-date').text(expense.date);
                $expenseElement.find('.exp-mode').text(expense.mode);
                $expenseElement.find('.exp-from').text(expense.from);
                $expenseElement.find('.exp-to').text(expense.to);
                $expenseElement.find('.exp-amount').text(expense.amount);
                break;
            case 'misc':
                $expenseElement.find('.exp-date').text(expense.date);
                $expenseElement.find('.exp-type').text(expense.type);
                $expenseElement.find('.exp-amount').text(expense.amount);
                $expenseElement.find('.exp-description').text(expense.description);
                break;
        }

        this.updateTotalAmount(type);
    },

    updateTotalAmount: function(expenseType) {
        const storageKey = `${expenseType}_expenses`;
        const expenses = JSON.parse(localStorage.getItem(storageKey) || '[]');
        const total = expenses.reduce((sum, exp) => sum + parseFloat(exp.amount || 0), 0);
        
        // Update total display
        $(`.${expenseType}-total-amount`).text(total.toFixed(2));
    },

    showToast: function(message, type = 'info') {
        const toast = `
            <div class="toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;

        $('.toast-container').append(toast);
        const $toast = $('.toast').last();
        const bsToast = new bootstrap.Toast($toast);
        bsToast.show();

        // Remove toast after it's hidden
        $toast.on('hidden.bs.toast', function() {
            $(this).remove();
        });
    }
};

// Initialize when document is ready
$(document).ready(function() {
    ExpenseHandler.init();
});

// Export the module
window.ExpenseHandler = ExpenseHandler;