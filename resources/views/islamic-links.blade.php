@include('layouts.header')
@include('layouts.navbar')
<body class="antialiased text-right" dir="rtl">
    <section class="hero bayan-islam">
        <div class="hero-content">
            <h1>بيان الإسلام للمسلمين وغير المسلمين</h1>
            <p>مصادر مختلفه لمعرفة الإسلام للمسلمين وغير المسلمين</p>
            <a class="arrow" href="#mainPage" class="text-white"><i class="fa-solid fa-angles-down"></i></a>
        </div>
    </section>
    <section id="mainPage">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-6 col-md-3 section">
                    <a href="https://byenah.com/ar/language-select"  target="_blank">كن داعيا للإسلام بلغات العالم </a>
                </div>
                <div class="col-12 col-sm-6 col-md-3 section">
                    <a href="https://byenah.com/ar/discover-islam-languages" target="_blank">عرّف بالإسلام بلغات العالم</a>
                </div>
                <div class="col-12 col-sm-12 col-md-3 section">
                    <a href="https://byenah.com/ar/muslims" target="_blank">مسلم</a>
                </div>
                <div class="col-12 col-sm-12 col-md-3 section">
                    <a href="https://byenah.com/ar/discover-islam" target="_blank">غير مسلم</a>
                </div>
            </div>
        </div>
    </section>
    @include('layouts.footer')
    @include('layouts.scripts')
</body>
</html>

