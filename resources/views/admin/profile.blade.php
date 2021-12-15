@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
       
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')

        @include('flash::message')
        <div class="row justify-content-center">
            <div class="card card-primary col-lg-8">
                <div class="card-body" style="width: 100%">
                  
                    {!! Form::open([ 'route' => 'profile.store','id' => 'push_notificaiton']) !!}

                    <div class="container">
                        <div class="col-md-12 pr-12">
                            <h4><i class="far fa-money-alt"></i> @lang('models/translator.profile')</h4>
                            <hr></div>
                            <div class="form-group col-md-12">
                            <label for="name">{{ __('models/translator.name') }}</label>
                            <input type="name" class="form-control" name="name"  id="name" value="{{$user->name}}">
               
                            </div>
                    
                    
                            <div class="form-group col-md-12">
                            <label for="name">{{ __('models/translator.email') }}</label>
                            <input type="email" class="form-control" name="email"  id="email" value="{{$user->email}}">
                                              </div>
                    
                                              <div class="form-group col-md-12">
                                                <label for="name">{{ __('models/translator.password') }}</label>
                                                <input type="password" name="password" class="form-control" minlength="6"  id="password" >
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

                    {!! Form::close() !!}
              
            </div>
        </div>
    </div>
    </div>
@endsection
