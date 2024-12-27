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
                              <h2 class="step-title">Create Account</h2>
                              <p class="step-description">Create a account or <a href="index.html">signin</a> to access warranty services portal.</p>
                            </div>
                          </div>
                    
                          <div class="step-card">
                            <div class="step-number">02</div>
                            <div class="step-content">
                              <div class="step-icon">
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                  <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                  <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                              </div>
                              <h2 class="step-title">Mobile Number</h2>
                              <p class="step-description">Enter the mobile number and press continue to proceed.</p>
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
                              <h2 class="step-title">OTP</h2>
                              <p class="step-description">Enter the OTP received on your mobile and press verify OTP to continue.</p>
                            </div>
                          </div>
                          <div class="step-card">
                            <div class="step-number">04</div>
                            <div class="step-content">
                              <div class="step-icon">
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                  <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                  <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                              </div>
                              <h2 class="step-title">Peronal Details</h2>
                              <p class="step-description">Enter your personal details along with your address.</p>
                            </div>
                          </div>
                    
                          <div class="step-card">
                            <div class="step-number">05</div>
                            <div class="step-content">
                              <div class="step-icon">
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                  <path d="M20 6L9 17l-5-5"></path>
                                </svg>
                              </div>
                              <h2 class="step-title">Review & Submit</h2>
                              <p class="step-description">Verify all information and submit your request for processing.</p>
                            </div>
                          </div>
                        </div>
                </div>
            </div>
        </div>
            <div class="right-side">
                <div class="card-s">
                    <div class="auth-container" id="signupPage">
                        <div class="auth-header">
                            <h1>Create Account</h1>
                            <p>Please complete all steps to register</p>
                        </div>
            
                        <div class="steps-container">
                            <div class="step">
                                <div class="step-circle active">1</div>
                                <div class="step-text">Number</div>
                            </div>
                            <div class="step">
                                <div class="step-circle">2</div>
                                <div class="step-text">OTP</div>
                            </div>
                            <div class="step">
                                <div class="step-circle">3</div>
                                <div class="step-text">Details</div>
                            </div>
                            
                        </div>
            
                        <!-- Step 1: Mobile Number -->
                        <form class="step-form active" id="step1Form">
                            <div class="form-group">
                                <label for="mobileNumber">Enter Mobile Number</label>
                                <input type="tel" id="mobileNumber" placeholder="Enter your mobile number" required>
                            </div>
                            <button type="submit" class="btn-primary">Continue</button>
                        </form>
            
                        <!-- Step 2: OTP Verification -->
                        <form class="step-form" id="step2Form">
                            <div class="form-group">
                                <label>Enter OTP sent to your mobile</label>
                                <div class="otp-inputs">
                                    <input type="text" maxlength="1" pattern="\d">
                                    <input type="text" maxlength="1" pattern="\d">
                                    <input type="text" maxlength="1" pattern="\d">
                                    <input type="text" maxlength="1" pattern="\d">
                                </div>
                            </div>
                            <button type="submit" class="btn-primary">Verify OTP</button>
                        </form>
            
                        <!-- Step 3: User Details -->
                        <form class="step-form" id="step3Form">
                            <div class="f-col">
                              <div class="form-group">
                                  <label for="name">Full Name</label>
                                  <input type="text" id="name" placeholder="Enter your full name" required>
                              </div>
                              <div class="form-group">
                                  <label for="email">Email Address</label>
                                  <input type="email" id="email" placeholder="Enter your email" required>
                              </div>
                            </div>
                            <div class="f-col">
                              <div class="form-group">
                                <label for="">State*</label>
                                <div class="custom-select-container" id="stateID">
                                      <input type="text" class="custom-select-input" readonly placeholder="Select an option...">
                                      <div class="dropdown-arrow"></div>
                                      <div class="custom-select-dropdown">
                                          <input type="text" class="search-box" placeholder="Type to search...">
                                          <div class="options-container"></div>
                                      </div>
                                  </div>
                              </div>
                              <div class="form-group">
                                <label for="">City*</label>
                                <div class="custom-select-container" id="cityID">
                                    <input type="text" class="custom-select-input" readonly placeholder="Select an option...">
                                    <div class="dropdown-arrow"></div>
                                    <div class="custom-select-dropdown">
                                        <input type="text" class="search-box" placeholder="Type to search...">
                                        <div class="options-container"></div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="form-group">
                              <label>Address</label>
                              <textarea placeholder="Enter your comment here" name="comment"></textarea>
                              </div>
                            <button type="submit" class="btn-primary">Complete Registration</button>
                        </form>
            
                        <!-- Login Link -->
                        <div class="auth-links">
                            <a href="index.html">Already have an account? Login here</a>
                        </div>
                        <div class="contact-info">
                            <p>Need help? Contact us at:</p>
                            <div class="contact-details">
                                <p><span>📍 Reach us at</span> :  Bangalore, India</p>
                                <p><span>📞 Call us at</span> :  +91-80-2205-8200</p>
                                <p><span>✉️ Contact us at</span> : <a href="mailto:sales@makita.in">sales@makita.in</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@push('scripts')
<script>
    $(document).ready(function() {
        if ($('#signupPage').length > 0) {
            $(".steps-grid .step-card").hide();
            $(".steps-grid .step-card:nth-child(2)").addClass("active-card")
            $(".steps-grid .step-card:nth-child(-n+2)").show();                
        }
    });
</script>
@endpush
@endsection