@extends('customer.layout.master')

@section('content')
<section id="form"><!--form-->
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-sm-offset-1">
                <div class="signup-form">
                    <h2>Login to your Account!</h2>

                    {{-- Work with Form --}}
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Email --}}
                        <input id="email" placeholder="Email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                            <p><small style="color:red">{{ $message }}</small></p>
                        @enderror

                        {{-- Password --}}
                        <input id="password" placeholder="Password" type="password" name="password" required autocomplete="new-password">
                        @error('password')
                            <p><small style="color:red">{{ $message }}</small></p>
                        @enderror
                        
                        {{-- Button --}}
                        <button type="submit" class="btn btn-primary">
                            {{ __('Login') }}
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section><!--/form-->
@endsection

@section('javascript')
    <script>
        (function() {
            
        })();
    </script>
@endsection