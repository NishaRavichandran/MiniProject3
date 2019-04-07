@if(session()->has('message'))
    <div class="alert alert-success" style="font-size: medium">
        {{ session()->get('message') }}
    </div>
@endif