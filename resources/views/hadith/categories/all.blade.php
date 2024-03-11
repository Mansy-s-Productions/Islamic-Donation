@include('layouts.header')
    <body class="antialiased">
        @include('layouts.navbar')
        @include('layouts.noto')
        <nav class="grey-nav">
            <h1 class="text-center">الأحاديث النبوية</h1>
            <div aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-black" href="{{route('home')}}">الرئيسية</a></li>
                    <li class="breadcrumb-item">الأحادبث</li>
                    <li class="breadcrumb-item active">الأقسام</li>
                </ol>
            </div>
        </nav>
        <section id="categoriesList" class="mt-5" dir="ltr">
            <div class="container">
                <div class="row align-items-center flex-row-reverse flex-wrap">
                    <div class="col-12 col-sm-6">
                        <h2 class="text-start h4">
                            الأقسام الرئيسية <i class="fa-solid fa-list"></i>
                        </h2>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="dropdown-center" >
                            <button dir="rtl" class="btn btn-primary dropdown-toggle languages-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-language mx-2"></i> اللغة
                            </button>
                            <ul class="dropdown-menu languages-menu">
                                @foreach (LanguagesLIst() as $language)
                                    <li><a class="dropdown-item " href="{{route('categoriesList', $language->code)}}">{{$language->native}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    @foreach ($AllCategories as $key => $category)
                        <div class="col-12 col-md-4">
                            <div class="category">
                                <a href="{{route('hadithList', [$lang, $category->id])}}"> {{ $category->title}} ({{ $category->hadeeths_count}}) </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @include('layouts.footer')

        @include('layouts.scripts')
    </body>
</html>


