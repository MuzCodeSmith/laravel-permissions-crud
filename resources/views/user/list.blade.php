<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Users / List') }}
            </h2>
            <a href="{{route('roles.create')}}" class="bg-slate-700 text-sm hover:bg-slate-500 text-white rounded-lg px-5 py-3">Create</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-message></x-message>
            
        </div>
    </div>
    <x-slot name="script">
        <script type="text/javascript">
            function deleteRole(id) {
                if (confirm('Are You sure you want to delete')) {
                    $.ajax({
                        url: '{{route("roles.destroy")}}',
                        type: 'delete',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        headers: {
                            'x-csrf-token': '{{csrf_token()}}'
                        },
                        success: function(response) {
                            window.location.href = '{{route("roles.index")}}'
                        }
                    })
                }
            }
        </script>
    </x-slot>
</x-app-layout>