@extends('layouts.app')

@section('content')

<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>

            <div class="layout-px-spacing">
                
                <div class="row layout-top-spacing">
                    <div class="col-md-12">
                        <div class="row">
                        <h2> {{ __('models/translator.user_manager') }} </h2>
                      
                        </div>

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
                            <button type="button" id="create_user" class="btn btn-primary">@lang('models/translator.create_user') </button>
                            <div class="table-responsive mb-4 mt-4">
                                <table id="orders" class="table table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                          
                                            <th>@lang('models/translator.user_no')  </th>
                                            <th>{{ __('models/translator.user') }}  </th>
                                            <th>{{ __('models/translator.role') }}  </th>
                                          
                                            <th class="no-content">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($users)  > 0)
                                        @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->getRoleNames() }}</td>
                                        <td>            
                                                <div class="btn-group">
                                                    {{-- <button type="button" class="btn btn-dark btn-sm">Open</button> --}}
                                                    <button type="button" class="btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference28" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                                                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuReference28">
                                                        <a class="dropdown-item edit"  data-user_id="{{$user->id}}"  data-name="{{$user->name}}" data-email="{{$user->email}}"  data-role="{{$user->getRoleNames()}}"   href="#">{{ __('models/translator.edit') }}</a> 
                                                    
                                                      {{-- <a class="dropdown-item accept_order" data-accept_order={{$order->id}} href="#">{{ __('models/translator.accept_order') }}</a> --}}
                                                       <a class="dropdown-item delete" data-user_id="{{$user->id}}"   href="#">{{ __('models/translator.delete') }}</a>
                                                
                                                      {{-- <div class="dropdown-divider"></div>
                                                      <a class="dropdown-item" href="#">Separated link</a> --}}
                                                    </div>
                                                  </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                            @endif
                                        
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>@lang('models/translator.user_no')  </th>
                                            <th>{{ __('models/translator.user') }}  </th>
                                            <th>{{ __('models/translator.role') }}  </th>
                                            <th class="no-content">Actions</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle">{{ __('models/translator.create_user') }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group mb-4">
                           
                                    <label>{{ __('models/translator.user_name') }} <a href="javascript:void(0)"  class="custom-file-container__image-clear" title="Clear Image"></a></label>
                                    <input type="text" required class="form-control"  id="name" name="name">
                                    <label>{{ __('models/translator.user_password') }} <a href="javascript:void(0)"  class="custom-file-container__image-clear" title="Clear Image"></a></label>
                                    <input type="text" min="6" required class="form-control" required  id="password" name="password">
                                    <label>{{ __('models/translator.user_email') }} <a href="javascript:void(0)"  class="custom-file-container__image-clear" title="Clear Image"></a></label>
                                    <input type="email"  required class="form-control" required  id="email" name="email">
                                    <div class="form-group mb-4">
                                        <label>{{ __('models/translator.role') }} <a href="javascript:void(0)"  class="custom-file-container__image-clear" title="Clear Image"></a></label>
                                        <select class="form-control" id="role" name="role">
                                            <option value="1">{{ __('models/translator.translator') }}</option>
                                            <option value="2">{{ __('models/translator.checker') }}</option>
                                            <option value="3">{{ __('models/translator.cs') }}</option>
                                            <option value="4">{{ __('models/translator.op') }}</option>
                                            <option value="5">{{ __('models/translator.accounting') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                                <button type="button" id="new_user" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
             
                <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalCenterTitle">{{ __('models/translator.create_user') }}</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                              </button>
                          </div>
                          <div class="modal-body">
                              <div class="form-group mb-4">
                         <input hidden name="id" id="user_id">
                                  <label>{{ __('models/translator.user_name') }} <a href="javascript:void(0)"  class="custom-file-container__image-clear" title="Clear Image"></a></label>
                                  <input type="text" required class="form-control"  id="name_edit" name="name">
                                  <label>{{ __('models/translator.user_password') }} <a href="javascript:void(0)"  class="custom-file-container__image-clear" title="Clear Image"></a></label>
                                  <input type="text" min="6" required class="form-control" required  id="password" name="password">
                                  <label>{{ __('models/translator.user_email') }} <a href="javascript:void(0)"  class="custom-file-container__image-clear" title="Clear Image"></a></label>
                                  <input type="email"  required class="form-control" required  id="email_edit" name="email">
                                  <div class="form-group mb-4">
                                      <label>{{ __('models/translator.role') }} <a href="javascript:void(0)"  class="custom-file-container__image-clear" title="Clear Image"></a></label>
                                      <select class="form-control" id="role_edit" name="role">
                                          <option value="1">{{ __('models/translator.translator') }}</option>
                                          <option value="2">{{ __('models/translator.checker') }}</option>
                                          <option value="3">{{ __('models/translator.cs') }}</option>
                                          <option value="4">{{ __('models/translator.op') }}</option>
                                          <option value="5">{{ __('models/translator.accounting') }}</option>
                                      </select>
                                  </div>
                              </div>
                          </div>
                          <div class="modal-footer">
                              <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                              <button type="button" id="update_user" class="btn btn-primary">Save</button>
                          </div>
                      </div>
                  </div>
              </div>
            </div>
           
          
          
            
@endsection

@section('page_scripts')

  <script>
      $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

          $('#orders').DataTable({
              "oLanguage": {
                  "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                  "sInfo": "Showing page _PAGE_ of _PAGES_",
                  "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                  "sSearchPlaceholder": "Search...",
                  "sLengthMenu": "Results :  _MENU_",
              },
              "stripeClasses": [],
              "lengthMenu": [20, 30, 100, 200],
              "pageLength": 20 ,
              "order": [[ 0, "desc" ]]
          });

          
          $('#uploadform').on('submit', function(event){
            var order_id= $('#order_id').val();
            if(order_id){
          
            request = $.ajax({
        url: '{{route('translator.ReUpload')}}',
        type: "post",
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        data:new FormData(this),
    });
  }

    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        console.log("Hooray, it worked!");
        $('#uploadModal').modal('hide');
        swal(
          'submit!',
          'Your order has been under review with checker.',
          'success'
        );
        setTimeout(
                  function() 
                  {
                     location.reload();
                  }, 2000); 
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        
    });

            
          });
          $(".upload_translations").click(function(event){
           var order_id= $(this).data("order_id");
       
             

           $('#order_id').val(order_id);
           $('#uploadModal').modal('show');
    
       
     // }
    })
    $("#create_user").click(function(event){
          
     

           $('#createModal').modal('show');
         
            
         
    });
    $(".edit").click(function(event){
           var name= $(this).data("name");
           var email = $(this).data("email");
           var role = $(this).data("role");
          var user_id = $(this).data("user_id");
            $('#name_edit').val(name);
            $('#email_edit').val(email);
            $('#user_id').val(user_id);
            
            var check =0;
            
          if(role =='translator')
          {
            alert(role);
            check=0; 
          }else if(role=='checker'){
            check=1
          } else if(role=='customer service'){
            check=2
          } else if (role=='operation manager'){
            check=3;
          }else if(role=='accounting'){
            check=4;
          }

           $('#role_edit option:eq('+check+')').attr('selected', 'selected')
    //      $('#role_edit option')
    // .filter(function(i, e) { return $(e).val() == check})
           $('#editModal').modal('show');
         
            
         
    });
    $("#new_user").click(function(event){
  var user_name= $('#name').val();;
  var user_password =$('#password').val();
  var user_email =$('#email').val();
  var role=$('#role').val();

request = $.ajax({
        url: '{{route('admin.user.create')}}',
        type: "post",
        data: {
            'name':user_name,
            'password':user_password,
            'email':user_email,
            'role':role
        }
    });

    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
       
                  
        swal(
          'changed!',
          'Your user has been created.',
          'success'
        )
        setTimeout(
                  function() 
                  {
                     location.reload();
                  }, 2000); 
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
    });

});

