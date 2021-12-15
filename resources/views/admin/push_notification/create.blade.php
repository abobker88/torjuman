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
                  
                    {!! Form::open([ 'route' => 'push_notification.store','id' => 'push_notificaiton']) !!}

                        @include('admin.push_notification.fields')

                    {!! Form::close() !!}
              
            </div>
        </div>
    </div>
    </div>
@endsection
