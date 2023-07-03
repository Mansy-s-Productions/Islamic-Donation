@include('layouts.header')
@include('layouts.navbar')
<body class="antialiased text-right" dir="rtl">
    <section id="suraList">
        <div class="container">
            <div class="row">
                @foreach ($AllSuras as $Sura)
                <div class="col-3">
                    <div class="sura">
                        <a href="{{route('singleSura', ['en',$Sura->id])}}">
                            {{$Sura->sura_name}}
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @include('layouts.scripts')
</body>
</html>
