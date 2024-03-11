<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-right">
            {{ __('إضافة حديث') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container">
                        <form action="{{route('admin.hadith.postCreate')}}" method="POST" enctype="multipart/form-data" >
                            @csrf
                                <div class="mb-5">
                                <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hadith title</label>
                                <textarea name="title" id="title" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                                </div>
                                <div class="mb-5">
                                    <label for="hadith_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hadith id</label>
                                    <input name="hadith_id" type="text" id="hadith_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                </div>
                                <div class="mb-5">
                                    <label for="lang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select a language</label>
                                    <select name="lang_code" id="lang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected>Choose a language</option>
                                    @foreach ($AllLanguages as $language)
                                        <option value="{{$language['code']}}">
                                            {{$language['native']}}
                                        </option>
                                    @endforeach
                                    </select>
                                </div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="user_avatar">Upload file</label>
                                <input name="image" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="user_avatar_help" id="user_avatar" type="file">
                                <button type="submit" class="mt-5 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
