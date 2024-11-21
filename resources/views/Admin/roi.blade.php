@extends('Admin/layout')
@section('page_title', 'ROI List | MAKITA')
@section('tools_roi', 'active')
@section('container')
    <div class="content-wrapper">
        @push('styles')
            <!-- DataTables -->
            <link rel="stylesheet" href="{{ asset('admin_assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
            <link rel="stylesheet"
                href="{{ asset('admin_assets//plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
            <link rel="stylesheet" href="{{ asset('admin_assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <style>
                .margin5px {
                    margin-left: 5px !important;
                }

                .minbtn {
                    background-color: #008290 !important;
                    border-color: #00e6ff !important;
                    cursor: unset !important;
                }

                .minbgcolor {
                    background-color: #008290 !important;
                }

                .minbordertop {
                    border-top: 3px solid #008290 !important;
                }

                .txtcolor {
                    color: #008290 !important;
                }

                .comptitle {
                    color: #008290 !important;
                    font-size: 20px !important;
                    font-weight: 900;
                    margin-right: 15px;
                }

                .compsubtitle {
                    color: #044c54 !important;
                    font-size: 15px !important;
                }

                .atagprice {
                    color: #008290 !important;
                    font-weight: 600 !important;
                }

                .nav-pills .nav-link.active,
                .nav-pills .show>.nav-link {
                    color: #fff !important;
                    background-color: #008290;
                }

                .cmptblhdr {
                    background-color: #008290 !important;
                    color: #fff !important;
                }

                .beptblhighlight {
                    background-color: #008290;
                    font-size: 17px;
                    color: white !important;
                }

                .beptbltitle {
                    color: #000;
                    font-weight: 600;
                }

                .table td,
                .table th {
                    border-top: 1px solid #b3babb;
                    color: black;
                }

                .roiresult {
                    display: inline-block;
                    margin: 5px;
                }

                .roiresult-container {
                    display: flex;
                    justify-content: space-between;
                }
            </style>
        @endpush


        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Out Door Power Equipment(OPE)</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">ROI</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="activity">
                                        <!-- Post -->
                                        <div class="post clearfix">
                                            <div class="roiresult-container">
                                                <span class="roiresult margin5px">
                                                    <p class="comptitle">Money Back In:
                                                        {{ round($achiveIn, 1) }} Month(s)</p>
                                                </span>
                                                <span class="roiresult margin5px">
                                                    <p class="comptitle">Saved Amount (1 year):
                                                        INR
                                                        {{ number_format($compeProdOneYearTotalCost - $makitaprodyeartotalcost) }}
                                                    </p>
                                                </span>
                                            </div>
                                            <!-- /.user-block -->
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="card card-widget widget-user">
                                                        <!-- Add the bg color to the header using any of the bg-* classes -->
                                                        <div class="widget-user-header bg-success minbgcolor">
                                                            <h3 class="widget-user-username">Cordless OPE Tools</h3>
                                                            <h5 class="widget-user-desc">Total Cost
                                                                &#8377;{{ number_format($makitaprodyeartotalcost) }}</h5>
                                                        </div>
                                                        <div class="widget-user-image">
                                                            <img class="img-circle elevation-2"
                                                                src="{{ asset('admin_assets/img/roi/battery.jfif') }}"
                                                                alt="">
                                                        </div>
                                                        <div class="card-footer">
                                                            <div class="row">
                                                                <div class="col-sm-4 border-right">
                                                                    <div class="description-block">
                                                                        <h5 class="description-header">
                                                                            &#8377;{{ number_format($makitaProdCost) }}
                                                                        </h5>
                                                                        <span class="description-text">Tool Cost</span>
                                                                    </div>
                                                                    <!-- /.description-block -->
                                                                </div>
                                                                <!-- /.col -->
                                                                <div class="col-sm-4 border-right">
                                                                    <div class="description-block">
                                                                        <h5 class="description-header">
                                                                            &#8377;{{ number_format($mPOneYearBattaryConsumCost) }}
                                                                        </h5>
                                                                        <span class="description-text">Battery Usage</span>
                                                                    </div>
                                                                    <!-- /.description-block -->
                                                                </div>
                                                                <!-- /.col -->
                                                                <div class="col-sm-4">
                                                                    <div class="description-block">
                                                                        <h5 class="description-header">
                                                                            &#8377;{{ number_format($makitaProdGenaralExpensesInAYear) }}
                                                                        </h5>
                                                                        <span class="description-text">General
                                                                            Expenses</span>
                                                                    </div>
                                                                    <!-- /.description-block -->
                                                                </div>
                                                                <!-- /.col -->
                                                            </div>
                                                            <!-- /.row -->
                                                        </div>
                                                    </div>
                                                    <!-- /.card -->
                                                </div>
                                                <div class="col-6">
                                                    <div class="card card-widget widget-user">
                                                        <!-- Add the bg color to the header using any of the bg-* classes -->
                                                        <div class="widget-user-header bg-danger">
                                                            <h3 class="widget-user-username">Engine OPE Tools</h3>
                                                            <h5 class="widget-user-desc">Total Cost
                                                                &#8377;{{ number_format($compeProdOneYearTotalCost) }}</h5>
                                                        </div>
                                                        <div class="widget-user-image">
                                                            <img class="img-circle elevation-2"
                                                                src="{{ asset('admin_assets/img/roi/engine.jfif') }}"
                                                                alt="">
                                                        </div>
                                                        <div class="card-footer">
                                                            <div class="row">
                                                                <div class="col-sm-4 border-right">
                                                                    <div class="description-block">
                                                                        <h5 class="description-header">&#8377;
                                                                            {{ number_format($compeProductCost) }}
                                                                        </h5>
                                                                        <span class="description-text">Tool Cost</span>
                                                                    </div>
                                                                    <!-- /.description-block -->
                                                                </div>
                                                                <!-- /.col -->
                                                                <div class="col-sm-4 border-right">
                                                                    <div class="description-block">
                                                                        <h5 class="description-header">
                                                                            &#8377;{{ number_format($competitorProdYearFuelConsumption) }}
                                                                        </h5>
                                                                        <span class="description-text">Fuel
                                                                            Consumption</span>
                                                                    </div>
                                                                    <!-- /.description-block -->
                                                                </div>
                                                                <!-- /.col -->
                                                                <div class="col-sm-4">
                                                                    <div class="description-block">
                                                                        <h5 class="description-header">
                                                                            &#8377;{{ number_format($competitorProdGenaralExpensesInAYear) }}
                                                                        </h5>
                                                                        <span class="description-text">General
                                                                            Expenses</span>
                                                                    </div>
                                                                    <!-- /.description-block -->
                                                                </div>
                                                                <!-- /.col -->
                                                            </div>
                                                            <!-- /.row -->
                                                        </div>
                                                    </div>
                                                    <!-- /.card -->
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.post -->

                                        <!-- Post -->
                                        <div class="post clearfix">
                                            <!-- /.user-block -->
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card">
                                                        <div class="card-header cmptblhdr">
                                                            <h3 class="card-title">BEP Calculation [BEP = Break Even Point]
                                                            </h3>
                                                        </div>
                                                        <!-- /.card-header -->
                                                        <div class="card-body table-responsive p-0">
                                                            <table class="table table-hover text-nowrap">
                                                                <thead>
                                                                    <tr>
                                                                        <th></th>
                                                                        <th>Month 0</th>
                                                                        <th>Month 1</th>
                                                                        <th>Month 2</th>
                                                                        <th>Month 3</th>
                                                                        <th>Month 4</th>
                                                                        <th>Month 5</th>
                                                                        <th>Month 6</th>
                                                                        <th>Month 7</th>
                                                                        <th>Month 8</th>
                                                                        <th>Month 9</th>
                                                                        <th>Month 10</th>
                                                                        <th>Month 11</th>
                                                                        <th>Month 12</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="beptbltitle">Makita</td>
                                                                        @php
                                                                            $makitaProdBEPCalculation = $makitaProdCost;
                                                                        @endphp
                                                                        @for ($i = 0; $i <= 12; $i++)
                                                                            <td
                                                                                @if ($i == round($achiveIn, 1)) echo class="beptblhighlight" @endif>
                                                                                {{ number_format($makitaProdBEPCalculation, 0, '.', ',') }}
                                                                            </td>
                                                                            @php
                                                                                $makitaProdBEPCalculation += $makitaProdGenaralExpensesInAMonth;
                                                                            @endphp
                                                                        @endfor
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="beptbltitle">Competitor</td>
                                                                        @php
                                                                            $compeProductBEPCalculation = $compeProductCost;
                                                                        @endphp
                                                                        @for ($i = 0; $i <= 12; $i++)
                                                                            <td
                                                                                @if ($i == round($achiveIn, 1)) echo class="beptblhighlight" @endif>
                                                                                {{ number_format($compeProductBEPCalculation, 0, '.', ',') }}
                                                                            </td>
                                                                            @php
                                                                                $compeProductBEPCalculation += $competitorProdGenaralExpensesInAMonth;
                                                                            @endphp
                                                                        @endfor
                                                                    </tr>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!-- /.card-body 24,807 -->
                                                    </div>
                                                    <!-- /.card -->
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.post -->

                                        <!-- Post -->
                                        <div class="post clearfix">
                                            <!-- /.user-block -->
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card">
                                                        <div class="card-header cmptblhdr">
                                                            <h3 class="card-title">Break Even Point Graph</h3>
                                                        </div>
                                                        <!-- /.card-header -->
                                                        <canvas id="salesChart" width="800" height="350"></canvas>

                                                        <!-- /.card-body 24,807 -->
                                                    </div>
                                                    <!-- /.card -->
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.post -->
                                    </div>
                                </div>
                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>


    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="chart.js"></script>

        <script type="text/javascript">
            // Generate Makita data for 12 months
            let makitaData = [];
            @php
                $makitaProdCost = $makitaProdCost; // Set your initial value here
            @endphp
            @for ($i = 0; $i <= 12; $i++)
                makitaData.push({{ round($makitaProdCost) }});
                @php
                    $makitaProdCost += $makitaProdGenaralExpensesInAMonth;
                @endphp
            @endfor

            // Generate Competitor data for 12 months
            let competitorData = [];
            @php
                $compeProductCost = $compeProductCost; // Set your initial value here
            @endphp
            @for ($i = 0; $i <= 12; $i++)
                competitorData.push({{ round($compeProductCost) }});
                @php
                    $compeProductCost += $competitorProdGenaralExpensesInAMonth;
                @endphp
            @endfor

            $(document).ready(function() {
                const ctx = $('#salesChart')[0].getContext('2d');

                const labels = ["Month 0", "Month 1", "Month 2", "Month 3", "Month 4", "Month 5", "Month 6",
                    "Month 7", "Month 8", "Month 9", "Month 10", "Month 11", "Month 12"
                ];

                const breakEvenPoint = {{ round($achiveIn, 1) }}; // PHP variable injected here
                const breakIndex = Math.round(breakEvenPoint); // Round to nearest index

                const data = {
                    labels: labels,
                    datasets: [{
                            label: 'Makita',
                            data: makitaData,
                            borderColor: 'rgba(75, 192, 192, 1)', // Blue for Makita
                            borderWidth: 2,
                            pointRadius: 4
                        },
                        {
                            label: 'Competitor',
                            data: competitorData,
                            borderColor: 'rgba(255, 0, 0, 1)', // Red for Competitor
                            borderWidth: 2,
                            pointRadius: 4
                        }
                    ]
                };

                // Custom plugin to add circles at break-even point and intersection point
                const highlightPoints = {
                    id: 'highlightPoints',
                    afterDatasetDraw(chart) {
                        const ctx = chart.ctx;
                        const makitaDataPoints = chart.getDatasetMeta(0).data;
                        const competitorDataPoints = chart.getDatasetMeta(1).data;

                        // Find intersection point
                        let intersectionPoint = null;
                        for (let i = 0; i < makitaDataPoints.length - 1; i++) {
                            const x1 = makitaDataPoints[i].x;
                            const y1 = makitaDataPoints[i].y;
                            const x2 = makitaDataPoints[i + 1].x;
                            const y2 = makitaDataPoints[i + 1].y;

                            for (let j = 0; j < competitorDataPoints.length - 1; j++) {
                                const x3 = competitorDataPoints[j].x;
                                const y3 = competitorDataPoints[j].y;
                                const x4 = competitorDataPoints[j + 1].x;
                                const y4 = competitorDataPoints[j + 1].y;

                                // Check for crossing
                                if ((y1 > y3 && y2 < y4) || (y1 < y3 && y2 > y4)) {
                                    // Calculate intersection (approximate)
                                    const slopeMakita = (y2 - y1) / (x2 - x1);
                                    const slopeCompetitor = (y4 - y3) / (x4 - x3);
                                    const intersectX = (y3 - y1 + slopeMakita * x1 - slopeCompetitor * x3) / (
                                        slopeMakita - slopeCompetitor);
                                    const intersectY = slopeMakita * (intersectX - x1) + y1;

                                    intersectionPoint = {
                                        x: intersectX,
                                        y: intersectY
                                    };
                                }
                            }
                        }

                        // Draw intersection circle
                        if (intersectionPoint) {
                            ctx.save();
                            ctx.beginPath();
                            ctx.arc(intersectionPoint.x, intersectionPoint.y, 6, 0, 2 * Math.PI);
                            ctx.fillStyle = 'rgba(0, 255, 0, 1)'; // Green fill for intersection
                            ctx.fill();
                            ctx.strokeStyle = 'white';
                            ctx.lineWidth = 2;
                            ctx.stroke();
                            ctx.restore();
                        }

                        // Draw circle at break-even point
                        const makitaPoint = chart.getDatasetMeta(0).data[breakIndex];
                        const competitorPoint = chart.getDatasetMeta(1).data[breakIndex];

                        // Draw circle at break-even point on Makita line
                        if (makitaPoint) {
                            ctx.save();
                            ctx.beginPath();
                            ctx.arc(makitaPoint.x, makitaPoint.y, 6, 0, 2 * Math.PI);
                            ctx.fillStyle = 'rgba(75, 192, 192, 1)'; // Blue fill for Makita break-even point
                            ctx.fill();
                            ctx.strokeStyle = 'white';
                            ctx.lineWidth = 2;
                            ctx.stroke();
                            ctx.restore();
                        }

                        // Draw circle at break-even point on Competitor line
                        if (competitorPoint) {
                            ctx.save();
                            ctx.beginPath();
                            ctx.arc(competitorPoint.x, competitorPoint.y, 6, 0, 2 * Math.PI);
                            ctx.fillStyle = 'rgba(255, 0, 0, 1)'; // Red fill for Competitor break-even point
                            ctx.fill();
                            ctx.strokeStyle = 'white';
                            ctx.lineWidth = 2;
                            ctx.stroke();
                            ctx.restore();
                        }

                        // Fill area between lines with different colors before and after the break-even point
                        const fillArea = (startIndex, endIndex, fillColor) => {
                            ctx.save();
                            ctx.beginPath();
                            ctx.moveTo(makitaDataPoints[startIndex].x, makitaDataPoints[startIndex].y);
                            for (let i = startIndex; i <= endIndex; i++) {
                                ctx.lineTo(makitaDataPoints[i].x, makitaDataPoints[i].y);
                            }
                            for (let i = endIndex; i >= startIndex; i--) {
                                ctx.lineTo(competitorDataPoints[i].x, competitorDataPoints[i].y);
                            }
                            ctx.closePath();
                            ctx.fillStyle = fillColor; // Fill with the specified color
                            ctx.fill();
                            ctx.restore();
                        };

                        // Fill area before break-even point (0 to breakIndex)
                        fillArea(0, breakIndex, 'rgba(255, 0, 0, 0.2)'); // Red shading before break-even

                        // Fill area after break-even point (breakIndex to end)
                        fillArea(breakIndex, makitaDataPoints.length - 1,
                            'rgba(75, 192, 192, 0.2)'); // Blue shading after break-even
                    }
                };

                const config = {
                    type: 'line',
                    data: data,
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Month'
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Expenses'
                                },
                                beginAtZero: false
                            }
                        },
                        plugins: {
                            legend: {
                                display: true
                            }
                        }
                    },
                    plugins: [highlightPoints]
                };

                new Chart(ctx, config);
            });
        </script>
    @endpush
@endsection
