<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('page_title')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('front_assets/css/normalize.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('front_assets/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('front_assets/css/styles-responsive.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    @stack('styles')
</head>

<body>
    <div class="wrapper">
        <header class="header">
            <div class="container">
                <div class="nav">
                    <div class="logo">
                        <img src="{{ asset('front_assets/img/makita-logo.jpg') }}" alt="">
                    </div>
                 
                    <div class="nav-item-container">
                        <button class="mobile-menu-btn">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div class="nav-item">
                            <span class="nav-title"></span>
                        </div>
                        @if(Auth::guard('customer')->check())
                        <a href="dashboard.html" class="nav-item">
                            <span class="nav-title">Dashboard</span>
                        </a>
                        <a href="{{ url('warranty-scan-machine') }}" class="nav-item">
                            <span class="nav-title">Warranty Service</span>
                        </a>
                        <a href="{{ url('warranty-registration-list-spec-cx') }}" class="nav-item">
                            <span class="nav-title">Warranty List</span>
                        </a>
                        <a href="{{ url('cx-tools-repair-list') }}" class="nav-item">
                            <span class="nav-title">Tool Repair List</span>
                        </a>
                        @endif
                        @if(!Auth::guard('customer')->check())
                        <a href="{{ url('cx-login') }}" class="nav-item active">
                            <span class="nav-title">Login | Register</span>
                        </a>
                        @endif
                        @if(Auth::guard('customer')->check())
                        <div class="nav-item user-status">
                            <div class="user-info">
                                <div class="user-avatar" id="userMenuButton">
                                    <i class="fas fa-user"></i>
                                </div>
                                <span class="user-name">John Doe</span>
                                <div class="dropdown-menu">
                                    <a href="{{ url('cx-signup-details') }}" class="dropdown-menu-item">
                                        <i class="fas fa-user-circle"></i>
                                        <span>My Profile</span>
                                    </a>
                                    <a href="/settings" class="dropdown-menu-item">
                                        <i class="fas fa-cog"></i>
                                        <span>Settings</span>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a href="{{ url('cx-logout') }}" class="dropdown-menu-item">
                                        <i class="fas fa-sign-out-alt"></i>
                                        <span>Logout</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </header>

        @section('container')
        @show

        <!-- Footer -->
        <footer class="footer">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo">
                        <img src="{{ asset('front_assets/img/makita-logo.jpg') }}" alt="Company Logo">
                    </div>
                    <div class="social-links">
                        <div class="social-icons">
                            <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                            <a href="#" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                            <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
                <div class="footer-section">
                    <h3>TOOLS BY SOLUTION</h3>
                    <ul>
                        <li><a href="#">Cordless</a></li>
                        <li><a href="#">Dust Management</a></li>
                        <li><a href="#">Cleaning Solutions</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3>HELPFUL LINKS</h3>
                    <ul>
                        <li><a href="#">Service Centers</a></li>
                        <li><a href="#">Technical Documents</a></li>
                        <li><a href="#">Warranty</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3>OUR COMPANY</h3>
                    <ul>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </div>


            </div>

            <div class="footer-bottom">
                <p>Copyright © 2024 MAKITA® INDIA., Inc. All Rights Reserved</p>
                <p>Unit II, Sy. No.93/3&4, Koralur Village Kasaba Hobli, Hoskote, Taluk, Bengaluru, Karnataka 560067</p>
            </div>
        </footer>
    </div>
    <script src="{{ asset('front_assets/js/default.js') }}"></script>  
    @stack('scripts')
</body>

</html>


{{-- old ui --}}
{{-- <!DOCTYPE html>
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
                    <li class="@yield('cx_tools_repair_list')"><a href="{{ url('cx-tools-repair-list') }}">Tools Repair List</a></li>
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
    <footer class="text-center">
        <a class="up-arrow" href="#myPage" data-toggle="tooltip" title="TO TOP">
            <span class="glyphicon glyphicon-chevron-up"></span>
        </a><br><br>
        <p> Made By <a href="" data-toggle="tooltip" title="Makita">Makita</a></p>
    </footer>
    <script src="{{ asset('admin_assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin_assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    @stack('scripts')
</body>
</html> --}}
