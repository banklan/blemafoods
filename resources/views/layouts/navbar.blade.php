<nav class="navbar navbar-expand-md navbar-dark shadow-sm" id="gen_nav">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('images/brand/logo.jpg') }}" height="40" alt="logo">
            <span>{{ config('app.name', 'Laravel') }}</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown {{ \Request::is('raw_foodstuffs') ? 'active' : '' }}">
                    <a id="catDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        Categories <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu" aria-labelledby="catDropdown">
                        <a class="dropdown-item" href="{{ route('foodstuff') }}">Raw Food Stuff</a>
                        <a class="dropdown-item" href="{{ route('soup_recipes') }}">Soup Recipes</a>
                        <a class="dropdown-item" href="{{ route('proteins') }}">Fish and Meat</a>
                        <a class="dropdown-item" href="{{ route('fruits_vegs') }}">Fruits & Vegetables</a>
                        <a class="dropdown-item" href="{{ route('herbs_spices') }}">Herbs & Spices</a>
                        <a class="dropdown-item" href="{{ route('coffee_tea') }}">Coffee & Tea</a>
                        <a class="dropdown-item" href="{{ route('drinks') }}">Beverages, Drinks & Water</a>
                        <a class="dropdown-item" href="{{ route('breakfast_cereal') }}">Breakfast & Cereal</a>
                        <a class="dropdown-item" href="{{ route('eggs_dairy') }}">Eggs & Dairy</a>
                        <a class="dropdown-item" href="{{ route('toiletries') }}">Toiletries</a>
                        <a class="dropdown-item" href="{{ route('household') }}">Household items</a>
                        <a class="dropdown-item" href="{{ route('groceries') }}">Groceries & Staples</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
                <li class="nav-item mr-3">
                    <a class="nav-link" href="">Services</a>
                </li>
                <li class="nav-item mr-3">
                    <a class="nav-link" href="#">Special Order</a>
                </li>
                <li class="nav-item mr-3">
                    <a class="nav-link" href="#">Who we are</a>
                </li>
                <li class="nav-item mr-3">
                    <a class="nav-link" href="#">Contact Us</a>
                </li>
                <li class="nav-item mr-3">
                    <a class="nav-link" href="{{ route('cart') }}">My Cart</a>
                </li>

                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
