@include('layouts.header')
    <body class="antialiased">
        @include('layouts.navbar')
        @include('layouts.noto')
        <nav class="grey-nav">
            <h1 class="text-center">الأحاديث النبوية</h1>
            <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">الحديث</li>
                    <li class="breadcrumb-item"><a href="{{route('home')}}">الرئيسية</a></li>
                </ol>
            </div>
        </nav>
        <section id="hadithList" dir="ltr">
            <div class="container">
                <div class="row">
                    @foreach ($AllHadith as $key => $hadith)
                    <div class="col-12">
                        <div class="hadith rounded">
                            <p class="mb-4">
                                {{$hadith->title}}
                            </p>
                            @if(Auth::check())
                                <div class="note_btns d-flex justify-content-between" dir="ltr">
                                    <div class="d-flex align-items-ceeter">
                                        <a class="btn btn-white btn-sm copy_bu copy-element"><span class="d-none">{{$hadith->title}} &nbsp; {{$hadith->link}} </span><i class="fa-regular fa-copy"></i></a>
                                        <div class="checkbox-wrapper-31">
                                            <input type="radio" data-type="hadith" data-id="{{$hadith->id}}" data-user="{{ Auth()->user()->id }}" @if (in_array($hadith->id ,$arrays)) class="submit-design-btn active" checked data-checked="true" @else class="submit-design-btn" data-cheked="false" @endif/>
                                            <svg viewBox="0 0 35.6 35.6">
                                                <circle class="background" cx="17.8" cy="17.8" r="17.8"></circle>
                                                <circle class="stroke" cx="17.8" cy="17.8" r="14.37"></circle>
                                                <polyline class="check" points="11.78 18.12 15.55 22.23 25.17 12.87"></polyline>
                                            </svg>
                                        </div>
                                    </div>
                                    <a class="fancybox" href="{{$hadith->getHadithImageAttribute($lang)}}" data-src="{{$hadith->getHadithImageAttribute($lang)}}" data-fancybox="gallery" data-caption="{{$hadith->title}}">
                                        <i class="image fa-regular fa-image"></i>
                                    </a>
                                </div>
                            @else
                                <div class="note_btns d-flex justify-content-between" dir="ltr">
                                    <div class="d-flex align-items-center">
                                        <a class="btn btn-white btn-sm copy_bu copy-element"><span class="d-none">{{$hadith->hadith_text}} &nbsp; {{$hadith->link}} </span><i class="fa-regular fa-copy"></i></a>
                                        <a class="btn bg-primary text-white rounded-2" href="{{route('login')}}">Login</a>
                                    </div>
                                    <a class="fancybox" href="{{$hadith->getHadithImageAttribute($lang)}}" data-fancybox="gallery" data-caption="{{$Aya->aya_text}}">
                                        <i class="image fa-regular fa-image"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    <div class="mt-5">
                        {{$AllHadith->links('vendor.pagination.simple-tailwind')}}
                    </div>
                </div>
            </div>
        </section>
        @include('layouts.scripts')
    </body>
</html>


