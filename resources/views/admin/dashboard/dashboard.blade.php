@extends('admin/layouts/default')
@section('title')
<title>Bhagban - Dashboard</title>
@stop
@section('inlinecss')

@stop
@section('breadcrum')
<h1 class="page-title">Dashboard</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">dashboard</li>
</ol>
@stop
@section('content')
<div class="app-content">
    <div class="side-app">
        <!-- PAGE-HEADER -->
        @include('admin.layouts.pagehead')
        
       {{-- <!-- PAGE-HEADER END -->
        <div class="col-12">
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Revenue Vs Expenses</h3>
                    </div>
                    <div class="card-body ">
                        <div id="index" class="overflow-hidden h-300 chart-dropshadow"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ROW-1 CLOSED -->

        <!-- ROW-2 OPEN -->
        <div class="row">
            <div class=" col-md-12 col-lg-12 col-xl-5">
                <div class="row">
                    <div class="col-sm-12 col-lg-6 col-md-6 ">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="mb-1 number-font">0.35</h2>
                                <p>Current Ratio</p>
                                <div class="progress h-2 mb-1">
                                    <div class="progress-bar bg-primary w-50" role="progressbar"></div>
                                </div>
                                <span class="text-muted"><span class="mb-0 text-success fs-13"><i class="fe fe-arrow-up"></i> 12%</span> increase</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="mb-1 number-font">1.45</h2>
                                <p>Quick Ratio</p>
                                <div class="progress h-2 mb-1">
                                    <div class="progress-bar bg-secondary w-20" role="progressbar"></div>
                                </div>
                                <span class="text-muted"><span class="mb-0 text-danger fs-13"><i class="fe fe-arrow-down"></i> 26%</span> decrease</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6 col-md-6 ">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="text-center">Income Budget</h4>
                                <div class="mt-3 text-center">
                                    <div class="chart-circle mx-auto chart-dropshadow-success" data-value="0.80" data-thickness="7" data-color="#33ce7b">
                                        <div class="chart-circle-value">
                                            <div class="font-weight-normal fs-20">75%</div>
                                        </div>
                                    </div>
                                    <p class="mb-0 mt-2">Total Income</p>
                                </div>
                                <ul class="list-items mt-2">
                                    <li class="p-1">
                                        <span class="list-label"></span>Budget
                                        <span class="list-items-percentage float-right font-weight-semibold mr-4">4500,00</span>
                                    </li>
                                    <li class="p-1">
                                        <span class="list-label"></span>Balance
                                        <span class="list-items-percentage float-right font-weight-semibold mr-4">-34,645</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6 col-md-6 ">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="text-center">Expense Budget</h4>
                                <div class="mt-3 text-center">
                                    <div class="chart-circle mx-auto chart-dropshadow-info" data-value="0.80" data-thickness="7" data-color="#26c2f7">
                                        <div class="chart-circle-value">
                                            <div class="font-weight-normal fs-20">65%</div>
                                        </div>
                                    </div>
                                    <p class="mb-0 mt-2">Total Expense</p>
                                </div>
                                <ul class="list-items mt-2">
                                    <li class="p-1">
                                        <span class="list-label"></span>Budget
                                        <span class="list-items-percentage float-right font-weight-semibold mr-4">5678,20</span>
                                    </li>
                                    <li class="p-1">
                                        <span class="list-label"></span>Balance
                                        <span class="list-items-percentage float-right font-weight-semibold mr-4">-24,835</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-12 col-md-12 col-xl-7">
                <div class="card h-450">
                    <div class="card-header">
                        <h3 class="card-title">Activity</h3>
                    </div>
                    <div class="card-body">
                        <div class="row ml-5 mb-0 text-center">
                            <div class="mr-5">
                                <span class="dot-label bg-info"></span>Income
                            </div><!-- col -->
                            <div class=" ">
                                <span class="dot-label bg-secondary"></span>Outcome
                            </div><!-- col -->
                        </div>
                        <div id="line-chart" class="overflow-hidden chart-dropshadow"></div>
                    </div>
                </div>
            </div><!-- COL END -->
        </div>
        <!-- ROW-2 CLOSED -->

        <!-- ROW-3 OPEN -->
        <div class="row">
            <div class=" col-md-12 col-lg-12 col-xl-7">
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="card overflow-hidden">
                            <div class="card-body pb-0">
                                <div class="float-left">
                                    <h6 class="mb-1">Total Quantity</h6>
                                    <h2 class="number-font mb-2">9,54,777</h2>
                                    <p class="mb-2 text-muted"><span class="mb-0 text-success fs-13 "><i class="fe fe-arrow-up"></i> 23%</span> for Last month</p>
                                </div>
                                <div class="float-right">
                                    <span class="mini-stat-icon bg-info"><i class="si si-eye "></i></span>
                                </div>
                            </div>
                            <div class="card-body pt-0 pb-0 border-top-0 overflow-hidden">
                                <div class="chart-wrapper overflow-hidden">
                                    <canvas id="areaChart1" class="areaChart overflow-hidden chart-dropshadow-info"></canvas>
                                </div>
                            </div>
                        </div>
                    </div><!-- COL END -->
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="card">
                            <div class="card-body pb-0">
                                <div class="float-left">
                                    <h6 class="mb-1">Total Cost</h6>
                                    <h2 class="number-font mb-2">$ 67,897</h2>
                                    <p class="mb-2 text-muted"><span class="mb-0 text-danger fs-13 "><i class="fe fe-arrow-down"></i> 12%</span> for Last month</p>
                                </div>
                                <div class="float-right">
                                    <span class="mini-stat-icon bg-danger"><i class="si si-volume-2"></i></span>
                                </div>
                            </div>
                            <div class="card-body pt-0 pb-0 border-top-0 overflow-hidden">
                                <div class="chart-wrapper ">
                                    <canvas id="areaChart2" class="areaChart chart-dropshadow-secondary"></canvas>
                                </div>
                            </div>
                        </div>
                    </div><!-- COL END -->
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="card">
                            <div class="card-body pb-0">
                                <div class="float-left">
                                    <h6 class="mb-1">Total Revenue</h6>
                                    <h2 class="number-font mb-2">178,698</h2>
                                    <p class="mb-2 text-muted"><span class="mb-0 text-success fs-13 "><i class="fe fe-arrow-up"></i> 26%</span> for Last month</p>
                                </div>
                                <div class="float-right">
                                    <span class="mini-stat-icon bg-warning"><i class="si si-chart"></i></span>
                                </div>
                            </div>
                            <div class="card-body pt-0 pb-0 border-top-0 overflow-hidden">
                                <div class="chart-wrapper ">
                                    <canvas id="areaChart3" class="areaChart chart-dropshadow-success"></canvas>
                                </div>
                            </div>
                        </div>
                    </div><!-- COL END -->
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="card">
                            <div class="card-body pb-0">
                                <div class="float-left">
                                    <h6 class="mb-1">Total Profit</h6>
                                    <h2 class="number-font mb-2">34,789</h2>
                                    <p class="mb-2 text-muted"><span class="mb-0 text-danger fs-13"><i class="fe fe-arrow-down"></i> 15%</span> for Last month</p>
                                </div>
                                <div class="float-right">
                                    <span class="mini-stat-icon bg-success"><i class="si si-user"></i></span>
                                </div>
                            </div>
                            <div class="card-body pt-0 pb-0 border-top-0 overflow-hidden">
                                <div class="chart-wrapper ">
                                    <canvas id="areaChart4" class="areaChart chart-dropshadow-warning"></canvas>
                                </div>
                            </div>
                        </div>
                    </div><!-- COL END -->
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-5">
                <div class="card  overflow-hidden">
                    <div class="card-header">
                        <h3 class="card-title">Sales By Category</h3>
                    </div>
                    <div class="card-body text-center">
                        <div id="morrisBar8" class="h-340 donutShadow"></div>
                        <div class="mt-2 text-center">
                            <span class="dot-label bg-info"></span><span class="mr-3">Technology</span>
                            <span class="dot-label bg-secondary"></span><span class="mr-3">Furniture</span>
                            <span class="dot-label bg-success"></span><span class="mr-3">Office Suppliers</span>
                        </div>
                    </div>
                </div>
            </div><!-- COL END -->
        </div>
        <!-- ROW-3 CLOSED -->

        <!-- ROW-4 OPEN -->
        <div class="row row-cards row-deck">
            <div class="col-xs-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header ">
                        <h3 class="card-title">User feedback</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive ">
                            <table class="users table card-table border table-striped table-vcenter text-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th colspan="2">User</th>
                                        <th>Feed back</th>
                                        <th>Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>2345</td>
                                        <td><img src="{{ asset('/public/admin/assets/images/users/3.jpg') }}" alt="profile-user" class="brround  avatar-sm w-32"></td>
                                        <td>Megan Peters</td>
                                        <td>please check pricing Info </td>
                                        <td class="text-nowrap">July 13, 2019</td>
                                        <td class="w-1"><button type="button" class="btn btn-icon  btn-danger"><i class="fa fa-trash-o"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>4562</td>
                                        <td><img src="{{ asset('/public/admin/assets/images/users/12.jpg') }}" alt="profile-user" class="brround  avatar-sm w-32"></td>
                                        <td>Phil Vance</td>
                                        <td>New stock</td>
                                        <td class="text-nowrap">June 15, 2019</td>
                                        <td><button type="button" class="btn btn-icon  btn-danger"><i class="fa fa-trash-o"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>8765</td>
                                        <td><img src="{{ asset('/public/admin/assets/images/users/15.jpg') }}" alt="profile-user" class="brround  avatar-sm w-32"></td>
                                        <td>Adam Sharp</td>
                                        <td>Daily updates</td>
                                        <td class="text-nowrap">July 8, 2019</td>
                                        <td><button type="button" class="btn btn-icon  btn-danger"><i class="fa fa-trash-o"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>2665</td>
                                        <td><img src="{{ asset('/public/admin/assets/images/users/5.jpg') }}" alt="profile-user" class="brround  avatar-sm w-32"></td>
                                        <td>Samantha Slater</td>
                                        <td>available item list</td>
                                        <td class="text-nowrap">June 28, 2019</td>
                                        <td><button type="button" class="btn btn-icon  btn-danger"><i class="fa fa-trash-o"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>2665</td>
                                        <td><img src="{{ asset('/public/admin/assets/images/users/11.jpg') }}" alt="profile-user" class="brround  avatar-sm w-32"></td>
                                        <td>Samantha Slater</td>
                                        <td>available item list</td>
                                        <td class="text-nowrap">June 28, 2019</td>
                                        <td><button type="button" class="btn btn-icon  btn-danger"><i class="fa fa-trash-o"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div><!-- COL END -->
        </div>
        <!-- ROW-5 CLOSED -->
    </div>--}}
    
