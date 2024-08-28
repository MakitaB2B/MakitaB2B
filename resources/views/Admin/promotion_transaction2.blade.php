@extends('Admin/layout')
@section('page_title', 'Promotion Transaction | MAKITA')
@section('promotiontransaction-expandable','menu-open')
@section('promotion-transaction-expandable','active')
@section('promotion_transaction_select','active')
@section('container')
    <div class="content-wrapper">
        @push('styles')
        <link rel="stylesheet" href="{{ asset('admin_assets/plugins/select2/css/select2.min.css') }}">

        <style>
            hr.thick {
              border: none;
              height: 10px; /* Adjust the height to make the rule thicker */
              background-color: #333; /* Choose the color of the horizontal rule */
            }

            .dacss {
            background: #007bff;
            padding: 5px;
            border-radius: 3px;
            color: snow;
            font-size: 17px;
        }
        </style>
       
        @endpush
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Promotion Transaction</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/promotions/promotion-transaction') }}">Promotion Transaction</a>
                            </li>
                            <li class="breadcrumb-item active">Promotion Transaction Master</li>
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
                                <h3 class="card-title">Promotion Transaction</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="POST" action="{{ route('asset-master.manage-asset-master-process') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label for="examplePromoCode">Promo Code*</label>
                                            <select class="promotions select2" name="promo_code" required id="examplePromoCode">
                                                    <option value="0">Select Promo Code</option>
                                                    @foreach ($promo_code as $item)
                                                    <option value="{{$item->promo_code}}">{{$item->promo_code}}</option>
                                                    @endforeach
                                            </select>
                                            @error('promo_code')
                                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="exampleRmname">Name*</label>
                                            <select class="custom-select select2" name="rm_name" required id="exampleRmname">
                                                @foreach ($regional_manager as $item)
                                                <option value="{{$item->rm_name}}">{{$item->rm_name}}</option>
                                                @endforeach
                                            </select>
                                            @error('rm_name')
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
                                            <label for="exampleDealerCode">Dealer Code*</label>
                                            <select class="custom-select select2" name="dealer_code" required id="exampleDealerCode">
                                                <option value="0">Select Dealer Code</option>
                                                @foreach ($dealer_master as $item)
                                                <option value="{{$item->dealer_code}}-{{$item->dealer_name}}">{{$item->dealer_code}}</option>
                                                @endforeach
                                            </select>
                                            @error('dealer_code')
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
                                        <div class="form-group col-md-3">
                                            <label for="exampleDealerName">Dealer Name*</label>
                                            <input type="text" class="form-control" name="dealername"
                                                value="" required id="exampleDealerName"
                                                placeholder="Enter Model">
                                            @error('dealername')
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
                                        {{-- <div class="form-group col-md-2">
                                            <label for="exampleModelQuantity">Quantity*</label>
                                            <input type="text" class="form-control" name="modelquantity"
                                                value="" required id="exampleModelQuantity"
                                                placeholder="Enter Model">
                                            @error('modelquantity')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div> --}}
                                        {{-- <div class="form-group col-md-2">
                                            <label for="examplePricePerQuantity">Price Per Quantity*</label>
                                            <input type="text" class="form-control" name="priceperquantity"
                                                value="" required id="examplePricePerQuantity"
                                                placeholder="Enter Model">
                                            @error('priceperquantity')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div> --}}
                                        <div class="form-group col-md-3">
                                            <label for="exampleTotalPrice">TotalPrice*</label>
                                            <input type="text" class="form-control" name="modeltotalprice"
                                                value="" required id="exampleTotalPrice"
                                                placeholder="Enter Model" required readonly>
                                            @error('modeltotalprice')
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
                                        {{-- <div class="form-group col-md-2">
                                            <label for="exampleModelStock">Stock*</label>
                                            <input type="text" class="form-control" name="model_stock"
                                                value="" required id="exampleModelStock"
                                                placeholder="Enter Serial Number" readonly>
                                            @error('model_stock')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div> --}}
            
                                    </div>
                                    <hr>
                                    <div class="promo_offer thick">
                                        {{-- <div class="promotions">
                                        row
                                        </div> --}}
                                        {{-- <div class="foc">
                                        
                                        </div> --}}
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

    <script src="{{ asset('admin_assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>

        $('.select2').select2({
            width: '100%'
        });

        $('#exampleDealerCode').on('change', function() {
            var selectedValue = $(this).val();
            let res = selectedValue.split('-');
            $('#exampleDealerName').val(res[1]);
        });


    let loop_count = 0;
    $('#examplePromoCode').on('change', function() {
        $('.promo_offer').empty();

        let promoID = $(this).val();
        $.ajax({
            url: '/admin/promotions/promotion-fetch',
            type: 'get',
            data: 'promoID=' + promoID,
            success: function(result) {

                console.log(result);


            // let html="";
            result.data.forEach(option => {

            loop_count++;

            let html =`<div class="row">
                <div class="form-group col-md-2">
                    <label for="exampleModel${loop_count}">Model No.</label>
                    <input type="text" class="form-control" name="model[]" value="${option.model_no}" id="exampleModel${loop_count}" placeholder="${option.model_no}" readonly>
                </div>
                <div class="form-group col-md-3">
                    <label for="description${loop_count}">Description</label>
                    <input type="text" class="form-control" name="description[]" value="${option.model_desc}" id="description${loop_count}" placeholder="Description" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="from_date${loop_count}">From Date[mm/dd/yyyy]</label>
                    <input type="date" class="form-control" name="from_date[]" value="${option.from_date}" id="from_date${loop_count}" placeholder="From Date" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="to_date${loop_count}">To Date[mm/dd/yyyy]</label>
                    <input type="date" class="form-control" name="to_date[]" value="${option.to_date}" id="from_date${loop_count}" placeholder="To Date" readonly>
                </div>
                <div class="form-group col-md-1">
                    <label for="exampleMrp${loop_count}">MRP</label>
                    <input type="text" class="form-control" name="mrp[]" value="${option.mrp}" id="examplePromoMrp${loop_count}" placeholder="MRP" readonly>
                </div>
                <div class="form-group col-md-1">
                    <label for="examplePromoDlp${loop_count}">DLP</label>
                    <input type="text" class="form-control" name="promodlp[]" value="${option.dlp}" id="examplePromoDlp${loop_count}" placeholder="DLP" readonly>
                </div>
                <div class="form-group col-md-1">
                    <label for="examplePromoStock${loop_count}">Stock</label>
                    <input type="text" class="form-control" name="promostock[]" value="${option.stock}" id="examplePromoStock${loop_count}" placeholder="Stock" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="exampleOfferType${loop_count}">Offer Type</label>
                    <input type="text" class="form-control" name="offertype[]" value="${option.offer_type}" id="exampleOfferType${loop_count}" placeholder="Offer Type" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="exampleOfferType${loop_count}">Product Type</label>
                    <input type="text" class="form-control" name="product_type[]" value="${option.product_type}" id="exampleOfferType${loop_count}" placeholder="Product Type" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="examplePromoPriceType${loop_count}">Price Type</label>
                    <input type="text" class="form-control" name="pricetype[]" value="${option.price_type}" id="examplePromoPriceType${loop_count}" placeholder="Price Type" readonly>
                </div>
                <div class="form-group col-md-1">
                    <label for="exampleOfferQty${loop_count}">Offer Qty</label>
                    <input type="text" class="form-control" name="offerqty[]" value="${option.qty}" id="exampleOfferQty${loop_count}" placeholder="Offer Qty" readonly>
                </div>
                <div class="form-group col-md-1">
                    <label for="examplePromoPrice${loop_count}">Price</label>
                    <input type="text" class="form-control" name="promoprice[]" value="${option.price}" value="" id="examplePromoPrice${loop_count}" placeholder="Offer Price" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="examplePromoPrice${loop_count}">Qty</label>
                    <input type="text" class="form-control" name="promoprice[]" value="" value="" id="examplePromoPrice${loop_count}" placeholder="Offer Price" >
                </div>
                
                </div> 
            `;
          
            $('.promo_offer').append(html);
         
               });
              }
           });
        });


    </script>
    @endpush
@endsection
