<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-right">
            {{ __('سورة'. $ArSura[0]->sura_ar_name) }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="pb-4 bg-white dark:bg-gray-900 flex justify-end">
                        <select id="languages" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected>اللغة</option>
                            <option @if ($suraKey == 'arabic')  selected @endif value="ar" data-lang="ar" data-key="arabic">
                                العربية
                            </option>
                            @foreach ($AllLanguages['translations'] as $language)
                                <option @if ($language['key'] == $suraKey) selected @endif value="{{$language['key']}}" data-lang="{{$language['language_iso_code']}}" data-key="{{$language['key']}}">
                                    {{$language['key']}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @if (isset($TheSura))
                    <table class="table w-full text-left text-gray-500 dark:text-gray-400" id="myTable">
                        <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="row" class="px-6 py-4 font-medium text-xl text-gray-900 whitespace-nowrap dark:text-white">#</th>
                                <th scope="row" class="px-6 py-4 font-medium text-xl text-gray-900 whitespace-nowrap dark:text-white">النص</th>
                                @if ($lang == 'ar')
                                @else
                                <th scope="row" class="px-6 py-4 font-medium text-xl text-gray-900 whitespace-nowrap dark:text-white">النص مترجم</th>
                                @endif
                                <th scope="row" class="px-6 py-4 font-medium text-xl text-gray-900 whitespace-nowrap dark:text-white">التصميم</th>
                                <th scope="row" class="px-6 py-4 font-medium text-xl text-gray-900 whitespace-nowrap dark:text-white">تعديل</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ArSura as $key => $Aya)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$Aya->aya_number}}</th>
                                <td class="px-6 py-4">{{$Aya->AyaOriginalText}}</td>
                                @if ($lang == 'ar')
                                @else
                                    <th scope="row" class="px-6 py-4">{{$TheSura['result'][$key]['translation']}}</th>
                                @endif
                                <td class="px-6 py-4">
                                    <a class="fancybox" href="{{QuranImageSrc($lang, $Aya->id)}}" data-fancybox="gallery{{$Aya->id}}">
                                        <img width="100" src="{{QuranImageSrc($lang, $Aya->id)}}" alt=""></td>
                                    </a>
                                <td class="px-6 py-4">
                                    <a href="{{route('admin.aya.getEdit', [$lang ,$suraKey ,$TheSura['result'][0]['sura'] , $Aya->id])}}"><i class="fa-regular fa-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @else
                    <table class="table w-full text-left text-gray-500 dark:text-gray-400" id="myTable">
                        <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="row" class="px-6 py-4 font-medium text-xl text-gray-900 whitespace-nowrap dark:text-white">#</th>
                                <th scope="row" class="px-6 py-4 font-medium text-xl text-gray-900 whitespace-nowrap dark:text-white">النص</th>
                                <th scope="row" class="px-6 py-4 font-medium text-xl text-gray-900 whitespace-nowrap dark:text-white">التصميم</th>
                                <th scope="row" class="px-6 py-4 font-medium text-xl text-gray-900 whitespace-nowrap dark:text-white">تعديل</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ArSura as $key => $Aya)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$Aya->aya_number}}</th>
                                <td class="px-6 py-4">{{$Aya->AyaOriginalText}}</td>
                                <td class="px-6 py-4">
                                    <a class="fancybox" href="{{QuranImageSrc($lang, $Aya->id)}}" data-fancybox="gallery{{$Aya->id}}">
                                        <img width="100" src="{{QuranImageSrc($lang, $Aya->id)}}" alt=""></td>
                                    </a>
                                <td class="px-6 py-4">
                                    <a href="{{route('admin.aya.getEdit', [$lang ,$suraKey ,$Aya->ar_sura_number , $Aya->id])}}"><i class="fa-regular fa-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

@include('components.data-tables')
@push('other-scripts')
    <script>
        $(document).ready(function() {
            $(function(){
            $('#languages').on('change', function () {
                // var url = $(this).val(); // get selected value
                var lang =  $(this).find(":selected").data('lang'); // en
                var key =  $(this).find(":selected").data('key'); // english_rwwad
                var id =  '{!! $ArSura[0]->ar_sura_number !!}'; // sura id
                if(lang == 'ar'){
                    window.location.href = "{{URL::to('dashboard/quran/sura/ar')}}"+'/'+id+'/arabic';
                }else{
                    window.location.href = "{{URL::to('dashboard/quran/sura/')}}"+'/'+lang+'/'+id+'/'+key;
                }
            });
        });
        });
    </script>
@endpush
</x-app-layout>


