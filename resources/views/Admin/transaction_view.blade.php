@extends('Admin/layout')
@section('page_title', 'Transaction Preview | MAKITA')
@section('transaction-preview-expandable','menu-open')
@section('transaction-preview-select','active')
@section('transaction_preview_select','active')
@section('container')

 <style>
    hr {
  border: none;
  border-top: 2px solid #D3D3D3; /* Change the thickness by adjusting the pixel value */
      }
 </style>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Transaction Preview</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Transaction Preview</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Transaction Preview</h3>

          <div class="card-tools">
            {{-- <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button> --}}
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-md-12 order-2 order-md-1">
                {{-- col-lg-8 --}}
              <div class="row">
                <div class="col-12 col-sm-4">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Transaction Id</span>
                      <span class="info-box-number text-center text-muted mb-0">{{$offerproduct[0]["order_id"] ?? null}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-4">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Promo Code</span>
                      <span class="info-box-number text-center text-muted mb-0" >{{$offerproduct[0]["promo_code"] ?? null }}</span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-4">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Order Date</span>
                      <span class="info-box-number text-center text-muted mb-0">{{\Carbon\Carbon::parse($offerproduct[0]["order_date"] ?? null)->format('d-m-Y') ?? null}}</span>
                    </div>
                  </div>
                </div>
              </div>
    {{-- General --}}
              <div class="row">
                <div class="col-md-6">
                  <div class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">Offer Product</h3>
        
                     <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                    @foreach($offerproduct as $offer)
                    <div class="row">
                      <div class="form-group col-md-6">
                        <label for="inputName">Offer Model</label>
                        <input type="text" id="inputName" class="form-control" value="{{ $offer->model_no }}" readonly>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputName">RM Name</label>
                        <input type="text" id="inputName" class="form-control" value="{{ $offer->rm_name }}" readonly>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputName">Dealer Code</label>
                        <input type="text" id="inputName" class="form-control" value="{{ $offer->dealer_code }}" readonly>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputName">Dealer Name</label>
                        <input type="text" id="inputName" class="form-control" value="{{ $offer->dealer_name }}" readonly>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputName">Product Type</label>
                        <input type="text" id="inputName" class="form-control" value="{{$offer->product_type}}" readonly>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputName">Offer Type</label>
                        <input type="text" id="inputName" class="form-control" value="{{$offer->offer_type}}" >
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputName">Price Type</label>
                        <input type="text" id="inputName" class="form-control" value="{{$offer->price_type}}" >
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputName">Order Qty</label>
                        <input type="text" id="inputName" class="form-control" value="{{$offer->order_qty}}" >
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputName">Offer Price</label>
                        <input type="text" id="inputName" class="form-control" value="{{$offer->offer_price}}" >
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputName">Order Price</label>
                        <input type="text" id="inputName" class="form-control" style="border: 4px solid #FF4D00;" value="{{$offer->order_price}}" >
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputName">Billed Qty</label>
                        <input type="text" id="inputName" class="form-control" value="{{$offer->billed_qty}}" >
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputName">Status</label>
                        <input type="text" id="inputName" class="form-control" value="{{$offer->status}}" >
                      </div>
                    </div>

                    <hr>
                    @endforeach
    
                    </div>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card -->
                </div>
                <div class="col-md-6">
                  <div class="card card-secondary">
                    <div class="card-header">
                      <h3 class="card-title">FOC</h3>
        
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      @foreach($focproduct as $offer)
                     <div class="row">
                      <div class="form-group col-md-6">
                        <label for="inputName">Offer Model</label>
                        <input type="text" id="inputName" class="form-control" value="{{ $offer->model_no }}" readonly>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputName">RM Name</label>
                        <input type="text" id="inputName" class="form-control" value="{{ $offer->rm_name }}" readonly>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputName">Dealer Code</label>
                        <input type="text" id="inputName" class="form-control" value="{{ $offer->dealer_code }}" readonly>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputName">Dealer Name</label>
                        <input type="text" id="inputName" class="form-control" value="{{ $offer->dealer_name }}" readonly>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputName">Product Type</label>
                        <input type="text" id="inputName" class="form-control" value="{{$offer->product_type}}" readonly>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputName">Offer Type</label>
                        <input type="text" id="inputName" class="form-control" value="{{$offer->offer_type}}" >
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputName">Price Type</label>
                        <input type="text" id="inputName" class="form-control" value="{{$offer->price_type}}" >
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputName">Order Qty</label>
                        <input type="text" id="inputName" class="form-control" value="{{$offer->order_qty}}" >
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputName">Offer Price</label>
                        <input type="text" id="inputName" class="form-control" value="{{$offer->offer_price}}" >
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputName">Order Price</label>
                        <input type="text" id="inputName" class="form-control" style="border: 4px solid #FF4D00;" value="{{$offer->order_price}}" >
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputName">Billed Qty</label>
                        <input type="text" id="inputName" class="form-control" value="{{$offer->billed_qty}}" >
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputName">Status</label>
                        <input type="text" id="inputName" class="form-control" value="{{$offer->status}}" >
                      </div>
                      </div>
  
                      <hr>
                      @endforeach
                    </div>
                    <!-- /.card-body -->
                  </div>
  
                </div>
              </div>
              {{-- General --}}
              <div class="row">
                <div class="col-12">
                  <h4>Change Order status</h4>
                <div class="post">
                  <div class="card-footer">
                    <div class="row">
                      <div class="form-group col-md-4">
                          <label for="exampleStatus">Order Status</label>
                          <select class="custom-select mySelect" name="status" id="exampleStatus">
                              @foreach($status as $type)
                                  <option value="{{$offerproduct[0]["order_id"]}}-{{$type}}">{{$type}}</option>
                              @endforeach
                          </select>
                          <span id="exampleTransactionStatus"></span>
                      </div>
                  
                      <div class="form-group col-md-4 d-flex align-items-end">
                          <button type="submit" class="btn btn-primary" id="changeStatusButton">Change Status</button>
                          <span id="changeStatusButtonText"></span>
                      </div>
                  
                      <div class="form-group col-md-4 d-flex align-items-end">
                          <button type="submit" class="btn btn-primary btn-lg float-right" id="sendMailButton" data-order-id="{{Crypt::encrypt($offerproduct[0]["order_id"] ?? null)}}">Send Mail</button>
                          <span id="sendMailButtonText"></span>
                      </div>

                      <input type="hidden" name="model_number" id="dealer_code"  value="{{$offerproduct[0]["dealer_code"]}}" required>
                      <input type="hidden" name="model_number" id="promo_code"  value="{{$offerproduct[0]["promo_code"]}}" required>
                  </div>
                  
                  </div>
                  <!-- /.card -->

                  </div>
                </div>
              </div>


            </div>
          </div>
        </div>
   
      </div>
  

    </section>

  </div>
  @push('scripts')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
      $(document).ready(function() {

          $('#changeStatusButton').on('click', function() {
            $("#exampleTransactionStatus").empty();
              var status = $('#exampleStatus').val();
              var dealer_code = $('#dealer_code').val();
              var promo_code = $('#promo_code').val();
              
              $.ajax({
                  url: '{{ route("transaction.change-status") }}', 
                  type: 'POST',
                  data: {
                      status: status,
                      _token: '{{ csrf_token() }}',
                      dealer_code: dealer_code,
                      promo_code: promo_code
                  },
                  success: function(response) {

                    $("#exampleTransactionStatus").html('<b style="color:green;">Status changed for order id:'+ response.data[0].order_id+ ', status:'+ response.data[0].status +'</b>');
  
                  },
                  error: function(xhr, status, error) {
      
                  }
              });
          });

          $('#sendMailButton').on('click', function() {
            $("#sendMailButtonText").empty();
            var currentDomain = window.location.origin;
            var orderid = $(this).data('order-id');  // Get the encrypted promo code from the data attribute
              $.ajax({
                  url: currentDomain+'/admin/promotions/transactionmail/' + orderid, 
                  type: 'GET',
                  // data: {
                  //     status: status,
                  //     _token: '{{ csrf_token() }}'
                  // },
                  success: function(response) {

                    $("#sendMailButtonText").html('<b style="color:green;">'+ response.message +'</b>');
  
                  },
                  error: function(xhr, status, error) {
      
                  }
              });
          });


      });
  </script>
  
  @endpush
@endsection

