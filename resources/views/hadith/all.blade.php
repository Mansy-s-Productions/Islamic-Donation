@include('layouts.header')
    <body class="antialiased">
        @include('layouts.navbar')
        @include('layouts.noto')
        <nav class="grey-nav">
            <h1 class="text-center">الأحاديث النبوية</h1>
            <div aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{route('home')}}">الأحاديث</a></li>
                    <li class="breadcrumb-item"><a href="{{route('home')}}">الرئيسية</a></li>
                </ol>
            </div>
        </nav>
        <section id="hadithList" class="mt-5" dir="ltr">
            <div class="container">
                <div class="row align-items-center flex-row-reverse flex-wrap">
                    <div class="col-12 col-sm-6">
                        <h2 class="text-start h4">
                            قائمة الأحاديث <i class="fa-solid fa-list"></i>
                        </h2>
                    </div>
                </div>
                <div class="row">
                    @foreach ($AllHadith as $key => $hadith)
                    @if (in_array($hadith['id'], $ImagesFiles))
                    <div class="col-12">
                        <div class="hadith rounded">
                            @if ($lang == 'ar')
                                @else
                                <p class="mb-4">
                                    {{$AllArHadith['data'][$key]['title']}}
                                </p>
                            @endif
                            <p class="mb-4">
                                {{$hadith['title']}}
                            </p>
                            @if(Auth::check())
                                <div class="note_btns d-flex justify-content-between" dir="ltr">
                                    <div class="d-flex align-items-ceeter">
                                        <a class="btn btn-white btn-sm copy_bu copy-element"><span class="d-none">{{$hadith['title']}} </span><i class="fa-regular fa-copy"></i></a>
                                        <div class="checkbox-wrapper-31">
                                            <input type="radio" data-type="hadith" data-id="{{$hadith['id']}}" data-language="{{$lang}}" data-user="{{ Auth()->user()->id }}" @if (in_array($hadith['id'] ,$arrays)) class="submit-design-btn active" checked data-checked="true" @else class="submit-design-btn" data-cheked="false" @endif/>
                                            <svg viewBox="0 0 35.6 35.6">
                                                <circle class="background" cx="17.8" cy="17.8" r="17.8"></circle>
                                                <circle class="stroke" cx="17.8" cy="17.8" r="14.37"></circle>
                                                <polyline class="check" points="11.78 18.12 15.55 22.23 25.17 12.87"></polyline>
                                            </svg>
                                        </div>
                                    </div>
                                    <a class="fancybox" href="{{HadithImageSrc($lang, $hadith['id'])}}" data-src="{{HadithImageSrc($lang, $hadith['id'])}}" data-fancybox="gallery{{$hadith['id']}}" data-caption="{{$hadith['title']}}">
                                        <i class="image fa-regular fa-image"></i>
                                    </a>
                                </div>
                            @else
                                <div class="note_btns d-flex justify-content-between" dir="ltr">
                                    <div class="d-flex align-items-center">
                                        <a class="btn btn-white btn-sm copy_bu copy-element"><span class="d-none">{{$hadith['title']}} </span><i class="fa-regular fa-copy"></i></a>
                                        <a class="btn bg-primary text-white rounded-2" href="{{route('login')}}">Login</a>
                                    </div>
                                    <a class="fancybox" href="{{HadithImageSrc($lang, $hadith['id'])}}" data-fancybox="gallery{{$hadith['id']}}" data-caption="{{$hadith['title']}}">
                                        <i class="image fa-regular fa-image"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif
                    @endforeach
                    <div class="mt-5">
                        {{$AllHadith->links('vendor.pagination.bootstrap-5')}}
                    </div>
                </div>
            </div>
        </section>
        @include('layouts.scripts')
    </body>
</html>


