<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Permissions / Edit') }}
        </h2>
        <a href="{{route('permissions.index')}}" class="bg-slate-700 text-sm text-white rounded-lg px-5 py-3">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{route('permissions.update',$permission->id)}}" method="post">
                        @csrf
                        <div>
                            <label for="" class="text-lg font-medium">Name</label>
                            <div class="mt-3 mb-2">
                                <input value="{{old('name',$permission->name)}}" type="text" name="name" placeholder="Enter Name" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                            </div>
                            @error('name')
                            <p class="text-red-400 font-medium mb-2" >{{$message}}</p>
                            @enderror
                            <button class="bg-slate-700 text-sm text-white rounded-lg px-5 py-3">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>