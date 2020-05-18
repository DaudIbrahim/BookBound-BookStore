@extends('customer.layout.master')

@section('content')
<section id="form"><!--form-->
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-sm-offset-1">
                <div class="signup-form">
                    <h2>New User Signup!</h2>

                    {{-- Work with Form --}}
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        {{-- Name --}}
                        <input id="name" placeholder="Full Name" type="text"name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <p><small style="color:red">{{ $message }}</small></p>
                        @enderror

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
                        
                        {{-- Password Confirm --}}
                        <input id="password-confirm" placeholder="Confirm Password" type="password" name="password_confirmation" required autocomplete="new-password">

                        {{-- Button --}}
                        <button type="submit" class="btn btn-primary">
                            {{ __('Create Account') }}
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