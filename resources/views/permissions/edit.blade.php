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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"  >
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form id="permission-edit-form" data-id="{{$permission->id}}">
                        @csrf
                        <div>
                            <label for="" class="text-lg font-medium">Name</label>
                            <div class="mt-3 mb-2">
                                <input value="{{old('name',$permission->name)}}" id="name" type="text" name="name" placeholder="Enter Name" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                            </div>
                            <!-- @error('name') -->
                            <!-- <p class="text-red-400 font-medium mb-2">{{$message}}</p> -->
                            <!-- @enderror -->
                            <button type="submit" class="bg-slate-700 text-sm text-white rounded-lg px-5 py-3">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function() {
                $('#permission-edit-form').on('submit', function(e) {

                    e.preventDefault();

                    const id = $(this).data('id');
                    const name = $('#name').val();
                    const token = $('input[name="_token"]').val();

                    // Clear messages
                    $('#name-error').text('');
                    $('#success-msg').addClass('hidden');

                    $.ajax({
                        url: `/permissions/${id}`,
                        type: 'POST',
                        data: {
                            _token: token,
                            name: name
                        },
                        success: function(response) {
                            $('#success-msg').removeClass('hidden');
                            window.location.href = '{{route("permissions.index")}}'
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;
                                if (errors.name) {
                                    $('#name-error').text(errors.name[0]);
                                }
                            }
                        }
                    });
                });
            });
        </script>
    </x-slot>
</x-app-layout>