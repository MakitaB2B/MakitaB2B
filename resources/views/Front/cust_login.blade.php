@extends('Front/cust_layout')
@section('page_title', 'Makita Customer | Customer Details')
@section('cxsignup_select', 'active')
@section('container')
        <main class="main-content bg-grey">
            <div class="container">
                <div class="content">
                    <div class="left-side">
                            <!-- <div class="carousel-container">
                                <div class="carousel">
                                    <div class="carousel-slide">
                                        <img src="./img/hero-.jpg" alt="Slide 1">
                                    </div>
                                    <div class="carousel-slide">
                                        <img src="./img/hero-.jpg" alt="Slide 2">
                                    </div>
                                    <div class="carousel-slide">
                                        <img src="./img/hero-.jpg" alt="Slide 3">
                                    </div>
                                </div>
                                
                                <button class="carousel-btn prev-btn">❮</button>
                                <button class="carousel-btn next-btn">❯</button>
                                
                                <div class="carousel-indicators"></div>
                            </div> -->
                        <div class="content-info">                            
                            <div class="card-container">
                                    <!-- <h1 class="title">WARRANTY SERVICE STEPS</h1> -->
                                    <div class="steps-grid">
                                      <div class="step-card">
                                        <div class="step-number">01</div>
                                        <div class="step-content">
                                          <div class="step-icon">
                                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                              <circle cx="12" cy="7" r="4"></circle>
                                            </svg>
                                          </div>
                                          <h2 class="step-title">Login | Register</h2>
                                          <p class="step-description">Create your account or sign in to access warranty services and track your claims.</p>
                                        </div>
                                      </div>
                                
                                      <div class="step-card">
                                        <div class="step-number">02</div>
                                        <div class="step-content">
                                          <div class="step-icon">
                                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                              <circle cx="11" cy="11" r="8"></circle>
                                              <path d="m21 21-4.3-4.3"></path>
                                            </svg>
                                          </div>
                                          <h2 class="step-title">Search Product</h2>
                                          <p class="step-description">Locate your product using the serial number, model name, or purchase details.</p>
                                        </div>
                                      </div>
                                
                                      <div class="step-card">
                                        <div class="step-number">03</div>
                                        <div class="step-content">
                                          <div class="step-icon">
                                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                              <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                              <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                          </div>
                                          <h2 class="step-title">Fill Details</h2>
                                          <p class="step-description">Provide the required information about your warranty claim and issue details.</p>
                                        </div>
                                      </div>
                                
                                      <div class="step-card">
                                        <div class="step-number">04</div>
                                        <div class="step-content">
                                          <div class="step-icon">
                                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                              <path d="M20 6L9 17l-5-5"></path>
                                            </svg>
                                          </div>
                                          <h2 class="step-title">Review & Submit</h2>
                                          <p class="step-description">Verify all information and submit your warranty request for processing.</p>
                                        </div>
                                      </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="right-side">
                        <div class="card-s">
                            <div class="auth-container" id="loginPage">
                                <div class="auth-header">
                                    <h1>Welcome Back</h1>
                                    <p>Please login to your account</p>
                                </div>
                                <form id="loginForm">
                                    <div class="form-group">
                                        <label for="loginNumber">Mobile Number</label>
                                        <input type="text"  class="form-control" id="loginNumber" placeholder="Enter your number" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="loginPassword">Password</label>
                                        <input type="password" class="form-control" id="loginPassword" placeholder="Enter your password" required>  
                                    </div>
                                    <button type="submit" class="btn-primary submit-button">Login</button>
                                    <div class="auth-links">
                                        <a href="register.html">Don't have an account? Register</a>
                                        <a href="#">Forgot Password?</a>
                                    </div>
                                    <div class="contact-info">
                                        <p>Need help? Contact us at:</p>
                                        <div class="contact-details">
                                            <p><span>📍 Reach us at</span> :  Bangalore, India</p>
                                            <p><span>📞 Call us at</span> :  +91-80-2205-8200</p>
                                            <p><span>✉️ Contact us at</span> : <a href="mailto:sales@makita.in">sales@makita.in</a></p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
@endsection