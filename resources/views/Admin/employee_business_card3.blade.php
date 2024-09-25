<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Card Design HTML/CSS</title>
    <!-- Font Awesome CDN-->
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.13.0/css/all.css"
      integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="{{ asset('custom_styles/css/style.css') }}">
    {{-- <link rel="stylesheet" href="./style.css"> --}}
</head>
<body>
    <div class="container">
        <div class="card card-front">
            <div class="top">
                <img src="https://i.postimg.cc/QCxQq9p6/card-logo.png" alt="Card Logo">
                <h1>EGATOR</h1>
                <P class="lead">
                    company name
                </P>
            </div>
            <div class="bottom">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>

        <div class="card card-back">
            <div class="left">
                <div class="top">
                    <img src="https://i.postimg.cc/QCxQq9p6/card-logo.png" alt="Card Logo">
                    <h1>egator</h1>
                    <p class="lead">
                        company tagline
                    </p>
                </div>
                <div class="middle contact-details">
                    <span class="icon">
                        <i class="fas fa-globe"></i>
                    </span>
                    <span class="content">
                        <p>www.egatorr.com</p>
                        <p>info@egatorr.com</p>
                    </span>
                </div>
                <div class="bttom"></div>
            </div>

            <div class="right">
                <div class="top contact-details">
                    <span class="icon">
                        <i class="fas fa-phone"></i>
                    </span>
                    <span class="content">
                        <p>+123-456-789-10</p>
                        <p>+123-456-789-10</p>
                    </span>
                    <span class="icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </span>
                    <span class="content">
                        <p>Your Location Here</p>
                        <p>New York Str 123, D890B</p>
                    </span>
                </div>
                <div class="middle">
                    <h2>john william</h2>
                    <p>graphic designer</p>
                </div>
                <div class="bottom"></div>
            </div>
        </div>
    </div>
</body>
</html>