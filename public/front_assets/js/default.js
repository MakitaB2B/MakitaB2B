// Constants
const CONSTANTS = {
    ANIMATION_DURATION: 300,
    CAROUSEL_INTERVAL: 5000,
    SEARCH_DEBOUNCE: 300,
    MOBILE_BREAKPOINT: 768,
    SWIPE_THRESHOLD: 50
};

// Utility functions
const utils = {
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    },

    isMobile() {
        return window.innerWidth <= CONSTANTS.MOBILE_BREAKPOINT;
    },

    fadeInOut($element, show, duration = CONSTANTS.ANIMATION_DURATION) {
        if (show) {
            $element.css('display', 'flex').hide().fadeIn(duration);
        } else {
            $element.fadeOut(duration);
        }
    }
};

// Form handling class
class FormManager {
    constructor() {
        this.currentStep = 1;
        this.steps = document.querySelectorAll('.step-circle');
        this.forms = document.querySelectorAll('.step-form');
        this.initializeOTPInputs();
        this.initializeFormSubmissions();
        this.initializeProductForms();
    }

    showStep(step) {
        this.forms.forEach(form => form.classList.remove('active'));
        this.forms[step - 1].classList.add('active');
        
        this.steps.forEach((stepCircle, index) => {
            if (index + 1 < step) {
                stepCircle.classList.add('completed');
                stepCircle.classList.remove('active');
            } else if (index + 1 === step) {
                stepCircle.classList.add('active');
                stepCircle.classList.remove('completed');
            } else {
                stepCircle.classList.remove('active', 'completed');
            }
        });
    }

    initializeOTPInputs() {
        const otpInputs = document.querySelectorAll('.otp-inputs input');
        otpInputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                if (e.target.value && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
            });
            
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    otpInputs[index - 1].focus();
                }
            });
        });
    }

    initializeProductForms() {
        // $(".product-form, .scan-link, .product-title").hide();
        
        // $(".form-link").on('click', () => {
        //     $(".scan-form, .form-link, .scan-title").hide();
        //     $(".product-form, .scan-link, .product-title").show();
        // });

        // $(".scan-link").on('click', () => {
        //     $(".product-form, .scan-link, .product-title").hide();
        //     $(".scan-form, .form-link, .scan-title").show();
        // });
        
        // $("#productForm .btn").click(function(e){
        //     e.preventDefault();
        //     window.location.href = 'product-details.html';
        // });
    }

    // initializeFormSubmissions() {
    //     document.getElementById('step1Form')?.addEventListener('submit', (e) => {
    //         e.preventDefault();
    //         this.currentStep = 2;
    //         this.showStep(this.currentStep);
    //         $(".steps-grid .step-card:nth-child(2)").removeClass("active-card")
    //         $(".steps-grid .step-card:nth-child(3)").addClass("active-card")
    //         $(".steps-grid .step-card:nth-child(3)").show();
    //     });

    //     document.getElementById('step2Form')?.addEventListener('submit', (e) => {
    //         e.preventDefault();
    //         this.currentStep = 3;
    //         this.showStep(this.currentStep);
    //         $(".steps-grid .step-card:nth-child(3)").removeClass("active-card")
    //         $(".steps-grid .step-card:nth-child(4),.steps-grid .step-card:nth-child(5) ").addClass("active-card").show();
    //     });

    //     document.getElementById('step3Form')?.addEventListener('submit', (e) => {
    //         e.preventDefault();
    //         window.location.href='dashboard.html';
    //     });
    // }
}

// Navigation class
class Navigation {
    constructor() {
        this.initializeDesktopNav();
        this.initializeMobileNav();
        this.handleWindowResize();
    }

    initializeDesktopNav() {
        $('.nav-item').on('click', function() {
            if (!utils.isMobile()) {
                $(this).find('.dropdown-menu').stop().fadeIn(CONSTANTS.ANIMATION_DURATION);
            }
        });

        $(document).on('click', () => {
            $('.dropdown-menu').fadeOut(CONSTANTS.ANIMATION_DURATION);
        });

        $('.dropdown-menu').on('click', (e) => e.stopPropagation());
    }

    initializeMobileNav() {
        $('.mobile-menu-btn').on('click', function() {
            $('.nav-item:not(:first-child)').toggleClass('show');
            $(this).find('i').toggleClass('fa-bars fa-times');
        });

        if (utils.isMobile()) {
            this.initializeMobileDropdowns();
        }
    }