$("#update_user").click(function(event){
  var user_name= $('#name_edit').val();;
  var user_password =$('#password').val();
  var user_email =$('#email_edit').val();
  var role=$('#role_edit').val();
  var id=$('#user_id').val();

request = $.ajax({
        url: '{{route('admin.user.edit')}}',
        type: "post",
        data: {
            'name':user_name,
            'password':user_password,
            'email':user_email,
            'role':role,
            'id':id
        }
    });

    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
       
                  
        swal(
          'changed!',
          'Your user has been created.',
          'success'
        )
        setTimeout(
                  function() 
                  {
                     location.reload();
                  }, 2000); 
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
    });

});


$(".delete").click(function(event){
           var user_id= $(this).data("user_id");
       
    swal({
      title: '{{ __('models/translator.are_you_sure') }}',
      text: "{{ __('models/translator.delete_user') }}",
      type: 'warning',
      showCancelButton: true,
      confirmButtonText: '{{ __('models/translator.accept') }}',
      cancelButtonText:'{{ __('models/translator.cancel') }}',
      padding: '2em'
    }).then(function(result) {
      if (result.value) {

        request = $.ajax({
        url: '{{route('admin.user.delete')}}',
        type: "post",
        data: {
            'id':user_id,
        }
    });

    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        swal(
          'changed!',
          'Your user has been deleted.',
          'success'
        )
        setTimeout(
                  function() 
                  {
                     location.reload();
                  }, 2000); 
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
    });
           





        
      }
    })
});
$(".show").click(function(event){
  var order_id= $(this).data("download_order");

request = $.ajax({
        url: '{{route('download_order')}}',
        type: "post",
        data: {
         
            'order_id':order_id
        }
    });

    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
       
                  
            console.log(response.data);
           const link = document.createElement('a');
           link.setAttribute('href', response.data);
           link.setAttribute('download', response.file); // Need to modify filename ...
           link.click();
        // setTimeout(
        //           function() 
        //           {
        //              location.reload();
        //           }, 2000); 
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
    });
//   jQuery.ajax({
//         type: "post",
//         url: '{{route('download_order')}}',
//         data: { 
//           'order_id':order_id
//        },
//         contentType:false,
//         processData:false,
//         success: function (res) {
//             const data = res;
//             console.log(data);
// //const link = document.createElement('a');
//            // link.setAttribute('href', data);
//            // link.setAttribute('download', 'yourfilename.extensionType'); // Need to modify filename ...
//            // link.click();
//         }
//     });
});
      </script>

    <script>
      

   
 

    </script>

@endsection