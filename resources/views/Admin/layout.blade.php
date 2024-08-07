<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('page_title')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('admin_assets/img/favicon.ico') }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admin_assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin_assets/css/adminlte.min.css') }}">
    @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('admin_assets/img/makita-left-aside.jpg') }}" alt="MAKITA"
                height="60" width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ url('admin/dashboard') }}" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ url('admin/logout') }}" class="nav-link">Logout</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                    aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="{{ asset('admin_assets/img/user1-128x128.jpg') }}" alt="User"
                                    class="img-size-50 mr-3 img-circle">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Brad Diesel
                                        <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">Call me whenever you can...</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="{{ asset('admin_assets/img/user8-128x128.jpg') }}" alt="User"
                                    class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        John Pierce
                                        <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">I got your message bro</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="dist/img/user3-128x128.jpg" alt="User"
                                    class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Nora Silvester
                                        <span class="float-right text-sm text-warning"><i
                                                class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">The subject goes here</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                    </div>
                </li>
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ url('admin/dashboard') }}" class="brand-link">
                <img src="{{ asset('admin_assets/img/makita-left-aside.jpg') }}" alt="Makita"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Makita-Power Tools</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        @php
                        $employees=Auth::guard('admin')->user()->employee;
                        @endphp
                        @if($employees->photo!=NULL)
                        <img src="{{ asset($employees->photo) }}" class="img-circle elevation-2"
                            alt="User Image">
                        @else
                        <img src="{{ asset('admin_assets/img/avator-placeholder-3.png') }}" class="img-circle elevation-2"
                            alt="User Image">
                        @endif
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ $employees->full_name }}</a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item menu-open">
                            <a href="{{ url('admin/dashboard') }}" class="nav-link @yield('dashboard_select')">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item @yield('stock-expandable')">
                            <a href="#" class="nav-link @yield('stock_select')">
                                <i class="nav-icon fa fa-microchip"></i>
                                <p>
                                    Stocks
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('admin/branch-stock') }}" class="nav-link @yield('branch_stock_select')">
                                        <i class="nav-icon fa fa-cubes"></i>
                                        <p>Branch Stocks</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('admin/reserved-stock') }}" class="nav-link @yield('reserved_stocks')">
                                        <i class="nav-icon fa fa-braille"></i>
                                        <p>Reserved Stocks</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('admin/replaced-parts') }}" class="nav-link @yield('replaced_parts')">
                                        <i class="nav-icon fa fa-compress"></i>
                                        <p>Replaced  Parts</p>
                                    </a>
                                </li>
                                @module('147092804369935471')
                                <li class="nav-item">
                                    <a href="{{ url('admin/pending-po') }}" class="nav-link @yield('pending_po')">
                                        <i class="nav-icon fa fa-spinner"></i>
                                        <p>ETA Enquiry</p>
                                    </a>
                                </li>
                                @endmodule
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/service-management') }}" class="nav-link @yield('service_management_select')">
                                <i class="nav-icon fa fa-wrench"></i>
                                <p>
                                    Service Management
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/factory-service-center') }}" class="nav-link @yield('factory_service_center_select')">
                                <i class="nav-icon fa fa-cogs"></i>
                                <p>
                                    Service Center
                                </p>
                            </a>
                        </li>
                        @module('product-category1569185750')
                        <li class="nav-item">
                            <a href="{{ url('admin/productcategory') }}" class="nav-link @yield('productcategory_select')">
                                <i class="nav-icon fas fa-list"></i>
                                <p>
                                    Product Category
                                </p>
                            </a>
                        </li>
                        @endmodule
                        @module('product-model683637913')
                        <li class="nav-item">
                            <a href="{{ url('admin/productmodel') }}" class="nav-link @yield('product_models_select')">
                                <i class="nav-icon fa fa-snowflake"></i>
                                <p>
                                    Product Model
                                </p>
                            </a>
                        </li>
                        @endmodule
                        @module('products245036701')
                        <li class="nav-item">
                            <a href="{{ url('admin/product') }}" class="nav-link @yield('product_select')">
                                <i class="nav-icon fas fa-briefcase"></i>
                                <p>
                                    Products
                                </p>
                            </a>
                        </li>
                        @endmodule
                        @module('department600397507')
                        <li class="nav-item">
                            <a href="{{ url('admin/department') }}" class="nav-link @yield('department_select')">
                                <i class="nav-icon fas fa-building"></i>
                                <p>
                                    Department
                                </p>
                            </a>
                        </li>
                        @endmodule
                        @module('designation1509507120')
                        <li class="nav-item">
                            <a href="{{ url('admin/designation') }}" class="nav-link @yield('designation_select')">
                                <i class="nav-icon fas fa-arrows-alt"></i>
                                <p>
                                    Designation
                                </p>
                            </a>
                        </li>
                        @endmodule
                        <li class="nav-item">
                            <a href="{{ url('admin/employee') }}" class="nav-link @yield('employees_select')">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Employees
                                </p>
                            </a>
                        </li>
                        <li class="nav-item @yield('expandable')">
                            <a href="#" class="nav-link @yield('state_location_select')">
                                <i class="nav-icon fas fa-globe"></i>
                                <p>
                                    States & Locations
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('admin/state') }}" class="nav-link @yield('state_select')">
                                        <i class="far fa-map nav-icon"></i>
                                        <p>States</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('admin/city/') }}" class="nav-link @yield('city_select')">
                                        <i class="fa fa-map-signs nav-icon"></i>
                                        <p>Cities</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('admin/location/') }}" class="nav-link @yield('location_select')">
                                        <i class="fa fa-map-pin nav-icon"></i>
                                        <p>Location</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/warranty-applications') }}" class="nav-link @yield('warrantyapp_select')">
                                <i class="nav-icon fas fa-sticky-note"></i>
                                <p>
                                    Warranty Applications
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/holidays') }}" class="nav-link @yield('holiday_select')">
                                <i class="nav-icon fas fa-calendar"></i>
                                <p>
                                    Holidays
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/employee/leave-application') }}" class="nav-link @yield('employee_leave_application_select')">
                                <i class="nav-icon fa fa-calendar-minus"></i>
                                <p>
                                    Leave Application
                                </p>
                            </a>
                        </li>
                        {{-- @module('modules2087432049') --}}
                        <li class="nav-item">
                            <a href="{{ url('admin/admins') }}" class="nav-link @yield('admins_select')">
                                <i class="nav-icon fas fa-lock"></i>
                                <p>
                                    Admins
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/roles') }}" class="nav-link @yield('role_select')">
                                <i class="nav-icon fa fa-tree"></i>
                                <p>
                                    Roles
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/permission') }}" class="nav-link @yield('permission_select')">
                                <i class="nav-icon fa fa-universal-access"></i>
                                <p>
                                    Permission
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/access-modules') }}" class="nav-link @yield('module_select')">
                                <i class="nav-icon fa fa-magic"></i>
                                <p>
                                    Modules
                                </p>
                            </a>
                        </li>
                        {{-- @endmodule --}}
                        <li class="nav-item">
                            <a href="{{ url('admin/teams') }}" class="nav-link @yield('teams_select')">
                                <i class="nav-icon fa fa-address-book"></i>
                                <p>
                                    Teams
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/daily-sales') }}" class="nav-link @yield('daily_sales')">
                                <i class="nav-icon fa fa-book"></i>
                                <p>
                                    Daily Sales
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/roi') }}" class="nav-link @yield('tools_roi')">
                                <i class="nav-icon fa fa-percent"></i>
                                <p>
                                    ROI
                                </p>
                            </a>
                        </li>
                        <li class="nav-item @yield('promotion-expandable')">
                            <a href="#" class="nav-link @yield('promotion-select')">
                                <i class="nav-icon fa fa-bullhorn"></i>
                                <p>
                                    Promo Management
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('admin/promotions') }}" class="nav-link @yield('promotion_select')">
                                        <i class="fas fa-percentage"></i>
                                        <p>Promotions</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('admin/promotions/promotion-transaction') }}" class="nav-link @yield('promotion_select')">
                                        <i class="fa fa-shopping-cart"></i>
                                        <p>Transactions</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item @yield('assetaudit-expandable')">
                            <a href="#" class="nav-link @yield('asset_audit_select')">
                                <i class="nav-icon fa fa-bars"></i>
                                <p>
                                    Assets & Audit 
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('admin/asset-master') }}" class="nav-link @yield('asset_master_select')">
                                        <i class="nav-icon fa fa-laptop"></i>
                                        <p>Asset Master</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item @yield('travelmanagement-expandable')">
                            <a href="#" class="nav-link @yield('travel-management-select')">
                                <i class="nav-icon fa fa-suitcase"></i>
                                <p>
                                    Travel Management
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('admin/travelmanagement/applyviewclaimtravelexpenses') }}" class="nav-link @yield('business-trips-select')">
                                        <i class="nav-icon fa fa-plane"></i>
                                        <p>Business Trips</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                      

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        @section('container')
        @show

        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2022-2023 <a href="#">Makita</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.0
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->
    <!-- jQuery -->
    <script src="{{ asset('admin_assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('admin_assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('admin_assets/js/adminlte.js') }}"></script>
    @stack('scripts')
</body>

</html>