    initializeMobileDropdowns() {
        $('.nav-title').on('click', function() {
            const $dropdown = $(this).siblings('.dropdown-menu');
            if ($dropdown.length) {
                $('.dropdown-menu').not($dropdown).slideUp(CONSTANTS.ANIMATION_DURATION);
                $dropdown.slideToggle(CONSTANTS.ANIMATION_DURATION);
            }
        });
    }

    handleWindowResize() {
        $(window).on('resize', utils.debounce(() => {
            if (!utils.isMobile()) {
                $('.nav-item').removeClass('show');
                $('.mobile-menu-btn i').removeClass('fa-times').addClass('fa-bars');
                $('.dropdown-menu').css('display', '');
            }
        }, CONSTANTS.SEARCH_DEBOUNCE));
    }
}

// Carousel class
class Carousel {
    constructor(selector) {
        this.$carousel = $(selector);
        this.$slides = this.$carousel.find('.carousel-slide');
        this.$indicators = this.$carousel.find('.carousel-indicators');
        this.currentIndex = 0;
        
        this.initialize();
        this.startAutoPlay();
        this.initializeTouchSupport();
    }

    initialize() {
        this.createIndicators();
        this.bindEvents();
    }

    createIndicators() {
        this.$slides.each((index) => {
            this.$indicators.append(
                `<div class="indicator${index === 0 ? ' active' : ''}"></div>`
            );
        });
    }

    bindEvents() {
        $('.next-btn').on('click', () => this.next());
        $('.prev-btn').on('click', () => this.prev());
        $('.indicator').on('click', (e) => this.goToSlide($(e.target).index()));
    }

    updateCarousel() {
        this.$carousel.css('transform', `translateX(-${this.currentIndex * 100}%)`);
        $('.indicator').removeClass('active').eq(this.currentIndex).addClass('active');
    }

    next() {
        this.currentIndex = (this.currentIndex + 1) % this.$slides.length;
        this.updateCarousel();
    }

    prev() {
        this.currentIndex = (this.currentIndex - 1 + this.$slides.length) % this.$slides.length;
        this.updateCarousel();
    }

    goToSlide(index) {
        this.currentIndex = index;
        this.updateCarousel();
    }

    startAutoPlay() {
        setInterval(() => this.next(), CONSTANTS.CAROUSEL_INTERVAL);
    }

    initializeTouchSupport() {
        let touchStartX = 0;
        
        this.$carousel.parent().on({
            touchstart: (e) => {
                touchStartX = e.originalEvent.touches[0].clientX;
            },
            touchend: (e) => {
                const touchEndX = e.originalEvent.changedTouches[0].clientX;
                const difference = touchStartX - touchEndX;
                
                if (Math.abs(difference) > CONSTANTS.SWIPE_THRESHOLD) {
                    difference > 0 ? this.next() : this.prev();
                }
            }
        });
    }
}

// Modal class
class Modal {
    constructor() {
        this.bindEvents();
        this.dataHandlers = new Map();
    }

    bindEvents() {
        $('[data-click="modal"]').on('click touch', (e) => {
            e.preventDefault();
            const elem = $(e.target).attr('data-target');
            const modalData = $(e.target).data();
            const hasData = Object.keys(modalData).length > 1;
            this.open(elem, hasData ? modalData : null);
        });

        $('.modal-close, .modal-overlay').on('click', function(e) {
            if (e.target === this) {
                Modal.close();
            }
        });

        $('.modal').on('click', (e) => e.stopPropagation());
    }

    registerDataHandler(modalSelector, handler) {
        this.dataHandlers.set(modalSelector, handler);
    }

    open(target, data = null) {
        const $modal = $(target);
        
        if (this.dataHandlers.has(target) && data) {
            try {
                const handler = this.dataHandlers.get(target);
                handler($modal, data);
            } catch (error) {
                console.warn(`Error handling modal data for ${target}:`, error);
            }
        }

        utils.fadeInOut($modal, true);
        $('body').css('overflow', 'hidden');
    }

    static close() {
        const $modalOverlay = $('.modal-overlay');
        $modalOverlay.fadeOut(CONSTANTS.ANIMATION_DURATION, function() {
            $('body').css('overflow', 'auto');
        });
    }

    static clearModal(modalSelector) {
        $(modalSelector).find('.modal-content').empty();
    }
}

