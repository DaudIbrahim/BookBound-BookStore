<div class="header_top"><!--header_top-->
    <div class="container">
        <div class="row">

            <div class="col-sm-6">
                <div class="social-icons pull-left">
                    <ul class="nav navbar-nav">
                        <li><a href="#" onclick="event.preventDefault()"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#" onclick="event.preventDefault()"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#" onclick="event.preventDefault()"><i class="fa fa-linkedin"></i></a></li>
                        <li><a href="#" onclick="event.preventDefault()"><i class="fa fa-dribbble"></i></a></li>
                        <li><a href="#" onclick="event.preventDefault()"><i class="fa fa-google-plus"></i></a></li>
                    </ul>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="social-icons pull-right">
                    <ul class="nav navbar-nav">

                        {{-- Register/Login --}}
                        @guest
                            <li><a href="{{ route('register') }}"><i class="fa fa-lock"></i> {{ __('Register') }}</a></li>
                            <li><a href="{{ route('login') }}"><i class="fa fa-lock"></i> {{ __('Login') }}</a></li>
                        @endguest

                        {{-- Authenticated --}}
                        @auth
                            @if (Auth::user()->is_admin)
                                <li>
                                    <a href="{{ route('admin.home') }}">
                                        <i class="fa fa-user"></i> {{ Auth::user()->name }} Panel
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a href="{{ '#' }}">
                                        <i class="fa fa-user"></i> {{ Auth::user()->name }}
                                    </a>
                                </li>
                            @endif
                        @endauth

                        {{-- Logout --}}
                        @auth
                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out fa-fw"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>

            

            

        </div>
    </div>
</div><!--/header_top-->