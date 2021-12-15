<div class="container">
    <div class="col-md-12 pr-12">
        <h4><i class="far fa-money-alt"></i> @lang('models/translator.info')</h4>
        <hr></div>
        <div class="form-group col-md-12">
        <label for="name">{{ __('models/translator.end_users') }}</label>

        <select class="form-control" id="user_id" name="user_id[]"  multiple="multiple">
            @foreach($users as $user)
          <option  value="{{$user->id}}">{{$user->name}}</option>
          @endforeach
</select>
<span class="help-block">
                              <i class="far fa-address-book"></i>&nbsp;By selecting a users, all other options will be discard and the notification will be send only to the selected drivers
</span>
        </div>


        <div class="form-group col-md-12">
        <label for="name">{{ __('models/translator.status') }}</label>
                              <select id="status" name="status" class="form-control" required>
                                <option value="">---Select---</option>
                                <option   value="a" >All</option>
                                <option   value="c" >Active</option>
                                <option  value="d" >Deactive</option>
                              </select>
        
                          </div>

                          <div class="form-group col-md-12">
        <label for="name">{{ __('models/translator.device_type') }}</label>
                              <select id="device_type" name="device_type" class="form-control" required>
                                <option value="">---Select---</option>
                                <option   value="a" >All</option>
                                <option   value="n" >Andriod</option>
                                <option  value="i" >IOS</option>
                              </select>
        
                          </div>


                          <div class="form-group  col-md-12">
  <div class="input-group-prepend">
  <label for="name">{{ __('models/translator.message') }}</label>
  </div>
  <textarea class="form-control" name="message" aria-label="With textarea" required></textarea>
</div>
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a id="reset" class="btn btn-default">Reset</a>
</div>
    </div>



@section('page_scripts')

<script>
$('#user_id').select2();
</script>
@endsection