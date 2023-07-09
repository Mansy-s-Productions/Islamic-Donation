<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-right">
            {{ __('الأحاديث النبوية') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-2 md:grid-cols-2 gap-4">
                        <div class="pb-4 bg-white dark:bg-gray-900">
                            <select id="categories" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected>القسم</option>
                                @foreach ($AllCategories as $category)
                                    <option @if ($category['id'] == $category_id) selected @endif value="{{$category['id']}}">
                                        {{$category['title']}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="pb-4 bg-white dark:bg-gray-900">
                                <select id="languages" class="float-end bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected>اللغة</option>
                                    @foreach ($AllLanguages as $language)
                                        <option @if ($language['code'] == $lang) selected @endif value="{{$language['code']}}">
                                            {{$language['native']}}
                                        </option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <table class="table w-full text-left text-gray-500 dark:text-gray-400" id="myTable">
                        <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="row" class="px-6 py-4 font-medium text-xl text-gray-900 whitespace-nowrap dark:text-white">#</th>
                                <th scope="row" class="px-6 py-4 font-medium text-xl text-gray-900 whitespace-nowrap dark:text-white">رقم الحديث</th>
                                @if ($lang == 'ar')
                                    @else
                                <th scope="row" class="px-6 py-4 font-medium text-xl text-gray-900 whitespace-nowrap dark:text-white">النص</th>
                                @endif
                                <th scope="row" class="px-6 py-4 font-medium text-xl text-gray-900 whitespace-nowrap dark:text-white">النص بالعربية</th>
                                <th scope="row" class="px-6 py-4 font-medium text-xl text-gray-900 whitespace-nowrap dark:text-white">التصميم</th>
                                <th scope="row" class="px-6 py-4 font-medium text-xl text-gray-900 whitespace-nowrap dark:text-white">تعديل</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($AllHadith as $key => $hadith)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" class="px-6 py-4">{{$key+1}}</th>
                                    <th scope="row" class="px-6 py-4">{{$hadith['id']}}</th>
                                    @if ($lang == 'ar')
                                    @else
                                    <th scope="row" class="px-6 py-4">{{$hadith['title']}}</th>
                                    @endif
                                    <td class="px-6 py-4" dir="rtl">{{$AllArHadith['data'][$key]['title']}}</td>
                                    <td class="px-6 py-4">
                                        <a class="fancybox" href="{{HadithImageSrc($lang, $hadith['id'])}}" data-fancybox="gallery{{$hadith['id']}}">
                                            <img width="100" class="lazy" data-src="{{HadithImageSrc($lang, $hadith['id'])}}" alt=""></td>
                                        </a>
                                    <td class="px-6 py-4">
                                        <a href="{{route('admin.hadith.getEdit', [$hadith['id'], $lang])}}"><i class="fa-regular fa-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                var url = $(this).val(); // get selected value
                if (url) { // require a URL
                    console.log(url);
                    window.location = url; // redirect
                }
                return false;
            });
            $('#categories').on('change', function () {
                var url = $(this).val(); // get selected value
                if (url) { // require a URL
                    console.log(url);
                    window.location = url; // redirect
                }
                return false;
            });
        });
        });
    </script>
@endpush
</x-app-layout>
