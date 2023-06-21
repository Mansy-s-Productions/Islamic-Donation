<nav class="main-navbar navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ url('public/img/islamhouse.com-logo.png') }}" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="{{ request()->is('/') ? 'active' : '' }} nav-link"
                        aria-current="page">الرئيسية</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('quranList') }}"
                        class="{{ request()->is('quranList') ? 'active' : '' }} nav-link" aria-current="page">القرآن
                        الكريم</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('categoriesList', 'ar') }}"
                        class="{{ request()->is('categoriesList') ? 'active' : '' }} nav-link"
                        aria-current="page">الحديث</a>
                </li>
            </ul>
        </div>
        <div class="login-buttons">
            @if (Auth::check())
                <!-- Authentication -->
                <x-responsive-nav-link :href="route('logout')" class="login-btn">
                    <i class="login-icon fa-solid fa-arrow-right-to-bracket"></i> {{ __('تسجيل الخروج') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('login')" class="login-btn">
                    <i class="login-icon fa-solid fa-arrow-right-to-bracket"></i> {{ __('تسجيل الدخول') }}
                </x-responsive-nav-link>
                {{-- <a class="nav-link" href="{{route('login')}}"><i class="fa-solid fa-arrow-right-to-bracket"></i>  تسجيل الدخول  </a> --}}
            @endif
        </div>
    </div>
</nav>
