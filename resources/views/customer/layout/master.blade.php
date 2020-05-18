<!DOCTYPE html>
<html lang="en">
<head>
    @include('customer.partials.head')
</head>
<body>
    <header id="header"><!--header-->
        @include('customer.partials.headertop')
        @include('customer.partials.headermiddle')
        @include('customer.partials.headerbottom')
    </header>

    @yield('content')
    {{-- Example --}}
    {{-- <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    @include('customer.partials.leftsidebar')
                </div>
                <div class="col-sm-9 padding-right">
                    @include('customer.partials.primary')
                </div>
            </div>
        </div>
    </section> --}}

    @include('customer.partials.footer')
    @include('customer.partials.scripts')
</body>
</html>