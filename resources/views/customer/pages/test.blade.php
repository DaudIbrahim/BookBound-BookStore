@extends('customer.layout.master')

@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <h1>test.blade.php</h1>
                    {{-- @include('customer.partials.leftsidebar') --}}
                </div>
                <div class="col-sm-9 padding-right">
                    {{-- @include('customer.partials.primary') --}}
                </div>
            </div>
        </div>
    </section>
@endsection


@section('javascript')
    <script>
        (function() {
            
        })();
    </script>
@endsection