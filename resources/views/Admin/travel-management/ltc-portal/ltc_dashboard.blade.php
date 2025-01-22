@extends('Admin/layout')
@section('page_title', 'LTC DASHBOARD | MAKITA')
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
        <div class="common-error">
            <p>Your LTC application is pending for approval. Please wait while your application is reviewed.</p>
            <a href="javascript:;" class="error-close"><i class="fa-solid fa-close"></i></a>
        </div>
        <div class="common-error">
            <p>Your LTC application is rejected due to the following reason:</p>
            <ul>
                <li>You have not submitted the required documents for the following dates: <b>01/01/2024, 02/01/2024, 03/01/2024.</b></li>
                <li>Your total travel expenses exceed the limit for the following dates: <b>04/01/2024, 05/01/2024.</b></li>
            </ul>   
            <a href="javascript:;" class="error-close"><i class="fa-solid fa-close"></i></a>            
        </div>
        <div class="action-grp">
            <div class="info-group color-info-box">
                <div><span class="color-box saturday-color"></span>Saturday</div>
                <div><span class="color-box sunday-color"></span>Sunday</div>
            </div>
            <div class="info-group">
                <div>**L - On Leave</div>
                <div>**H - Holiday Today</div>
            </div> 
            <div class="btn-grp">
                <button class="btn btn-primary accept-btn" disabled>Accept / Accept All</button>
                <button class="btn btn-secondary reject-btn" disabled>Reject / Reject All</button>     
            </div>  
                
        </div>
        <table class="table table-bordered custom-table ltc-table">
            <thead>
                <tr>
                    <th width="30">
                        <div class="checkbox-wrapper">
                            <input type="checkbox" class="form-check-input" id="selectAll">
                        </div>
                    </th>
                    <th>Date</th>
                    <th class="td-hide">In Time</th>
                    <th class="td-hide">Out Time</th>
                    <th class="td-hide">Travel Exp.(Total)</th>
                    <th class="td-hide">Food Exp.(Total)</th>
                    <th class="td-hide">Misc. Exp.(Total)</th>
                    <th class="td-hide">Total</th>
                    <th>Status</th>
                    <th width="30"></th>
                </tr>
            </thead>
            
            <tbody>
            </tbody>
        </table>        
    </div>
