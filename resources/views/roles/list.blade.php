<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Roles / List') }}
            </h2>
            @can('create roles')
            <a href="{{route('roles.create')}}" class="bg-slate-700 text-sm hover:bg-slate-500 text-white rounded-lg px-5 py-3">Create</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>
            <table id="roles-table" class="w-full bg-white">
                <thead class="bg-gray-50">
                    <tr class="border-b">
                        <th width="60">#</th>
                        <th width="180">Name</th>
                        <th>Permissions</th>
                        <th width="180">Created</th>
                        <th width="250" class="text-center">Action</th>
                    </tr>
                </thead>
            </table>

        </div>
    </div>
    <x-slot name="script">
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>
        <script type="text/javascript">
            $(function() {
                $('#roles-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route("roles.data") }}',
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'permissions',
                            name: 'permissions'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });
            });

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