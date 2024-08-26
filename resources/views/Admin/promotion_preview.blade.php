{{-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Project Detail</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">

  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">

<div class="wrapper"> --}}

@extends('Admin/layout')
@section('page_title', 'Promotion Preview | MAKITA')
@section('promotion-preview-expandable','menu-open')
@section('promotion-preview-select','active')
@section('promotion_preview_select','active')
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
            <h1>Promotion Preview</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Promotion Preview</li>
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
          <h3 class="card-title">Promotion Preview</h3>

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
                      <span class="info-box-text text-center text-muted">Promo Code</span>
                      <span class="info-box-number text-center text-muted mb-0">{{$offerproduct[0]["promo_code"] ?? null}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-4">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">From Date</span>
                      <span class="info-box-number text-center text-muted mb-0">{{\Carbon\Carbon::parse($offerproduct[0]["from_date"] ?? null)->format('d-m-Y') }}</span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-4">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">To Date</span>
                      <span class="info-box-number text-center text-muted mb-0">{{\Carbon\Carbon::parse($offerproduct[0]["to_date"] ?? null)->format('d-m-Y') ?? null}}</span>
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
                        <label for="inputName">Model Description</label>
                        <input type="text" id="inputName" class="form-control" value="{{$offer->model_desc}}" readonly>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputName">MRP</label>
                        <input type="text" id="inputName" class="form-control" value="{{$offer->mrp}}" readonly>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputName">DLP</label>
                        <input type="text" id="inputName" class="form-control" value="{{$offer->dlp}}" readonly>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputName">Stock</label>
                        <input type="text" id="inputName" class="form-control" value="{{$offer->total_stock}}" readonly>
                      </div>

                      <div class="form-group col-md-6">
                        <label for="inputName">Price Type</label>
                        <input type="text" id="inputName" class="form-control" value="{{$offer->price_type}}" >
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputName">Offer Qty</label>
                        <input type="text" id="inputName" class="form-control" value="{{$offer->qty}}" >
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputName">Price</label>
                        <input type="text" id="inputName" class="form-control" value="{{$offer->price}}" >
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
                          <label for="inputName">FOC Model</label>
                          <input type="text" id="inputName" class="form-control" value="{{ $offer->model_no }}" readonly>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="inputName">FOC Description</label>
                          <input type="text" id="inputName" class="form-control" value="{{$offer->model_desc}}" readonly>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="inputName">MRP</label>
                          <input type="text" id="inputName" class="form-control" value="{{$offer->mrp}}" readonly>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="inputName">DLP</label>
                          <input type="text" id="inputName" class="form-control" value="{{$offer->dlp}}" readonly>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="inputName">Stock</label>
                          <input type="text" id="inputName" class="form-control" value="{{$offer->total_stock}}" readonly>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="inputName">FOC Qty</label>
                          <input type="text" id="inputName" class="form-control" value="{{$offer->qty}}" >
                        </div>
                        <div class="form-group col-md-6">
                          <label for="inputName">Special Price</label>
                          <input type="text" id="inputName" class="form-control" value="{{$offer->price}}" >
                        </div>
                      </div>
  
                      <hr>
                      @endforeach
                    </div>
                    <!-- /.card-body -->
                  </div>
              
                  {{-- ghjghj --}}
                </div>
              </div>
              {{-- General --}}
              <div class="row">
                <div class="col-12">
                  <h4>Sample Mail Format</h4>
                    <div class="post">
                      {{-- <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg" alt="user image">
                        <span class="username">
                          <a href="#">Jonathan Burke Jr.</a>
                        </span>
                        <span class="description">Shared publicly - 7:45 PM today</span>
                      </div> --}}
                      <p>
                       We would like to approve the following promotion.
                      </p>
                      <p>
                      Buy 3 No's of AZCZ2356 and 4 No's of RTY765 , Get 3 sets of RTY7657 and 7 sets of PGV7899 FREE
                       </p>
                       <p>
                        4900 Nos of AZCZ2356 available.
                       </p>
                       <p> Please Check below link to view Promotion Preview</p>

                      <p>
                        <a href="http://127.0.0.1:8080/admin/promotions/promotion-preview/{{Crypt::encrypt($offerproduct[0]["promo_code"] ?? null)}}" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Promotion Preview</a>
                      </p>
                      <p>PROMO NO - {{$offerproduct[0]->promo_code}}</p>

                          <!-- /.card -->
                  <div class="card card-info">
                    <div class="card-header">
                      <h3 class="card-title">Promotion</h3>
        
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body p-0">
                      <table class="table table-bordered">
                       
                        <thead>
                          <tr>
                            <th>Offer Model</th>
                            <th>MRP</th>
                            <th>DLP</th>
                            <th>BEST</th>
                            <th>SPECIAL</th>
                            <th>TOTAL STOCK</th>
                            <th>HO</th>
                            <th>DELHI</th>
                            <th>Gujarat</th>
                            <th>Kerala</th>
                            <th>Chennai</th>
                            <th>Kolkata</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($offerproduct as $offer)
                          <tr>
                            <td>{{$offer->model_no}}</td>
                            <td>{{$offer->mrp}}</td>
                            <td>{{$offer->dlp}}</td>
                            <td>{{$offer->best}}</td>
                            <td>{{$offer->price ?? '-'}}</td>
                            <td>{{$offer->total_stock}}</td>
                            <td>{{$offer->ka01 ?? '-'}}</td>
                            <td>{{$offer->dl01 ?? '-'}}</td>
                            <td>{{$offer->gj01 ?? '-'}}</td>
                            <td>{{$offer->kl01 ?? '-'}}</td>
                            <td>{{$offer->tn01 ?? '-'}}</td>
                            <td>{{$offer->mh01 ?? '-'}}</td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>

                    </div>
                    <div class="card-body p-0">
                      <table class="table table-bordered">
                       
                        <thead>
                          <tr>
                            <th>FOC Model</th>
                            <th>MRP</th>
                            <th>DLP</th>
                            <th>BEST</th>
                            <th>SPECIAL</th>
                            <th>TOTAL STOCK</th>
                            <th>HO</th>
                            <th>DELHI</th>
                            <th>Gujarat</th>
                            <th>Kerala</th>
                            <th>Chennai</th>
                            <th>Kolkata</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($focproduct as $offer)
                          <tr>
                            <td>{{$offer->model_no}}</td>
                            <td>{{$offer->mrp}}</td>
                            <td>{{$offer->dlp}}</td>
                            <td>{{$offer->best}}</td>
                            <td>{{$offer->price ?? '-'}}</td>
                            <td>{{$offer->total_stock}}</td>
                            <td>{{$offer->ka01 ?? '-'}}</td>
                            <td>{{$offer->dl01 ?? '-'}}</td>
                            <td>{{$offer->gj01 ?? '-'}}</td>
                            <td>{{$offer->kl01 ?? '-'}}</td>
                            <td>{{$offer->tn01 ?? '-'}}</td>
                            <td>{{$offer->mh01 ?? '-'}}</td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
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

  @endpush
@endsection

  {{-- <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

 
  <aside class="control-sidebar control-sidebar-dark">

  </aside>

</div>
<script src="../../plugins/jquery/jquery.min.js"></script>
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../dist/js/adminlte.min.js"></script>
<script src="../../dist/js/demo.js"></script>
</body>
</html> --}}
