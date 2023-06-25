<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-right" dir="rtl">
            {{ __('كل السور: '. $suraKey) }}
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
                    <table class="table w-full text-left text-gray-500 dark:text-gray-400" id="myTable">
                        <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="row" class="px-6 py-4 font-medium text-xl text-gray-900 whitespace-nowrap dark:text-white">#</th>
                                <th scope="row" class="px-6 py-4 font-medium text-xl text-gray-900 whitespace-nowrap dark:text-white">إسم السورة</th>
                                <th scope="row" class="px-6 py-4 font-medium text-xl text-gray-900 whitespace-nowrap dark:text-white">تعديل</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($AllSura as $key => $Aya)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" class="px-6 py-4">{{$key+1}}</th>
                                    <td class="px-6 py-4">{{$Aya->sura_name}}</td>
                                    <td class="px-6 py-4">
                                        <a href="{{route('admin.sura.getEdit', [$lang, $Aya->id, $suraKey])}}"><i class="fa-regular fa-pen-to-square"></i></a>
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
                // var url = $(this).val(); // get selected value
                var lang =  $(this).find(":selected").data('lang'); // en
                var key =  $(this).find(":selected").data('key'); // english_rwwad
                    window.location.href = "{{URL::to('dashboard/quran/')}}"+'/'+lang+'/'+key;
            });
        });
        });
    </script>
@endpush
</x-app-layout>
