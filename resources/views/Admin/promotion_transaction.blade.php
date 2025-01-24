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
        .alert{
            display : none;
            margin-left: 20px; 
            margin-right: 20px; 
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

        <div class="alert alert-danger alert-dismissible fade show " role="alert">
            <span class="transaction-error-message"> </span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
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

                          
                            <form method="POST" action="{{ route('admin.promotions.transaction-create') }}" enctype="multipart/form-data" id="transactionForm">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label for="examplePromoCode">Promo Code*</label>
                                            <select class="promotions select2" name="promo_code" id="examplePromoCode">
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
{{-- 
                                        <div class="form-group col-md-2">
                                            <label for="exampleRmname">Regional Manager Name*</label>
                                            <select class="custom-select select2" name="rm_name" required id="exampleRmname">
                                                @foreach ($regional_manager as $item)
                                                <option value="{{$item->full_name}}">{{$item->full_name}}</option>
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
                                        </div> --}}
                                        {{-- Auth::guard('admin')->user()->employee->full_name --}}
                                        <div class="form-group col-md-2">
                                            <label for="exampleRmname">Regional Manager Name*</label>
                                            <input type="text" class="form-control" name="rm_name"
                                                value="{{$regional_manager->employee->full_name}}" required id="exampleRmname"
                                                placeholder="Enter Model" >
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
                                            <label for="exampleRmname">Region*</label>
                                            <select class="custom-select select2" name="rm_region" id="exampleRmregion">
                                                @foreach ($transaction_email as $item)
                                                <option value="{{$item->region}}-{{$item['sales_name']['employee_slug']}}">{{$item->region}}-{{$item['sales_name']['full_name']}}</option>
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
                                            <select class="custom-select select2" name="dealer_code" id="exampleDealerCode" placeholder="Dealer Code">
                                                <option value=""  >Select Dealer Code</option>
                                                @foreach ($dealer_master as $item)
                                                <option value="{{$item->Customer}}-{{$item->Name}}">{{$item->Customer}}</option>
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
                                        <div class="form-group col-md-2">
                                            <label for="exampleDealerName">Dealer Name*</label>
                                            <input type="text" class="form-control" name="dealername"
                                                value="" required id="exampleDealerName"
                                                placeholder="Enter Model" disabled>
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
                                        <div class="form-group col-md-2">
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
                                            <input type="text" class="form-control stock" name="model_stock"
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
                                       
                                    
                                    </div>   
                                    <div class="foc_offer thick">
                                      
                                    
                                    </div>  
                                    
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary" id="submitbutton" >Submit</button>
                                </div>
                                {{-- <input type="hidden" value="" name="assetmaster_slug" required /> --}}
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
            $('#exampleDealerName').val(res[2]);
        });

        $('#examplePromoCode').on('change', function() {
            let loop_count = 0;
            $('.promo_offer').empty();
            $('.foc_offer').empty();
            $("#exampleTotalPrice").empty();
            $('#submitbutton').prop('disabled', true);
            let promoID = $(this).val();
        $.ajax({
            url: '/admin/promotions/promotion-fetch',
            type: 'get',
            data: 'promoID=' + promoID,
            success: function(result) {
            let  promohtml='<h6 class="dacss">Offer Product<h6>' ;let fochtml='<h6 class="dacss">FOC Product<h6>';
            let hr =`<hr>`;
            result.data.forEach(option => {
                loop_count++;
                let html = generateHtml(option, loop_count);
                    
                if (option.product_type !== 'FOC') {
                    promohtml+=html;
                } else {
                    fochtml+=html;
                }
            });
            promohtml+=hr;
            fochtml+=hr;
            $('.promo_offer').append( promohtml); 
            $('.foc_offer').append( fochtml);
            $('#submitbutton').prop('disabled', true);
            }

        });

        });

        function generateHtml(option, loop_count) {

            let html=`
                    <div class="row rowdata">
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
                            <label for="exampleLp${loop_count}">LP</label>
                            <input type="text" class="form-control" name="lp[]" value="${option.lp}" id="examplePromoLp${loop_count}" placeholder="LP" readonly>
                        </div>
                        <div class="form-group col-md-1">
                            <label for="exampleLp${loop_count}">BEST</label>
                            <input type="text" class="form-control" name="best[]" value="${option.best}" id="examplePromoBest${loop_count}" placeholder="LP" readonly>
                        </div>
                        <div class="form-group col-md-1">
                            <label for="examplePromoDlp${loop_count}">DLP</label>
                            <input type="text" class="form-control" name="promodlp[]" value="${option.dlp}" id="examplePromoDlp${loop_count}" placeholder="DLP" readonly>
                        </div>
                        <div class="form-group col-md-1">
                            <label for="examplePromoStock${loop_count}">Stock</label>
                            <input type="text" class="form-control stock" name="promostock[]" value="${option.stock}" id="examplePromoStock${loop_count}" placeholder="Stock" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleOfferType${loop_count}">Offer Type</label>
                            <input type="text" class="form-control" name="offertype[]" value="${option.offer_type}" id="exampleOfferType${loop_count}" placeholder="Offer Type" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleProductType${loop_count}">Product Type</label>
                            <input type="text" class="form-control" name="product_type[]" value="${option.product_type}" id="exampleProductType${loop_count}" placeholder="Product Type" readonly>
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
                            <input type="text" class="form-control" name="price[]" value="${option.price}" id="examplePrice${loop_count}" placeholder="Offer Price" readonly>
                        </div>
                     
                `;

                let offerhtml=  ` <div class="form-group col-md-2">
                            <label for="examplePromoQty${loop_count}">Qty</label>
                            <input type="text" class="form-control" name="qty[]" value="" id="exampleQty${loop_count}" placeholder="Qty">
                            <span id="exampleQtyStatus${loop_count}"></span>
                        </div>
                    </div>`;

                let fochtml=  ` <div class="form-group col-md-2">
                            <label for="examplePromoQty${loop_count}">Qty</label>
                            <input type="text" class="form-control" name="qty[]" value="" id="exampleQty${loop_count}" placeholder="Qty" disabled>
                            <span id="exampleQtyStatus${loop_count}"></span>
                        </div>
                    </div>`;

                    if(option.product_type=='FOC'||option.offer_type=="Combo Offer" && loop_count>1){
                    html+=fochtml;
                    }else{
                    html+=offerhtml;  
                    }

                return html;
            }

        function debounce(func, wait, immediate) {
            var timeout;
            return function() {
                var context = this, args = arguments;
                var later = function() {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                var callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(context, args);
            };
        };

        $(document).ready(function() {
            const validateUserQuantity = (qty, offerQty, stock, modelNo) => {
            const numQty = parseInt(qty || 0);
            if (!qty) return { isValid: false, error: 'Quantity is required' };
            if (numQty <= 0) return { isValid: false, error: 'Quantity must be greater than 0' };
            if (numQty % offerQty !== 0) return { isValid: false, error: `Quantity must be multiple of ${offerQty}` };
            if (numQty > stock) return { isValid: false, error: `Quantity ${numQty} exceeds stock (${stock}) for ${modelNo}` };
            return { isValid: true, error: '' };
        };

        const calculateQuantity = (sourceQty, sourceOfferQty, targetOfferQty) => 
            Math.floor(sourceQty / sourceOfferQty) * targetOfferQty || 0;

        const updateQuantities = (sourceRow, sourceQty) => {
            const sourceOfferQty = parseInt(sourceRow.find('[id^=exampleOfferQty]').val());
            const sourceOfferType = sourceRow.find('[name="offertype[]"]').val();
            const updateRow = (row, offerQty, stock, modelNo) => {
                const calculatedQty = calculateQuantity(sourceQty, sourceOfferQty, offerQty);
                const validation = validateUserQuantity(calculatedQty, offerQty, stock, modelNo);
                row.find('[id^=exampleQty]').val(calculatedQty);
                row.find('[id^=exampleQtyStatus]').text(validation.error).css('color', validation.error ? 'red' : '');
            };

            $('.promo_offer .rowdata, .foc_offer .rowdata').each(function () {
                const row = $(this);
                const offerQty = parseInt(row.find('[id^=exampleOfferQty]').val());
                const stock = parseInt(row.find('.stock').val());
                const modelNo = row.find('[id^=exampleModel]').val();

                if (row.closest('.promo_offer').length && row.index() !== sourceRow.index()) {
                    if (row.find('[name="offertype[]"]').val() === sourceOfferType) updateRow(row, offerQty, stock, modelNo);
                } else if (row.closest('.foc_offer').length) updateRow(row, offerQty, stock, modelNo);
            });
        };

        const validateForm = () => {
            let isValid = true, hasComboOffer = false, comboOfferValid = true;

            $('.promo_offer .rowdata').each(function () {
                const row = $(this);
                const qty = row.find('[id^=exampleQty]').val();
                const offerQty = parseInt(row.find('[id^=exampleOfferQty]').val());
                const stock = parseInt(row.find('.stock').val());
                const modelNo = row.find('[id^=exampleModel]').val();
                const offerType = row.find('[name="offertype[]"]').val();

                if (offerType === 'Combo Offer') {
                    hasComboOffer = true;
                    if (!qty || parseInt(qty) <= 0) comboOfferValid = false;
                }

                if (!validateUserQuantity(qty, offerQty, stock, modelNo).isValid) isValid = false;
            });

            $('.foc_offer .rowdata').each(function () {
                const row = $(this);
                const qty = row.find('[id^=exampleQty]').val();
                if (qty) {
                    const offerQty = parseInt(row.find('[id^=exampleOfferQty]').val());
                    const stock = parseInt(row.find('.stock').val());
                    const modelNo = row.find('[id^=exampleModel]').val();
                    if (!validateUserQuantity(qty, offerQty, stock, modelNo).isValid) isValid = false;
                }
            });

            $('#submitbutton').prop('disabled', !(isValid && (!hasComboOffer || comboOfferValid)));
            return isValid;
        };

        $(document).on('input', '.promo_offer [id^=exampleQty]', function () {
            const row = $(this).closest('.rowdata');
            const qty = $(this).val();
            const offerQty = parseInt(row.find('[id^=exampleOfferQty]').val());
            const stock = parseInt(row.find('.stock').val());
            const modelNo = row.find('[id^=exampleModel]').val();

            const validation = validateUserQuantity(qty, offerQty, stock, modelNo);
            row.find('[id^=exampleQtyStatus]').text(validation.error).css('color', validation.error ? 'red' : '');

            updateQuantities(row, parseInt(qty));
            validateForm();
        });

        const initialize = () => {
            $('.foc_offer [id^=exampleQty]').prop('disabled', true);
            $('#submitbutton').prop('disabled', true);
            $(document).on('keypress', '[id^=exampleQty]', e => (e.which >= 48 && e.which <= 57) || e.which === 8 || e.which === 0);
            validateForm();
        };

        initialize();
    });

        function displayModelData(modelDataJson,promocode) {

            $.ajax({
                url: '/admin/promotions/transaction-verify',
                type: 'get',
                data: { data: modelDataJson ,promocode:promocode},  
                success: function(data) {

                    $("#exampleTotalPrice").val(data.total_price);
    
                }
            });

        }

        $(document).on("click", "#submitbutton",function(e){
        e.preventDefault();
        let promoCode = $("#examplePromoCode").val();
        let rmCode = $("#exampleRmregion").val();
        let dealerCode = $("#exampleDealerCode").val();
        
        $(".error-message").remove();
        $("#examplePromoCode, #exampleRmregion,#exampleDealerCode").removeClass("is-invalid");
    
        let isValid = true;
    
        if (!promoCode || promoCode == 0 || !rmCode || rmCode.length === 0 || !dealerCode  || dealerCode == 0) {
            $("#examplePromoCode").addClass("is-invalid");
            $(".transaction-error-message").text('Please enter a promo code / region / dealer code');
            $(".alert").css("display", "block");
            isValid = false;
        }
        
        if (isValid) {
            $(this).closest("form").submit();
        }
        });

    </script>
    @endpush
@endsection
