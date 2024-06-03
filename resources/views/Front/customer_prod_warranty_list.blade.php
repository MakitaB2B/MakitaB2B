@extends('Front/layout')
@section('page_title', 'Makita Customer | Customer Details')
@section('warranty_list', 'active')
@section('container')

    <!-- The Team Modal -->
    <div class="modal" id="teamCreateModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Create Service Request</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <p>[Model:<span id="smn"></span>]&nbsp;&nbsp;[Sl. No. : <span id="ssn"></span>]</p>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form method="POST" action="{{ route('cx-tsr-registration') }}">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="exampleServiceRequest">Service Center*</label>
                                <select class="form-control" name="service_center"
                                    style="width: 100%;font-size: medium !important;" required>
                                    <option value="">Please Select FSC</option>
                                    @foreach ($fscList as $fsc)
                                        <option value="{{ $fsc->fsc_slug }}">{{ $fsc->center_name }}</option>
                                    @endforeach
                                </select>
                                @error('service_center')
                                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                        {{ $message }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleServiceRequest">Dealer/Customer Name*</label>
                                <input class="form-control" type="text" name="cx_name" value="{{ $customerName }}"
                                    required>
                                @error('name')
                                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                        {{ $message }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleServiceRequest">Contact Number*</label>
                                <input class="form-control" type="text" name="cx_number" value="{{ $customerPhone }}"
                                    required>
                                @error('name')
                                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                        {{ $message }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="exampleIssue">Issue*</label>
                                <textarea class="form-control" name="tools_issue" rows="5" placeholder="Enter tool issues that you are facing"
                                    required></textarea>
                                @error('name')
                                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                        {{ $message }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <!-- /.card-body -->
                        <input type="hidden" name="model_number" id="monu" required>
                        <input type="hidden" name="machine_sl_no" id="msn" required>
                        <input type="hidden" name="incoming_source"  value="{{ Crypt::encrypt('cx') }}" required>
                        <input type="hidden" name="srSlug" value={{ Crypt::encrypt(0) }} required>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    <!-- Container (Contact Section) -->
    <div id="contact" class="container">
        <div class="row">
            <x-reachus />
            <div class="col-md-8">
                @php
                    $arrayCount = $warrantyList->count();
                @endphp
                @if ($arrayCount > 0)
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
                                <th>Service</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($warrantyList as $list)
                                @php
                                    $type = match ($list->application_status) {
                                        'in-review' => 'In-Review',
                                        'accepted' => 'Accepted',
                                        'rejected' => 'Rejected',
                                        default => 'Yet to Review',
                                    };
                                @endphp
                                <tr>
                                    <td class="wmn">{{ $list->model->pluck('model_number')->implode('') }}</td>
                                    <td class="wmsn">{{ $list->machine_serial_number }}</td>
                                    <td>{{ $list->model->pluck('warranty_period')->implode('') }} Months</td>
                                    <td>{{ Carbon\Carbon::parse($list->date_of_purchase)->format('d M Y') }}</td>
                                    <td>{{ Carbon\Carbon::parse($list->warranty_expiry_date)->format('d M Y') }}</td>
                                    <td>{{ $type }}</td>
                                    <td title="Raise Service Request"><button type="button" class="btn btn-primary raiseSr"
                                            data-toggle="modal" data-target="#teamCreateModal">Raise SR</button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @elseif ($arrayCount == 0)
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
    @push('scripts')
        <!-- Page specific script -->
        <script>
            $(function() {
                $(".raiseSr").click(function() {
                    var modelNo = $.trim($(this).closest('tr').find('td.wmn').text());
                    var machineSlNo = $.trim($(this).closest('tr').find('td.wmsn').text());
                    $("#monu").val(modelNo);
                    $("#smn").text(modelNo);
                    $("#msn").val(machineSlNo);
                    $("#ssn").text(machineSlNo);
                });
            });
        </script>
    @endpush
@endsection
