@extends('Admin/layout')
@section('page_title', 'LTC FORM | MAKITA')
@section('travelmanagement-expandable', 'menu-open')
@section('travelmanagement-expandable', 'active')
@section('business-trips-select', 'active')
@section('container')
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('admin_assets/css/custom-styles.css') }}">
@endpush
    <div class="content-wrapper btc-application"> 
        <div class="custom-container">
            <!-- Time Information Step -->
            <div class="step-container active" data-step="1">
                <h5 class="text-primary">Trip Information</h5>
                <div class="btc-details-section">                
                    <div class="row">
                        <div class="form-group col-6 col-md-4">
                            <label for="exampleSDT">Starting Date & Time*</label>
                            <div class="input-group date" id="startDateTime" data-target-input="nearest">
                                <input type="text" name="starting_date_time"
                                    class="form-control datetimepicker-input" 
                                    data-target="#startDateTime"
                                    data-toggle="datetimepicker"
                                    autocomplete="off"
                                    required readonly/>
                                <div class="input-group-append" data-target="#startDateTime"
                                    data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            <div class="calendar-wrapper"></div> <!-- Ensure calendar wrapper is here -->
                        </div>
                        <div class="form-group col-6 col-md-4">
                            <label for="exampleInputCostEstimation">Ending Date & Time*</label>
                            <div class="input-group date" id="endDateTime" data-target-input="nearest">
                                <input type="text" name="bta_ending_datetime"
                                    class="form-control datetimepicker-input" 
                                    data-target="#endDateTime"
                                    data-toggle="datetimepicker"
                                    required readonly/>
                                <div class="input-group-append" data-target="#endDateTime"
                                    data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            <div class="calendar-wrapper"></div> <!-- Ensure calendar wrapper is here -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-4 form-group">
                            <label class="form-label">Place of Visit</label>
                            <input type="text" class="form-control trip-to validate-text" name="tripTo" required  oninput="validateInput(this, 'alphabets')" onpaste="handlePaste(event, 'alphabets')">
                        </div>
                        <div class="col-12 col-md-4 form-group">
                            <label class="form-label">Total Food Expense Approved</label>
                            <input type="text" class="form-control total-food-expense" name="totalFoodExpense" required disabled value="1500" readonly>
                        </div>
                        <div class="col-12 col-md-4 form-group">
                            <label class="form-label">No of Days</label>
                            <input type="text" class="form-control no-of-days" name="noOfDays" disabled readonly>
                        </div>                        
                    </div>
                    <div class="row">
                        <div class="col-12 form-group">
                            <label class="form-label">Purpose of Visit</label>
                            <textarea class="form-control purpose-of-visit" rows="3" name="purposeOfVisit" required  oninput="validateInput(this, 'alphabets')" onpaste="handlePaste(event, 'alphabets')"></textarea>
                        </div>
                    </div>
                </div>
    
    
                <div class="row">
                    <div class="col-12">
                        <button class="btn btn-primary float-end go-next-step">
                            Next<i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>
            </div>
    
            <div class="step-container" data-step="2">
                <div class="common-details toggle-container type-2">
                    <!-- <div class="trip-info-title">
                        <span>Business Travel Claims Info</span>
                        <span>
                            <a href="javascript:;">
                                <i class="fa-solid fa-minus"></i>
                            </a>
                        </span>
                    </div> -->
                    <div class="tavel-info-details">
                        <div class="flight-container vertical">
                            <div class="connecting-line"></div>
                            
                            <div class="flight-segment">
                                <i class="fa-solid fa-plane-departure"></i>
                            </div>
                            
                            <div class="flight-icon">
                                <i class="fa-solid fa-plane"></i>
                            </div>
    
                            <div class="flight-segment">
                                <i class="fa-solid fa-plane-arrival"></i>
                            </div>
                        </div>
                        <div class="travel-form-container">
                            <div class="trip-info-box">
                                <div class="trip-info-title type-2">
                                    <span>Trip Information</span>
                                </div>
                                <div class="exp-data-wrapper trip-info">
                                                        
                                </div>
                            </div>                    
                            <div class="day-details-box">
                    
                                <div class="trip-info-title type-2">
                                    <span>Select a date to fill the details</span>
                                </div>              
                                <div class="btc-details-section day-details" id="daysContainer"> 
                                </div>
                                
                            </div>  
                            <div class="exp-details-box">
                                <div class="top-header-section">
                                    <div class="top-card-title">
                                        <h5 class="text-primary">Add Expense Details</h5>
                                    </div>
                                    <div class="expense-details-g">        
                                        <a class="day-no h-expense add-more-btn">
                                            <div class="icon">
                                                <i class="fa-solid fa-plus"></i>
                                            </div>
                                            <div class="btn-txt">
                                                Add Hotel Expense
                                            </div>
                                        </a>
                                        <a class="day-no m-expense add-more-btn">
                                            <div class="icon">
                                                <i class="fa-solid fa-plus"></i>
                                            </div>
                                            <div class="btn-txt">
                                                Add Mischellaneous Expense
                                            </div>
                                        </a>
                                        <a class="day-no t-expense add-more-btn">
                                            <div class="icon">
                                                <i class="fa-solid fa-plus"></i>
                                            </div>
                                            <div class="btn-txt">
                                                Add Travel Expense
                                            </div>
                                        </a>
                                    </div>
                                </div>      
                                <div class="exp-data-wrapper main-wrap exp-wrapper">
                                    <div class="exp-card-title">Day 1</div>
                                    <div class="f-m-details">
                                        <div class="exp-data-wrapper hotel-exp-data">
                                            <div class="exp-card-title">Hotel Expense</div>
                                            <div class="exp-data-container">
                                            </div>                
                                        </div>
                                        <div class="exp-data-wrapper misc-exp-data">
                                            <div class="exp-card-title">Miscellaneous Expense</div>
                                            
                                            <div class="exp-data-container">
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="exp-data-wrapper travel-exp-data">
                                        <div class="exp-card-title">Travel Expense</div>
                                        <div class="exp-data exp-table">
                                            <div class="exp-row row-header">
                                                <span class="exp-title">Transport Mode</span>
                                                <span class="exp-title">Starting Meter</span>
                                                <span class="exp-title">Closing Meter</span>
                                                <span class="exp-title">Places Visited</span>
                                                <span class="exp-title">Claim</span>
                                                <span class="exp-title">Toll</span>
                                                <span class="exp-title exp-bill-copy">Bill Copy</span>
                                                <span class="exp-title">Actions</span>
                                            </div>
                                            <div class="row-body">                           
                                            </div>                       
                                        </div>
                                    </div>
                                    <div class="action-btns">
                                        <a href="javascript:;" class="btn btn-secondary show-date-list"><i class="fa-solid fa-close"></i> Cancel</a>
                                        <a href="javascript:;" class="btn btn-primary show-date-list submit-day-form"><i class="fa-solid fa-floppy-disk"></i> Submit Data</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                                          
                    </div>  
                    <div class="action-btns main-submit-btn">
                        <a href="javascript:;" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Submit Apllication</a>
                    </div>     
                </div>
                
                
            </div>
        </div>
    
        <template id="hotel-expense-template">
            <div class="hotel-wrapper">                
                <div class="row">
                    <div class="col-12 hotel-expense-wrapper" >
                        <!-- Update the Hotel Expenses section -->
                        <div id="hotelRow" class="expense-container">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Hotel Expense #1</h6>
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-label">Amount</label>
                                            <div class="input-group e-grp">
                                                <span class="input-group-text">&#8377;</span>
                                                <input type="text" id="hotelClaim" class="form-control expense-input"  placeholder="e.g 123.45"  required oninput="validateInput(this, 'float')" onpaste="handlePaste(event, 'float')">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- File Uploader Container -->
                                    <div class="e-grp">
                                        <label class="form-label">Attachments</label>
                                        <div id="hotel-attachments"></div>
                                    </div>
                                    <small class="text-danger expense-message"></small>
                                </div>
                            </div>
                        </div>                  
                    </div>
                    <!-- <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="card-title mb-0">Total Hotel Expenses</h6>
                                <h5 class="text-primary mb-0" id="totalHotelExpenses">&#8377;0.00</h5>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </template>
    
        <!-- Templates -->
        <template id="travel-entry-template">
            <div class="card travel-entry">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0">Travel Expense #1</h5>
                                <button type="button" class="btn btn-danger btn-floating remove-entry" style="display: none;">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-6 e-grp">
                            <label class="form-label">Mode of Transport*</label>
                            <div class="mode-transport-container"></div>
                        </div>
                        <div class="col-12 col-md-6 e-grp">
                            <label class="form-label">Type of Transport*</label>
                            <div class="type-transport-container"></div>
                        </div>
                    </div>
                    <div class="row mb-3 approval-documents-section" style="display: none;">
                        <div class="col-12 e-grp">
                            <label class="form-label">Approval Document*</label>
                            <div class="approval-documents"></div>
                            <small class="text-muted">Please attach approval document for private car usage</small>
                        </div>
                    </div>
                    <div class="row meter-fields-row mb-3">
                        <div class="col-12 col-md-4 e-grp">
                            <label class="form-label">Starting Meter</label>
                            <input type="text" class="form-control starting-meter" placeholder="e.g 123" oninput="validateInput(this, 'numbers')" onpaste="handlePaste(event, 'numbers')">
                        </div>
                        <div class="col-12 col-md-4 e-grp">
                            <label class="form-label">Closing Meter</label>
                            <input type="text" class="form-control closing-meter" placeholder="e.g 123" oninput="validateInput(this, 'numbers')" onpaste="handlePaste(event, 'numbers')">
                        </div>
                        <div class="col-12 col-md-4 e-grp">
                            <label class="form-label">Total KMS</label>
                            <input type="text" class="form-control total-kms" placeholder="e.g 123" oninput="validateInput(this, 'numbers')" onpaste="handlePaste(event, 'numbers')">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-6 e-grp">
                            <label class="form-label">Toll Charges</label>
                            <input type="text" class="form-control toll-charges" placeholder="e.g 123.45" oninput="validateInput(this, 'float')" onpaste="handlePaste(event, 'float')">
                        </div>
                        <div class="col-12 col-md-6 e-grp">
                            <label class="form-label">Fuel Charges</label>
                            <input type="text" class="form-control fuel-charges" placeholder="e.g 123.45" oninput="validateInput(this, 'float')" onpaste="handlePaste(event, 'float')" >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 e-grp places-visited-container">
                            <label class="form-label">Places Visited</label>
                            <textarea class="form-control places-visited" rows="3" oninput="validateInput(this, 'alphabets')" onpaste="handlePaste(event, 'alphabets')"></textarea>
                        </div>
                    </div>
                    <!-- Add file upload section -->
                    <div class="row">
                        <div class="col-12 e-grp">
                            <label class="form-label">Supporting Documents</label>
                            <!-- Add specific class for initialization -->
                            <div class="travel-documents-uploader"></div>
                            <small class="text-muted">Upload receipts for toll, fuel, and other travel expenses</small>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    
        <!-- Misc Entry Template -->
        <template id="misc-entry-template">
            <div class="card misc-entry mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Misc Expense #1</h5>
                        <button type="button" class="btn btn-danger btn-floating remove-misc-entry" style="display: none;">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-6 e-grp">
                            <label class="form-label">Type*</label>
                            <div class="expense-type-container"></div>
                        </div>
                        <div class="col-12 col-md-6 e-grp">
                            <label class="form-label">Claim Amount*</label>
                            <input type="number" class="form-control claim-amount" required oninput="validateInput(this, 'float')"  onpaste="handlePaste(event, 'float')">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 e-grp">
                            <label class="form-label">Supporting Documents*</label>
                            <div class="misc-documents-uploader"></div>
                        </div>
                    </div>
                </div>
            </div>
        </template> 
    </div>
    <div class="modal fade" id="expenseModal" tabindex="-1" aria-labelledby="expenseModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
            <input type="hidden" name="dateInput" class="selected-date">
            <input type="hidden" name="dayInput" class="selected-day">
          <div class="modal-header">
            <h5 class="modal-title" id="expenseModalTitle">Modal Title</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Modal content goes here.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Add this right after your content-wrapper div -->
    <div class="toast-container position-fixed top-0 end-0 p-3"></div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- InputMask -->
    <script src="{{ asset('admin_assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('admin_assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('admin_assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}">
    </script>
    <script src="{{ asset('admin_assets/js/custom-js/fileUploader.js') }}"></script>
    <script src="{{ asset('admin_assets/js/custom-js/dropdown.js') }}"></script>
    <script src="{{ asset('admin_assets/js/custom-js/calendar.js') }}"></script>
    <script src="{{ asset('admin_assets/js/custom-js/app.js') }}"></script>
    <script src="{{ asset('admin_assets/js/expense-handler.js') }}"></script>
    <script>

        // Initialize when document is ready
        $(document).ready(async () => {
            await BTCStateManager.init();
            ExpenseAppBTC.init();

        });

        $(document).on('change keyup', '.file-input, input', function () {
            const $error = $(this).closest('.e-grp');
            let meterRow = $(this).closest('.meter-fields-row');
            // Check if there are any files selected
            if (this.files && this.files.length > 0) {
                // Remove error class and message
                $error.find('.is-invalid').removeClass('is-invalid');
                $error.find('.expense-message').remove();
            }
            if($(this).val() != ""){                

                if(meterRow.length > 0){
                    ExpenseAppBTC.calculateFuelCharges();
                } else{
                    $(this).removeClass('is-invalid');
                    $(this).closest('.e-grp').find('.expense-message').remove();
                    
                }
               
            }
            
        });

        function validateInput(input, type) {
            let regex, errorMessage;

            // Define regex and error message based on type
            switch (type) {
                case 'numbers':
                    regex = /^[0-9]*$/;
                    errorMessage = 'Only numbers are allowed.';
                    break;
                case 'alphabets':
                    regex = /^[a-zA-Z\s]*$/;
                    errorMessage = 'Only alphabets and spaces are allowed.';
                    break;
                case 'float':
                    regex = /^[0-9]*(\.[0-9]{0,2})?$/;
                    errorMessage = 'Enter a valid number with up to 2 decimal places.';
                    break;
                default:
                    console.error('Invalid validation type');
                    return;
            }

            const errorElement = input.parentNode.querySelector('small.text-danger'); // Find the error message <small>

            // Validate input value
            if (!regex.test(input.value)) {
                // Clean the input based on type
                if (type === 'alphabets') {
                    // Remove non-alphabet characters
                    input.value = input.value.replace(/[^a-zA-Z\s]/g, '');
                } else if (type === 'numbers') {
                    // Remove non-numeric characters
                    input.value = input.value.replace(/[^0-9]/g, '');
                } else if (type === 'float') {
                    // Remove invalid float characters
                    input.value = input.value.replace(/[^0-9.]/g, '').replace(/(\..{0,2}).*/g, '$1');
                }
                // Append or show the error message
                if (errorElement) {
                    errorElement.innerHTML = errorMessage;
                    errorElement.style.display = 'block';
                } else {
                    // Create and append the error message if it doesn't exist
                    const newErrorElement = document.createElement('small');
                    newErrorElement.className = 'text-danger expense-message';
                    newErrorElement.style.display = 'block';
                    newErrorElement.innerHTML = errorMessage;
                    input.parentNode.appendChild(newErrorElement);
                }
            } else {
                // Hide the error message if the input is valid
                if (errorElement) {
                    errorElement.style.display = 'none';
                }
            }
        }
        
        function handlePaste(event, type) {
            // Prevent default paste behavior
            event.preventDefault();

            // Get the pasted data
            const pastedData = (event.clipboardData || window.clipboardData).getData('text');

            // Validate pasted data based on the type
            let regex;
            switch (type) {
                case 'numbers':
                    regex = /^[0-9]*$/;
                    break;
                case 'alphabets':
                    regex = /^[a-zA-Z\s]*$/;
                    break;
                case 'float':
                    regex = /^[0-9]*(\.[0-9]{0,2})?$/;
                    break;
                default:
                    console.error('Invalid validation type');
                    return;
            }

            // If pasted data matches the regex, set it to the input value
            if (regex.test(pastedData)) {
                event.target.value = pastedData;
                event.target.nextElementSibling.style.display = 'none'; // Hide error
            } else {
                // Show an error message if pasted data is invalid
                event.target.nextElementSibling.innerHTML = 'Invalid input on paste.';
                event.target.nextElementSibling.style.display = 'block';
            }
        }
        
    </script>
@endpush