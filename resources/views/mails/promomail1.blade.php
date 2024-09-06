<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Promotion Mail</title>
</head>
<body>

            <p> We would like to approve the following promotion. </p>
              {{-- <p>
                {{$textfromatmodelqty}}
               </p> --}}
               {{-- <p>
              {{$offerproduct[0]["stock"]}} No's of {{$offerproduct[0]["model_no"]}} available.
               </p> --}}
               <p> Please Check below link to view Promotion Preview</p>
{{-- 
              <p>
                <a href="http://127.0.0.1:8080/admin/promotions/promotion-preview/{{Crypt::encrypt($offerproduct[0]["promo_code"] ?? null)}}" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Promotion Preview</a>
              </p>
              <p>PROMO NO - {{$offerproduct[0]->promo_code}}</p> --}}

                  <!-- /.card -->
          {{-- <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Promotion</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0"> --}}
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
                  {{-- @foreach($offerproduct as $offer) --}}
                  <tr>
                    {{-- <td>{{$offer->model_no}}</td>
                    <td>{{$offer->mrp}}</td>
                    <td>{{$offer->dlp}}</td>
                    <td>{{$offer->best}}</td>
                    <td>{{$offer->price ?? '-'}}</td> 
                    <td>{{$offer->stock}}</td>
                    <td>{{$offer->ka01 ?? '-'}}</td>
                    <td>{{$offer->dl01 ?? '-'}}</td>
                    <td>{{$offer->gj01 ?? '-'}}</td>
                    <td>{{$offer->kl01 ?? '-'}}</td>
                    <td>{{$offer->tn01 ?? '-'}}</td>
                    <td>{{$offer->wb01 ?? '-'}}</td> --}}
                  </tr>
                  {{-- @endforeach --}}
                </tbody>
              </table>

            {{-- </div>
            <div class="card-body p-0"> --}}
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
                  {{-- @foreach($focproduct as $offer) --}}
                  <tr>
                    {{-- <td>{{$offer->model_no}}</td>
                    <td>{{$offer->mrp}}</td>
                    <td>{{$offer->dlp}}</td>
                    <td>{{$offer->best}}</td>
                    <td>{{$offer->price ?? '-'}}</td>
                    <td>{{$offer->stock}}</td>
                    <td>{{$offer->ka01 ?? '-'}}</td>
                    <td>{{$offer->dl01 ?? '-'}}</td>
                    <td>{{$offer->gj01 ?? '-'}}</td>
                    <td>{{$offer->kl01 ?? '-'}}</td>
                    <td>{{$offer->tn01 ?? '-'}}</td>
                    <td>{{$offer->wb01 ?? '-'}}</td> --}}
                  </tr>
                  {{-- @endforeach --}}
                </tbody>
              </table>
            {{-- </div> --}}
         
          {{-- </div> --}}
         

            {{-- </div>
        </div>
      </div> --}}
    
</body>
</html>