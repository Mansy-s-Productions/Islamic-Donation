<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User edit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-5 text-4xl font-bold dark:text-white">Edit: <span class="text-red-500">{{$TheUser->name}}</span></h1>
                    <div class="container">
                        <form action="{{route('userEdit.post', $TheUser->id)}}" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-1 mb-8">
                                <div class="flex items-center">
                                    <h2 class="text-xl font-bold dark:text-white text-bold">Name</h2> <span class="ml-6">{{$TheUser->name}}</span>
                                </div>
                                <div class="flex items-center">
                                    <h2 class="text-xl font-bold dark:text-white">Email:</h2> <span class="ml-6">{{$TheUser->email}}</span>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-1 mb-8">
                                <div class="flex items-center">
                                    <h2 class="text-xl font-bold dark:text-white">Role:</h2>
                                        @if ($TheUser->Role == true)
                                        <span class="ml-6">Admin</span>
                                        @else
                                        <span class="ml-6">Volunteer</span>
                                    @endif
                                </div>
                                <div class="flex items-center">
                                    <h2 class="text-xl font-bold dark:text-white">Status:</h2>
                                        @if ($TheUser->UserStatus == true)
                                        <span class="ml-6 bg-green-100 text-green-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Active</span>
                                        @else
                                        <span class="ml-6 bg-red-100 text-red-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Inactive</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="flex items-start mb-6">
                                        <div class="flex items-center h-5">
                                            <input id="active" type="checkbox" name="active" value="" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" @if ($TheUser->UserStatus == true) checked @endif>
                                        </div>
                                        <label for="active" class="ml-2 text-gray-900 dark:text-gray-300">Active</label>
                                    </div>
                                    <div class="flex items-start mb-6">
                                        <div class="flex items-center h-5">
                                            <input id="role" type="checkbox" name="role" value="" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" @if ($TheUser->role == true) checked @endif>
                                        </div>
                                        <label for="role" class="ml-2 text-gray-900 dark:text-gray-300">Admin?</label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
