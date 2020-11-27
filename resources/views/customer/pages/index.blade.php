@extends('customer.layout.master')

@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    @include('customer.partials.leftsidebar')
                </div>

                <div class="col-sm-9 padding-right">
                    @include('customer.partials.shop')
                </div>
            </div>
        </div>
    </section>
@endsection

@section('javascript')
    <script>
        var append = @json($append);
        if (document.getElementById('author-' + append.author)) {
            document.getElementById('author-' + append.author).focus();
        }
    </script>
@endsection