@if(Session::has('success'))
<div class="bg-green-200 border-green-600 text-green-600 rounded-lg py-4 px-4 shadow-md mb-3">
    {{Session::get('success')}}
</div>
@endif
@if(Session::has('error'))
<div class="bg-red-200 border-red-600 text-red-600 rounded-lg py-3 px-4 shadow-md mb-3">
    {{Session::get('error')}}
</div>
@endif