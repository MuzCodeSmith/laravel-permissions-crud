<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Users / Create') }}
            </h2>
            <a href="{{route('users.index')}}" class="bg-slate-700 text-sm text-white rounded-lg px-5 py-3">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{route('users.store')}}" method="post">
                        @csrf
                        <div>
                            <label for="" class="text-lg font-medium">Name</label>
                            <div class="mt-3 mb-2">
                                <input value="{{old('name')}}" type="text" name="name" placeholder="Enter Name" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('name')
                                <p class="text-red-400 font-medium mb-2">{{$message}}</p>
                                @enderror
                            </div>
                            <label for="" class="text-lg font-medium">Email</label>
                            <div class="mt-3 mb-2">
                                <input value="{{old('email')}}" type="text" name="email" placeholder="Enter Email" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('email')
                                <p class="text-red-400 font-medium mb-2">{{$message}}</p>
                                @enderror
                            </div>

                            <label for="" class="text-lg font-medium">Password</label>
                            <div class="mt-3 mb-2">
                                <input value="{{old('password')}}" type="password" name="password" placeholder="Enter Password" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('password')
                                <p class="text-red-400 font-medium mb-2">{{$message}}</p>
                                @enderror
                            </div>

                            <label for="" class="text-lg font-medium">Confirm Password</label>
                            <div class="mt-3 mb-2">
                                <input value="{{old('confirm_password')}}" type="password" name="confirm_password" placeholder="Re-Enter Password" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                            </div>

                            <label for="" class="text-lg font-medium">Roles</label>
                            <div class="grid grid-cols-4 mb-3">
                                @if($roles->isNotEmpty())
                                @foreach($roles as $role)
                                <div class="mt-3">
                                    <input type="checkbox" class="rounded" name="roles[]" id="roles-{{$role->id}}" value="{{$role->name}}">
                                    <label for="roles-{{$role->id}}">{{$role->name}}</label>
                                </div>
                                @endforeach
                                @endif
                            </div>
                            <button class="bg-slate-700 text-sm text-white rounded-lg px-5 py-3">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>