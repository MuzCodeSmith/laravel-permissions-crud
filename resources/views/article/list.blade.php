<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Articles / List') }}
            </h2>
            @can('create articles')
                <a href="{{route('articles.create')}}" class="bg-slate-700 text-sm hover:bg-slate-500 text-white rounded-lg px-5 py-3">Create</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr class="border-b">
                        <th class="px-6 py-5 text-left" width="60">#</th>
                        <th class="px-6 py-5 text-left">Name</th>
                        <th class="px-6 py-5 text-left" width="180">Created</th>
                        <th class="px-6 py-5 text-center" width="250">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if($articles->isNotEmpty())
                    @foreach($articles as $article)
                    <tr class="border-b">
                        <td class="px-6 py-5 text-left">{{$article->id}}</td>
                        <td class="px-6 py-5 text-left">{{$article->title}}</td>
                        <td class="px-6 py-5 text-left">{{\Carbon\Carbon::parse($article->created_at)->format('d M, Y')}}</td>
                        <td class="px-6 py-5 text-left">
                            @can('edit articles')
                                <a href="{{route('articles.edit',$article->id)}}" class="bg-slate-700 hover:bg-slate-500 text-sm text-white rounded-lg px-5 py-3">Edit</a>
                            @endcan
                            @can('delete articles')
                                <a href="javascript:void(0);" onclick="deleteArticle({{$article->id}})" class="bg-red-700 hover:bg-red-500 text-sm text-white rounded-lg px-5 py-3">Delete</a>
                            @endcan

                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            <div class="py-4">
                {{$articles->links()}}
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script type="text/javascript">
            function deleteArticle(id) {
                if (confirm('Are You sure you want to delete')) {
                    $.ajax({
                        url: '{{route("articles.destroy")}}',
                        type: 'delete',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        headers: {
                            'x-csrf-token': '{{csrf_token()}}'
                        },
                        success: function(response) {
                            window.location.href = '{{route("articles.index")}}'
                        }
                    })
                }
            }
        </script>
    </x-slot>
</x-app-layout>