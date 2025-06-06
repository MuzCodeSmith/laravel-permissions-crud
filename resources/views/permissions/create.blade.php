<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Permissions / Create') }}
            </h2>
            <a href="{{route('permissions.index')}}" class="bg-slate-700 text-sm text-white rounded-lg px-5 py-3">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- <div id="success-msg" class="text-green-600 font-semibold mt-4 hidden">
                        Permission added successfully!
                    </div> -->
                    <form id="permission-form">
                        @csrf
                        <div>
                            <label for="name" class="text-lg font-medium">Name</label>
                            <div class="mt-3 mb-2">
                                <input value="{{old('name')}}" id="name" type="text" name="name" placeholder="Enter Name" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                            </div>
                            <p class="text-red-400 font-medium mb-2" id="name-error"></p>
                            <button type="submit" class="bg-slate-700 text-sm text-white rounded-lg px-5 py-3">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script type="text/javascript">
            $(document).ready(function() {
                $('#permission-form').on('submit', function(e) {
                    e.preventDefault();
                    let form = $(this);
                    let name = $('#name').val();
                    let token = $('input[name="_token"]').val();

                    $('#name-error').text('');
                    $('#success-msg').addClass('hidden');

                    $.ajax({
                        url: "{{route('permissions.store')}}",
                        method: 'POST',
                        data: {
                            _token: token,
                            name: name,
                        },
                        success: function(response) {
                            $('#success-msg').removeClass('hidden');
                            $('#name').val('');
                            window.location.href = '{{route("permissions.index")}}'
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                let errors = xhr.responseJSON.errors;
                                if (errors.name) {
                                    $('#name-error').text(errors.name[0]);
                                }
                            }
                        }
                    })
                })
            });
        </script>
    </x-slot>
</x-app-layout>