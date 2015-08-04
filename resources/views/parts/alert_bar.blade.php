{{-- error.start --}}
@if(!$errors->isEmpty())
    @foreach ($errors->all() as $error)
    <div class='row'>
        <div class='span12'>
            <div class="alert alert-error">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              {{$error}}
            </div>
        </div>
    </div>
    @endforeach
@endif
{{-- message.start --}}
@if($tmp_message = Session::get('message'))
    <div class='row'>
        <div class='span12'>
            <div class="alert alert-error">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              {{$tmp_message}}
            </div>
        </div>
    </div>
@endif