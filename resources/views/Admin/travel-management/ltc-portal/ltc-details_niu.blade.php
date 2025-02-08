@extends('Admin/layout')
@section('page_title', 'LTC DETAILS | MAKITA')
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
<div class="content-wrapper rescss"> 
    <div class="custom-container">
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
                <a href="javascript:;" class="btn btn-primary">Accept / Accept All</a>
                <a href="javascript:;" class="btn btn-secondary">Reject / Reject All</a>     
            </div>   
               
        </div>
        <table class="table table-bordered custom-table">
            <thead>
                <tr>
                    <th width="30">
                        <div class="checkbox-wrapper">
                            <input type="checkbox" class="form-check-input" id="selectAll">
                        </div>
                    </th>
                    <th>Date</th>
                    <th>In Time</th>
                    <th>Out Time</th>
                    <th>Travel Exp.(Total)</th>
                    <th>Food Exp.(Total)</th>
                    <th>Misc. Exp.(Total)</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th width="30"></th>
                </tr>
            </thead>
            
            <tbody>
            </tbody>
        </table>        
    </div>
</div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('admin_assets/js/custom-js/custom.js') }}"></script>

@endpush