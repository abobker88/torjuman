
 <main class="container" style="min-height: 60vh;">
    <section class="login-container">
      <div class="login-cols">
        <div class="login-logo">
          <img
            src=" {{asset('torjuman_public/media/img/loginform_img.png')}}"
            alt=""
            srcset=""
            class="login-img"
          />
        </div>
        <div class="login-form">
          <form action="#">
            <div class="form-group">
              <label for="name"> Name </label>
              <i class="bi bi-person"></i>
              <input
                type="text"
                name="name"
                required
                id="name"
                class="form-control"
                placeholder="Enter Full Name"
              />
            </div>
            <div class="form-group">
              <label for="email"> Email </label>
              <i class="bi bi-at"></i>
              <input
                type="email"
                required
                name="email"
                id="email"
                class="form-control"
                placeholder="Enter Email Address"
              />
            </div>
            <div class="form-group">
                <label for="email"> Password </label>
                <i class="bi bi-at"></i>
                <input
                  type="password"
                  name="password"
                  min="6"
                  required
                  id="password"
                  class="form-control"
                  placeholder="Enter Password"
                />
              </div>
              <div class="form-group">
                <label for="email"> Confirm Password </label>
                <i class="bi bi-at"></i>
                <input
                  type="password"
                  required
                  name="confirm_password"
                  id="confirm_password"
                  min="6"
                  class="form-control"
                  placeholder="Enter Password"
                />
              </div>
            <div class="form-group">
              <input
                type="button"
                class="btn btn-lg btn-block login-btn btn-hover"
                value="Create an Account"
                id="submit_register"
              />
            </div>
            <div class="form-group">
              <input
                type="button"
                class="btn btn-lg btn-block login-btn button-add"
                value=""
                id=""
                style="background-color: #ffffff;
                color: #000;
                border: #D6E2EF solid 1px;
                border-radius: 11px;"
              />
            </div>
            <div class="user-actions">
              
              <div class="sign-up">
                <span style="color: #464646"> Already have an account ? <a style="text-decoration: none" href="{{ Route('website.login') }}">Sign In</a>  </span>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>
  </main>

  @section('page_scripts')

  <script>
    $.ajaxSetup({
     headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
 });
 
 $("#submit_register").click(function(event){
   var name= $('#name').val();;
   var email =$('#email').val();;
   var password =$('#password').val();;
   var confirm_password =$('#confirm_password').val();
 request = $.ajax({
         url: '{{route('website.register.post')}}',
         type: "post",
         data: {
             "_token": "{{ csrf_token() }}",
             'name':name,
             'email':email,
             'password':password,
             'confirm_password':confirm_password
         }
     });
 
     // Callback handler that will be called on success
     request.done(function (response, textStatus, jqXHR){
         // Log a message to the console
        
               if(response.success)    
               {
                 swal(
           'Success!',
         response.message,
           'success'
         )
               } else {
                 swal(
           'fail!',
         response.message,
           'error'
         )
               }
        
         
         setTimeout(
                   function() 
                   {
                      location.reload();
                   }, 2000); 
     });
 
     // Callback handler that will be called on failure
     request.fail(function (jqXHR, textStatus, errorThrown){
         // Log the error to the console
 
         swal(
           'fail!',
           errorThrown,
           'error'
         )
         console.error(
             "The following error occurred: "+
             textStatus, errorThrown
         );
     });
 
 });
 </script>
 
 @endsection