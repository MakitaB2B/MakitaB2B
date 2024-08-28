@extends('Admin/layout')
@section('page_title', 'Promotion Creation | MAKITA')
@section('promotion-expandable','menu-open')
@section('promotion-select','active')
@section('promotion_select','active')
@section('container')
<div class="content-wrapper">
    @push('styles')
    {{-- <link rel="stylesheet" href="{{ asset('admin_assets/plugins/select2/css/select2.min.css') }}"> --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush
    <style>
        /* .select2-container--default .select2-selection--single {
            border-radius: 0px !important;
        } */
        select2-container--default .select2-selection--multiple .select2-selection__choice {
          background-color:#007bff !important;
        }
        .dacss {
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
                        <form method="POST" action="{{ route('asset-master.manage-asset-master-process') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                {{-- <div class="soloOffer"> --}}
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="examplePromoCode">Promo Code</label>
                                            <input type="text" class="form-control" name="promocode" value="{{$promo_code}}"
                                                id="examplePromoCode" placeholder="Promo Code">
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
                                        <div class="form-group col-md-4">
                                            <label for="examplePromoFromDate">From Date</label>
                                            <input type="date" class="form-control" name="promo_from_date" value=""
                                                id="examplePromoFromDate" placeholder="Enter Promotion From Date">
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
                                        <div class="form-group col-md-4">
                                            <label for="examplePromoToDate">To Date</label>
                                            <input type="date" class="form-control" name="promo_to_date" value=""
                                                id="examplePromoToDate" placeholder="Enter Promotion To Date">
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
                                        {{-- ----------------- --}}
                                        {{-- <div class="form-group col-md-3">
                                            <label for="examplePromoPriceType">Price Type</label>
                                            <select class="custom-select" name="pricetype" id="examplePromoPriceType">
                                                <option value="">Please Select Price Type</option>
                                                @foreach($price_type as $type)
                                                <option value="{{$type}}">{{ucfirst(trans($type))}}</option>
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
                                        </div> --}}
                                        {{-- ----------------- --}}
                                        {{-- correct code --}}
                                        {{-- <div class="form-group col-md-12">
                                            <label for="exampleOfferProduct">Offer Product</label>
                                            <select class="select2" name="offer_product" style="width: 100%;" multiple="multiple" 
                                            onchange="offer_product_add_remove()" id="exampleOfferProduct">
                                                <option value="novalue">Please Select Model No</option>
                                                @foreach ($model_no as $modelno)
                                                <option 
                                                    value="{{ $modelno->item }}">{{ $modelno->item }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('offer_product')
                                            <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                {{ $message }}
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            @enderror
                                        </div> --}}

                                        <div class="form-group col-md-12">
                                        <label for="exampleOfferProduct">Offer Product</label>   
                                        <select id="searchable-select" class="select2 exampleOfferProduct" name="offer_product[]" multiple="multiple" style="width: 100%;" onchange="offer_product_add_remove()"></select>
                                        @error('offer_product')
                                        <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                            {{ $message }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        @enderror
                                        </div>
                                       {{-- -------------------------------- --}}
                                        {{-- <div class="form-group col-md-3">
                                            <label for="examplePromoPrice">Price</label>
                                            <input type="text" class="form-control" name="promoprice" value=""
                                                id="examplePromoPrice" placeholder="Price">
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
                                        </div>  --}}
                                        {{-- -------------------------------- --}}
                                    </div>
                                    <div class="Offer form-row">
                                    </div>
                                    <h6 class="dacss">FOC Product(s)</h6>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="promofoc">FOC Model No</label>
                                            <select class="select2" multiple="multiple"
                                                data-placeholder="Select Foc Model No(s)" style="width: 100%;"
                                                name="promofoc[]" onchange="foc_offer_product_add_remove()" id="exampleFOC">
                                                <option value="nofoc">No Foc</option>
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
                                    <div class="Foc ">
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


{{-- <script src="{{ asset('admin_assets/plugins/select2/js/select2.full.min.js') }}"></script> --}}

 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>


    $(function () {
        $('#exampleFOC').select2();
    });

    //------------------------

    $(document).ready(function() {
            $('#searchable-select').select2({
                placeholder: 'Search for data',
                minimumInputLength: 3,
                ajax: {
                    url: '{{ route("search.data") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term // search term
                        };
                    },
                    processResults: function(data) {
                        console.log(data);
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.item,
                                    id: item.item
                                };
                            })
                        };
                    },
                    cache: true
                }
            });
        });
     //------------------------

