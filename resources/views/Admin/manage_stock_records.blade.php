@extends('Admin/layout')
@section('page_title', 'Stock List | MAKITA')
@section('stock-expandable','menu-open')
@section('stock_select','active')
@section('branch_stock_select', 'active')
@section('container')
    <style>
        .mainstock {
            background: #249303;
        }

        .demoin {
            background: darkorange;
        }

        .demoout {
            background: orangered
        }

        .serviceroom {
            background: #009b9b;
        }

        .showroom {
            background: #8e2fa0;
        }

        .bstockheader {
            color: #fff;
            padding: 2px;
            border-radius: 1px;
        }

        .searchbox {
            border: none;
            outline: none;
            border-bottom: 1px solid #ccc;
            /* You can adjust the color and thickness of the outline */
        }

        .searchbox:focus,
        .searchbox:active {
            border-color: transparent;
            border-bottom: 1px solid #249303;
        }

        .searchicon {
            color: #009b9b;
            margin-left: -16px;
        }

        .searchicon:hover {
            color: #009b1a;
            cursor: pointer;
        }
    </style>
    <div class="content-wrapper">
        @push('styles')
            <!-- DataTables -->
            <link rel="stylesheet" href="{{ asset('admin_assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
            <link rel="stylesheet"
                href="{{ asset('admin_assets//plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
            <link rel="stylesheet" href="{{ asset('admin_assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
        @endpush
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-10">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Stocks</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if (session()->has('message'))
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">{{ session('message') }}</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                        class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="float-left">
                                    <h3 class="card-title"><strong>{{ $stockDetails[0]['item'] }}</strong>, <small>Total:
                                            {{ $stockDetails[0]['grandtotal'] }}</small></h3>
                                </div>
                                <div class="float-right">
                                    <input type="text" class="searchbox" placeholder="Search by Item" id="searchtxt">
                                    <i class="fas fa-search searchicon smi"></i>
                                    <br>
                                    <span id="searchresultmsg"></span>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="thdmain">
                                            <th class="mainstock bstockheader">Main Stock</th>
                                            <th class="demoin bstockheader">Demo In</th>
                                            <th class="demoout bstockheader">Demo Out</th>
                                            <th class="serviceroom bstockheader">Service Room</th>
                                            <th class="showroom bstockheader">Show Room</th>
                                        </tr>
                                    </thead>
                                    <tbody id="searchresult">
                                        <tr>
                                            @php
                                                if ($stockDetails[0]['cb01'] == '') {
                                                    $cbMainStock = 0;
                                                } elseif ($stockDetails[0]['cb01'] != '') {
                                                    $cbMainStock = $stockDetails[0]['cb01'];
                                                }
                                                if ($stockDetails[0]['cb02'] == '') {
                                                    $cbDemoINStock = 0;
                                                } elseif ($stockDetails[0]['cb02'] != '') {
                                                    $cbDemoINStock = $stockDetails[0]['cb02'];
                                                }
                                                if ($stockDetails[0]['cb05'] == '') {
                                                    $cbShowRoomStock = 0;
                                                } elseif ($stockDetails[0]['cb05'] != '') {
                                                    $cbShowRoomStock = $stockDetails[0]['cb05'];
                                                }
                                            @endphp
                                            <td>Coimbatore: {{ $cbMainStock }}</td>
                                            <td>Coimbatore: {{ $cbDemoINStock }}</td>
                                            <td>NA</td>
                                            <td>NA</td>
                                            <td>Coimbatore: {{ $cbShowRoomStock }}</td>
                                        </tr>
                                        <tr>
                                            @php
                                                if ($stockDetails[0]['dl01'] == '') {
                                                    $dlMainStock = 0;
                                                } elseif ($stockDetails[0]['dl01'] != '') {
                                                    $dlMainStock = $stockDetails[0]['dl01'];
                                                }
                                                if ($stockDetails[0]['dl02'] == '') {
                                                    $dlDemoInStock = 0;
                                                } elseif ($stockDetails[0]['dl02'] != '') {
                                                    $dlDemoInStock = $stockDetails[0]['dl02'];
                                                }
                                                if ($stockDetails[0]['dl03'] == '') {
                                                    $dlDemoOutStock = 0;
                                                } elseif ($stockDetails[0]['dl03'] != '') {
                                                    $dlDemoOutStock = $stockDetails[0]['dl03'];
                                                }
                                                if ($stockDetails[0]['dl04'] == '') {
                                                    $dlServiceRoomStock = 0;
                                                } elseif ($stockDetails[0]['dl04'] != '') {
                                                    $dlServiceRoomStock = $stockDetails[0]['dl04'];
                                                }
                                                if ($stockDetails[0]['dl04'] == '') {
                                                    $dlShowRoomStock = 0;
                                                } elseif ($stockDetails[0]['dl04'] != '') {
                                                    $dlShowRoomStock = $stockDetails[0]['dl04'];
                                                }
                                            @endphp
                                            <td>DELHI: {{ $dlMainStock }}</td>
                                            <td>DELHI: {{ $dlDemoInStock }}</td>
                                            <td>DELHI: {{ $dlDemoOutStock }}</td>
                                            <td>DELHI: {{ $dlServiceRoomStock }}</td>
                                            <td>DELHI: {{ $dlShowRoomStock }}</td>
                                        </tr>
                                        <tr>
                                            @php
                                                if ($stockDetails[0]['gh01'] == '') {
                                                    $dlMainStock = 0;
                                                } elseif ($stockDetails[0]['gh01'] != '') {
                                                    $dlMainStock = $stockDetails[0]['gh01'];
                                                }
                                            @endphp
                                            <td>Guwahati: {{ $dlMainStock }}</td>
                                            <td>NA</td>
                                            <td>NA</td>
                                            <td>NA</td>
                                            <td>NA</td>
                                        </tr>
                                        <tr>
                                            @php
                                                if ($stockDetails[0]['gj01'] == '') {
                                                    $gjMainStock = 0;
                                                } elseif ($stockDetails[0]['gj01'] != '') {
                                                    $gjMainStock = $stockDetails[0]['gj01'];
                                                }
                                                if ($stockDetails[0]['gj02'] == '') {
                                                    $gjDemoInStock = 0;
                                                } elseif ($stockDetails[0]['gj02'] != '') {
                                                    $gjDemoInStock = $stockDetails[0]['gj02'];
                                                }
                                                if ($stockDetails[0]['gj03'] == '') {
                                                    $gjDemoOutStock = 0;
                                                } elseif ($stockDetails[0]['gj03'] != '') {
                                                    $gjDemoOutStock = $stockDetails[0]['gj03'];
                                                }
                                                if ($stockDetails[0]['gj04'] == '') {
                                                    $gjServiceRoomStock = 0;
                                                } elseif ($stockDetails[0]['gj04'] != '') {
                                                    $gjServiceRoomStock = $stockDetails[0]['gj04'];
                                                }
                                                if ($stockDetails[0]['gj05'] == '') {
                                                    $gjShowRoomStock = 0;
                                                } elseif ($stockDetails[0]['gj05'] != '') {
                                                    $gjShowRoomStock = $stockDetails[0]['gj05'];
                                                }
                                            @endphp
                                            <td>Gujarat: {{ $gjMainStock }}</td>
                                            <td>Gujarat: {{ $gjDemoInStock }}</td>
                                            <td>Gujarat: {{ $gjDemoOutStock }}</td>
                                            <td>Gujarat: {{ $gjServiceRoomStock }}</td>
                                            <td>Gujarat: {{ $gjShowRoomStock }}</td>
                                        </tr>
                                        <tr>
                                            @php
                                                if ($stockDetails[0]['id01'] == '') {
                                                    $idMainStock = 0;
                                                } elseif ($stockDetails[0]['id01'] != '') {
                                                    $idMainStock = $stockDetails[0]['id01'];
                                                }
                                                if ($stockDetails[0]['id02'] == '') {
                                                    $idDemoInStock = 0;
                                                } elseif ($stockDetails[0]['id02'] != '') {
                                                    $idDemoInStock = $stockDetails[0]['id02'];
                                                }
                                                if ($stockDetails[0]['id04'] == '') {
                                                    $idServiceRoomStock = 0;
                                                } elseif ($stockDetails[0]['id04'] != '') {
                                                    $idServiceRoomStock = $stockDetails[0]['id04'];
                                                }
                                            @endphp
                                            <td>Indore: {{ $idMainStock }}</td>
                                            <td>Indore: {{ $idDemoInStock }}</td>
                                            <td>NA</td>
                                            <td>Indore: {{ $idServiceRoomStock }}</td>
                                            <td>NA</td>
                                        </tr>
                                        <tr>
                                            @php
                                                if ($stockDetails[0]['jm01'] == '') {
                                                    $jmMainStock = 0;
                                                } elseif ($stockDetails[0]['jm01'] != '') {
                                                    $jmMainStock = $stockDetails[0]['jm01'];
                                                }
                                                if ($stockDetails[0]['jm02'] == '') {
                                                    $jmDemoInStock = 0;
                                                } elseif ($stockDetails[0]['jm02'] != '') {
                                                    $jmDemoInStock = $stockDetails[0]['jm02'];
                                                }
                                                if ($stockDetails[0]['jm04'] == '') {
                                                    $jmServiceRoomStock = 0;
                                                } elseif ($stockDetails[0]['jm04'] != '') {
                                                    $jmServiceRoomStock = $stockDetails[0]['jm04'];
                                                }
                                            @endphp
                                            <td>Jamshedpur: {{ $jmMainStock }}</td>
                                            <td>Jamshedpur: {{ $jmDemoInStock }}</td>
                                            <td>NA</td>
                                            <td>Jamshedpur: {{ $jmServiceRoomStock }}</td>
                                            <td>NA</td>
                                        </tr>
                                        <tr>
                                            @php
                                                if ($stockDetails[0]['ka01'] == '') {
                                                    $kaMainStock = 0;
                                                } elseif ($stockDetails[0]['ka01'] != '') {
                                                    $kaMainStock = $stockDetails[0]['ka01'];
                                                }
                                                if ($stockDetails[0]['ka02'] == '') {
                                                    $kaDemoInStock = 0;
                                                } elseif ($stockDetails[0]['ka02'] != '') {
                                                    $kaDemoInStock = $stockDetails[0]['ka02'];
                                                }
                                                if ($stockDetails[0]['ka03'] == '') {
                                                    $kaDemoOutStock = 0;
                                                } elseif ($stockDetails[0]['ka03'] != '') {
                                                    $kaDemoOutStock = $stockDetails[0]['ka03'];
                                                }
                                                if ($stockDetails[0]['ka04'] == '') {
                                                    $kaServiceRoomStock = 0;
                                                } elseif ($stockDetails[0]['ka04'] != '') {
                                                    $kaServiceRoomStock = $stockDetails[0]['ka04'];
                                                }
                                                if ($stockDetails[0]['ka05'] == '') {
                                                    $kaShowRoomStock = 0;
                                                } elseif ($stockDetails[0]['ka05'] != '') {
                                                    $kaShowRoomStock = $stockDetails[0]['ka05'];
                                                }
                                            @endphp
                                            <td>Karnataka: {{ $kaMainStock }}</td>
                                            <td>Karnataka: {{ $kaDemoInStock }}</td>
                                            <td>Karnataka: {{ $kaDemoOutStock }}</td>
                                            <td>Karnataka: {{ $kaServiceRoomStock }}</td>
                                            <td>Karnataka: {{ $kaShowRoomStock }}</td>
                                        </tr>
                                        <tr>
                                            @php
                                                if ($stockDetails[0]['kl01'] == '') {
                                                    $klMainStock = 0;
                                                } elseif ($stockDetails[0]['kl01'] != '') {
                                                    $klMainStock = $stockDetails[0]['kl01'];
                                                }
                                                if ($stockDetails[0]['kl02'] == '') {
                                                    $klDemoInStock = 0;
                                                } elseif ($stockDetails[0]['kl02'] != '') {
                                                    $klDemoInStock = $stockDetails[0]['kl02'];
                                                }
                                                if ($stockDetails[0]['kl03'] == '') {
                                                    $klDemoOutStock = 0;
                                                } elseif ($stockDetails[0]['kl03'] != '') {
                                                    $klDemoOutStock = $stockDetails[0]['kl03'];
                                                }
                                                if ($stockDetails[0]['kl04'] == '') {
                                                    $klServiceRoomStock = 0;
                                                } elseif ($stockDetails[0]['kl04'] != '') {
                                                    $klServiceRoomStock = $stockDetails[0]['kl04'];
                                                }
                                                if ($stockDetails[0]['kl05'] == '') {
                                                    $klShowRoomStock = 0;
                                                } elseif ($stockDetails[0]['kl05'] != '') {
                                                    $klShowRoomStock = $stockDetails[0]['kl05'];
                                                }
                                            @endphp
                                            <td>Kerala: {{ $klMainStock }}</td>
                                            <td>Kerala: {{ $klDemoInStock }}</td>
                                            <td>Kerala: {{ $klDemoOutStock }}</td>
                                            <td>Kerala: {{ $klServiceRoomStock }}</td>
                                            <td>Kerala: {{ $klShowRoomStock }}</td>
                                        </tr>
                                        <tr>
                                            @php
                                                if ($stockDetails[0]['mh01'] == '') {
                                                    $mhMainStock = 0;
                                                } elseif ($stockDetails[0]['mh01'] != '') {
                                                    $mhMainStock = $stockDetails[0]['mh01'];
                                                }
                                                if ($stockDetails[0]['mh02'] == '') {
                                                    $mhDemoInStock = 0;
                                                } elseif ($stockDetails[0]['mh02'] != '') {
                                                    $mhDemoInStock = $stockDetails[0]['mh02'];
                                                }
                                                if ($stockDetails[0]['mh03'] == '') {
                                                    $mhDemoOutStock = 0;
                                                } elseif ($stockDetails[0]['mh03'] != '') {
                                                    $mhDemoOutStock = $stockDetails[0]['mh03'];
                                                }
                                                if ($stockDetails[0]['mh05'] == '') {
                                                    $mhShowRoomStock = 0;
                                                } elseif ($stockDetails[0]['mh05'] != '') {
                                                    $mhShowRoomStock = $stockDetails[0]['mh05'];
                                                }
                                            @endphp
                                            <td>Maharashtra: {{ $mhMainStock }}</td>
                                            <td>Maharashtra: {{ $mhDemoInStock }}</td>
                                            <td>Maharashtra: {{ $mhDemoOutStock }}</td>
                                            <td>NA</td>
                                            <td>Maharashtra: {{ $mhShowRoomStock }}</td>
                                        </tr>
                                        <tr>
                                            @php
                                                if ($stockDetails[0]['pn01'] == '') {
                                                    $pnMainStock = 0;
                                                } elseif ($stockDetails[0]['pn01'] != '') {
                                                    $pnMainStock = $stockDetails[0]['pn01'];
                                                }
                                                if ($stockDetails[0]['pn02'] == '') {
                                                    $pnDemoInStock = 0;
                                                } elseif ($stockDetails[0]['pn02'] != '') {
                                                    $pnDemoInStock = $stockDetails[0]['pn02'];
                                                }
                                                if ($stockDetails[0]['pn03'] == '') {
                                                    $pnDemoOutStock = 0;
                                                } elseif ($stockDetails[0]['pn03'] != '') {
                                                    $pnDemoOutStock = $stockDetails[0]['pn03'];
                                                }
                                                if ($stockDetails[0]['pn04'] == '') {
                                                    $pnServiceRoomStock = 0;
                                                } elseif ($stockDetails[0]['pn04'] != '') {
                                                    $pnServiceRoomStock = $stockDetails[0]['pn04'];
                                                }
                                            @endphp
                                            <td>Pune: {{ $pnMainStock }}</td>
                                            <td>Pune: {{ $pnDemoInStock }}</td>
                                            <td>Pune: {{ $pnDemoOutStock }}</td>
                                            <td>Pune: {{ $pnServiceRoomStock }}</td>
                                            <td>NA</td>
                                        </tr>
                                        <tr>
                                            @php
                                                if ($stockDetails[0]['py01'] == '') {
                                                    $pyMainStock = 0;
                                                } elseif ($stockDetails[0]['py01'] != '') {
                                                    $pyMainStock = $stockDetails[0]['py01'];
                                                }
                                                if ($stockDetails[0]['py02'] == '') {
                                                    $pyDemoInStock = 0;
                                                } elseif ($stockDetails[0]['py02'] != '') {
                                                    $pyDemoInStock = $stockDetails[0]['py02'];
                                                }
                                                if ($stockDetails[0]['py03'] == '') {
                                                    $pyDemoOutStock = 0;
                                                } elseif ($stockDetails[0]['py03'] != '') {
                                                    $pyDemoOutStock = $stockDetails[0]['py03'];
                                                }
                                                if ($stockDetails[0]['py04'] == '') {
                                                    $pyServiceRoomStock = 0;
                                                } elseif ($stockDetails[0]['py04'] != '') {
                                                    $pyServiceRoomStock = $stockDetails[0]['py04'];
                                                }
                                            @endphp
                                            <td>Peenya: {{ $pyMainStock }}</td>
                                            <td>Peenya: {{ $pyDemoInStock }}</td>
                                            <td>Peenya: {{ $pyDemoOutStock }}</td>
                                            <td>Peenya: {{ $pyServiceRoomStock }}</td>
                                            <td>NA</td>
                                        </tr>
                                        <tr>
                                            @php
                                                if ($stockDetails[0]['rd01'] == '') {
                                                    $rdMainStock = 0;
                                                } elseif ($stockDetails[0]['rd01'] != '') {
                                                    $rdMainStock = $stockDetails[0]['rd01'];
                                                }
                                                if ($stockDetails[0]['rd02'] == '') {
                                                    $rdDemoInStock = 0;
                                                } elseif ($stockDetails[0]['rd02'] != '') {
                                                    $rdDemoInStock = $stockDetails[0]['rd02'];
                                                }
                                                if ($stockDetails[0]['rd04'] == '') {
                                                    $rdServiceRoomStock = 0;
                                                } elseif ($stockDetails[0]['rd04'] != '') {
                                                    $rdServiceRoomStock = $stockDetails[0]['rd04'];
                                                }
                                            @endphp
                                            <td>Rudrapur: {{ $rdMainStock }}</td>
                                            <td>Rudrapur: {{ $rdDemoInStock }}</td>
                                            <td>NA</td>
                                            <td>Rudrapur: {{ $rdServiceRoomStock }}</td>
                                            <td>NA</td>
                                        </tr>
                                        <tr>
                                            @php
                                                if ($stockDetails[0]['tn01'] == '') {
                                                    $tnMainStock = 0;
                                                } elseif ($stockDetails[0]['tn01'] != '') {
                                                    $tnMainStock = $stockDetails[0]['tn01'];
                                                }
                                                if ($stockDetails[0]['tn02'] == '') {
                                                    $tnDemoInStock = 0;
                                                } elseif ($stockDetails[0]['tn02'] != '') {
                                                    $tnDemoInStock = $stockDetails[0]['tn02'];
                                                }
                                                if ($stockDetails[0]['tn03'] == '') {
                                                    $tnDemoOutStock = 0;
                                                } elseif ($stockDetails[0]['tn03'] != '') {
                                                    $tnDemoOutStock = $stockDetails[0]['tn03'];
                                                }
                                                if ($stockDetails[0]['tn04'] == '') {
                                                    $tnServiceRoomStock = 0;
                                                } elseif ($stockDetails[0]['tn04'] != '') {
                                                    $tnServiceRoomStock = $stockDetails[0]['tn04'];
                                                }
                                                if ($stockDetails[0]['tn05'] == '') {
                                                    $tnShowRoomStock = 0;
                                                } elseif ($stockDetails[0]['tn05'] != '') {
                                                    $tnShowRoomStock = $stockDetails[0]['tn05'];
                                                }
                                            @endphp
                                            <td>Chennai: {{ $tnMainStock }}</td>
                                            <td>Chennai: {{ $tnDemoInStock }}</td>
                                            <td>Chennai: {{ $tnDemoOutStock }}</td>
                                            <td>Chennai: {{ $tnServiceRoomStock }}</td>
                                            <td>Chennai: {{ $tnShowRoomStock }}</td>
                                        </tr>
                                        <tr>
                                            @php
                                                if ($stockDetails[0]['vd01'] == '') {
                                                    $vdMainStock = 0;
                                                } elseif ($stockDetails[0]['vd01'] != '') {
                                                    $vdMainStock = $stockDetails[0]['vd01'];
                                                }
                                                if ($stockDetails[0]['vd04'] == '') {
                                                    $vdServiceRoomStock = 0;
                                                } elseif ($stockDetails[0]['vd04'] != '') {
                                                    $vdServiceRoomStock = $stockDetails[0]['vd04'];
                                                }
                                            @endphp
                                            <td>Vadora: {{ $vdMainStock }}</td>
                                            <td>NA</td>
                                            <td>NA</td>
                                            <td>Vadora: {{ $vdServiceRoomStock }}</td>
                                            <td>NA</td>
                                        </tr>
                                        <tr>
                                            @php
                                                if ($stockDetails[0]['wb01'] == '') {
                                                    $wbMainStock = 0;
                                                } elseif ($stockDetails[0]['wb01'] != '') {
                                                    $wbMainStock = $stockDetails[0]['wb01'];
                                                }
                                                if ($stockDetails[0]['wb02'] == '') {
                                                    $wbDemoInStock = 0;
                                                } elseif ($stockDetails[0]['wb02'] != '') {
                                                    $wbDemoInStock = $stockDetails[0]['wb02'];
                                                }
                                                if ($stockDetails[0]['wb03'] == '') {
                                                    $wbDemoOutStock = 0;
                                                } elseif ($stockDetails[0]['wb03'] != '') {
                                                    $wbDemoOutStock = $stockDetails[0]['wb03'];
                                                }
                                                if ($stockDetails[0]['wb04'] == '') {
                                                    $wbServiceRoomStock = 0;
                                                } elseif ($stockDetails[0]['wb04'] != '') {
                                                    $wbServiceRoomStock = $stockDetails[0]['wb04'];
                                                }
                                                if ($stockDetails[0]['wb05'] == '') {
                                                    $wbShowRoomStock = 0;
                                                } elseif ($stockDetails[0]['wb05'] != '') {
                                                    $wbShowRoomStock = $stockDetails[0]['wb05'];
                                                }
                                            @endphp
                                            <td>kolkata: {{ $wbMainStock }}</td>
                                            <td>kolkata: {{ $wbDemoInStock }}</td>
                                            <td>kolkata: {{ $wbDemoOutStock }}</td>
                                            <td>kolkata: {{ $wbServiceRoomStock }}</td>
                                            <td>kolkata: {{ $wbShowRoomStock }}</td>
                                        </tr>


                                    </tbody>
                                    <tfoot>
                                        <tr class="thdmain">
                                            <th class="mainstock bstockheader">Main Stock</th>
                                            <th class="demoin bstockheader">Demo In</th>
                                            <th class="demoout bstockheader">Demo Out</th>
                                            <th class="serviceroom bstockheader">Service Room</th>
                                            <th class="showroom bstockheader">Show Room</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    @push('scripts')
        <!-- DataTables  & Plugins -->
        <script src="{{ asset('admin_assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('admin_assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('admin_assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('admin_assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('admin_assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('admin_assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('admin_assets/plugins/jszip/jszip.min.js') }}"></script>
        <script src="{{ asset('admin_assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
        <script src="{{ asset('admin_assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
        <script src="{{ asset('admin_assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('admin_assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('admin_assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

        <!-- Page specific script -->
        <script>
            $('.smi').on('click', function() {
                let searchtxt = $.trim($("#searchtxt").val());
                let searchFrom = "mngStockRecord";
                if (searchtxt != '' && searchtxt.length > 3) {
                    $("#searchresultmsg").text('Please Wait while processing....').css({
                        "color": "green",
                        "font-weight": "600",
                        "font-size": "11px"
                    });
                    $.ajax({
                        url: '/admin/stock-search',
                        type: 'post',
                        data: 'searchtxt=' + searchtxt + '&searchFrom=' + searchFrom +
                            '&_token={{ csrf_token() }}',
                        success: function(result) {
                            $('#searchresult').html(result);
                            $('.thdmain').hide();
                            $("#searchresultmsg").text('');
                        }
                    });
                }
                if (searchtxt.length < 3) {
                    $("#searchresultmsg").text('Should input more than 3 character').css({
                        "color": "red",
                        "font-weight": "600",
                        "font-size": "10px"
                    });
                }
            });


            let stockLastString;
            $('td').on('click', function() {
                stockLastString = $(this).text();
            });
            $("td[contenteditable=true]").blur(function() {
                var stockValue = $(this).text();
                var fbsSlugStr = $(this).closest('tr').find('td.getSlug').text();
                let fbsSlugSplit = fbsSlugStr.split('-');
                let fbsSlug = $.trim(fbsSlugSplit[0]);

                var splitStockUpdatedStr = stockValue.split(":");
                var stockUpdatedVal = $.trim(splitStockUpdatedStr[1]);

                var splitStockLastString = stockLastString.split(":");
                var stockLastVal = $.trim(splitStockLastString[1]);

                if (stockUpdatedVal != stockLastVal) {
                    $.post('/admin/update-stock', 'stockValue=' + stockValue + '&fbsSlug=' + fbsSlug +
                        '&_token={{ csrf_token() }}',
                        function(data) {
                            if (data != '') {
                                // message_status.show();
                                // message_status.text(data);
                                // //hide the message
                                // setTimeout(function() {
                                //     message_status.hide()
                                // }, 1000);
                                console.log(data);
                            }
                        });
                }
            });

            $(function() {
                $("#example1").DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                $('#example2').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                });
            });
        </script>
    @endpush
@endsection
