<!DOCTYPE html>
<html lang="pl">

<head>
    <!-- Meta tags -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="apple-mobile-web-app-title" content="XXX" />

    <!-- Open Graph -->
    <meta property="og:title" content="XXX" />
    <meta property="og:description" content="" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="" />
    <meta property="og:url" content="" />
    <meta property="og:site_name" content="XXX" />

    <title>Food Legit Check</title>

    <!-- Canonical link -->
    <link rel="canonical" href="" />
    <!-- Favicon -->
    <link rel="shortcut icon" href= {{ asset("/img/favicon.png") }} />
    <link rel="apple-touch-icon" sizes="192x192" href={{ asset("/img/favicon.png") }} />
    <link rel="apple-touch-startup-image" href={{ asset("/img/favicon.png") }} />
    <!-- Font Awesome -->
    <!-- <script src="https://kit.fontawesome.com/95a2d2c3f2.js" crossorigin="anonymous"></script> -->
    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href={{ asset("/css/style.css") }} />
    <!-- Scripts -->
    <script type="text/javascript" defer src={{ asset("/js/script.js") }}></script>
    @if ($activeSite == 'catalog')
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" defer src="/js/filter.js"></script>
    @endif
</head>
@include('partials.header')

@yield('content')

@include('partials.footer')
</html>