// CustomSelect class
class CustomSelect {
    constructor(selector, options) {
        this.options = options;
        this.highlightedIndex = -1;
        
        this.$container = $(selector);
        this.$input = this.$container.find('.custom-select-input');
        this.$dropdown = this.$container.find('.custom-select-dropdown');
        this.$searchBox = this.$container.find('.search-box');
        this.$optionsContainer = this.$container.find('.options-container');
        
        this.initialize();
    }

    initialize() {
        this.renderOptions(this.options);
        this.bindEvents();
    }

    renderOptions(items, isLoading = false) {
        this.$optionsContainer.empty();
        
        if (isLoading) {
            this.$optionsContainer.addClass('loading');
            for (let i = 0; i < 5; i++) {
                this.$optionsContainer.append('<div class="option-item"></div>');
            }
            return;
        }

        this.$optionsContainer.removeClass('loading');
        
        if (items.length === 0) {
            this.$optionsContainer.append('<div class="no-results">No matches found</div>');
            return;
        }

        items.forEach(option => {
            this.$optionsContainer.append(
                `<div class="option-item" data-id="${option.id}">${option.text}</div>`
            );
        });
    }

    bindEvents() {
        this.$input.on('click', (e) => this.handleInputClick(e));
        this.$searchBox.on('input', (e) => this.handleSearch(e));
        this.$optionsContainer.on('click', '.option-item', (e) => this.handleOptionSelect(e));
        $(document).on('click', (e) => this.handleClickOutside(e));
        $(document).on('keydown', (e) => this.handleKeyboardNavigation(e));
    }

    handleInputClick(e) {
        e.stopPropagation();
        this.$container.toggleClass('active');
        
        if (!this.$dropdown.is(':visible')) {
            this.$dropdown.addClass('opening');
            requestAnimationFrame(() => {
                this.$dropdown.addClass('open').show();
                this.$searchBox.val('').focus();
                this.renderOptions(this.options);
            });
        } else {
            this.closeDropdown();
        }
    }

    handleSearch(e) {
        e.stopPropagation();
        this.renderOptions([], true);
        
        utils.debounce(() => {
            const searchTerm = this.$searchBox.val().toLowerCase();
            const filteredOptions = this.options.filter(option => 
                option.text.toLowerCase().includes(searchTerm)
            );
            this.renderOptions(filteredOptions);
        }, 300)();
    }

    handleOptionSelect(e) {
        const selectedId = $(e.target).data('id');
        const selectedOption = this.options.find(opt => opt.id === selectedId);
        this.$input.val(selectedOption.text);
        this.closeDropdown();
        this.$input.trigger('change', [selectedOption]);
    }

    handleClickOutside(e) {
        if (!$(e.target).closest('.custom-select-container').length) {
            this.closeDropdown();
        }
    }

    handleKeyboardNavigation(e) {
        if (!this.$dropdown.is(':visible')) return;

        const $options = $('.option-item');
        const optionsLength = $options.length;

        switch(e.keyCode) {
            case 40: // Down arrow
                e.preventDefault();
                this.highlightedIndex = Math.min(this.highlightedIndex + 1, optionsLength - 1);
                this.updateHighlight();
                this.scrollToHighlighted();
                break;
            case 38: // Up arrow
                e.preventDefault();
                this.highlightedIndex = Math.max(this.highlightedIndex - 1, 0);
                this.updateHighlight();
                this.scrollToHighlighted();
                break;
            case 13: // Enter
                e.preventDefault();
                if (this.highlightedIndex >= 0) {
                    $options.eq(this.highlightedIndex).click();
                }
                break;
            case 27: // Escape
                e.preventDefault();
                this.closeDropdown();
                break;
        }
    }

    closeDropdown() {
        this.$container.removeClass('active');
        this.$dropdown.removeClass('open');
        setTimeout(() => {
            this.$dropdown.hide().removeClass('opening');
        }, 200);
    }

    updateHighlight() {
        $('.option-item').removeClass('highlighted');
        $('.option-item').eq(this.highlightedIndex).addClass('highlighted');
    }

    scrollToHighlighted() {
        const $highlighted = $('.option-item.highlighted');
        if ($highlighted.length) {
            const container = this.$optionsContainer[0];
            const item = $highlighted[0];
            
            const containerHeight = container.offsetHeight;
            const itemHeight = item.offsetHeight;
            const scrollTop = container.scrollTop;
            const itemOffset = item.offsetTop;
            
            if (itemOffset < scrollTop) {
                container.scrollTop = itemOffset;
            } else if (itemOffset + itemHeight > scrollTop + containerHeight) {
                container.scrollTop = itemOffset + itemHeight - containerHeight;
            }
        }
    }
}