//    let foc_loop_count = 0;
//    let foc_previousSelectedOptions = [];



    let loop_count = 0;
    let previousSelectedOptions = [];

    function offer_product_add_remove() {
    let selectedOptions = $('.exampleOfferProduct').val();
    
    let addedOptions = selectedOptions.filter(option => !previousSelectedOptions.includes(option));
    
    previousSelectedOptions = selectedOptions;
    
    addedOptions.forEach(option => {
        loop_count++;
        let html = `
             <div class="row" id="${option}">
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
                <select class="custom-select mySelect" name="pricetype[]" id="examplePromoPriceType${loop_count}" onchange="showSelectedValue('${loop_count}')">
                    <option value="">Please Select Price Type</option>
                    @foreach($price_type as $type)
                    <option value="{{$type}}">{{ucfirst(trans($type))}}</option>
                    @endforeach
                </select>
           </div>
            <div class="form-group col-md-2">
                <label for="exampleOfferQty${loop_count}">Offer Qty</label>
                <input type="text" class="form-control" name="offerqty[]" id="exampleOfferQty${loop_count}" placeholder="Offer Qty">
            </div>
            <div class="form-group col-md-2">
                <label for="examplePromoPrice${loop_count}">Price</label>
                <input type="text" class="form-control" name="promoprice[]" value="" id="examplePromoPrice${loop_count}" placeholder="Price">
            </div>   
            </div>
        `;
      
        if(option != 'novalue'){
            $('.Offer').append(html);
         }
    });

    jQuery(".exampleOfferProduct option").not(":selected").each(function(index, option) {
        var deselectedValue = jQuery(option).val();
        var divToRemove = document.getElementById(deselectedValue);

            if (divToRemove) {
                divToRemove.remove();
            }
    });

    }

    //------------------------------------------------

    // let previousSelectedOptions = [];
    // let loop_count = 0;

    // function offer_product_add_remove() {
        
    //     console.log('hello');
    //     let selectedOptions = $('#exampleOfferProduct').val();

    //     if (!selectedOptions) {
    //         console.error('selectedOptions is undefined or null');
    //         return;
    //     }

    //     let addedOptions = selectedOptions.filter(option => !previousSelectedOptions.includes(option));

    //     previousSelectedOptions = [...selectedOptions];

    //     addedOptions.forEach(option => {
    //         loop_count++;
    //         let html = `
    //             <div class="row" id="${option}">
    //             <div class="form-group col-md-2">
    //                 <label for="exampleMode${loop_count}">Selected Model Name</label>
    //                 <input type="text" class="form-control" name="model1[]" value="${option}" id="exampleMode${loop_count}" placeholder="${option}" readonly>
    //             </div>
    //             <div class="form-group col-md-4">
    //                 <label for="offerdescription${loop_count}">Offer Description</label>
    //                 <input type="text" class="form-control" name="offerdescription[]" id="offerdescription${loop_count}" placeholder="Offer Description" readonly>
    //             </div>
    //             <div class="form-group col-md-2">
    //                 <label for="examplePromoMrp${loop_count}">MRP</label>
    //                 <input type="text" class="form-control" name="promomrp[]" id="examplePromoMrp${loop_count}" placeholder="MRP" readonly>
    //             </div>
    //             <div class="form-group col-md-2">
    //                 <label for="examplePromoDlp${loop_count}">DLP</label>
    //                 <input type="text" class="form-control" name="promodlp[]" id="examplePromoDlp${loop_count}" placeholder="DLP" readonly>
    //             </div>
    //             <div class="form-group col-md-2">
    //                 <label for="examplePromoStock${loop_count}">Stock</label>
    //                 <input type="text" class="form-control" name="promostock[]" id="examplePromoStock${loop_count}" placeholder="Stock" readonly>
    //             </div>
    //             <div class="form-group col-md-2">
    //                 <label for="examplePromoPriceType${loop_count}">Price Type</label>
    //                 <select class="custom-select mySelect" name="pricetype[]" id="examplePromoPriceType${loop_count}" onchange="showSelectedValue('${loop_count}')">
    //                     <option value="">Please Select Price Type</option>
    //                     @foreach($price_type as $type)
    //                     <option value="{{$type}}">{{ucfirst(trans($type))}}</option>
    //                     @endforeach
    //                 </select>
    //         </div>
    //             <div class="form-group col-md-2">
    //                 <label for="exampleOfferQty${loop_count}">Offer Qty</label>
    //                 <input type="text" class="form-control" name="offerqty[]" id="exampleOfferQty${loop_count}" placeholder="Offer Qty">
    //             </div>
    //             <div class="form-group col-md-2">
    //                 <label for="examplePromoPrice${loop_count}">Price</label>
    //                 <input type="text" class="form-control" name="promoprice[]" value="" id="examplePromoPrice${loop_count}" placeholder="Price">
    //             </div>   
    //             </div>
    //         `;

    //         if (option !== 'novalue') {
    //             $('.Offer').append(html);
    //         }
    //     });
    // }







    //-----------------------------------------------


    function foc_offer_product_add_remove() {
        // Get selected values
        let selectedOptions = $('#exampleFOC').val();
        
        // Determine which option was added
        let addedOptions = selectedOptions.filter(option => !foc_previousSelectedOptions.includes(option));
        
        // Update previous selected options
        foc_previousSelectedOptions = selectedOptions;
        
        // Handle added options
        addedOptions.forEach(option => {
            foc_loop_count++;
            let html = `
                <div class="row" id="${option}">
                <div class="form-group col-md-2">
                  <label for="examplefocmodel${loop_count}">Model 1</label>
                  <input type="text" class="form-control" name="focmodel[]" value="${option}" id="examplefocmodel${loop_count}" placeholder="Model 1" readonly>
                </div>
                 <div class="form-group col-md-4">
                    <label for="examplefocdescription${loop_count}">Model Description</label>
                    <input type="text" class="form-control" name="focdescription[]" value="" id="examplefocdescription${loop_count}" placeholder="Model 1" readonly>
                </div>
               <div class="form-group col-md-2">
                <label for="examplefocPromoMrp${loop_count}">MRP</label>
                <input type="text" class="form-control" name="focpromomrp[]" id="examplefocPromoMrp${loop_count}" placeholder="MRP" readonly>
               </div>
               <div class="form-group col-md-2">
                <label for="examplefocPromoDlp${loop_count}">DLP</label>
                <input type="text" class="form-control" name="focpromodlp[]" id="examplefocPromoDlp${loop_count}" placeholder="DLP" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="examplefocstock${loop_count}">Model1 Stock</label>
                    <input type="text" class="form-control" name="focstock[]" value="" id="examplefocstock${loop_count}" placeholder="Model Stock1" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="examplefocqty${loop_count}">Model1 Qty</label>
                    <input type="text" class="form-control" name="focqty[]" value="" id="examplefocqty${loop_count}" placeholder="Model 1">
                </div>
               <div class="form-group col-md-2">
                <label for="examplefocSpecialPrice${loop_count}">Special Price</label>
                <input type="text" class="form-control" name="focspecialprice[]" value="" id="examplefocSpecialPrice${loop_count}" placeholder="Special Price">
               </div> 
                </div>
            `;

            if(option != 'nofoc'){
             $('.Foc').append(html);
            }
            
        });


        jQuery("#exampleFOC option").not(":selected").each(function(index, option) {
            var deselectedValue = jQuery(option).val();
            var divToRemove = document.getElementById(deselectedValue);

                if (divToRemove) {
                    divToRemove.remove();
                }
        });

        }

        function showSelectedValue(id) {
      
            var Id = document.getElementById('examplePromoPriceType'+id);
            var Value = jQuery(Id).val();
            if (Value != "special price") {
                document.getElementById('examplePromoPrice'+id).readOnly = true;
            }else{
                document.getElementById('examplePromoPrice'+id).readOnly = false; 
            }
        }


</script>
@endpush
@endsection