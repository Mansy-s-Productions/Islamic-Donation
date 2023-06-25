<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All Languages') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="table w-full text-left text-gray-500 dark:text-gray-400" id="myTable">
                        <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">#</th>
                                <th scope="col" class="px-6 py-3">اﻹسم</th>
                                <th scope="col" class="px-6 py-3">الكود</th>
                                <th scope="col" class="px-6 py-3">الترتيب</th>
                                <th scope="col" class="px-6 py-3">تعديل</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($AllLanguages as $key => $Lang)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$key+1}}</th>
                                    <td class="px-6 py-4">{{$Lang->lang_name}}</td>
                                    <td class="px-6 py-4">{{$Lang->lang_code}}</td>
                                    <td class="px-6 py-4">{{$Lang->order}}</td>
                                    <td class="px-6 py-4">
                                        <button id="dropdownMenuIconButton" data-dropdown-toggle="dropdownDots" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600" type="button">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </button>
                                        <!-- Dropdown menu -->
                                        <div id="dropdownDots" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownMenuIconButton">
                                            <li>
                                                <a href="{{route('admin.languages.getEdit', $Lang->id)}}" class="block px-4 py-2 hover:bg-green-500 hover:text-white dark:hover:bg-gray-600 dark:hover:text-white"><i class="fa-regular fa-eye"></i> Edit</a>
                                            </li>
                                            <li>
                                                <a href="{{route('admin.languages.delete', $Lang->id)}}" class="block px-4 py-2 hover:bg-red-500 hover:text-white  dark:hover:bg-gray-600 dark:hover:text-white"><i class="fa-solid fa-trash"></i> Delete</a>
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

</x-app-layout>
