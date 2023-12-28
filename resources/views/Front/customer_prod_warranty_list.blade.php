@extends('Front/layout')
@section('page_title', 'Makita Customer | Customer Details')
@section('warranty_list', 'active')
@section('container')

    <!-- Container (Contact Section) -->
    <div id="contact" class="container">
        <div class="row">
            <x-reachus />
            <div class="col-md-8">
                @php
                    $arrayCount= $result->count();
                @endphp
                @if ($arrayCount>0)
               <p style="color:black;font-size:15px">Warranty List</p>
               <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Model</th>
                    <th>Serial No.</th>
                    <th>Period</th>
                    <th>Purchase Date</th>
                    <th>Warranty End</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($result as $list)
                    @php
                        $type = match($list->application_status){
                            'in-review'=>'In-Review',
                            'accepted'=>'Accepted',
                            'rejected'=>'Rejected',
                            default => 'Yet to Review',
                        };
                    @endphp
                    <tr>
                        <td>{{ $list->model->pluck('model_number')->implode('') }}</td>
                        <td>{{$list->machine_serial_number}}</td>
                        <td>{{ $list->model->pluck('warranty_period')->implode('') }} Months</td>
                        <td>{{ Carbon\Carbon::parse($list->date_of_purchase)->format('d M Y') }}</td>
                        <td>{{ Carbon\Carbon::parse($list->warranty_expiry_date)->format('d M Y') }}</td>
                        <td>{{$type}}</td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
              @elseif ($arrayCount==0)
              <p style="color:black;font-size:15px">No record found, Register a new warranty Now?</p>
              <a href="{{ url('warranty-scan-machine') }}">
                <button type="button" class="btn btn-success">Register Warranty</button>
              </a>
              @endif
            </div>
        </div>
        <br>
        <x-warrantypolicy />
    </div>
@endsection
