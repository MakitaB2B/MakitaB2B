<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('custom_styles/css/business_card.css') }}">
    <title>Makita Business Card</title>
</head>
<body>

    <div class="card-container">
    
        <!-- Top Section -->
        <div class="card card-front">
             <div class="card-front-top">

                <div class="card-left">
                    <div class="front-name">
                        <h3>D Janarthanan</h3>
                        <p>Sr. Sales & Service Engineer</p>
                    </div>
                <div class="front-qr-code"> 
                    <img src="{{ asset('custom_styles/img/qr-code.png') }}" alt="QR Code">
                </div>

                </div>
                <div class="card-right">
                    <span class="front-address">
                        <h3>Makita Power Tools India Pvt. Ltd.</h3>
                        <p>Head Office:</p>
                    </span>
                </div>

             </div>

            <div class="card-front-bottom">
                <img src="{{ asset('custom_styles/img/logo-05.png') }}" alt="Card Logo">
            </div>
        </div>

        <!-- Bottom Section -->
        <div class="card card-rear">
             <div class="card-rear-top">
                <div class="card-left">
                    <img src="{{ asset('custom_styles/img/logo-03.png') }}" alt="Card Logo">
                    <img src="{{ asset('custom_styles/img/logo-04.png') }}" alt="Card Logo">
                </div>
                <div class="card-right">
                    <span class="rear-name">
                        <h3>D Janarthanan</h3>
                        <p>Sr. Sales & Service Engineer</p>

                    </span>
                    <span class="rear-address">
                    <p>Head Office:</p>
                    <h3>Makita Power Tools India Pvt. Ltd.</h3>
                    </span>
                </div>
             </div>
             <div class="card-rear-bottom">
                <img  src="{{ asset('custom_styles/img/logo-02.png') }}" alt="Card Logo">
             </div>
        </div>
      
    </div>

    {{-- <svg width="108.95mm" height="139.87mm" viewBox="0 0 1089.5 1398.7" xmlns="http://www.w3.org/2000/svg">
        <!-- Background with rounded corners -->
        <rect x="0" y="0" width="1089.5" height="1398.7" rx="30" ry="30" fill="#ffffff" stroke="#000000" stroke-width="2"/>
        
        <!-- Top Section -->
        <rect x="0" y="0" width="1089.5" height="580" fill="#f4f4f4" />
        <text x="50%" y="290" font-size="60" text-anchor="middle" fill="#000">Top Section</text>
        
        <!-- Address Section -->
        <rect x="0" y="580" width="1089.5" height="455.5" fill="#e0e0e0" />
        <text x="50%" y="800" font-size="50" text-anchor="middle" fill="#000">Address and Contact Information</text>
        
        <!-- Bottom Section -->
        <rect x="0" y="1035.5" width="1089.5" height="363.2" fill="#008297" />
        <text x="50%" y="1220" font-size="60" text-anchor="middle" fill="#fff">QR Code or Details</text>
    </svg> --}}

</body>
</html>
