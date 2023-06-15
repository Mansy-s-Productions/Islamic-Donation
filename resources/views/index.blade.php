    @include('layouts.header')
    @include('layouts.navbar')
    <body class="antialiased text-right" dir="rtl">
        <section id="mainPage">
            <div class="container">
                <div class="row">
                    <div class="col-6 section">
                        <a href="{{route('quranList')}}">القرآن الكريم</a>
                    </div>
                    <div class="col-6 section">
                        <a href="{{route('hadithList')}}">الحديث</a>
                    </div>
                </div>
            </div>
        </section>
        @include('layouts.scripts')
    </body>
</html>

