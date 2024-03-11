<button id="scroll-to-top" class=""><i class="fa-solid fa-angle-up"></i></button>
<div class="sharethis-sticky-share-buttons"></div>
<nav class="main-navbar navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ url('public/img/logo.png') }}" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa-solid fa-bars-staggered"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="{{ request()->is('/') ? 'active' : '' }} nav-link"
                        aria-current="page">الرئيسية</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('quranList') }}"
                        class="{{ request()->is('quran') ? 'active' : '' }} nav-link" aria-current="page">القرآن
                        الكريم</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('categoriesList', 'ar') }}"
                        class="nav-link"
                        aria-current="page">الحديث</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('islamicLinks') }}"
                        class="{{ request()->is('islamicLinks') ? 'active' : '' }} nav-link"
                        aria-current="page">بيان الإسلام</a>
                </li>
                <li>
                    <div class="login-buttons second-login-btn">
                        @if (Auth::check())
                            <!-- Authentication -->
                            <x-responsive-nav-link :href="route('logout')" class="login-btn">
                                <i class="login-icon fa-solid fa-arrow-right-to-bracket"></i> {{ __('تسجيل الخروج') }}
                            </x-responsive-nav-link>
                        @else
                            <x-responsive-nav-link :href="route('login')" class="login-btn">
                                <i class="login-icon fa-solid fa-arrow-right-to-bracket"></i> {{ __('تسجيل الدخول') }}
                            </x-responsive-nav-link>
                        @endif
                    </div>
                </li>
            </ul>
        </div>
        <div class="login-buttons main-login-btn">
            @if (Auth::check())
                <!-- Authentication -->
                <x-responsive-nav-link :href="route('logout')" class="login-btn">
                    <i class="login-icon fa-solid fa-arrow-right-to-bracket"></i> {{ __('تسجيل الخروج') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('login')" class="login-btn">
                    <i class="login-icon fa-solid fa-arrow-right-to-bracket"></i> {{ __('تسجيل الدخول') }}
                </x-responsive-nav-link>
            @endif
        </div>
    </div>
</nav>
