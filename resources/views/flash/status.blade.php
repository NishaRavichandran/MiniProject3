@if (session('status'))
    <div class="alert alert-success" style="font-size: medium">
        {{ session('status') }}
    </div>
@endif

