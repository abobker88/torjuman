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
                        <h2>{{ __('models/translator.chat_admin') }} </h2>
                    </div>
                    @include('adminlte-templates::common.errors')

        @include('flash::message')
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
                            <div class="table-responsive mb-4 mt-4">
                                <table id="orders" class="table table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                          
                                            <th>@lang('models/translator.order_no')  </th>
                                            <th>{{ __('models/translator.user') }}  </th>
                                            <th>{{ __('models/translator.service') }}  </th>
                                            <th>{{ __('models/translator.status') }}  </th>
                                            <th> {{ __('models/translator.price') }} </th>
                                            <th> {{ __('models/translator.date') }} </th>
                                          
                                            <th class="no-content">{{ __('models/translator.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         @if(isset($orders) && count($orders) > 0)
                                            @foreach($orders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->user->name }}</td>
                                            <td>{{ $order->service->name }}</td>
                                            <td>{{ $order->status}} </td>
                                            <td>{{ $order->total_amount }}</td>
                                            <td>{{ $order->date }}</td>
                                            <td>
                                             
                                                <div class="btn-group">
                                                 
                                                  
                                                    <a class="dropdown-item" href="{{ Route('admin.chat',['user_id' => $order->user_id,'order_id'=>$order->id]) }}">{{ __('models/translator.chat') }}</a> 
                                                    
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
                                            <th>@lang('models/translator.order_no')  </th>
                                            <th>{{ __('models/translator.user') }}  </th>
                                            <th>{{ __('models/translator.service') }}  </th>
                                            <th>{{ __('models/translator.status') }}  </th>
                                            <th> {{ __('models/translator.price') }} </th>
                                            <th> {{ __('models/translator.date') }} </th>
                                            <th class="no-content">{{ __('models/translator.action') }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle">{{ __('models/translator.cancel_order') }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group mb-4">
                                  <input hidden name="order_id" id="order_id" >
                                    <label for="exampleFormControlTextarea1">{{ __('models/translator.cancel_reason') }}</label>
                                    <textarea id="reason" name="reason" required class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                                <button type="button" id="cancel_order" class="btn btn-primary">Save</button>
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


          $(".accept_order").click(function(event){
           var order_id= $(this).data("accept_order");
       
    swal({
      title: '{{ __('models/translator.are_you_sure') }}',
      text: "{{ __('models/translator.accept_order_info') }}",
      type: 'warning',
      showCancelButton: true,
      confirmButtonText: '{{ __('models/translator.accept') }}',
      cancelButtonText:'{{ __('models/translator.cancel') }}',
      padding: '2em'
    }).then(function(result) {
      if (result.value) {

        request = $.ajax({
        url: '{{route('translator.order.accept')}}',
        type: "post",
        data: {
            'order_id':order_id,
        }
    });

    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        swal(
          'changed!',
          'Your order has been accepted.',
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