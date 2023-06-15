@include('layouts.header')
    <body class="antialiased">
        @include('layouts.navbar')
        @include('layouts.noto')
        <nav class="grey-nav">
            <h1 class="text-center">سورة - {{$AllArAya[0]->sura_ar_name}}</h1>
            <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">{{$AllArAya[0]->sura_ar_name}}</li>
                    <li class="breadcrumb-item"><a href="{{route('quranList')}}">القرآن الكريم</a></li>
                <li class="breadcrumb-item"><a href="{{route('home')}}">الرئيسية</a></li>
                </ol>
            </div>
        </nav>
        <section id="ayaList">
            <div class="container">
                <div class="row">
                    @foreach ($AllAya as $key => $Aya)
                    <div class="col-12">
                        <div class="aya rounded">
                            <p class="aya-ar-name">{{$AllArAya[$key]->aya_text}}</p>
                            <p>
                                {{$Aya->aya_text}}
                            </p>
                            @if(Auth::check())
                                <div class="note_btns d-flex justify-content-between" dir="ltr">
                                    <div class="d-flex align-items-ceeter">
                                        <a class="btn btn-white btn-sm copy_bu copy-element"><span class="d-none">{{$Aya->aya_text}}</span><i class="fa-regular fa-copy"></i></a>
                                        <div class="checkbox-wrapper-31">
                                            <input type="radio" data-type="quran" data-id="{{$Aya->id}}" data-user="{{ Auth()->user()->id }}" @if (in_array($Aya->id ,$arrays)) class="submit-design-btn active" checked data-checked="true" @else class="submit-design-btn" data-cheked="false" @endif/>
                                            <svg viewBox="0 0 35.6 35.6">
                                                <circle class="background" cx="17.8" cy="17.8" r="17.8"></circle>
                                                <circle class="stroke" cx="17.8" cy="17.8" r="14.37"></circle>
                                                <polyline class="check" points="11.78 18.12 15.55 22.23 25.17 12.87"></polyline>
                                            </svg>
                                        </div>
                                    </div>
                                    <a class="fancybox" href="{{$Aya->AyaImage}}" data-src="{{$Aya->AyaImage}}" data-fancybox="gallery" data-caption="{{$Aya->aya_text}}">
                                        <i class="image fa-regular fa-image"></i>
                                    </a>
                                </div>
                            @else
                            <div class="note_btns d-flex justify-content-between" dir="ltr">
                                <div class="d-flex align-items-center">
                                    <a class="btn btn-white btn-sm copy_bu copy-element"><span class="d-none">{{$Aya->aya_text}}</span><i class="fa-regular fa-copy"></i></a>
                                    <a class="btn bg-primary text-white rounded-2" href="{{route('login')}}">Login</a>
                                </div>
                                <a class="fancybox" href="{{$Aya->AyaImage}}" data-fancybox="gallery" data-caption="{{$Aya->aya_text}}">
                                    <i class="image fa-regular fa-image"></i>
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="Modal-{{$Aya->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">تفاصيل اﻻية</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img src="{{$Aya->AyaImage}}" alt="">
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                            <a href="{{$Aya->AyaImage}}" download type="button" class="btn btn-primary">تحميل الصوره</a>
                            </div>
                        </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        @include('layouts.scripts')

    </body>
</html>


