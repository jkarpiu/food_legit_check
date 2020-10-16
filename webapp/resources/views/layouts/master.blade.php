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
    <link rel="shortcut icon" href={{ asset("/img/favicon.png") }} />
    <link rel="apple-touch-icon" sizes="192x192" href={{ asset("/img/favicon.png") }} />
    <link rel="apple-touch-startup-image" href={{ asset("/img/favicon.png") }} />
    <!-- Font Awesome -->
    <!-- <script src="https://kit.fontawesome.com/95a2d2c3f2.js" crossorigin="anonymous"></script> -->
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css"
        integrity="sha512-1cK78a1o+ht2JcaW6g8OXYwqpev9+6GqOkz9xmBN9iUUhIndKtxwILGWYOSibOKjLsEdjyjZvYDq/cZwNeak0w=="
        crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" href={{ asset("/css/style.css") }} />
    <!-- Scripts -->
    <script type="text/javascript" defer src={{ asset("/js/script.js") }}></script>
    @if ($activeSite == 'catalog')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
        integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
        crossorigin="anonymous"></script> --}}
    <script type="text/javascript" defer src="/js/catalog.js"></script>
    @endif
</head>

<body>
    @include('partials.header')

    @yield('content')

    @include('partials.footer')

</body>
{{-- @if ($activeSite == 'catalog')
<script>
    $(document).ready(function () {
        var _token = $('input[name="_token"]').val();
        load_data('', _token);

        functopn load_data(id = "", _token) {
            $.ajax({
                url: "{{ route('loadmore.load_data') }}",
                method: "POST",
                data: {
                    id: id,
                    _token: _token
                },
                success: (data) => {
                    $('.load_more').remove();
                    $('.list-products').append(data);
                }
            })
        }
        $(document).on('click', '#load_more', () => {
            var id = $(this).data('id');
            $('#load_more').html('<b>Loading...</b>');
            load_data(id, _token);
        })
    });

</script>
@endif --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"
    integrity="sha512-A7AYk1fGKX6S2SsHywmPkrnzTZHrgiVT7GcQkLGDe2ev0aWb8zejytzS8wjo7PGEXKqJOrjQ4oORtnimIRZBtw=="
    crossorigin="anonymous"></script>
<script defer>
    AOS.init({
        delay: 200,
        duration: 1200,
        once: false,
    });

</script>

</html>
