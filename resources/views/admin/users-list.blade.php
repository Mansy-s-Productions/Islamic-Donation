<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="">
                        <table class="table table-striped" id="myTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="px-6 py-3">#</th>
                                    <th scope="col" class="px-6 py-3">اﻹسم</th>
                                    <th scope="col" class="px-6 py-3">البريد الألكتروني</th>
                                    <th scope="col" class="px-6 py-3">الحالة</th>
                                    <th scope="col" class="px-6 py-3">تعديل</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($AllUsers as $key => $User)
                                    <tr>
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$key+1}}</th>
                                        <td class="px-6 py-4">{{$User->name}}</td>
                                        <td class="px-6 py-4">{{$User->email}}</td>
                                        <td class="px-6 py-4">@if ($User->UserStatus == true)
                                            <span class="">نشط <span class="bg-success d-inline-block h-25 p-1 rounded text-white"></span></span>
                                            @else
                                            <span>غير نشط <span class="bg-danger d-inline-block h-25 p-1 rounded text-white"></span></span>
                                        @endif</td>
                                        <td class="px-6 py-4">
                                            <a href="{{route('userEdit', $User->id)}}"><i class="fa-regular fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('components.data-tables')

</x-app-layout>
