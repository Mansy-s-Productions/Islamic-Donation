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
                    <div class="pb-4 bg-white dark:bg-gray-900 flex justify-end">
                            <select id="languages" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected>اللغة</option>
                                @foreach ($AllLanguages as $language)
                                    <option @if ($language->lang_code == $lang) selected @endif value="{{$language->lang_code}}">
                                        {{$language->lang_name}}
                                    </option>
                                @endforeach
                            </select>
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
                                        <button id="dropdownMenuIconButton" data-dropdown-toggle="dropdownDots{{$hadith['id']}}" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600" type="button">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </button>
                                        <!-- Dropdown menu -->
                                        <div id="dropdownDots{{$hadith['id']}}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownMenuIconButton">
                                            <li>
                                                <a href="{{route('admin.hadith.getEdit', [$hadith['id'], $lang])}}" class="block px-4 py-2 hover:bg-green-500 hover:text-white dark:hover:bg-gray-600 dark:hover:text-white"><i class="fa-regular fa-eye"></i> Edit</a>
                                            </li>
                                            <li>
                                                <a href="{{route('admin.hadith.delete', [$hadith['id'], $lang])}}" class="block px-4 py-2 hover:bg-red-500 hover:text-white  dark:hover:bg-gray-600 dark:hover:text-white"><i class="fa-solid fa-trash"></i> Delete</a>
                                            </li>
                                            </ul>
                                        </div>
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
        });
        });
    </script>
@endpush
</x-app-layout>
