@extends('Front/layout')
@section('page_title', 'Makita Warranty | Warranty Card')
@section('warrantycard_select', 'active')
@section('container')

    <!-- Container (Contact Section) -->
    <div id="contact" class="container">
        <div class="row">
            <div class="col-md-4">
                <p>Warranty? Reach Us at.</p>
                <p><span class="glyphicon glyphicon-map-marker"></span>Bangalore, India</p>
                <p><span class="glyphicon glyphicon-phone"></span>Phone: +91-80-2205-8200</p>
                <p><span class="glyphicon glyphicon-envelope"></span>Email: sales@makita.in</p>
            </div>
            <div class="col-md-8">
                <form method="POST" action="{{ route('warranty-registration-process') }}" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-12 form-group">
                            <label for="mop">Mode of Purchase<span class="required">*</span>: </label>
                            <input type="radio" id="online" name="mode_of_purchase" value="online" required>
                            <label for="online" class="mr20">Online</label>
                            <input type="radio" id="offline" name="mode_of_purchase" value="offline" required>
                            <label for="offline">Offline </label>
                            @error('mode_of_purchase')
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible show">
                                    {{ $message }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="sealerdealername">Purchase From<span class="required">*</span></label>
                            <input class="form-control" name="purchase_from" placeholder="Seller Name" type="text"
                                required>
                            @error('purchase_from')
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible show">
                                    {{ $message }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                            @enderror
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="pop">Place Of Purchase<span class="required">*</span></label>
                            <input class="form-control" name="place_of_purchase" placeholder="Place Of Purchase"
                                type="text" required>
                            @error('place_of_purchase')
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible show">
                                    {{ $message }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="dop">Date of Purchase<span class="required">*</span></label>
                            <input class="form-control" id="dop" name="date_of_purchase" type="date" required>
                            @error('date_of_purchase')
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible show">
                                    {{ $message }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                            @enderror
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="model">Model Number<span class="required">*</span></label>
                            <input class="form-control" value="{{$models[0]->model_number}}" disabled>
                            <input class="form-control" type="hidden" name="model_number" value="{{$models[0]->id}}" required>
                            @error('model_number')
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible show">
                                    {{ $message }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="invoice">Invoice Number<span class="required">*</span></label>
                            <input class="form-control" id="modelno" name="invoice_number"
                                placeholder="Invoice Number" type="text" value="" required>
                            @error('invoice_number')
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible show">
                                    {{ $message }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                            @enderror
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="msn">Machine Serial Number<span class="required">*</span></label>
                            <input class="form-control" type="text" value="{{base64_decode($slno)}}" disabled>
                            <input class="form-control" id="slno" name="machine_serial_number"
                                 type="hidden" required value="{{base64_decode($slno)}}">
                            @error('machine_serial_number')
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible show">
                                    {{ $message }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="invoice">Invoice Copy</label>
                            <input class="f12" name="invoice_copy" type="file"
                                accept="image/png, image/jpeg,image/png">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="invoice">A photo of the machine along with the SL no.<span
                                    class="required">*</span></label>
                            <input class="f12" name="machine_slno_photo" type="file"
                                accept="image/png, image/jpeg,image/png" required>
                            @error('machine_slno_photo')
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible show">
                                    {{ $message }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <textarea class="form-control" id="comments" name="comment" placeholder="Comment" rows="3"></textarea>
                    <br>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <button class="btn pull-right" type="submit">Send</button>
                        </div>
                    </div>
                    @csrf
                </form>
            </div>
        </div>
        <br>
        <x-warrantypolicy />
    </div>
@endsection
