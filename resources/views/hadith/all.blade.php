@include('layouts.header')
    <body class="antialiased">
        @include('layouts.navbar')
        @include('layouts.noto')
        <nav class="grey-nav">
            <h1 class="text-center">الأحاديث النبوية</h1>
            <div aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">الرئيسية</a></li>
                    <li class="breadcrumb-item active"><a href="{{route('categoriesList', 'ar')}}">الأحاديث</a></li>
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
                    @forelse ($FinalHadith as $key => $hadith)
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
                                            <input type="radio" data-bs-toggle="modal" id="ModalSubmit{{$hadith['id']}}" data-bs-target=".modal" data-type="hadith" data-sura="{{$hadith['id']}}"  data-id="{{$hadith['id']}}" data-language="{{$lang}}" data-user="{{ Auth()->user()->id }}" @if (in_array($hadith['id'] ,$arrays)) class="submit-design-btn active" disabled checked data-checked="true" @else class="submit-design-btn" data-cheked="false" @endif/>
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
                        @empty
                        <p class="text-center">  <span class="badge text-bg-danger">لم يتم إضافة تصميمات بعد في هذا القسم</span></p>
                    @endforelse
                    <div class="mt-5">
                        {{$FinalHadith->links('vendor.pagination.bootstrap-5')}}
                    </div>
                </div>
            </div>
        </section>
        <!-- Modal -->
        <div class="modal fade" tabindex="-1" aria-labelledby="platform" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" >
            <div class="modal-content">
                <div class="modal-body d-flex flex-column justify-content-center text-center">
                    <span class="social-platform facebook" data-platform="facebook">Facebook</span>
                    <span class="social-platform whatsapp" data-platform="whatsapp">Whatsapp</span>
                    <span class="social-platform instagram" data-platform="instagram">Instagram</span>
                </div>
            </div>
            </div>
        </div>
        @include('layouts.scripts')
    </body>
</html>


