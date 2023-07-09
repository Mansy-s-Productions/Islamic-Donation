<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight" dir="rtl">
            تقرير عن المتطوع:  <span class="text-red-500">{{$UserDesigns[0]->User->name}}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="table w-full text-left text-gray-500 dark:text-gray-400" id="myTable">
                        <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="row" class="px-6 py-4 font-medium text-xl text-gray-900 whitespace-nowrap dark:text-white">#</th>
                                <th scope="row" class="px-6 py-4 font-medium text-xl text-gray-900 whitespace-nowrap dark:text-white">القسم</th>
                                <th scope="row" class="px-6 py-4 font-medium text-xl text-gray-900 whitespace-nowrap dark:text-white">السورة</th>
                                <th scope="row" class="px-6 py-4 font-medium text-xl text-gray-900 whitespace-nowrap dark:text-white">اللغة</th>
                                <th scope="row" class="px-6 py-4 font-medium text-xl text-gray-900 whitespace-nowrap dark:text-white">الرقم</th>
                                <th scope="row" class="px-6 py-4 font-medium text-xl text-gray-900 whitespace-nowrap dark:text-white">المنصه</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($UserDesigns as $key => $User)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" class="px-6 py-4">{{$key+1}}</th>
                                    <td class="px-6 py-4">
                                        @if ($User->type == 'quran')
                                        <span class="badge text-bg-info">قرآن</span>
                                        @else
                                        <span class="badge text-bg-warning">حديث</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($User->type == 'quran')
                                        <span class="">{{$User->Quran->sura_ar_name}}</span>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">{{$User->lang}}</td>
                                    <td class="px-6 py-4">{{$User->design_id}}</td>
                                    <td class="px-6 py-4">
                                        @if ($User->platform == 'whatsapp')
                                            <span class="badge text-bg-success">Whatsapp</span>
                                        @elseif ($User->platform == 'facebook')
                                        <span class="badge text-bg-primary">Facebook</span>
                                        @elseif ($User->platform == 'instagram')
                                        <span class="badge text-bg-danger">Instagram</span>
                                        @endif
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
</x-app-layout>
