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
    <div class="business-card front" style="width: 550px; height:350px">
        <div class="left-section" style="width: 40% !important;">
            <p><strong>D Janarthanan</strong><br>Sr. Sales & Service Engineer</p>
            <div class="qr-code">
                <!-- Add your QR code image here -->
                <img src="{{ asset('custom_styles/img/QR_code_for_mobile_English_Wikipedia.svg') }}" alt="QR Code" style="width:110px; height:110px;margin-top:30px">
            </div>
        </div>
        <div class="right-section" style="width: 60% !important;">
            <p style="font-size: 16px;"><strong>Makita Power Tools India Pvt. Ltd.</strong><br>
            No. 30, Jawaharlal Nehru Salai,<br>
            100 Feet Road, Koyambedu,<br>
            Chennai - 600107<br>
            Tel: +91-44-2479-2522<br>
            Mobile: +91-98400-43109<br>
            Email: ope_tn@makita.in<br>
            Website: <a href="https://www.makita.in">www.makita.in</a>
            </p>
        </div>
        <div class="logo">
            <img src="{{ asset('custom_styles/img/logo-05.png') }}" alt="Card Logo" style="width:500px; height:90px;">
        </div>
    </div>

    <div class="business-card back">
        <div class="back-header">
            <img src="{{ asset('custom_styles/img/logo-03.png') }}" alt="Card Logo">
            <img src="{{ asset('custom_styles/img/logo-04.png') }}" alt="Card Logo">
        </div>
        <div class="back-details">
            <p><strong>D Janarthanan</strong><br>Sr. Sales & Service Engineer</p>
            <p><strong>Head Office:</strong><br>
            Makita Power Tools India Pvt. Ltd.<br>
            Unit - II, Sy. Nos. 93/3 & 93/4,<br>
            Koralur Village, Kasaba Hobli,<br>
            Hoskote Taluk, Bangalore - 560067<br>
            Mobile: +91-98400-43109<br>
            Email: ope_tn@makita.in<br>
            Website: <a href="https://www.makita.in">www.makita.in</a>
            </p>
        </div>
        <div class="footer">
            <img  src="{{ asset('custom_styles/img/logo-02.png') }}" alt="Card Logo">
        </div>
    </div>
    </div>
</body>
</html>
