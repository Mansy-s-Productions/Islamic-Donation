<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users list') }}
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
                                <th scope="row" class="px-6 py-4 font-medium text-xl text-gray-900 whitespace-nowrap dark:text-white">إسم المتطوع</th>
                                <th scope="row" class="px-6 py-4 font-medium text-xl text-gray-900 whitespace-nowrap dark:text-white">البريد الألكتروني</th>
                                <th scope="row" class="px-6 py-4 font-medium text-xl text-gray-900 whitespace-nowrap dark:text-white">التصاميم المنشورة</th>
                                <th scope="row" class="px-6 py-4 font-medium text-xl text-gray-900 whitespace-nowrap dark:text-white">تقرير</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($AllUsers as $key => $User)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" class="px-6">{{$key+1}}</th>
                                    <td class="px-6 py-4">{{$User->name}}</td>
                                    <td class="px-6 py-4">{{$User->email}}</td>
                                    <td class="px-6 py-4">{{count($User->UserSubmits)}}</td>
                                    <td class="px-6 py-4">
                                        @if (count($User->UserSubmits))
                                            <a href="{{route('userReport.get', $User->id)}}"><i class="fa-regular fa-eye"></i></a>
                                            @else
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
