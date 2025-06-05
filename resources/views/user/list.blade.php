<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Users / List') }}
            </h2>
            <a href="{{route('users.create')}}" class="bg-slate-700 text-sm hover:bg-slate-500 text-white rounded-lg px-5 py-3">Create</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-message></x-message>
        <table class="w-full">
                <thead class="bg-gray-50">
                    <tr class="border-b">
                        <th class="px-6 py-5 text-left" width="60">#</th>
                        <th class="px-6 py-5 text-left" width="200">Name</th>
                        <th class="px-6 py-5 text-left">Roles</th>
                        <th class="px-6 py-5 text-left" width="180">Created</th>
                        <th class="px-6 py-5 text-center" width="250">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if($users->isNotEmpty())
                    @foreach($users as $user)
                    <tr class="border-b">
                        <td class="px-6 py-5 text-left">{{$user->id}}</td>
                        <td class="px-6 py-5 text-left">{{$user->name}}</td>
                        <td class="px-6 py-5 text-left">{{$user->roles->pluck('name')->implode(', ')}}</td>
                        <td class="px-6 py-5 text-left">{{\Carbon\Carbon::parse($user->created_at)->format('d M, Y')}}</td>
                        <td class="px-6 py-5 text-left">
                            @can('edit users')
                            <a href="{{route('users.edit',$user->id)}}" class="bg-slate-700 hover:bg-slate-500 text-sm text-white rounded-lg px-5 py-3">Edit</a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            <div class="py-4">
                {{$users->links()}}
            </div>
            
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