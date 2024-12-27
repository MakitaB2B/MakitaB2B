<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('page_title')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('front_assets/css/normalize.css') }}">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                        <img src="{{asset('front_assets/img/makita-logo.jpg')}}" alt="">
                    </div>
                    <div class="nav-item-container">
                        <button class="mobile-menu-btn">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div class="nav-item">
                            <span class="nav-title"></span>
                        </div>
                        <a href="dashboard.html" class="nav-item">
                          <span class="nav-title">Dashboard</span>
                        </a>
                        <a href="warranty-service.html" class="nav-item">
                            <span class="nav-title">Warranty Service</span>
                        </a>
                        <a href="warranty-list.html" class="nav-item">
                            <span class="nav-title">Warranty List</span>
                        </a>
                        <a href="tool-service.html" class="nav-item">
                            <span class="nav-title">Tool Repair List</span>
                        </a>
                        <a href="index.html" class="nav-item active">
                            <span class="nav-title">Login | Register</span>
                        </a>                    
                        <div class="nav-item user-status">
                            <div class="user-info">                
                                <div class="user-avatar" id="userMenuButton">
                                    <i class="fas fa-user"></i>
                                </div>
                                <span class="user-name">John Doe</span>
                                <div class="dropdown-menu">
                                    <a href="/profile" class="dropdown-menu-item">
                                        <i class="fas fa-user-circle"></i>
                                        <span>My Profile</span>
                                    </a>
                                    <a href="/settings" class="dropdown-menu-item">
                                        <i class="fas fa-cog"></i>
                                        <span>Settings</span>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a href="/logout" class="dropdown-menu-item">
                                        <i class="fas fa-sign-out-alt"></i>
                                        <span>Logout</span>
                                    </a>
                                </div>
                            </div>
                        </div>
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
                  <img src="{{asset('front_assets/img/makita-logo.jpg')}}" alt="Company Logo"> 
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
    <script src="js/default.js"></script>
    @stack('scripts')
</body>
</html>
