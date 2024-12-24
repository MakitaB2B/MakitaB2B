
/**
 * CustomDropdown Module
 * Reusable custom dropdown implementation with support for dependent dropdowns
 */
const CustomDropdown = {
    init: function(options) {
        const defaults = {
            container: null,          // Container element (required)
            data: [],                 // Array of options
            valueField: 'value',      // Value field name
            textField: 'text',        // Text field name
            placeholder: 'Select',     // Placeholder text
            onChange: null,           // Change event callback
            defaultValue: null,       // Default selected value
            required: false,          // Is field required
            disabled: false          // Is dropdown disabled
        };

        const settings = { ...defaults, ...options };

        if (!settings.container) {
            console.error('Container element is required');
            return;
        }

        this.createDropdown(settings);
        return this;
    },

    createDropdown: function(settings) {
        const $container = $(settings.container);
        
        // Create dropdown structure
        const $dropdown = $(`
            <div class="custom-select">
                <input type="hidden" class="dropdown-value" value="" ${settings.required ? 'required' : ''}>
                <button type="button" class="select-trigger" data-value="" ${settings.disabled ? 'disabled' : ''}>
                    ${settings.placeholder}
                </button>
                <div class="select-options"></div>
            </div>
        `);

        // Add options
        const $options = $dropdown.find('.select-options');
        settings.data.forEach(item => {
            const value = item[settings.valueField];
            const text = item[settings.textField];
            $options.append(`
                <div class="select-option" data-value="${value}">${text}</div>
            `);
        });

        // Set default value if provided
        if (settings.defaultValue) {
            const defaultItem = settings.data.find(item => 
                item[settings.valueField] === settings.defaultValue
            );
            if (defaultItem) {
                $dropdown.find('.select-trigger')
                    .text(defaultItem[settings.textField])
                    .attr('data-value', defaultItem[settings.valueField]);
                $dropdown.find('.dropdown-value').val(defaultItem[settings.valueField]);
            }
        }

        // Store settings for future reference
        $dropdown.data('settings', settings);

        // Add event handlers
        this.attachEvents($dropdown);

        // Add to container
        $container.empty().append($dropdown);
    },

    attachEvents: function($dropdown) {
        const $trigger = $dropdown.find('.select-trigger');
        const $options = $dropdown.find('.select-options');
        const $value = $dropdown.find('.dropdown-value');
        const settings = $dropdown.data('settings');

        // Toggle dropdown
        $trigger.on('click', function(e) {
            if (settings.disabled) return;
            e.preventDefault();
            e.stopPropagation();
            const wasActive = $(this).hasClass('active');

            // Close all other dropdowns
            $('.select-trigger').removeClass('active');
            $('.select-options').removeClass('active');

            if (!wasActive) {
                $(this).addClass('active');
                $options.addClass('active');

                // Scroll to selected option
                const selectedValue = $(this).attr('data-value');
                if (selectedValue) {
                    const $selectedOption = $options.find(`[data-value="${selectedValue}"]`);
                    if ($selectedOption.length) {
                        $selectedOption.addClass('selected');
                        $selectedOption[0].scrollIntoView({ block: 'nearest' });
                    }
                }
            }
        });

        $trigger.off('click').on('click', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            
            if ($(this).prop('disabled')) return;
            
            const $options = $(this).siblings('.select-options');
            $('.select-options').not($options).removeClass('active');
            $('.select-trigger').not(this).removeClass('active');
            
            $(this).toggleClass('active');
            $options.toggleClass('active');
        });

        // Select option
        $options.on('click', '.select-option', function() {
            const value = $(this).data('value');
            const text = $(this).text();

            $options.find('.select-option').removeClass('selected');
            $(this).addClass('selected');

            $trigger.text(text)
                   .attr('data-value', value)
                   .removeClass('error');
            $value.val(value);
            
            // Close dropdown
            $trigger.removeClass('active');
            $options.removeClass('active');

            

            // Trigger change event
            if (settings.onChange) {
                settings.onChange(value, text);
            }
        });

        // Close dropdown when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.custom-select').length) {
                $('.select-trigger').removeClass('active');
                $('.select-options').removeClass('active');
            }
        });
    },

    // Public methods
    setValue: function(container, value) {
        const $container = $(container);
        const $dropdown = $container.find('.custom-select');
        const $option = $dropdown.find(`.select-option[data-value="${value}"]`);
        
        $option.find('.select-option').removeClass('selected');

        if ($option.length) {
            const text = $option.text();
            $option.addClass('selected');
            $dropdown.find('.select-trigger')
                    .text(text)
                    .attr('data-value', value)
                    .removeClass('error');
            $dropdown.find('.dropdown-value').val(value);
        }
    },

    getValue: function(container) {
        return $(container).find('.dropdown-value').val();
    },

    disable: function(container) {
        const $container = $(container);
        $container.find('.select-trigger').prop('disabled', true);
        $container.find('.custom-select').addClass('disabled');
    },

    enable: function(container) {
        const $container = $(container);
        $container.find('.select-trigger').prop('disabled', false);
        $container.find('.custom-select').removeClass('disabled');
    },

    setError: function(container, isError) {
        $(container).find('.select-trigger').toggleClass('error', isError);
    },

    updateOptions: function(container, newData, settings = {}) {
        const $container = $(container);
        const $dropdown = $container.find('.custom-select');
        const $options = $dropdown.find('.select-options');
        const currentSettings = $dropdown.data('settings');
        
        // Merge settings
        const updatedSettings = { ...currentSettings, ...settings };
        
        // Update options
        $options.empty();
        newData.forEach(item => {
            const value = item[updatedSettings.valueField];
            const text = item[updatedSettings.textField];
            $options.append(`
                <div class="select-option" data-value="${value}">${text}</div>
            `);
        });

        // Reset selection
        $dropdown.find('.select-trigger')
                .text(updatedSettings.placeholder)
                .attr('data-value', '');
        $dropdown.find('.dropdown-value').val('');
    }
};

