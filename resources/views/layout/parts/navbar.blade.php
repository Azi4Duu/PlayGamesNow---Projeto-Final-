<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a href="{{route('home')}}" class="logo">
                        <img src="{{asset('assets/images/logo.png')}}" alt="" style="width: 200px;">
                    </a>
                    <!-- ***** Logo End ***** -->
                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                        @auth
                            @php
                                $user = auth()->user();
                                $names = explode(' ', trim($user->name));
                                if(count($names) > 1){
                                    $initials = strtoupper(substr($names[0], 0,1).substr($names[count($names) - 1], 0,1));
                                }
                                else{
                                    $initials = strtoupper(substr($names[0], 0,1));
                                }
                            @endphp
                            <li><a href="{{route('home')}}" @if(Route::is('home')) class="active" @endif>Home</a></li>
                            <li><a href="{{route('games.shop')}}">Our Shop</a></li>
                            <li><a href="#">Contact Us</a></li>
                            @role('customer')
                                <li><a href="{{route('customer.cart.index')}}">Cart</a></li>
                                <li>
                                    <a href="{{route('customer.profile.show')}}" @if(Route::is('customer.profile.*')) class="active" @endif>
                                        {{$initials}}
                                        <i class="fa-regular fa-user"></i>
                                    </a>
                                </li>
                            @endrole
                            @role('admin')
                            <li>
                                <a href="{{route('admin.dashboard.show')}}" @if(Route::is('profile.*')) class="active" @endif>
                                    {{$names[0]}}
                                    <i class="fa-solid fa-crown"></i>
                                </a>
                            </li>
                            @endrole
                            <li>
                                <form action="{{route('logout')}}" method="POST">
                                    @csrf
                                    <button type="submit" class="nav-auth-btn">
                                        Sign out
                                    </button>
                                </form>
                            </li>
                        @endauth
                        @guest
                                <li><a href="{{route('home')}}" @if(Route::is('home')) class="active" @endif>Home</a></li>
                                <li><a href="{{route('games.shop')}}" @if(Route::is('games.*')) class="active" @endif >Our Shop</a></li>
                                <li><a href="#">Contact Us</a></li>
                                <li><a href="{{route('login')}}">Sign In</a></li>
                        @endguest
                    </ul>
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
</header>

