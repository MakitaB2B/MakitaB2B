@extends('Admin/layout')
@section('page_title', 'Promotion Creation | MAKITA')
@section('promotion-expandable','menu-open')
@section('promotion-select','active')
@section('promotion_select','active')
@section('container')
    <div class="content-wrapper">
        @push('styles')
        <link rel="stylesheet" href="{{ asset('admin_assets/plugins/select2/css/select2.min.css') }}">
        @endpush
        <style>
            .select2-container--default .select2-selection--single {
                border-radius: 0px !important;
            }
            .dacss{
                background: #007bff;
                padding: 5px;
                border-radius: 3px;
                color: snow;
                font-size: 17px;
            }
        </style>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Promotion Creation</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/promotions') }}">Promotion List</a>
                            </li>
                            <li class="breadcrumb-item active">Promotion Creation</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Promotions</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="POST" action="{{ route('asset-master.manage-asset-master-process') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-8">
                                            <label for="exampleAssetTypeName">Offer Type*</label>
                                            <select class="custom-select" name="offer_type" required onChange="handleSelection(value)">
                                                <option value="">Please Select</option>
                                                @foreach($offer_type as $type)
                                                <option  value="{{$type}}">{{ucfirst(trans($type))}}</option>
                                                @endforeach
                                            </select>
                                            @error('offer_type')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <h6 class="dacss">Solo Offer</h6> 
                                    <div class="soloOffer">
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label for="examplePromoFromDate">From Date</label>
                                            <input type="date" class="form-control" name="promo_from_date"
                                                value=""  id="examplePromoFromDate"
                                                placeholder="Enter Promotion From Date">
                                            @error('promo_from_date')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="examplePromoToDate">To Date</label>
                                            <input type="date" class="form-control" name="promo_to_date"
                                                value=""  id="examplePromoToDate"
                                                placeholder="Enter Promotion To Date">
                                            @error('promo_to_date')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="examplePromoCode">Promo Code</label>
                                            <input type="text" class="form-control" name="promocode"
                                                value=""  id="examplePromoCode"
                                                placeholder="Promo Code" readonly>
                                            @error('promocode')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="exampleOfferProduct">Offer Product</label>
                                            <select class="custom-select" name="offer_product" id="exampleOfferProduct">
                                                <option value="">Please Select Model No</option>
                                                <option value="Model 1">Model 1</option>
                                            </select>
                                            @error('offer_product')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="exampleOfferQty">Offer Qty</label>
                                            <input type="text" class="form-control" name="offerqty"
                                                value=""  id="exampleOfferQty"
                                                placeholder="Offer Qty">
                                            @error('offerqty')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="examplePromoPriceType">Price Type</label>
                                            <select class="custom-select" name="pricetype" id="examplePromoPriceType">
                                                <option value="">Please Select Price Type</option>
                                                @foreach($price_type as $type)
                                                <option  value="{{$type}}">{{ucfirst(trans($type))}}</option>
                                                @endforeach
                                            </select>
                                            @error('pricetype')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div> 
                                        <div class="form-group col-md-2">
                                            <label for="examplePromoPrice">Price</label>
                                            <input type="text" class="form-control" name="promoprice"
                                                value=""  id="examplePromoPrice"
                                                placeholder="Price" >
                                            @error('promoprice')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>   
                                        <div class="form-group col-md-2">
                                            <label for="examplePromoDlp">DLP</label>
                                            <input type="text" class="form-control" name="promodlp"
                                                value=""  id="examplePromoDlp"
                                                placeholder="DLP" readonly>
                                            @error('promodlp')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>                                     
                                        <div class="form-group col-md-2">
                                            <label for="examplePromoMrp">MRP</label>
                                            <input type="text" class="form-control" name="promomrp"
                                                value=""  id="examplePromoMrp"
                                                placeholder="MRP" readonly >
                                            @error('promomrp')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>  
                                        <div class="form-group col-md-2">
                                            <label for="examplePromoStock">Stock</label>
                                            <input type="text" class="form-control" name="promostock"
                                                value=""  id="examplePromoStock"
                                                placeholder="Stock" readonly>
                                            @error('promostock')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <h6 class="dacss">FOC Product(s)</h6>
                                    <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="promofoc">FOC Model No</label>
                                        <select class="select2" multiple="multiple" data-placeholder="Select Foc Model No(s)" style="width: 100%;" name="promofoc[]">
                                          <option value="model1">model1</option>
                                          <option value="model2">model2</option>
                                        </select>
                                        @error('promofoc')
                                            <div
                                                class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                {{ $message }}
                                                <button type="button" class="close" data-dismiss="alert"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                        @enderror
                                    </div>
                                    </div> 
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label for="exampleMode1">Model 1</label>
                                            <input type="text" class="form-control" name="model1"
                                                value=""  id="exampleMode1"
                                                placeholder="Model 1" readonly>
                                            @error('model1')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="exampleMode1">Model1 Qty</label>
                                            <input type="text" class="form-control" name="model1Qty"
                                                value=""  id="exampleMode1"
                                                placeholder="Model 1" >
                                            @error('model1')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="exampleMode1">Model1 Stock</label>
                                            <input type="text" class="form-control" name="model1Stock"
                                                value=""  id="exampleMode1"
                                                placeholder="Model 1" >
                                            @error('model1')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                    </div> 


                                  </div>   
                                  
                                  <div class="comboOffer">
                                    <div class="row">

                                    </div>    



                                  </div>   
                                    
                                  
                                    
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary" id="submt">Submit</button>
                                </div>
                                <input type="hidden" value="" name="assetmaster_slug" required />
                            </form>
                        </div>
                        <!-- /.card -->

                    </div>
                    <!--/.col (left) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    @push('scripts')
    <!-- Select2 -->
    <script src="{{ asset('admin_assets/plugins/select2/js/select2.full.min.js') }}"></script>
        <script>
        $(function() {
                $('.select2').select2()
        });

        function handleSelection(choice) {
        document.getElementById('select').disabled=true;
        document.getElementById(choice).style.display="block"
        }

        </script>
    @endpush
@endsection
