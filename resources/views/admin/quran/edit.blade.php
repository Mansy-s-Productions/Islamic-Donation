<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if ($lang == 'ar')
            {{ __('Edit Aya: '. $TheAya->sura_ar_name) }}
            @else
                {{ __('Edit Aya: '. $TheAya['aya']) }}
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container">
                        @if ($lang == 'ar')
                        <form action="{{route('admin.aya.postEdit', [$lang ,$TheAya->ar_sura_number  ,$TheAya->aya_number])}}" method="POST" enctype="multipart/form-data" >
                            @csrf
                                <div class="mb-6">
                                    <p class="mb-5 border-b p-2 rounded text-right" dir="rtl">
                                        {{old('aya_text') ??  $TheAya->aya_formed_text}}
                                    </p>
                                </div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="user_avatar">Upload file</label>
                                <input name="image" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="user_avatar_help" id="user_avatar" type="file">
                                <a class="mt-3 block fancybox" href="{{asset(QuranImageSrc($lang, $TheAya->ar_sura_number, $TheAya->aya_number))}}" data-fancybox="gallery{{ $TheAya->id}}">
                                    <img width="100" src="{{asset(QuranImageSrc($lang, $TheAya->ar_sura_number, $TheAya->aya_number))}}" alt=""></td>
                                </a>
                                <button type="submit" class="mt-5 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                        </form>
                        @else
                        <form action="{{route('admin.aya.postEdit', [$lang ,$TheAya['sura']  ,$TheAya['aya']])}}" method="POST" enctype="multipart/form-data" >
                            @csrf
                                <div class="mb-6">
                                    <p class="mb-5 border-b p-2 rounded text-right" dir="rtl">
                                        {{old('aya_text') ??  $TheAya['translation']}}
                                    </p>
                                </div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="user_avatar">Upload file</label>
                                <input name="image" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="user_avatar_help" id="user_avatar" type="file">
                                <a class="mt-3 block fancybox" href="{{asset(QuranImageSrc($lang, $TheAya['sura'], $TheAya['aya']))}}" data-fancybox="gallery{{$TheAya['id']}}">
                                    <img width="100" src="{{asset(QuranImageSrc($lang, $TheAya['sura'], $TheAya['aya']))}}" alt=""></td>
                                </a>
                                <button type="submit" class="mt-5 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
