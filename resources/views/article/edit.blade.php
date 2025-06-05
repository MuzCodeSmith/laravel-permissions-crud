<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Articles / Edit') }}
            </h2>
            <a href="{{route('articles.index')}}" class="bg-slate-700 text-sm text-white rounded-lg px-5 py-3">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{route('articles.update',$article->id)}}" method="post">
                        @csrf
                        <div>
                            <label for="" class="text-lg font-medium">Title</label>
                            <div class="mt-3 mb-2">
                                <input value="{{old('title',$article->title)}}" type="text" name="title" placeholder="Enter Title" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('title')
                                <p class="text-red-400 font-medium mb-2">{{$message}}</p>
                                @enderror
                            </div>

                            <label for="" class="text-lg font-medium">Content</label>
                            <div class="mt-3 mb-2">
                                <textarea name="text" id="" cols="30" rows="10" placeholder="Enter Content" class="border-gray-300 shadow-sm w-1/2 rounded-lg">{{old('text', $article->text)}}</textarea>
                            </div>
                            <label for="" class="text-lg font-medium">Author</label>
                            <div class="mt-3 mb-2">
                                <input value="{{old('author',$article->author)}}" type="text" name="author" placeholder="Author" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('author')
                                <p class="text-red-400 font-medium mb-2">{{$message}}</p>
                                @enderror
                            </div>
                            <button class="bg-slate-700 text-sm text-white rounded-lg px-5 py-3">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>