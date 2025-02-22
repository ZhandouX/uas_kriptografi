<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Delta Cafe - Create QR Code</title>
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
                            <li><a href="{{ route('create-qrcode') }}" class="active">QR Code</a></li>
                            <li><a href="{{ route('contact') }}">Contact</a></li>
                            <li><a href="{{ route('profile.edit') }}">Profile</a></li>
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
                    class="tm-header-line">&nbsp;Create Your&nbsp;&nbsp;<img src="img/header-line.png" alt="Line" 
                    class="tm-header-line"></h2>
                <h2 class="gold-text tm-welcome-header-2">QR Code</h2>
                
                <form method="POST" action="{{ route('store-qrcode') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="ttl" style="color: white; text-align: center;">Nama</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="document_url" class="ttl" style="color: white; text-align: center;">URL Dokumen</label>
                            <input type="url" id="document_url" name="document_url" class="form-control" value="{{ old('document_url', $document_url ?? '') }}" required>
                            @error('document_url')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="tm-more-button tm-more-button-welcome margin-top-30">Confirm</button>
                    </form>
                                        
                    @if(session('qr_code_filename'))
                        <div class="text-center mt-4" style="color: gray;">
                            <h3>QR Code Dokumen:</h3>
                            <img src="{{ asset('storage/' . session('qr_code_filename')) }}" alt="QR Code" class="img-thumbnail">
                            <p><strong>Nama:</strong> {{ session('name') }}</p>
                            <p><strong>URL Dokumen:</strong> <a href="{{ session('document_url') }}" target="_blank">{{ session('document_url') }}</a></p>
                        </div>
                    @endif
                    
                    @if(session('success'))
                        <div class="text-success text-center mt-2">
                            {{ session('success') }}
                        </div>
                    @endif
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