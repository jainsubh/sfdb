@if ($errors->any())
<div class="alert alert-danger" role="alert">
    <button class="close" type="button" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    @foreach ($errors->all() as $error)
        <div class="message col-md-8">{{ $error }}</div>
    @endforeach
</div>
@endif