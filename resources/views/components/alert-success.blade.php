@if(session('success'))
    <div class="mb-4 bg-green-100 p-4 border border-green-200 text-green-600 rounded-md">
        {{ session('success') }}
    </div>
@endif