/**
 * DependentDropdown Module
 * Handles dependent dropdown relationships
 */
const DependentDropdown = {
    init: function(options) {
        const defaults = {
            parentContainer: null,    // Parent dropdown container
            childContainer: null,     // Child dropdown container
            parentData: [],           // Parent dropdown data
            childData: {},            // Child data mapping to parent values
            parentValueField: 'value',
            parentTextField: 'text',
            childValueField: 'value',
            childTextField: 'text',
            parentPlaceholder: 'Select Parent',
            childPlaceholder: 'Select Child',
            onChange: null,           // Callback for final selection
            required: false           // Are fields required
        };

        const settings = { ...defaults, ...options };

        if (!settings.parentContainer || !settings.childContainer) {
            console.error('Both parent and child containers are required');
            return;
        }

        this.createDependentDropdowns(settings);
        return this;
    },

    createDependentDropdowns: function(settings) {
        // Initialize parent dropdown
        CustomDropdown.init({
            container: settings.parentContainer,
            data: settings.parentData,
            valueField: settings.parentValueField,
            textField: settings.parentTextField,
            placeholder: settings.parentPlaceholder,
            required: settings.required,
            onChange: (value) => {
                this.updateChildDropdown(value, settings);
            }
        });

        // Initialize child dropdown (disabled initially)
        CustomDropdown.init({
            container: settings.childContainer,
            data: [],
            valueField: settings.childValueField,
            textField: settings.childTextField,
            placeholder: settings.childPlaceholder,
            required: settings.required,
            disabled: true,
            onChange: (value, text) => {
                if (settings.onChange) {
                    const parentValue = CustomDropdown.getValue(settings.parentContainer);
                    settings.onChange(parentValue, value);
                }
            }
        });
    },

    updateChildDropdown: function(parentValue, settings) {
        const $childContainer = $(settings.childContainer);
        
        if (parentValue && settings.childData[parentValue]) {
            CustomDropdown.enable(settings.childContainer);
            CustomDropdown.updateOptions(
                settings.childContainer, 
                settings.childData[parentValue],
                { placeholder: settings.childPlaceholder }
            );
            
            const $dropdown = $childContainer.find('.custom-select');
            CustomDropdown.attachEvents($dropdown);
            
            // Restore saved child value if exists
            const savedChildValue = $childContainer.data('savedValue');
            if (savedChildValue && settings.childData[parentValue].find(item => item.value === savedChildValue)) {
                CustomDropdown.setValue(settings.childContainer, savedChildValue);
            }
        } else {
            CustomDropdown.updateOptions(
                settings.childContainer, 
                [],
                { placeholder: settings.childPlaceholder }
            );
            CustomDropdown.disable(settings.childContainer);
        }
    
        if (settings.onChange) {
            settings.onChange(parentValue, null);
        }
    }
};

// Export the modules
window.CustomDropdown = CustomDropdown;
window.DependentDropdown = DependentDropdown;