@extends('layouts.app')

@section('content')

            <div class="layout-px-spacing">
                
                <div class="row layout-top-spacing">
                    <div class="col-md-12">
                        <h2>{{ $driver->first_name }} {{ $driver->last_name }}</h2>
                    </div>
                    @if(session()->has('success'))
                    <div class="col-md-12">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                          <strong>{{ session()->get('success') }}</strong>
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                    </div>
                   @endif
                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                        <div class="widget-content widget-content-area br-6">
                            <ul class="nav nav-tabs  mb-3 mt-3" id="simpletab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Basic Information</a>
    </li>
    <li class="nav-item">
       <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Vehicle Information</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Documents</a>
    </li>
</ul>
<div class="tab-content" id="simpletabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="statbox widget box box-shadow">
          <div class="widget-header">
              <div class="row">
                  <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                      <h4>Basic Information</h4>
                  </div>                 
              </div>
          </div>
          <div class="widget-content widget-content-area">

                      <form method="post" action="{{ url('driver_edit') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="driver_id" value="{{ $driver->id }}">
                        <div class="row">
                          <div class="form-group col-md-6">
                              <p>First name</p>
                              <input type="text" name="first_name" placeholder="Type here" class="form-control" required="" value="{{ $driver->first_name }}">
                          </div>
                          <div class="form-group col-md-6">
                              <p>Last name</p>
                              <input type="text" name="last_name" placeholder="Type here" class="form-control" required="" value="{{ $driver->last_name }}">
                          </div>
                          <div class="form-group col-md-6">
                              <p>Email</p>
                              <input type="email" name="email" placeholder="Type here" class="form-control" required="" value="{{ $driver->email }}">
                          </div>
                          <div class="form-group col-md-6">
                              <p>Username</p>
                              <input type="text" name="username" placeholder="Type here" class="form-control" required="" value="{{ $driver->username }}">
                          </div>
                          <div class="form-group col-md-6">
                              <p>Phone</p>
                              <input type="text" name="phone" placeholder="Type here" class="form-control" required="" value="{{ $driver->phone }}">
                          </div>
                          <div class="form-group col-md-6">
                              <p>Approval State</p>
                              <select name="approval_state" class="form-control" required>
                                <option value="">---Select---</option>
                                <option value="p" @if($driver->approval_state == 'p') selected="" @endif>Pending</option>
                                <option value="a" @if($driver->approval_state == 'a') selected="" @endif>Approved</option>
                                <option value="r" @if($driver->approval_state == 'r') selected="" @endif>Reject</option>
                              </select>
                          </div>
                          <div class="form-group col-md-6">
                              <p>Is Active</p>
                              <select name="is_active" class="form-control" required>
                                <option value="">---Select---</option>
                                <option value="1" @if($driver->is_active == 1) selected="" @endif>Active</option>
                                <option value="0" @if($driver->is_active == 0) selected="" @endif>Not Active</option>
                              </select>
                        </div>
                        <div class="form-group col-md-6">
                              <p>Is Available</p>
                              <select name="is_available" class="form-control" required>
                                <option value="">---Select---</option>
                                <option value="1" @if($driver->is_available == 1) selected="" @endif>Available</option>
                                <option value="0" @if($driver->is_available == 0) selected="" @endif>Not Available</option>
                              </select>
                        </div>
                        <div class="form-group col-md-6">
                              <p>Is Phone Verified</p>
                              <select name="is_phone_verified" class="form-control" required>
                                <option value="">---Select---</option>
                                <option value="1" @if($driver->is_phone_verified == 1) selected="" @endif>Verified</option>
                                <option value="0" @if($driver->is_phone_verified == 0) selected="" @endif>Not Verified</option>
                              </select>
                        </div>
                      <div class="col-md-12">
                      <input type="submit" name="txt" value="Update" class="mt-4 btn btn-primary">   
                      </div>                                  
                  </div>
                      </form>
                  
          </div>
      </div>  
    </div>
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <form method="post" action="{{ url('driver_vehicle_edit') }}" enctype='multipart/form-data'>
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="driver_id" value="{{ $driver->id }}">
              @if(!is_null($driver->vehicle))
              <input type="hidden" name="vehicle_id" value="{{ $driver->vehicle->id }}">
              @else
              <input type="hidden" name="vehicle_id" value="0">
              @endif
              <div class="row">
                <div class="form-group col-md-6">
                    <p>Maker</p>
                    <input type="text" name="maker" placeholder="Type here" class="form-control" required="" @if(isset($driver->vehicle->maker)) value="{{ $driver->vehicle->maker }}" @endif>
                </div>
                <div class="form-group col-md-6">
                    <p>Model</p>
                    <input type="text" name="model" placeholder="Type here" class="form-control" required="" @if(isset($driver->vehicle->model)) value="{{ $driver->vehicle->model }}" @endif>
                </div>
                <div class="form-group col-md-6">
                    <p>Year</p>
                    <input type="text" name="year" placeholder="Type here" class="form-control" required="" @if(isset($driver->vehicle->year)) value="{{ $driver->vehicle->year }}" @endif>
                </div>
                <div class="form-group col-md-6">
                    <p>Color</p>
                    <input type="text" name="color" placeholder="Type here" class="form-control" required="" @if(isset($driver->vehicle->color)) value="{{ $driver->vehicle->color }}" @endif>
                </div>
                <div class="form-group col-md-12">
                    <p>Licence plate</p>
                    <input type="text" name="licence_plate" placeholder="Type here" class="form-control" required="" @if(isset($driver->vehicle->licence_plate)) value="{{ $driver->vehicle->licence_plate }}" @endif>
                </div>
                <div class="form-group col-md-6">
                    <p>Upload Front Image</p>
                    <input type="file" name="front_photo" class="form-control">
                    @if(isset($driver->vehicle->front_photo)) 
                    <img src="{{ url('uploads/vehicle/'.$driver->vehicle->front_photo) }}" width="300">
                    @endif
                </div>
                <div class="form-group col-md-6">
                    <p>Upload Back Image</p>
                    <input type="file" name="back_photo" class="form-control">
                    @if(isset($driver->vehicle->back_photo)) 
                    <img src="{{ url('uploads/vehicle/'.$driver->vehicle->back_photo) }}" width="300">
                    @endif
                </div>
                <div class="form-group col-md-12">
                  <input type="submit" value="Update" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>
   
    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
       @if(isset($driver->vehicle->documents) && count($driver->vehicle->documents) > 0)
        <div class="row">
       @foreach($driver->vehicle->documents as $document)
         <div class="col-md-4" style="position: relative;">
          <a href="{{ url('del-doc/'.$document->id) }}" onclick="return confirm('Are you sure?')" class="btn btn-danger">
            Delete file
          </a>
           <img src="{{ url('uploads/vehicle/'.$document->image) }}" width="100%">
         </div>
       @endforeach
       </div>
       @endif
       <form method="post" action="{{ url('/vehicle_docment') }}" enctype='multipart/form-data'>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="vehicle_id" value="{{ $driver->vehicle->id }}">
         <div class="row">
           <div class="form-group col-md-6">
             <p>More Upload</p>
             <input type="file" name="document" class="form-control">
           </div>
           <div class="col-md-12">
             <input type="submit" class="btn btn-primary" value="Update">
           </div>
         </div>
       </form>
    </div>
</div>
                        </div>
                    </div>

                </div>

            </div>
            
@endsection

@section('page_scripts')

  
@endsection