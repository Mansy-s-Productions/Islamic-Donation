@include('layouts.header')
@include('layouts.navbar')
<body class="antialiased text-right" dir="rtl">
    <section id="suraList">
        <nav class="grey-nav">
            <h1 class="text-center">القرآن الكريم</h1>
            <div aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">الرئيسية</a></li>
                    <li class="breadcrumb-item"><a href="{{route('quranList')}}">القرآن الكريم</a></li>
                </ol>
            </div>
        </nav>
        <div class="container mt-4">
            <div class="row">
                @foreach ($AllSuras as $Sura)
                <div class="col-12 col-md-4">
                    <a href="{{route('singleSura', ['en',$Sura->id])}}" class="sura">
                            {{$Sura->sura_name}}
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @include('layouts.footer')
    @include('layouts.scripts')
</body>
</html>
