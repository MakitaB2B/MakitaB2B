@extends('Admin/layout')
@section('page_title', 'Promotion Transaction | MAKITA')
@section('promotiontransaction-expandable','menu-open')
@section('promotion-transaction-expandable','active')
@section('promotion_transaction_select','active')
@section('container')
    <div class="content-wrapper">
        @push('styles')

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
                                            <select class="custom-select" name="promo_code" required id="examplePromoCode">
                                                <option value="">Please Select</option>
                                                <option value="PromoCode1">PromoCode1</option>
                                                <option value="PromoCode2">PromoCode2</option>
                                            </select>
                                            @error('promo_code')
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
                                            <label for="exampleDealerCode">Name*</label>
                                            <select class="custom-select" name="rm_name" required id="exampleDealerCode">
                                                <option value="">Please Select</option>
                                                <option value="RM1">RM1</option>
                                                <option value="RM2">RM2</option>
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
                                            <select class="custom-select" name="dealer_code" required id="exampleDealerCode">
                                                <option value="">Please Select</option>
                                                <option value="DealerCode1">DealerCode1</option>
                                                <option value="DealerCode2">DealerCode2</option>
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
                                        <div class="form-group col-md-2">
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
                                        <div class="form-group col-md-2">
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
                                        </div>
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
                                        <div class="form-group col-md-2">
                                            <label for="exampleTotalPrice">TotalPrice*</label>
                                            <input type="text" class="form-control" name="modeltotalprice"
                                                value="" required id="exampleTotalPrice"
                                                placeholder="Enter Model">
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
                                        <div class="form-group col-md-2">
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
                                        </div>
            
                                    </div>
                                    <hr>
                                    <div class="row offer_product thick">
                                        <div class="offer">
                                        
                                        </div>
                                        <div class="foc">
                                        
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
      

        <script>

                let loop_count = 0;
                $('#examplePromoCode').on('change', function() {
                    let promoID = $(this).val();
                    $.ajax({
                        url: '/admin/promotions/promotion-fetch',
                        type: 'get',
                        data: 'promoID=' + promoID,
                        success: function(result) {
                        

                        // let resultArray = Object.values(result);

                        // var dataArray = Object.entries(result).map(([key, value]) => ({ [key]: value }));

                        // var offerProductArray = Object.values(result.offer_product);
                        // var focArray = Object.values(result.foc);

                        // var data=["offer_product":offerProductArray,"foc":focArray];

                        // var dataArray = [
                        //                 { "offer_product": Object.values(result.offer_product) },
                        //                 { "foc": Object.values(result.foc) }
                        //                 ];


                        // var dataArray = Object.entries(result).map(([key, value]) => ({ [key]: Object.entries(value) }));

                        // console.log(dataArray);

                        result.forEach(option => {

                            let html="";

                            if(option.offer_product){
                                html +=`<h6 class="dacss">Offer Product</h6>`;
                            }
                            
                            else{
                                html +=`<h6 class="dacss">FOC</h6>`;
                            }

                            // <div class="row" id="${option}"></div>

                            result.forEach(options => {

                        loop_count++;

                          html +=`
                            <div class="row">
                            <div class="form-group col-md-2">
                                <label for="exampleMode${loop_count}">Selected Model Name</label>
                                <input type="text" class="form-control" name="model1[]" value="${option}" id="exampleMode${loop_count}" placeholder="${option}" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="offerdescription${loop_count}">Offer Description</label>
                                <input type="text" class="form-control" name="offerdescription[]" id="offerdescription${loop_count}" placeholder="Offer Description" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="examplePromoMrp${loop_count}">MRP</label>
                                <input type="text" class="form-control" name="promomrp[]" id="examplePromoMrp${loop_count}" placeholder="MRP" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="examplePromoDlp${loop_count}">DLP</label>
                                <input type="text" class="form-control" name="promodlp[]" id="examplePromoDlp${loop_count}" placeholder="DLP" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="examplePromoStock${loop_count}">Stock</label>
                                <input type="text" class="form-control" name="promostock[]" id="examplePromoStock${loop_count}" placeholder="Stock" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="examplePromoPriceType${loop_count}">Price Type</label>
                                <input type="text" class="form-control" name="pricetype[]" id="examplePromoPriceType${loop_count}" placeholder="Price Type" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="exampleOfferQty${loop_count}">Offer Qty</label>
                                <input type="text" class="form-control" name="offerqty[]" id="exampleOfferQty${loop_count}" placeholder="Offer Qty">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="examplePromoPrice${loop_count}">Price</label>
                                <input type="text" class="form-control" name="promoprice[]" value="" id="examplePromoPrice${loop_count}" placeholder="Price">
                            </div> </div>  
                        `;
                    
                        if(options.offer_product){
                            $('.offer_product .offer').append(html);
                        }
                        else{
                            $('.offer_product .foc').append(html);
                        }
                         
                    });

                        });

                        }
                    });
                });

           
    // let loop_count = 0;
    // let previousSelectedOptions = [];

    // function getpromoproducts() {
    


    // }

        </script>
    @endpush
@endsection
