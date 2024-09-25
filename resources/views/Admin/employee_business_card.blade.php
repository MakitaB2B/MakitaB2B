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
        <div class="top-section card card-front">
            <h2>Top Section Content</h2>
            <p>This could be the logo or employee information.</p>
        </div>

        <!-- Bottom Section -->
        <div class="bottom-section card-rear">
            <h2>Bottom Section Content</h2>
            <p>This could be the contact information, QR code, or any other details.</p>
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
