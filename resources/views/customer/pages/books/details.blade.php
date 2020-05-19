@extends('customer.layout.master')

@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-1">{{-- positioning --}}</div>

                <div class="col-sm-9 padding-right">
                    @include('customer.partials.productdetails')
                </div>

                <div class="col-sm-2">{{-- positioning --}}</div>
            </div>
        </div>
    </section>
@endsection

@section('javascript')
    <script>
        
    </script>
@endsection