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
<div class="content-wrapper"> 
    <div class="custom-container">
    <div>
        <!-- Step Indicator -->
        <div class="stepper">
            <div class="step active" data-step="1">
                <span class="step-title"><i class="bi bi-clock"></i> Time Info</span>
            </div>
            <div class="step" data-step="2">
                <span class="step-title"><i class="bi bi-cup-hot"></i> Food</span>
            </div>
            <div class="step" data-step="3">
                <span class="step-title"><i class="bi bi-car-front"></i> Travel</span>
            </div>
            <div class="step" data-step="4">
                <span class="step-title"><i class="bi bi-three-dots"></i> Misc</span>
            </div>
        </div>

        <!-- Time Information Step -->
        <div class="step-container active" data-step="1">
            <h5 class="text-primary">Time Information</h5>
            
            <!-- Calendar Section -->
            <div class="calendar-section">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-4 mb-3">
                        <label class="form-label">Select Date</label>
                        <input type="text" class="form-control datepicker" readonly placeholder="Select a date" required>
                        <i class="fa fa-calendar"></i>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 mb-3">
                        <label class="form-label">Select Day</label>
                        <div id="dayTypeDropdown"></div>
                    </div>
                </div>

                <div class="calendar-wrapper">
                    <div class="calendar-header">
                        <button class="btn btn-link" id="prevMonth">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <h6 class="mb-0" id="currentMonth">December 2024</h6>
                        <button class="btn btn-link" id="nextMonth">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                    <table class="calendar">
                        <thead>
                            <tr>
                                <th>Sun</th>
                                <th>Mon</th>
                                <th>Tue</th>
                                <th>Wed</th>
                                <th>Thu</th>
                                <th>Fri</th>
                                <th>Sat</th>
                            </tr>
                        </thead>
                        <tbody id="calendarBody"></tbody>
                    </table>
                </div>
            </div>
            
            <!-- Time Selection -->
            <div class="row">
                <div class="col-6 col-md-3 col-lg-3 mb-3">
                    <label class="form-label">In Time</label>
                    <div class="custom-time-input" id="inTimeContainer">
                        <div class="d-flex align-items-center gap-2">
                            <div id="inHoursDropdown"></div>
                            <span class="time-separator">:</span>
                            <div id="inMinutesDropdown"></div>
                        </div>
                    </div>
                    <div class="time-error-message">In time must be earlier than out time</div>
                </div>
                <div class="col-6 col-md-3 col-lg-3 mb-3">
                    <label class="form-label">Out Time</label>
                    <div class="custom-time-input" id="outTimeContainer">
                        <div class="d-flex align-items-center gap-2">
                            <div id="outHoursDropdown"></div>
                            <span class="time-separator">:</span>
                            <div id="outMinutesDropdown"></div>
                        </div>
                    </div>
                    <div class="time-error-message">Out time must be later than in time</div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <button class="btn btn-primary float-end next-step">
                        Next<i class="bi bi-arrow-right ms-2"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Food Expenses Step -->
        <!-- Update the Food Expenses section in your HTML -->
        <div class="step-container food-wrapper" data-step="2">
            <h5 class="text-primary">Food Expenses <span class="text-secondary">(Based on working hours) <a href="javascript:;" onclick="showInfo(event)"><i class="bi bi-info-circle me-2"></i></a></span></h5>
            <div class="alert alert-info mb-4" style="display: none;">
                <i class="bi bi-info-circle me-2"></i>
                Food expenses are calculated based on your working hours:
                <ul class="mb-0 mt-2">
                    <li>Breakfast: Early arrival before 7:00</li>
                    <li>Lunch: Working past 12:00</li>
                    <li>Dinner: Working past 20:00</li>
                </ul>
            </div>
            
            <div class="row">
                <div class="col-12 food-expense-wrapper" >
                    <!-- Update the Food Expenses section -->
                    <div id="breakfastRow" class="expense-container">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Breakfast Claim</h6>
                                <div class="mb-3">
                                    <label class="form-label">Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text">&#8377;</span>
                                        <input type="text" id="breakfastClaim" class="form-control expense-input" value="0.00">
                                    </div>
                                </div>
                                <!-- File Uploader Container -->
                                <div class="file-upload-block">
                                    <label class="form-label">Attachments</label>
                                    <div id="breakfast-attachments"></div>
                                </div>
                                <small class="text-danger expense-message"></small>
                            </div>
                        </div>
                    </div>
                    
                    <div id="lunchRow" class="expense-container">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Lunch Claim</h6>
                                <div class="mb-3">
                                    <label class="form-label">Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text">&#8377;</span>
                                        <input type="text" id="lunchClaim" class="form-control expense-input" value="0.00">
                                    </div>
                                </div>
                                <!-- File Uploader Container -->
                                <div class="file-upload-block">
                                    <label class="form-label">Attachments</label>
                                    <div id="lunch-attachments"></div>
                                </div>
                                <small class="text-danger expense-message"></small>
                            </div>
                        </div>
                    </div>
                    
                    <div id="dinnerRow" class="expense-container">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Dinner Claim</h6>
                                <div class="mb-3">
                                    <label class="form-label">Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text">&#8377;</span>
                                        <input type="text" id="dinnerClaim" class="form-control expense-input" value="0.00">
                                    </div>
                                </div>
                                <!-- File Uploader Container -->
                                <div class="file-upload-block">
                                    <label class="form-label">Attachments</label>
                                    <div id="dinner-attachments"></div>
                                </div>
                                <small class="text-danger expense-message"></small>
                            </div>
                        </div>
                    </div>                    
                </div>
                <!-- <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="card-title mb-0">Total Food Expenses</h6>
                            <h5 class="text-primary mb-0" id="totalFoodExpenses">&#8377;0.00</h5>
                        </div>
                    </div>
                </div> -->
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <button class="btn btn-primary float-start prev-step">
                        <i class="bi bi-arrow-left me-2"></i>Previous
                    </button>
                    <button class="btn btn-primary float-end next-step">
                        Next<i class="bi bi-arrow-right ms-2"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Travel Expenses Step -->
        <div class="step-container" data-step="3">
            <h5 class="text-primary">Travel Expenses</h5>
            <div id="travelEntriesContainer">
                <!-- Travel entries will be dynamically added here -->
            </div>
            <div class="row mb-3">
                <div class="col-12 text-center">
                    <button class="btn btn-primary" id="addTravelEntry">
                        Add More<i class="bi bi-plus ms-2"></i>
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button class="btn btn-primary float-start prev-step">
                        <i class="bi bi-arrow-left me-2"></i>Previous
                    </button>
                    <button class="btn btn-primary float-end next-step">
                        Next<i class="bi bi-arrow-right ms-2"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Misc Expenses Step -->
        <div class="step-container" data-step="4">
            <h5 class="text-primary">Miscellaneous Expenses</h5>
            <div id="miscExpensesContainer">
                <!-- Misc entries will be dynamically added here -->
            </div>
            <div class="row mb-3">
                <div class="col-12 text-center">
                    <button class="btn btn-primary" id="addMiscExpense">
                        Add More<i class="bi bi-plus ms-2"></i>
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button class="btn btn-primary float-start prev-step">
                        <i class="bi bi-arrow-left me-2"></i>Previous
                    </button>
                    <button class="btn btn-primary float-end" id="submit-form">
                        Submit Claim<i class="bi bi-send ms-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Templates -->
    <template id="travel-entry-template">
        <div class="card travel-entry">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Travel Entry #<span class="entry-number">1</span></h5>
                            <button type="button" class="btn btn-danger btn-floating remove-entry" style="display: none;">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label">Mode of Transport*</label>
                        <div class="mode-transport-container"></div>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label">Type of Transport*</label>
                        <div class="type-transport-container"></div>
                    </div>
                </div>
                <div class="row meter-fields-row mb-3">
                    <div class="col-12 col-md-4">
                        <label class="form-label">Starting Meter</label>
                        <input type="number" class="form-control starting-meter" value="0" min="0">
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label">Closing Meter</label>
                        <input type="number" class="form-control closing-meter" value="0" min="0">
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label">Total KMS</label>
                        <input type="number" class="form-control total-kms" value="0" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label">Toll Charges</label>
                        <input type="number" class="form-control toll-charges" value="0.00" min="0" step="0.01">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label">Fuel Charges</label>
                        <input type="number" class="form-control fuel-charges" value="0.00" min="0" step="0.01">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <label class="form-label">Places Visited*</label>
                        <textarea class="form-control places-visited" rows="3" required></textarea>
                    </div>
                </div>
                <!-- Add file upload section -->
                <div class="row">
                    <div class="col-12">
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
                    <h5 class="card-title mb-0">Misc Expense Entry #<span class="entry-number">1</span></h5>
                    <button type="button" class="btn btn-danger btn-floating remove-misc-entry" style="display: none;">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label">Type*</label>
                        <div class="expense-type-container"></div>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label">Claim Amount*</label>
                        <input type="number" class="form-control claim-amount" value="0" min="0" step="0.01">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label class="form-label">Supporting Documents*</label>
                        <div class="misc-documents-uploader"></div>
                    </div>
                </div>
            </div>
        </div>
    </template>     
    </div>
</div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('admin_assets/js/custom-js/fileUploader.js') }}"></script>
    <script src="{{ asset('admin_assets/js/custom-js/dropdown.js') }}"></script>
    <script src="{{ asset('admin_assets/js/custom-js/calendar.js') }}"></script>
    <script src="{{ asset('admin_assets/js/custom-js/app.js') }}"></script>
    <script>
        function showInfo(e){
            $(e.target).closest(".food-wrapper").find(".alert-info").toggle();
        }

        $(document).ready(function () {
        $("#ltcModal").click(function () {
            $.ajax({
                url: "/travelmanagement/ltc-application-form", 
                method: "GET",
                success: function (response) {
                    console.log("AJAX call successful:", response);
                    window.location.href = window.location.origin + "/travelmanagement/ltc-application-form";
                },
                error: function (error) {
                    console.error("AJAX call failed:", error);
                    alert("An error occurred. Please try again.");
                }
            });
        });
        });

    </script>
@endpush