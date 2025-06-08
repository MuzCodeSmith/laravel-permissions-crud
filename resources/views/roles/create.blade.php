<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Roles / Create') }}
            </h2>
            <a href="{{route('permissions.index')}}" class="bg-slate-700 text-sm text-white rounded-lg px-5 py-3">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form id="role-form">
                        @csrf
                        <div>
                            <label for="" class="text-lg font-medium">Name</label>
                            <div class="mt-3 mb-2">
                                <input value="{{old('name')}}" id="name" type="text" name="name" placeholder="Enter Name" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('name')
                                <p class="text-red-400 font-medium mb-2">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="grid grid-cols-4 mb-3">
                                @if($permissions->isNotEmpty())
                                @foreach($permissions as $permission)
                                <div class="mt-3">
                                    <input type="checkbox" id="permission-{{$permission->id}}" class="rounded" name="permissions[]" value="{{$permission->name}}">
                                    <label for="permission-{{$permission->id}}">{{$permission->name}}</label>
                                </div>
                                @endforeach
                                @endif
                            </div>
                            <button class="bg-slate-700 text-sm text-white rounded-lg px-5 py-3">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#role-form').on('submit', function(e) {
                    e.preventDefault(); // Stop default form submit

                    let name = $('#name').val();
                    let permissions = [];

                    $('input[name="permissions[]"]:checked').each(function() {
                        permissions.push($(this).val());
                    });

                    let token = $('input[name="_token"]').val();

                    $.ajax({
                        url: "{{ route('roles.store') }}",
                        method: "POST",
                        data: {
                            token: token,
                            name: name,
                            permissions: permissions
                        },
                        success: function(response) {
                            $('#role-form')[0].reset(); 
                            window.location.href = '{{route("roles.index")}}'
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                let errors = xhr.responseJSON.errors;
                                if (errors.name) {
                                    // alert(errors.name[0]);
                                }
                            } else {
                                alert('Something went wrong.');
                            }
                        }
                    });
                });
            });
        </script>

    </x-slot>
</x-app-layout>