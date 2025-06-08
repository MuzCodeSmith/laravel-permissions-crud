<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Permissions / List') }}
            </h2>
            @can('create permissions')
            <a href="{{route('permissions.create')}}" class="bg-slate-700 text-sm text-white rounded-lg px-5 py-3">Create</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div id="success-msg" class="text-green-600 font-semibold mt-4 hidden">
                Permission updated successfully!
            </div>
            <x-message></x-message>
            <table id="permissions-table" class="min-w-full bg-white">
                <thead class="bg-gray-50">
                    <tr>
                        <th width="60">#</th>
                        <th>Name</th>
                        <th width="180">Created</th>
                        <th width="250">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <x-slot name="script">
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>

        <script type="text/javascript">
            $(function () {
                $('#permissions-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('permissions.data') }}',
                    columns: [
                        { data: 'id', name: 'id' },
                        { data: 'name', name: 'name' },
                        { data: 'created_at', name: 'created_at' },
                        { data: 'action', name: 'action', orderable: false, searchable: false },
                    ]
                });
            });

            function deletePermission(id) {
                if (confirm('Are You sure you want to delete')) {
                    $.ajax({
                        url: '{{route("permissions.destroy")}}',
                        type: 'delete',
                        data: { id: id },
                        dataType: 'json',
                        headers: {
                            'x-csrf-token': '{{csrf_token()}}'
                        },
                        success: function(response) {
                            $('#permissions-table').DataTable().ajax.reload();
                        }
                    });
                }
            }
        </script>
    </x-slot>
</x-app-layout>
