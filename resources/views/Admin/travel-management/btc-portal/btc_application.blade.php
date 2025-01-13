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
        <div class="step-container" data-step="1">
            <h5 class="text-primary">Time Information</h5>
            <div class="btc-details-section">                
                <div class="row">
                    <div class="form-group col-6 col-md-4">
                        <label for="exampleSDT">Starting Date & Time*</label>
                        <div class="input-group date" id="startDateTime" data-target-input="nearest">
                            <input type="text" name="starting_date_time"
                                class="form-control datetimepicker-input" data-target="#startDateTime"
                                required />
                            <div class="input-group-append" data-target="#startDateTime"
                                data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-6 col-md-4">
                        <label for="exampleInputCostEstimation">Ending Date & Time*</label>
                        <div class="input-group date" id="endDateTime" data-target-input="nearest">
                            <input type="text" name="bta_ending_datetime"
                                class="form-control datetimepicker-input" data-target="#endDateTime"
                                required />
                            <div class="input-group-append" data-target="#endDateTime"
                                data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-4 form-group">
                        <label class="form-label">Place of Visit</label>
                        <input type="text" class="form-control places-visited" name="visitedPlace">
                    </div>
                    <div class="col-12 col-md-4 form-group">
                        <label class="form-label">Pre Approved Visit</label>
                        <div class="pre-approved"></div>
                    </div>
                    <div class="col-12 col-md-4 form-group">
                        <label class="form-label">No of Days</label>
                        <input type="text" class="form-control no-of-days" name="noOfDays" disabled>
                    </div>
                    <div class="col-12 form-group">
                        <label class="form-label">Purpose of Visit</label>
                        <textarea class="form-control purpose-visit" rows="3" name="purposeVisit" required></textarea>
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

        <div class="step-container active" data-step="2">
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
                                <div class="exp-data">
                                    <span class="exp-title">Starting Date</span>
                                    <span class="exp-value">01-Jan-2025 05:00 AM</span>
                                </div>
                                <div class="exp-data">
                                    <span class="exp-title">Trip To</span>
                                    <span class="exp-value">Bangalore</span>
                                </div>                        
                                
                                <div class="exp-data">
                                    <span class="exp-title">Number of Days</span>
                                    <span class="exp-value">8</span>
                                </div>
                                <div class="exp-data">
                                    <span class="exp-title">Ending Date</span>
                                    <span class="exp-value">09-Jan-2025 08:00 PM</span>
                                </div>
                                <div class="exp-data">
                                    <span class="exp-title">Visit Pre Approved</span>
                                    <span class="exp-value">Yes</span>
                                </div>
                                <div class="exp-data">
                                    <span class="exp-title">Purpose of Visit</span>
                                    <span class="exp-value">Business Visit</span>
                                </div>                        
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
                                    <a class="day-no f-expense add-more-btn">
                                        <div class="icon">
                                            <i class="fa-solid fa-plus"></i>
                                        </div>
                                        <div class="btn-txt">
                                            Add Food Expense
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
                                    <a class="day-no m-expense add-more-btn">
                                        <div class="icon">
                                            <i class="fa-solid fa-plus"></i>
                                        </div>
                                        <div class="btn-txt">
                                            Add Mischellaneous Expense
                                        </div>
                                    </a>
                                </div>
                            </div>      
                            <div class="exp-data-wrapper main-wrap exp-wrapper">
                                <div class="exp-card-title">Day 1</div>
                                <div class="f-m-details">
                                    <div class="exp-data-wrapper food-exp-data">
                                        <div class="exp-card-title">Food Expense</div>
                                        <div class="exp-data">
                                        </div>                
                                    </div>
                                    <div class="exp-data-wrapper misc-exp-data">
                                        <div class="exp-card-title">Miscellaneous Expense</div>
                                        
                                        <div class="exp-data">
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

    <template id="food-expense-template">
        <div class="food-wrapper">
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
                    <div id="foodRow" class="expense-container">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Food Claim</h6>
                                <div class="mb-3">
                                    <label class="form-label">Amount</label>
                                    <div class="input-group e-grp">
                                        <span class="input-group-text">&#8377;</span>
                                        <input type="text" id="foodClaim" class="form-control expense-input" required>
                                    </div>
                                </div>
                                <!-- File Uploader Container -->
                                <div class="file-upload-block e-grp">
                                    <label class="form-label">Attachments</label>
                                    <div id="food-attachments"></div>
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
        </div>
    </template>

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
                    <div class="col-12 col-md-6 e-grp">
                        <label class="form-label">Mode of Transport*</label>
                        <div class="mode-transport-container"></div>
                    </div>
                    <div class="col-12 col-md-6 e-grp">
                        <label class="form-label">Type of Transport*</label>
                        <div class="type-transport-container"></div>
                    </div>
                </div>
                <div class="row meter-fields-row mb-3">
                    <div class="col-12 col-md-4 e-grp">
                        <label class="form-label">Starting Meter</label>
                        <input type="number" class="form-control starting-meter" value="0" min="0">
                    </div>
                    <div class="col-12 col-md-4 e-grp">
                        <label class="form-label">Closing Meter</label>
                        <input type="number" class="form-control closing-meter" value="0" min="0">
                    </div>
                    <div class="col-12 col-md-4 e-grp">
                        <label class="form-label">Total KMS</label>
                        <input type="number" class="form-control total-kms" value="0" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-6 e-grp">
                        <label class="form-label">Toll Charges</label>
                        <input type="number" class="form-control toll-charges" value="0.00" min="0" step="0.01">
                    </div>
                    <div class="col-12 col-md-6 e-grp">
                        <label class="form-label">Fuel Charges</label>
                        <input type="number" class="form-control fuel-charges" value="0.00" min="0" step="0.01">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 e-grp">
                        <label class="form-label">Places Visited*</label>
                        <textarea class="form-control places-visited" rows="3" required></textarea>
                    </div>
                </div>
                <!-- Add file upload section -->
                <div class="row">
                    <div class="col-12">
                        <label class="form-label">Supporting Documents</label>
                        <!-- Add specific class for initialization -->
                        <div class="travel-documents-uploader e-grp"></div>
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
                    <div class="col-12 col-md-6 e-grp">
                        <label class="form-label">Type*</label>
                        <div class="expense-type-container"></div>
                    </div>
                    <div class="col-12 col-md-6 e-grp">
                        <label class="form-label">Claim Amount*</label>
                        <input type="number" class="form-control claim-amount" value="0" min="0" step="0.01">
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
       $(function() {  
            const expenseData = JSON.parse(localStorage.getItem('expenseData'));
            const bool = [ 
                {value:1, text:'Pre Approved'},
                {value:0, text:'Need Approval'}
            ]                 
            function showInfo(e){
                $(e.target).closest(".food-wrapper").find(".alert-info").toggle();
            }
            $('#startDateTime').datetimepicker({
                format: 'DD-MMM-YYYY HH:mm:ss',
                useCurrent: false,
                maxDate: moment(),
                icons: {
                    time: 'far fa-clock'
                }
            });
            $('#endDateTime').datetimepicker({
                format: 'DD-MMM-YYYY HH:mm:ss',
                useCurrent: false,
                maxDate: moment(),
                icons: {
                    time: 'far fa-clock'
                }
            });
            $("#startDateTime").on("change.datetimepicker", function (e) {
                const selectedStartDate = e.date;
                $('#endDateTime').datetimepicker('minDate', selectedStartDate);
            });

            $("#endDateTime").on("change.datetimepicker", function (e) {
                const selectedEndDate = e.date;
                $('#startDateTime').datetimepicker('maxDate', selectedEndDate || moment());
            });
            function calculateNoOfDays(){
                var noOfDays;
                var startingDT = new Date($('input[name="starting_date_time"]').val());
                var endingDT = new Date($('input[name="bta_ending_datetime"]').val());
                if (isNaN(startingDT.getTime()) || isNaN(endingDT.getTime())) {
                    $("#result").text("Invalid date format. Please check the input.");
                    return;
                }
                 // Calculate the total difference in days
                 noOfDays = Math.floor((endingDT - startingDT) / (1000 * 60 * 60 * 24));

                // Check if the start time is before 9 PM
                var startHour = startingDT.getHours();
                var startMinutes = startingDT.getMinutes();
                if (startHour < 21 || (startHour === 21 && startMinutes === 0)) {
                    noOfDays += 1; // Count start day
                }

                // Check if the end time is exactly 6 AM
                var endHour = endingDT.getHours();
                var endMinutes = endingDT.getMinutes();
                if (endHour === 6 && endMinutes === 0) {
                    noOfDays += 1; // Count end day
                }
                return noOfDays;
            }
            $('#startDateTime, #endDateTime').on("change.datetimepicker", function(e){
                var noOfDays = calculateNoOfDays();
                if(noOfDays){
                    $(".no-of-days").val(noOfDays)
                }
            })
            CustomDropdown.init({
                container: '.pre-approved',
                data: bool,
                placeholder: 'Select One'
            });
            $(".go-next-step").click(function(){
                var dataIdx = $(this).closest(".step-container").data("step")
                var expenseDetails;
                var startingDT = new Date($('input[name="starting_date_time"]').val());
                var endingDT = new Date($('input[name="bta_ending_datetime"]').val());                            
                var visitedPlace = $('input[name="visitedPlace"]').val() || 'NA';
                var preApproved = $('.pre-approved .dropdown-value').val() || '0';                
                var purposeVisit = $('textarea[name="purposeVisit"]').val() || 'NA';
                if(validateRequiredInput()){
                    expenseDetails = {
                        "startingDT":startingDT,
                        "endingDT":endingDT,
                        "visitedPlace":visitedPlace,
                        "preApproved":preApproved,
                        "noOfDays":calculateNoOfDays(),
                        "purposeVisit":purposeVisit
                    }
                    localStorage.setItem("expenseData",JSON.stringify(expenseDetails))
                    dataIdxNxt = dataIdx + 1
                    $(this).closest(".step-container").removeClass("active")
                    $(`.step[data-step="${dataIdx}"]`).removeClass("active")
                    $(`.step-container[data-step="${dataIdxNxt}"], .step[data-step="${dataIdxNxt}"]`).addClass("active");   
                }
            })
            $(".prev-step").click(function(){
                var dataIdx = $(this).closest(".step-container").data("step")
                dataIdxNxt = dataIdx - 1
                $(this).closest(".step-container").removeClass("active")
                $(`.step[data-step="${dataIdx}"]`).removeClass("active")
                $(`.step-container[data-step="${dataIdxNxt}"], .step[data-step="${dataIdxNxt}"]`).addClass("active");
            })
            $("#addTravelEntry").click(function(){
                const template = document.getElementById('travel-entry-template').content.cloneNode(true);
                $("#travelEntriesContainer").append(template)
            })
        
            $(".f-expense, .t-expense, .m-expense").click(function (e) {
                e.preventDefault();
                var modalContent,fileConfig,modalTitle;
                var ddContainer = $("#expenseModal");
                if($(e.target).hasClass("f-expense") || $(e.target).parent().hasClass("f-expense")){
                    modalContent =  document.getElementById('food-expense-template').content.cloneNode(true);
                    modalTitle = "Food Expense Form"
                    fileConfig = {
                        container: `#food-attachments`,
                        maxFiles:3,
                        buttonText: 'Add Receipt',
                        uploadIcon: 'bi-receipt'    
                    }            
                }
                if($(e.target).hasClass("t-expense") || $(e.target).parent().hasClass("t-expense")){
                    modalContent =  document.getElementById('travel-entry-template').content.cloneNode(true);
                    modalTitle = "Travel Expense Form"
                    fileConfig = {
                        container: `.travel-documents-uploader`,
                        maxFiles: 5,
                        buttonText: 'Add Receipt',
                        uploadIcon: 'bi-receipt'
                    }                
                }
                if($(e.target).hasClass("m-expense") || $(e.target).parent().hasClass("m-expense")){
                    modalContent =  document.getElementById('misc-entry-template').content.cloneNode(true);
                    modalTitle = "Miscellaneous Expense Form"
                    fileConfig = {
                        container: `.misc-documents-uploader`,
                        maxFiles: 5,
                        buttonText: 'Add Receipt',
                        uploadIcon: 'bi-receipt'
                    }
                }
                $("#expenseModalTitle").html(modalTitle)
                $("#expenseModal .modal-body").html(modalContent)
                $("#expenseModal").modal("show");
                FileUploader.init(fileConfig);
                if(ddContainer){
                    ExpenseApp.travelManager.initializeTransportDropdowns(ddContainer);
                    ExpenseApp.miscManager.initializeExpenseTypeDropdown(ddContainer);
                }
            });
            $(".file-input").change(()=>{
                isValid = true;
                var files = FileUploader.getFiles(modelID,SectionID) || [];
                if(amount > 0 && files.length > 0){
                    $(`#foodRow`).find('.expense-message')
                    .text(!isValid ? 'Please attach receipt for the expense claim' : '')
                    .toggle(!isValid).removeClass("text-danger ").addClass("text-muted");
                }
            })
            $("#expenseModal .btn-primary").click(function(e){
                var expenseType,getData;
                var expenseData = JSON.parse(localStorage.getItem("expenseData")) || {};                                
                var modelID = $(".file-uploader").data("module")
                var SectionID = $(".file-uploader").data("section")
                var files = FileUploader.getFiles(modelID,SectionID) || [];
                var getDate = $(".selected-date").val()        
                var getDay = $(".selected-day").val()     

                if($(this).closest("#expenseModal").find("#foodRow").length){
                    var amount = $("#foodClaim").val();
                    expenseType = "foodExpenses"                
                    if(amount > 0 && !files.length > 0){
                        isValid = false;
                        $(`#foodRow`).find('.expense-message')
                        .text(!isValid ? 'Please attach receipt for the expense claim' : '')
                        .toggle(!isValid).addClass("text-danger ").removeClass("text-muted");
                    }                
                    if(amount > 1500){
                        isValid = false;
                        $("#foodClaim").closest(".input-group").append(`<small class="text-danger expense-message" style="width:100%">Amount cannot be greater than 1500</small>`)
                    }
                    getData = {
                        "type":expenseType,
                        "amount": amount,
                        "filesUploaded": files
                    }
                }

                if($(this).closest("#expenseModal").find(".travel-entry").length){
                    var modeOfTransport = $(".mode-transport-container .dropdown-value").val()
                    var transportType = $(".type-transport-container .dropdown-value").val();
                    var startingMeter = $(".starting-meter").val();
                    var closingMeter = $(".closing-meter").val();
                    var tollCharges = $(".toll-charges").val();
                    var fuelCharges = $(".fuel-charges").val();
                    var placesVisited = $(".places-visited").val();
                    expenseType = "travelExpenses";
                    getData = {
                        "type":expenseType,
                        "modeOfTransport": modeOfTransport,
                        "transportType":transportType,
                        "startingMeter":startingMeter,
                        "closingMeter":closingMeter,
                        "tollCharges":tollCharges,
                        "fuelCharges":fuelCharges,
                        "placesVisited":placesVisited,
                        "filesUploaded": files
                    }
                }

                if($(this).closest("#expenseModal").find(".misc-entry").length){
                    var miscType = $("#expenseModal .dropdown-value").val()
                    var claimAmount = $("#expenseModal .claim-amount").val()
                    expenseType = "miscExpense";
                    if(!miscType && !claimAmount > 0 && !files.length > 0){
                        isValid = false;
                        $("#foodClaim").closest(".input-group").append(`<small class="text-danger expense-message" style="width:100%">Amount cannot be greater than 1500</small>`)
                    }
                    getData = {
                        "type":expenseType,
                        "type": miscType,
                        "claimAmount":claimAmount,
                        "filesUploaded": files
                    }
                }       
                if(expenseData.claim){

                }else {
                    
                }     
                if(validateRequiredInput()){
                    addOrUpdateClaimDataPart(getDay, getDate, expenseType, getData);
                    $("#expenseModal").modal("hide");
                }               
                
            })

            function validateRequiredInput(){
                var isValid = true;
                    $("input[required]").each(function () {
                    const value = $(this).closest(".e-grp").find("input").val();
                    if (value === "") {
                        isValid = false;
                        $(this).closest('.e-grp').append(`<small class="text-danger expense-message">This field is required!!</small>`);
                    } else {
                        $(this).closest('.e-grp').remove("expense-message");
                    }
                });

                return isValid;
            }
            const addOrUpdateClaimDataPart = (dayNo, date, key, newData) => {
                // Retrieve data from localStorage or initialize an empty object
                let expenseData = JSON.parse(localStorage.getItem("expenseData")) || {};

                // Ensure claimData exists in expenseData
                if (!expenseData.claimData) {
                    expenseData.claimData = {};
                }

                // Ensure claimData exists for the given dayNo
                if (!expenseData.claimData[dayNo]) {
                    expenseData.claimData[dayNo] = { date: date }; // Initialize with date
                }

                let dayClaim = expenseData.claimData[dayNo];

                // Ensure the key exists (e.g., travelEntries, miscExpense)
                if (!Array.isArray(dayClaim[key])) {
                    dayClaim[key] = [];
                }

                // Check for duplicates and add new data
                if (Array.isArray(newData)) {
                    newData.forEach((entry) => {
                        const isDuplicate = dayClaim[key].some((existing) =>
                            JSON.stringify(existing) === JSON.stringify(entry)
                        );
                        if (!isDuplicate) {
                            dayClaim[key].push(entry);
                        }
                    });
                } else {
                    const isDuplicate = dayClaim[key].some((existing) =>
                        JSON.stringify(existing) === JSON.stringify(newData)
                    );
                    if (!isDuplicate) {
                        dayClaim[key].push(newData);
                    }
                }

                // Save the updated data back to localStorage
                localStorage.setItem("expenseData", JSON.stringify(expenseData));
                console.log(`Updated claimData for day ${dayNo}:`, expenseData.claimData[dayNo]);
                showLocalData(dayNo)
            };

            function showLocalData(dayNo) {
                // Retrieve data from localStorage
                var updatedData = JSON.parse(localStorage.getItem("expenseData"));               
                

                if (!updatedData || !updatedData.claimData || !updatedData.claimData[`${dayNo}`]) {
                    console.error("No data found for the specified day");
                    return;
                }

                const dayData = updatedData.claimData[`${dayNo}`];

                $(".exp-wrapper").css("display", "flex");
                $(".exp-wrapper > .exp-card-title").html(`${dayNo} : ${dayData.date}`)
                $(".selected-date").val(`${dayData.date}`)
                $(".selected-day").val(`${dayNo}`)

                // Display Food Expenses
                if (dayData.foodExpenses?.length) {
                    var container = $(".food-exp-data .exp-data");
                    container.html("");

                    dayData.foodExpenses.forEach((foodExpense) => {
                        const itemHTML = `
                            <span class="exp-title">${foodExpense.type}</span>
                            <span class="exp-value">₹${foodExpense.amount}</span>
                            <span class="exp-bill-copy">
                                ${(foodExpense.filesUploaded || [])
                                    .map(
                                        (file) =>
                                            `<a href="http://localhost:3000/img/${file.name}"><i class="fa-solid fa-file"></i></a>`
                                    )
                                    .join("")}
                            </span>
                            <span class="exp-card-btns">
                                <span class="o-icons">
                                    <a href="javascript:;"><i class="fa-solid fa-pencil"></i></a>
                                    <a href="javascript:;"><i class="fa-solid fa-trash"></i></a>
                                </span>
                                <span class="a-icons">
                                    <a href="javascript:;"><i class="fa-solid fa-check-double"></i></a>
                                    <a href="javascript:;"><i class="fa-solid fa-close"></i></a>
                                </span>
                            </span>
                        `;
                        container.append(itemHTML);
                    });
                    $(".food-exp-data").addClass("display-block");
                    $(".f-expense").closest(".expense-details-g").addClass("extended");
                    $(".f-expense .icon").html(`<i class="fa-solid fa-check-double"></i>`)
                    $(".f-expense .btn-txt").html(`Add More Food Expense`);
                } else {
                    $(".f-expense .icon").html(`<i class="fa-solid fa-plus"></i>`)
                    $(".f-expense").closest(".expense-details-g").removeClass("extended");
                    $(".f-expense .btn-txt").html(`Add Food Expense`);
                    $(".food-exp-data").removeClass("display-block");
                }

                // Display Misc Expenses
                if (dayData.miscExpense?.length) {
                    var container = $(".misc-exp-data .exp-data");
                    container.html("");

                    dayData.miscExpense.forEach((miscExpense) => {
                        const itemHTML = `
                            <span class="exp-title">${miscExpense.type}</span>
                            <span class="exp-value">₹${miscExpense.claimAmount}</span>
                            <span class="exp-bill-copy">
                                ${(miscExpense.filesUploaded || [])
                                    .map(
                                        (file) =>
                                            `<a href="http://localhost:3000/img/${file.name}"><i class="fa-solid fa-file"></i></a>`
                                    )
                                    .join("")}
                            </span>
                            <span class="exp-card-btns">
                                <span class="o-icons">
                                    <a href="javascript:;"><i class="fa-solid fa-pencil"></i></a>
                                    <a href="javascript:;"><i class="fa-solid fa-trash"></i></a>
                                </span>
                                <span class="a-icons">
                                    <a href="javascript:;"><i class="fa-solid fa-check-double"></i></a>
                                    <a href="javascript:;"><i class="fa-solid fa-close"></i></a>
                                </span>
                            </span>
                        `;
                        container.append(itemHTML);
                    });
                    $(".misc-exp-data").addClass("display-block");
                    $(".m-expense").closest(".expense-details-g").addClass("extended");
                    $(".m-expense .icon").html(`<i class="fa-solid fa-check-double"></i>`)
                    $(".m-expense .btn-txt").html(`Add More Misc Expense`);
                } else {
                    $(".m-expense .icon").html(`<i class="fa-solid fa-plus"></i>`)
                    $(".m-expense").closest(".expense-details-g").removeClass("extended");
                    $(".m-expense .btn-txt").html(`Add Misc Expense`);
                    $(".misc-exp-data").removeClass("display-block");
                }

                // Display Travel Expenses
                if (dayData.travelExpenses?.length) {
                    var container = $(".travel-exp-data .row-body");
                    container.html("");

                    dayData.travelExpenses.forEach((travelExpense) => {
                        const itemHTML = `
                            <div class="exp-row">
                                <span class="exp-value"><span class="exp-title">Transport Mode</span>${travelExpense.modeOfTransport} - ${travelExpense.transportType}</span>
                                <span class="exp-value"><span class="exp-title">Starting Meter</span>${travelExpense.startingMeter || 0}</span>
                                <span class="exp-value"><span class="exp-title">Closing Meter</span>${travelExpense.closingMeter || 0}</span>
                                <span class="exp-value"><span class="exp-title">Places Visited</span>${travelExpense.placesVisited || 'N/A'}</span>
                                <span class="exp-value"><span class="exp-title">Claim</span>₹${travelExpense.fuelCharges || 0}</span>
                                <span class="exp-value"><span class="exp-title">Claim</span>₹${travelExpense.tollCharges || 0}</span>
                                <span class="exp-value exp-bill-copy">
                                    <span class="exp-title exp-bill-copy">Bill Copy</span>
                                    ${(travelExpense.filesUploaded || [])
                                        .map(
                                            (file) =>
                                                `<a href="http://localhost:3000/img/${file.name}"><i class="fa-solid fa-file"></i></a>`
                                        )
                                        .join("")}
                                </span>
                                <span class="exp-card-btns">
                                    <span class="o-icons">
                                        <a href="javascript:;"><i class="fa-solid fa-pencil"></i></a>
                                        <a href="javascript:;"><i class="fa-solid fa-trash"></i></a>
                                    </span>
                                    <span class="a-icons">
                                        <a href="javascript:;"><i class="fa-solid fa-check-double"></i></a>
                                        <a href="javascript:;"><i class="fa-solid fa-close"></i></a>
                                    </span>
                                </span>
                            </div>
                        `;
                        container.append(itemHTML);
                    });
                    $(".travel-exp-data").addClass("display-block");
                    $(".t-expense").addClass("extended");
                    $(".t-expense .icon").html(`<i class="fa-solid fa-check-double"></i>`)
                    $(".t-expense .btn-txt").html(`Add More Travel Expense`);
                } else {
                    $(".travel-exp-data").addClass("display-block");
                    $(".t-expense").closest(".expense-details-g").removeClass("extended");
                    $(".t-expense .icon").html(`<i class="fa-solid fa-plus"></i>`)
                    $(".t-expense .btn-txt").html(`Add Travel Expense`);
                    $(".travel-exp-data").removeClass("display-block");
                }
            }

            function generateDays() {
                const startDate = new Date(expenseData.startingDT);
                const $container = $('#daysContainer');
                
                // Clear existing content
                $container.empty();

                // Generate buttons for each day
                for (let i = 0; i < expenseData.noOfDays; i++) {
                    const currentDate = new Date(startDate);
                    currentDate.setDate(startDate.getDate() + i);
                    
                    // Format date as dd-MMM-yyyy
                    const day = String(currentDate.getDate()).padStart(2, '0');
                    const month = currentDate.toLocaleDateString('en-US', { month: 'short' });
                    const year = currentDate.getFullYear();
                    const dayNo =  'Day ' + (i + 1);
                    const formattedDate = `${day}-${month}-${year}`;
                    const expenseData = JSON.parse(localStorage.getItem("expenseData")) || {};
                    let isSubmitted = expenseData.claimData[dayNo]?.isSubmitted; 

                    // const $dayButton = $('<button>')
                    //     .addClass(`day-button ${isSubmitted == 1 ? 'is-selected' : ''}`)
                    //     .append(`<div class="day-icon"><i class="fa-solid fa-calendar-days"></i></div>`)
                    //     .append(
                    //         $('<div>')
                    //             .addClass('day-number')
                    //             .text('Day ' + (i + 1))
                    //     )
                    //     .append(
                    //         $('<div>')
                    //             .addClass('day-date')
                    //             .text(formattedDate)
                    //     );
                      
                      const $dayButton =   `<button class="day-button date-card ${isSubmitted == 1 ? 'selected' : ''}">
                            <div class="icon-wrapper">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                            </div>
                            <div class="content">
                                <div class="day day-number">Day ${(i + 1)}</div>
                                <div class="date day-date">${formattedDate}</div>
                            </div>
                            <div class="status-icon" style="display:${isSubmitted == 1 ? '' : 'none'}">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>
                        </button>
                        `
                    $container.append($dayButton);
                }
            }

            $(document).on('click', '.day-button', function() {
                $('.day-button').removeClass('selected');
                $(this).addClass('selected');

                // Get both day number and date
                const dayText = $(this).find('.day-number').text();
                const dateText = $(this).find('.day-date').text();
                const dayNumber = parseInt(dayText.replace('Day ', ''));

                handleDaySelect(dayText, dateText)

            });
            $(".show-date-list").on('click', () => {
                showDateList();
            })
            $('.submit-day-form').on('click', () => {
                let userConfirmed = confirm('Are you sure you want to submit the data?');
                if (userConfirmed) {
                    let expenseData = JSON.parse(localStorage.getItem("expenseData")) || {};
                    let dayNo = $('.day-number').text()
                    expenseData.claimData[dayNo].isSubmitted = 1;
                    localStorage.setItem("expenseData", JSON.stringify(expenseData));
                    showDateList();
                }
            })
            function showDateList(){
                $(".day-details-box").show();
                $(".exp-details-box").hide();
                $(".exp-wrapper").hide();
            }
            function hideExpDetails(){
                $(".day-details-box").hide();
                $(".exp-details-box").show(); 
            }

            const handleDaySelect = (dayText, dateSelected) => {
                const expenseData = JSON.parse(localStorage.getItem("expenseData"));
                console.log(`Selected day ${dayText} - ${dateSelected}`);
                $(".day-details-box").hide()
                $(".exp-details-box").show()    
                const dayData = expenseData.claimData[dayText];            
                if(dayData?.foodExpenses?.length || dayData?.travelExpenses?.length || dayData?.miscExpense?.length){
                    showLocalData(dayText)
                } else{
                    $(".exp-wrapper").css("display", "none");
                    $(".selected-date").val(dateSelected)
                    $(".selected-day").val(dayText)
                }
            };

            $(".toggle-container .trip-info-title a").on('click', function () {
                toggleTavelInfo($(this));
            });

            function toggleTavelInfo(elem) {
                var thisElem = elem;
                var icon = thisElem.find(".fa-minus"); // Find the specific icon inside the clicked element
                icon.toggleClass("fa-plus");
                
                if (icon.hasClass("fa-plus")) {
                    thisElem.closest(".toggle-container").find(".toggle-box").hide();
                } else {
                    thisElem.closest(".toggle-container").find(".toggle-box").show();
                }
            }

            // Initialises the functions
            generateDays();

        });
    </script>
@endpush