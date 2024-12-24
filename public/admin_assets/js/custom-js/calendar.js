// Complete calendar.js
const Calendar = {
    settings: null,
    initialized: false,
    init: function(options) {
        // Initialize with defaults first
        this.initialized = false;
        this.settings = {
            container: '#calendarBody',
            minDate: null,
            maxDate: new Date(),
            onChange: null,
            inputSelector: '.datepicker',
            wrapperSelector: '.calendar-wrapper'
        };

        // Merge valid options
        if (options && typeof options === 'object') {
            // Handle dates specifically
            if (options.minDate) {
                try {
                    this.settings.minDate = options.minDate instanceof Date ? 
                        new Date(options.minDate) : new Date(options.minDate);
                    
                    if (isNaN(this.settings.minDate.getTime())) {
                        console.warn('Invalid minDate provided');
                        this.settings.minDate = null;
                    }
                } catch (e) {
                    console.error('Error setting minDate:', e);
                    this.settings.minDate = null;
                }
            }

            if (options.maxDate) {
                try {
                    this.settings.maxDate = options.maxDate instanceof Date ? 
                        new Date(options.maxDate) : new Date(options.maxDate);
                    
                    if (isNaN(this.settings.maxDate.getTime())) {
                        console.warn('Invalid maxDate provided');
                        this.settings.maxDate = new Date();
                    }
                } catch (e) {
                    console.error('Error setting maxDate:', e);
                    this.settings.maxDate = new Date();
                }
            }

            // Merge other options
            this.settings = { 
                ...this.settings, 
                ...options,
                minDate: this.settings.minDate, // Keep our processed dates
                maxDate: this.settings.maxDate
            };
        }

        if (!$(this.settings.container).length) {
            console.error('Calendar container not found:', this.settings.container);
            return null;
        }

        const currentDate = new Date();
        
        this.setupInput();
        $(this.settings.wrapperSelector).hide();
        this.renderCalendar(currentDate);
        this.attachEvents();
        this.initialized = true;
        return this;
    },
    ensureInitialized: function() {
        if (!this.initialized || !this.settings) {
            console.error('Calendar not properly initialized. Call Calendar.init() first.');
            return false;
        }
        return true;
    },

    setupInput: function() {
        const $input = $(this.settings.inputSelector);
        const $wrapper = $(this.settings.wrapperSelector);
        
        if (!$input.length || !$wrapper.length) {
            console.warn('Input or calendar wrapper not found');
            return;
        }

        // Remove any existing handlers first
        $input.off('click.calendar');
        $(document).off('click.calendar');

        // Show calendar when input is clicked
        $input.on('click.calendar', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $wrapper.show();
        });

        // Hide calendar when clicking outside
        $(document).on('click.calendar', function(e) {
            if (!$(e.target).closest(this.settings.wrapperSelector).length && 
                !$(e.target).is(this.settings.inputSelector)) {
                $wrapper.hide();
            }
        }.bind(this));
    },

    renderCalendar: function(date) {
        // Check if settings and container exist
        if (!this.settings || !this.settings.container) {
            console.error('Calendar settings or container not initialized');
            return;
        }

        // Ensure we have a valid date
        if (!date || !(date instanceof Date)) {
            date = new Date();
        }

        try {
            // Verify container exists in DOM
            const $container = $(this.settings.container);
            if (!$container.length) {
                console.error('Calendar container not found in DOM:', this.settings.container);
                return;
            }

            const year = date.getFullYear();
            const month = date.getMonth();
            
            $('#currentMonth').text(
                date.toLocaleString('default', { 
                    month: 'long', 
                    year: 'numeric' 
                })
            );

            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const startingDay = firstDay.getDay();
            const monthLength = lastDay.getDate();
            
            let html = '';
            let day = 1;
            
            for (let i = 0; i < 6; i++) {
                html += '<tr>';
                
                for (let j = 0; j < 7; j++) {
                    if (i === 0 && j < startingDay) {
                        html += '<td class="disabled"></td>';
                    } else if (day > monthLength) {
                        html += '<td class="disabled"></td>';
                    } else {
                        const currentDay = new Date(year, month, day);
                        const isDisabled = this.isDateDisabled(currentDay);
                        const isToday = this.isDateToday(currentDay);
                        const dateStr = this.formatDate(currentDay);
                        
                        html += `<td class="${isDisabled ? 'disabled' : ''} ${isToday ? 'today' : ''}" 
                                    data-date="${dateStr}">
                                ${day}
                               </td>`;
                        day++;
                    }
                }
                
                html += '</tr>';
                if (day > monthLength) break;
            }

            // Update container content
            $container.html(html);
        } catch (e) {
            console.error('Error rendering calendar:', e);
        }
    },

    isDateToday: function(date) {
        if (!date || !(date instanceof Date) || isNaN(date.getTime())) {
            return false;
        }

        try {
            const today = new Date();
            return date.getDate() === today.getDate() &&
                   date.getMonth() === today.getMonth() &&
                   date.getFullYear() === today.getFullYear();
        } catch (e) {
            console.error('Error in isDateToday:', e);
            return false;
        }
    },

    isDateDisabled: function(date) {
        // First check if we have a valid date parameter
        if (!date || !(date instanceof Date)) {
            return true;
        }

        // Check if settings exist
        if (!this.settings) {
            return false;
        }

        try {
            // Check minDate
            if (this.settings.minDate && this.settings.minDate instanceof Date) {
                const minDateCopy = new Date(this.settings.minDate);
                minDateCopy.setHours(0, 0, 0, 0);
                const dateCopy = new Date(date);
                dateCopy.setHours(0, 0, 0, 0);
                
                if (dateCopy < minDateCopy) {
                    return true;
                }
            }

            // Check maxDate
            if (this.settings.maxDate && this.settings.maxDate instanceof Date) {
                const maxDateCopy = new Date(this.settings.maxDate);
                maxDateCopy.setHours(23, 59, 59, 999);
                const dateCopy = new Date(date);
                dateCopy.setHours(0, 0, 0, 0);
                
                if (dateCopy > maxDateCopy) {
                    return true;
                }
            }

            return false;
        } catch (e) {
            console.error('Error in isDateDisabled:', e);
            return true;
        }
    },

    formatDate: function(date) {
        if (!date || !(date instanceof Date) || isNaN(date.getTime())) {
            return '';
        }

        try {
            const day = date.getDate().toString().padStart(2, '0');
            const month = date.toLocaleString('default', { month: 'short' });
            const year = date.getFullYear();
            return `${day}-${month}-${year}`;
        } catch (e) {
            console.error('Error in formatDate:', e);
            return '';
        }
    },

    attachEvents: function() {
        // Previous month button
        $('#prevMonth').off('click').on('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            const currentDate = new Date($('#currentMonth').text());
            currentDate.setMonth(currentDate.getMonth() - 1);
            this.renderCalendar(currentDate);
        });

        // Next month button
        $('#nextMonth').off('click').on('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            const currentDate = new Date($('#currentMonth').text());
            currentDate.setMonth(currentDate.getMonth() + 1);
            this.renderCalendar(currentDate);
        });

        // Date selection
        $(this.settings.container).off('click', 'td:not(.disabled)').on('click', 'td:not(.disabled)', (e) => {
            e.preventDefault();
            e.stopPropagation();
            const date = $(e.currentTarget).data('date');
            
            $(`${this.settings.container} td`).removeClass('selected');
            $(e.currentTarget).addClass('selected');
            
            if (this.settings.inputSelector) {
                $(this.settings.inputSelector).val(date);
            }
            
            $(this.settings.wrapperSelector).hide();
            
            if (this.settings.onChange) {
                this.settings.onChange(date);
            }
        });
    },

    getDate: function(container) {
        try {
            if (!container) return '';
            const selected = $(container).find('td.selected').data('date');
            return selected || '';
        } catch (e) {
            console.error('Error in getDate:', e);
            return '';
        }
    },

    setDate: function(container, date) {
        // Add container validation
        if (!container) {
            console.error('No container provided to setDate');
            return;
        }
        if (!this.ensureInitialized()) {
            return;
        }

        // Ensure settings are initialized
        if (!this.settings) {
            console.error('Calendar settings not initialized');
            return;
        }
        
        try {
            const dateObj = new Date(date);
            if (!isNaN(dateObj.getTime())) {
                this.renderCalendar(dateObj);
                
                const formattedDate = this.formatDate(dateObj);
                const $container = $(container);
                
                if ($container.length) {
                    $container.find('td').removeClass('selected');
                    $container.find(`td[data-date="${formattedDate}"]`).addClass('selected');
                    
                    if (this.settings.inputSelector) {
                        const $input = $(this.settings.inputSelector);
                        if ($input.length) {
                            $input.val(formattedDate);
                        }
                    }
                }
            }
        } catch (e) {
            console.error('Error in setDate:', e);
        }
    }
};


// Export the module
window.Calendar = Calendar;