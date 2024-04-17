<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('page_title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="{{ asset('front_assets/css/style_warranty.css') }}">
    @stack('styles')
</head>

<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="50">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <img src="{{asset('front_assets/img/makita-logo.jpg')}}"  >
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::guard('customer')->check())
                    <li class="@yield('warrantycard_select')"><a href="{{ url('warranty-scan-machine') }}">Register Warranty</a></li>
                    <li class="@yield('warranty_list')"><a href="{{ url('warranty-registration-list-spec-cx') }}">Warranty List</a></li>
                    <li class="@yield('profile_select')"><a href="{{ url('cx-signup-details') }}">Profile</a></li>
                    @endif
                    @if (Auth::guard('customer')->check())
                    <li><a href="{{ url('cx-logout') }}">logout</a></li>
                    @else
                    <li class="dropdown @yield('cxsignup_select')">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Login
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('cx-login') }}">Login</a></li>
                            <li><a href="{{ url('cx-signup') }}">Registration</a></li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @section('container')
    @show

    <!-- Footer -->
    <footer class="text-center">
        <a class="up-arrow" href="#myPage" data-toggle="tooltip" title="TO TOP">
            <span class="glyphicon glyphicon-chevron-up"></span>
        </a><br><br>
        <p> Made By <a href="" data-toggle="tooltip" title="Makita">Makita</a></p>
    </footer>
    <script src="{{ asset('admin_assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('admin_assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    @stack('scripts')
</body>
</html>
