<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Delta Profile</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Damion" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/templatemo-style.css" rel="stylesheet">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon"/>
</head>
<body>
    <!-- Preloader -->
    <div id="loader-wrapper">
      <div id="loader"></div>
      <div class="loader-section section-left"></div>
      <div class="loader-section section-right"></div>
    </div>
    <!-- End Preloader -->

    <div class="tm-top-header">
        <div class="container">
            <div class="row">
                <div class="tm-top-header-inner">
                    <div class="tm-logo-container">
                        <img src="img/logo.png" alt="Logo" class="tm-site-logo">
                        <h1 class="tm-site-name tm-handwriting-font">Delta Cafe</h1>
                    </div>
                    <nav class="tm-nav">
                        <ul>
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li><a href="{{ route('menu') }}">Menu</a></li>
                            <li><a href="{{ route('create-qrcode') }}">Create QR Code</a></li>
                            <li><a href="{{ route('contact') }}">Contact</a></li>
                            <li><a href="{{ route('profile.edit') }}" class="active">My Profile</a></li>                
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    
    <section class="tm-welcome-section">
        <div class="container tm-position-relative">
        <div class="tm-lights-container">
            <img src="img/light.png" alt="Light" class="light light-1">
            <img src="img/light.png" alt="Light" class="light light-2">
            <img src="img/light.png" alt="Light" class="light light-3">  
        </div>
            
            <div class="row tm-welcome-content">
                <h2 class="white-text tm-handwriting-font tm-welcome-header"><img src="img/header-line.png" alt="Line" 
                    class="tm-header-line">&nbsp;Delta Profile&nbsp;&nbsp;<img src="img/header-line.png" alt="Line" 
                    class="tm-header-line"></h2>                
        
                <div class="bg-white p-4 sm:p-8 shadow sm:rounded-lg">
                      @include('profile.partials.update-profile-information-form')
                </div>
                <form class="tm-more-button tm-more-button-welcome margin-top-30" method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button class="tm-more-button tm-more-button-welcome margin-top-30"> <link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}</link>
                            </button>
                </form>
                <div class="bg-white p-4 sm:p-8 shadow sm:rounded-lg mt-4">
                    @include('profile.partials.update-password-form')
                </div>
                <div class="bg-white p-4 sm:p-8 shadow sm:rounded-lg mt-4">
                     @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </section>
    
    <footer>
        <div class="tm-black-bg">
            <div class="container text-center">
                <p class="white-text">&copy; 2025 Cafe House. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
    <script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>      <!-- jQuery -->
    <script type="text/javascript" src="js/templatemo-script.js"></script>      <!-- Template Script -->

</body>
</html>