</div>
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rejection Remarks</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="rejectRemarks" class="form-label">Please enter rejection remarks*</label>
                    <textarea class="form-control" id="rejectRemarks" rows="3" required></textarea>
                    <div class="invalid-feedback">Please enter remarks for rejection.</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmReject">Confirm Reject</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('admin_assets/js/custom-js/custom.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(".error-close").click(function(){
                $(this).parent().hide();
            });

            // Initialize action buttons as disabled
            const $acceptBtn = $('.accept-btn');
            const $rejectBtn = $('.reject-btn');
            const $checkboxes = $('.row-checkbox');
            const $selectAll = $('#selectAll');
            
            // Handle checkbox changes
            function updateButtonStates() {
                const checkedCount = $('.row-checkbox:checked').length;
                $acceptBtn.prop('disabled', checkedCount === 0);
                $rejectBtn.prop('disabled', checkedCount === 0);
            }

            // Checkbox event handlers
            $selectAll.change(function() {
                const isChecked = $(this).prop('checked');
                $('.row-checkbox').prop('checked', isChecked);
                updateButtonStates();
            });

            $(document).on('change', '.row-checkbox', function() {
                updateButtonStates();
                // Update select all checkbox
                const allChecked = $('.row-checkbox:checked').length === $('.row-checkbox').length;
                $selectAll.prop('checked', allChecked);
            });

            // Accept button handler
            $acceptBtn.click(function() {
                const checkedCount = $('.row-checkbox:checked').length;
                const message = checkedCount === $('.row-checkbox').length ? 
                    'Are you sure you want to accept all entries?' :
                    `Are you sure you want to accept ${checkedCount} selected entries?`;

                if (confirm(message)) {
                    acceptSelectedEntries();
                }
            });

            // Reject button handler
            $rejectBtn.click(function() {
                const $modal = $('#rejectModal');
                $modal.modal('show');
                // Clear previous remarks and validation states
                $('#rejectRemarks').val('').removeClass('is-invalid');
            });

            // Confirm reject handler
            $('#confirmReject').click(function() {
                const remarks = $('#rejectRemarks').val().trim();
                if (!remarks) {
                    $('#rejectRemarks').addClass('is-invalid');
                    return;
                }
                
                rejectSelectedEntries(remarks);
                $('#rejectModal').modal('hide');
            });

            function acceptSelectedEntries() {
                const selectedRows = [];
                $('.row-checkbox:checked').each(function() {
                    const $row = $(this).closest('tr');
                    const rowData = {
                        date: $row.find('td:eq(1)').text(),
                        // Add other data you need to send to server
                    };
                    selectedRows.push(rowData);
                    
                    // Update UI to show accepted state
                    $row.find('.status-pending')
                        .removeClass('status-pending')
                        .addClass('status-approved')
                        .text('Approved');
                });

                // Here you would typically make an API call to update the server
                console.log('Accepting entries:', selectedRows);
                
                // Reset checkboxes and button states
                $selectAll.prop('checked', false);
                $('.row-checkbox').prop('checked', false);
                updateButtonStates();
                
                // Show success message
                showToast('Selected entries have been approved successfully', 'success');
            }

            function rejectSelectedEntries(remarks) {
                const selectedRows = [];
                $('.row-checkbox:checked').each(function() {
                    const $row = $(this).closest('tr');
                    const rowData = {
                        date: $row.find('td:eq(1)').text(),
                        remarks: remarks
                        // Add other data you need to send to server
                    };
                    selectedRows.push(rowData);
                    
                    // Update UI to show rejected state
                    $row.find('.status-pending')
                        .removeClass('status-pending')
                        .addClass('status-rejected')
                        .text('Rejected');
                });

                // Here you would typically make an API call to update the server
                console.log('Rejecting entries:', selectedRows, 'Remarks:', remarks);
                
                // Reset checkboxes and button states
                $selectAll.prop('checked', false);
                $('.row-checkbox').prop('checked', false);
                updateButtonStates();
                
                // Show success message
                showToast('Selected entries have been rejected successfully', 'success');
            }

            // Add this if you don't already have a toast function
            function showToast(message, type = 'success') {
                const toast = `
                    <div class="toast align-items-center text-white bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">${message}</div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                        </div>
                    </div>
                `;
                
                const $toast = $(toast);
                $('.toast-container').append($toast);
                new bootstrap.Toast($toast[0], { delay: 3000 }).show();
                
                $toast.on('hidden.bs.toast', function() {
                    $(this).remove();
                });
            }


            // Handle the dropdown toggle
            $('.status-pending').on('click', function (e) {
                e.stopPropagation(); // Prevent the click from propagating to the body
                $('.dropdown-menu').hide(); // Hide all other dropdowns
                $(this).siblings('.dropdown-menu').toggle(); // Show the current dropdown
            });

            // Handle dropdown option click
            $(document).on('click', '.dropdown-menu li', function () {
                let selectedStatus = $(this).text().trim();
                let $row = $(this).closest('tr');
                let statusCell = $row.find('.status-pending');

                if (selectedStatus === 'Approved') {
                    const message = $('.row-checkbox:checked').length === $('.row-checkbox').length ? 
                        'Are you sure you want to accept all entries?' :
                        `Are you sure you want to accept ${$('.row-checkbox:checked').length} selected entries?`;

                    if (confirm(message)) {
                        statusCell.removeClass().addClass('status-pending status-approved').text('Approved').append(`<i class="bi bi-chevron-down toggle-icon"></i>`);
                    }
                } else if (selectedStatus === 'Rejected') {
                    const $modal = $('#rejectModal');
                    $modal.modal('show');
                    $('#rejectRemarks').val('').removeClass('is-invalid');

                    $('#confirmReject').off('click').on('click', function () {
                        const remarks = $('#rejectRemarks').val().trim();
                        if (!remarks) {
                            $('#rejectRemarks').addClass('is-invalid');
                            return;
                        }
                        statusCell.removeClass().addClass('status-pending status-rejected').text('Rejected').append(`<i class="bi bi-chevron-down toggle-icon"></i>`);
                        $modal.modal('hide');
                    });
                } else {
                    statusCell.removeClass().addClass('status-pending status-' + selectedStatus.toLowerCase()).text(selectedStatus).append(`<i class="bi bi-chevron-down toggle-icon"></i>`);
                }

                $(this).closest('.dropdown-menu').hide();
            });

            // Hide dropdown when clicking outside
            $(document).on('click', function () {
                $('.dropdown-menu').hide();
            });
        });
    </script>
@endpush