</div>
@stop

@section('inlinejs')
<!-- SPARKLINE JS-->
<script src="{{ asset('/public/admin/assets/js/jquery.sparkline.min.js') }}"></script>

<!-- CHART-CIRCLE JS -->
<script src="{{ asset('/public/admin/assets/js/circle-progress.min.js') }}"></script>

<!-- RATING STAR JS-->
<script src="{{ asset('/public/admin/assets/plugins/rating/jquery.rating-stars.js') }}"></script>

<!-- CHARTJS CHART JS-->
<script src="{{ asset('/public/admin/assets/plugins/chart/Chart.bundle.js') }}"></script>
<script src="{{ asset('/public/admin/assets/plugins/chart/utils.js') }}"></script>

<!-- C3.JS') }} CHART JS -->
<script src="{{ asset('/public/admin/assets/plugins/charts-c3/d3.v5.min.js') }}"></script>
<script src="{{ asset('/public/admin/assets/plugins/charts-c3/c3-chart.js') }}"></script>

<!-- INPUT MASK JS-->
<script src="{{ asset('/public/admin/assets/plugins/input-mask/jquery.mask.min.js') }}"></script>

<!-- CHARTJS CHART JS -->
<script src="{{ asset('/public/admin/assets/plugins/chart/Chart.bundle.js') }}"></script>
<script src="{{ asset('/public/admin/assets/plugins/chart/utils.js') }}"></script>

<!-- PIETY CHART JS-->
<script src="{{ asset('/public/admin/assets/plugins/peitychart/jquery.peity.min.js') }}"></script>
<script src="{{ asset('/public/admin/assets/plugins/peitychart/peitychart.init.js') }}"></script>

<!--MORRIS js-->
<script src="{{ asset('/public/admin/assets/plugins/morris/morris.js') }}"></script>
<script src="{{ asset('/public/admin/assets/plugins/morris/raphael-min.js') }}"></script>

<!-- ECharts JS -->
<script src="{{ asset('/public/admin/assets/plugins/echarts/echarts.js') }}"></script>

<!-- INDEX JS-->
<script src="{{ asset('/public/admin/assets/js/index4.js') }}"></script>

@stop
