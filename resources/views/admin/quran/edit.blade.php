<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Aya: '. $TheAya->aya_number) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container">
                        <form action="{{route('admin.aya.postEdit', [$lang, $TheAya->id])}}" method="POST" enctype="multipart/form-data" >
                            @csrf
                                <div class="mb-6">
                                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Aya Text</label>
                                <textarea name="aya_text" id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{old('aya_text') ??  $TheAya->aya_text}}</textarea>
                                </div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="user_avatar">Upload file</label>
                                <input name="image" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="user_avatar_help" id="user_avatar" type="file">
                                <a class="mt-3 block fancybox" href="{{$TheAya->AyaImage}}" data-fancybox="gallery{{$TheAya->id}}">
                                    <img width="100" src="{{$TheAya->AyaImage}}" alt=""></td>
                                </a>
                                <button type="submit" class="mt-5 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
