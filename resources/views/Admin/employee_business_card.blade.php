<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Card</title>
    <link rel="stylesheet" href="{{ asset('custom_styles/css/style1.css') }}">
</head>
<body>
    <div class="business-card-container">
    <div class="business-card front" >  
        {{-- style="width: 550px; height:350px" --}}
        <div class="left-section" >
            <p><strong>D Janarthanan</strong><br><small>Sr. Sales & Service Engineer</small></p>
            <div class="qr-code">
                <!-- Add your QR code image here -->
                <img src="{{ asset('custom_styles/img/QR_code_for_mobile_English_Wikipedia.svg') }}" alt="QR Code">
            </div>
        </div>
        <div class="right-section">
            <p><strong>Makita Power Tools India Pvt. Ltd.</strong><br>
            <small> No. 30, Jawaharlal Nehru Salai,<br>
            100 Feet Road, Koyambedu,<br>
            Chennai - 600107<br>
            Tel: +91-44-2479-2522<br></p>
            <p>Mobile  : +91-98400-43109<br>
               Email   : ope_tn@makita.in<br>
               Website : <a href="https://www.makita.in">www.makita.in</a></small>
            </p>
        </div>
        <div class="logo">
            <img src="{{ asset('custom_styles/img/logo-05.png') }}" alt="Card Logo" style="width:500px; height:90px;">
        </div>
    </div>

    <div class="business-card back">
        
        <div class="back-header" style="display: inline-grid;">
            <img src="{{ asset('custom_styles/img/logo-04.png') }}" style="height:50px" alt="Card Logo">
            <img src="{{ asset('custom_styles/img/logo-03.png') }}" style="height:50px;margin-top:30px;" alt="Card Logo">
        </div>
        <div class="back-details">
            <span>
            <p><strong>D Janarthanan</strong><br><small>Sr. Sales & Service Engineer</small></p>
            </span>
            <span>
            <p><small>Head Office:</small><br></p>    
            <p><strong>Makita Power Tools India Pvt. Ltd.</strong><br>
            <small> Unit - II, Sy. Nos. 93/3 & 93/4,<br>
            Koralur Village, Kasaba Hobli,<br>
            Hoskote Taluk, Bangalore - 560067<br></p>
          {{-- <pre>Mobile  : +91-98400-43109<br>
               Email   : ope_tn@makita.in<br>
               Website : <a href="https://www.makita.in">www.makita.in</a></small></pre> --}}
               <div class="contact-info">
                <div>
                  <span>Mobile :</span>
                  <span>+91-98400-43109</span>
                </div>
                <div>
                  <span>Email :</span>
                  <span><a href="mailto:ope_tn@makita.in">ope_tn@makita.in</a></span>
                </div>
                <div>
                  <span>Website :</span>
                  <span><a href="https://www.makita.in">www.makita.in</a></span>
                </div>
              </div>
            </span>
        </div>
        
        <div class="footer">
            <img  src="{{ asset('custom_styles/img/logo-02.png') }}" alt="Card Logo" style="width: 548px;">
        </div>
    </div>
    </div>
</body>
</html>
