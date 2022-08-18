@if(session()->has('message'))
<div class="col-md-12"><div class="alert alert-success"> {{ session()->get('message') }} </div></div>
@endif

@if(session()->has('err_message'))
<div class="col-md-12"><div class="alert alert-danger"> {{ session()->get('err_message') }} </div></div>
@endif

@if($errors->any())
<div class="col-md-12">
    <div class="alert alert-danger p-1 m-1">
        <ul class="p-0 m-0" style="list-style: none;">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif
