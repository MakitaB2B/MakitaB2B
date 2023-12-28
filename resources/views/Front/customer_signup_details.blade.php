@extends('Front/layout')
@section('page_title', 'Makita Customer | Customer Details')
@section('profile_select', 'active')
@section('container')

    <!-- Container (Contact Section) -->
    <div id="contact" class="container">
        @push('styles')
            <!-- Select2 -->
            <link rel="stylesheet" href="{{ asset('admin_assets/plugins/select2/css/select2.min.css') }}">
        @endpush
        <style>
            .select2-container--default .select2-selection--single {
                border-radius: 0px !important;
            }
        </style>
        <div class="row">
            <x-reachus />
            <form method="post" action="{{ route('cx-profile-manage') }}">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="sealerdealername">Name<span class="required">*</span></label>
                            <input class="form-control" id="name" name="name" placeholder="Enter Name"
                                value="{{ $name }}" type="text" required>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="pop">Email</label>
                            <input class="form-control" id="email" name="email" placeholder="Enter Email"
                                value="{{ $email }}" type="email">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="sealerdealerstate">State<span class="required">*</span></label>
                            <select class="form-control select2" name="state" style="width: 100%;" id="state"
                                required>
                                <option value="0">Please Select State</option>
                                @foreach ($states as $stateList)
                                    <option @if ($stateList->id == $state_id) selected @endif value="{{ $stateList->id }}">
                                        {{ ucfirst(trans($stateList->name)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6 form-group ajax-loader">
                            <label for="pop">City<span class="required">*</span></label>
                            <select class="form-control select2" name="city" style="width: 100%;" id="city">
                                @if ($city_id != '')
                                    <option>Select A City</option>
                                    @foreach ($cityByState as $citiesbystateList)
                                        <option @if ($citiesbystateList->id == $city_id) selected @endif
                                            value="{{ $citiesbystateList->id }}">
                                            {{ $citiesbystateList->name }}</option>
                                    @endforeach
                                    @else
                                    <option>Select A State To Fetch City</option>
                                @endif
                            </select>
                        </div>
                        <p class="citymsg" style="color: rgb(222 83 7 / 77%)"></p>
                    </div>
                    <textarea class="form-control" id="comments" name="address" placeholder="Enter Address" rows="5">{{ $address }}</textarea>
                    <br>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <button class="btn pull-right" type="submit">Send</button>
                        </div>
                    </div>
                </div>
                @csrf
            </form>
        </div>
        <br>
        <x-warrantypolicy />
    </div>
    @push('scripts')
        <!-- Select2 -->
        <script src="{{ asset('admin_assets/plugins/select2/js/select2.full.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#state').on('change', function() {
                    $('.ajax-loader').hide();
                    $('.citymsg').text("Please wait while fetching Cities...").show();
                    let stateID = $(this).val();
                    $.ajax({
                        url: '/city/get-cities-by-state',
                        type: 'post',
                        data: 'stateID=' + stateID + '&_token={{ csrf_token() }}',
                        success: function(result) {
                            $('.ajax-loader').show();
                            $('.citymsg').hide();
                            $('#city').html(result);
                        }
                    });
                });
            });
            $(function() {
                $('.select2').select2()
            });
        </script>
    @endpush
@endsection
