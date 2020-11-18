    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
        
    @if (route::is('checkout.index'))
        <title>Stripe</title>
    @endif
    <script src="https://js.stripe.com/v3/"></script>
    <link href="{{ asset('css/stripe.css') }}" rel="stylesheet">

    <title>Book Bound</title>
    <link href="{{ asset('assets/customer') }}/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('assets/customer') }}/assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ asset('assets/customer') }}/assets/css/prettyPhoto.css" rel="stylesheet">
    <link href="{{ asset('assets/customer') }}/assets/css/price-range.css" rel="stylesheet">
    <link href="{{ asset('assets/customer') }}/assets/css/animate.css" rel="stylesheet">
	<link href="{{ asset('assets/customer') }}/assets/css/main.css" rel="stylesheet">
	<link href="{{ asset('assets/customer') }}/assets/css/responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    {{-- <link rel="shortcut icon" href="{{ asset('assets/customer') }}/assets/images/ico/favicon.ico"> --}}
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('assets/customer') }}/assets/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('assets/customer') }}/assets/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('assets/customer') }}/assets/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('assets/customer') }}/assets/images/ico/apple-touch-icon-57-precomposed.png">