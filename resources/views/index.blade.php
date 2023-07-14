    @include('layouts.header')
    @include('layouts.navbar')
    <body class="antialiased text-right" dir="rtl">
        <section class="hero">
            <div class="hero-content">
            <h1>منصة التصاميم الدينية</h1>
            <p>تصاميم مختلفه للقران والاحاديث بعدة لغات</p>
            <a href="#mainPage" class="text-white"><i class="fa-solid fa-angles-down"></i></a>
            </div>
        </section>
        <section id="mainPage">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-6 section">
                        <a href="{{route('quranList')}}">القرآن الكريم</a>
                    </div>
                    <div class="col-12 col-md-6 section">
                        <a href="{{route('categoriesList', 'ar')}}">الحديث</a>
                    </div>
                </div>
            </div>
        </section>
        @include('layouts.footer')
        @include('layouts.scripts')
    </body>
</html>

