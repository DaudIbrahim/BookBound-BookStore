@extends('admin.layout.master')

@section('page-header')
  Test Page Ready <small>Divided in 3 very simple Sections</small>
@endsection

@section('content')
<div class="row">
  <div class="col-md-12">

     <div class="card">      
        <div class="card-action">
           Empty Page
        </div>

        <div class="card-content">
           <p>
              Lorem ipsum dolcivita sit amet,
           </p>
        </div>

        <div class="clearBoth"><br/></div>
     </div>
  </div>
</div>
@endsection

@section('javascript')
  <script>
      (function() {
         console.log('READY');
      })();
  </script>
@endsection
