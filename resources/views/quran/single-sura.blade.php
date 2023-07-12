@include('layouts.header')
    <body class="antialiased">
        @include('layouts.navbar')
        @include('layouts.noto')
        <nav class="grey-nav">
            <h1 class="text-center"> سورة - {{$ArSura[0]->sura_ar_name}}</h1>
            <div aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">الرئيسية</a></li>
                    <li class="breadcrumb-item"><a href="{{route('quranList')}}">القرآن الكريم</a></li>
                </ol>
            </div>
        </nav>
        <section id="ayaList" class="mt-4">
            <div class="container">
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="col-12 col-sm-6">
                            <div class="dropdown-center" >
                                <button dir="rtl" class="btn btn-primary dropdown-toggle languages-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-language mx-2"></i> اللغة
                                </button>
                                <ul class="dropdown-menu languages-menu">
                                    @foreach ($values as $key => $language)
                                        <li><a class="dropdown-item" href="{{route('singleSura', [$keys[$key], $SuraTranslation[0]['sura']])}}">
                                            {{ucfirst($language)}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @forelse ($FinalQuran as $key => $Aya)
                        <div class="col-12">
                            <div class="aya rounded">
                                <p class="aya-ar-name">{{$Aya['arabic_text']}}</p>
                                <p dir="ltr">
                                    {{$Aya['translation']}}
                                </p>
                                @if(Auth::check())
                                    <div class="note_btns d-flex justify-content-between" dir="ltr">
                                        <div class="d-flex align-items-ceeter">
                                            <a class="btn btn-white btn-sm copy_bu copy-element"><span class="d-none">{{$Aya['translation']}}</span><i class="fa-regular fa-copy"></i></a>
                                            <div class="checkbox-wrapper-31">
                                                        <!-- Button trigger modal -->
                                                {{-- <input type="radio" data-bs-toggle="modal" id="ModalSubmit{{$Aya['id']}}" data-target="#platformModal{{$Aya['id']}}" data-type="quran" data-sura="{{$Aya['sura']}}" data-id="{{$Aya['id']}}" data-language="{{$lang}}" data-user="{{ Auth()->user()->id }}" @if (in_array($Aya['id'] ,$arrays)) class="submit-design-btn active" checked data-checked="true" @else class="submit-design-btn" data-cheked="false" @endif/> --}}
                                                <input type="radio" data-bs-toggle="modal" id="ModalSubmit{{$Aya['id']}}" data-bs-target=".modal" data-type="quran" data-sura="{{$Aya['sura']}}" data-id="{{$Aya['id']}}" data-language="{{$lang}}" data-user="{{ Auth()->user()->id }}" @if (in_array($Aya['id'] ,$arrays)) class="submit-design-btn active" checked disabled="true" data-checked="true" @else class="submit-design-btn" data-cheked="false" @endif/>
                                                <svg viewBox="0 0 35.6 35.6">
                                                    <circle class="background" cx="17.8" cy="17.8" r="17.8"></circle>
                                                    <circle class="stroke" cx="17.8" cy="17.8" r="14.37"></circle>
                                                    <polyline class="check" points="11.78 18.12 15.55 22.23 25.17 12.87"></polyline>
                                                </svg>
                                            </div>
                                        </div>
                                        <a class="fancybox" href="{{QuranImageSrc($lang, $Aya['sura'], $Aya['aya'])}}" data-src="{{QuranImageSrc($lang, $Aya['sura'], $Aya['aya'])}}" data-fancybox="gallery{{$Aya['id']}}" data-caption="{{$Aya['translation']}}">
                                            <i class="image fa-regular fa-image"></i>
                                        </a>
                                    </div>
                                @else
                                    <div class="note_btns d-flex justify-content-between" dir="ltr">
                                        <div class="d-flex align-items-center">
                                            <a class="btn btn-white btn-sm copy_bu copy-element"><span class="d-none">{{$Aya['translation']}}</span><i class="fa-regular fa-copy"></i></a>
                                            <a class="btn bg-primary text-white rounded-2" href="{{route('login')}}">Login</a>
                                        </div>
                                        <a class="fancybox" href="{{QuranImageSrc($lang, $Aya['sura'], $Aya['aya'])}}" data-fancybox="gallery{{$Aya['id']}}" data-caption="{{$Aya['translation']}}">
                                            <i class="image fa-regular fa-image"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                    <p class="text-center">  <span class="badge text-bg-danger">لم يتم إضافة تصميمات بعد في هذه السورة</span></p>
                    @endforelse
                    {{-- @if (empty($ImagesFiles))
                            <p class="text-center">التصميميات في هذه اللغة غير متوفرة بعد </p>
                            @else
                    @endif --}}
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