// Initialize everything when document is ready
$(document).ready(() => {
    const formManager = new FormManager();
    const navigation = new Navigation();
    const carousel = new Carousel('.carousel');
    const modal = new Modal();

    // Initialize custom selects
    function initializeCustomSelects(configs, selectIds = null) {
        const customSelects = {};
        const idsToInitialize = selectIds || Object.keys(configs);
        
        idsToInitialize.forEach(selectId => {
            if (configs[selectId]) {
                const selector = `#${selectId}`;
                customSelects[selectId] = new CustomSelect(selector, configs[selectId]);
                
                $(`${selector} .custom-select-input`).on('change', (event, selectedOption) => {
                    console.log(`${selectId} changed:`, selectedOption);
                });
            }
        });

        return customSelects;
    }
    
    // Initialize select configurations
    const selectConfigs = {
        'select1': [
            { id: 1, text: 'PDC1200' },
            { id: 2, text: 'PDC01' },
            { id: 3, text: 'DF001G' },
            { id: 4, text: 'DF002G' }
        ],
        'select2': [
            { id: 1148347989437599823, text: 'HO Service Center' },
            { id: 374166173807015820, text: 'Peenya FSC' },
            { id: 856453023726250757, text: 'Chennai FSC' }
        ],
        'stateID': [
            { id: 1, text: 'Andhra Pradeshh' },
            { id: 2, text: 'Arunachal Pradesh' },
            { id: 4, text: 'Assam' },
            { id: 5, text: 'Bihar' },
            { id: 6, text: 'karnataka' },
            { id: 7, text: 'Maharastra' }
        ],
        'cityID': [
            { id: 1, text: 'Bengaluru' },
            { id: 2, text: 'Hoskote' },
            { id: 3, text: 'Mangalore' }
        ],

    };
    const customSelects = initializeCustomSelects(selectConfigs);

    // Initialize tabs
    const tabs = document.querySelectorAll('.warranty-tab');
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
        });
    });

    // Initialize table functionality
    const tableRows = document.querySelectorAll('tbody tr');
    const tableHeaders = Array.from(document.querySelectorAll('thead th')).map(th => th.textContent.trim());

    tableRows.forEach(row => {
        row.addEventListener('click', (e) => {
            e.preventDefault();
            if(e.target.className == 'raise'){
                modal.open('#serviceModal');
                return;
            }
            const rowData = {
                title: 'Service Details',
                cells: Array.from(row.cells).map(cell => cell.textContent.trim()),
                headers: tableHeaders,
                id: row.dataset.id,
                customData: row.dataset.customData
            };

            let $modal = $('#detailModal');
            if (!$modal.length) {
                $('body').append(`
                    <div id="detailModal" class="modal-overlay">
                        <div class="modal">
                            <div class="modal-header">
                                <div class="dashboard-title">
                                ${rowData.title}
                                </div>
                                <button class="modal-close">&times;</button>
                            </div>
                            <div class="modal-content"></div>
                            <button class="modal-close">&times;</button>
                        </div>
                    </div>
                `);
                
                $modal = $('#detailModal');
                $modal.find('.modal-close').on('click', () => Modal.close());
                $modal.on('click', function(e) {
                    if ($(e.target).hasClass('modal-overlay')) {
                        Modal.close();
                    }
                });
            }

            modal.open('#detailModal', rowData);
        });

        row.addEventListener('mouseover', () => {
            row.style.cursor = 'pointer';
        });
    });

    // Register modal data handler
    modal.registerDataHandler('#detailModal', ($modal, data) => {
        if (!data || !data.cells) {
            $modal.find('.modal-content').html('<h2>No Data Available</h2>');
            return;
        }

        const content = `
                <div class="modal-row-details">
                    <table class="detail-table">
                        <tbody>
                            ${data.cells.map((cell, index) => `
                                <tr>
                                    <th>${data.headers[index] || `Column ${index + 1}`}</th>
                                    <td>${cell}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                    ${data.id ? `<p>Row ID: ${data.id}</p>` : ''}
                    ${data.customData ? `<p>Additional Data: ${data.customData}</p>` : ''}
                </div>
        `;

        $modal.find('.modal-content').html(content);
    });

});

// Export classes for module usage if needed
// export {
//     FormManager,
//     Navigation,
//     Carousel,
//     Modal,
//     CustomSelect,
//     utils,
//     CONSTANTS
// };