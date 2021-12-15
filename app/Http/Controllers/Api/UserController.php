<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\UserRequist\ChangePassword;
use App\Http\Requests\UserRequist\ForgetPassword;
use App\Http\Requests\UserRequist\Login;
use App\Http\Requests\UserRequist\Register;
use App\Http\Requests\UserRequist\ResetPassword;
use App\Http\Requests\UserRequist\Update;
use App\Http\Resources\SingleUser;
use App\Models\DeviceToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Str;
use App\Traits\ImageTrait;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Response;
class UserController extends AppBaseController
{
    use  ImageTrait;
  /** @OA\Info(title="Torjman API", version="0.1") */

/**
* @OA\Post(

 *  path="/api/user/register",

 *  operationId="Registration",
 *  tags={"User"},

 *  summary="register user ",



   *  @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *       name="mobile",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *      @OA\Parameter(
     *      name="fcm_token",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *         @OA\Parameter(
     *      name="mobile_type",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     * 
     *  *  @OA\Parameter(
     *      name="lang",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),


 *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Entity",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(response=400, description="Bad request"),
        *      @OA\Response(response=200, description="User register"),
        *      @OA\Response(response=404, description="Resource Not Found"),

 * )

 */
    public function register(Register $request)
    {
       
        $token = Str::random(80);
        $id = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile, 
            'password' => bcrypt($request->password),
        ])->id;
        $user=User::find($id);
        $user->assignRole('end_user');
        $user->api_token=$id.''.$token;
        $user->locale=$request->lang;
        $user->save();

        \Session::put('locale',$request->lang);
        \App::setLocale($request->lang);

        if ($request->fcm_token) {
            DeviceToken::create([
                'fcm_token' => $request->fcm_token,
                'device_type' => $request->mobile_type,
                'user_id' => $user->id,
            ]);
        }
        
        return $this->sendResponse(new SingleUser($user), __('models/translator.user_register_successfully'));
    }

    /**
* @OA\Post(

 *  path="/api/user/signup_with_google",

 *  operationId="Registration",
 *  tags={"User"},

 *  summary="register user ",



   *  @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *       name="mobile",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
    
     *      @OA\Parameter(
     *      name="fcm_token",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *         @OA\Parameter(
     *      name="mobile_type",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),


 *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Entity",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(response=400, description="Bad request"),
        *      @OA\Response(response=200, description="User register and login"),
        *      @OA\Response(response=404, description="Resource Not Found"),

 * )

 */
public function google(Request $request)
{
   
    $token = Str::random(80);
    try{
        $old_user=User::where('email',$request->email)->first();
        if($old_user){
            return $this->sendResponse(  new SingleUser($old_user),  __('login_successfully'));
        }
    $id = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'mobile' => $request->mobile, 
        'is_google'=>'1'
    ])->id;
    $user=User::find($id);
    $user->assignRole('end_user');
    $user->api_token=$id.''.$token;
    $user->save();
    if ($request->fcm_token) {
        DeviceToken::create([
            'fcm_token' => $request->fcm_token,
            'device_type' => $request->mobile_type,
            'user_id' => $user->id,
        ]);
    }
    auth()->login($user);
    
    return $this->sendResponse(  new SingleUser($user),  __('models/translator.login_successfully'));
} catch (\Exception $ex) {
    return $this->sendError(__('models/translator.email_already_exist'));
}
}

    
    /**
    * @OA\Post(

        *  path="/api/user/login",
       
        *  operationId="Login",
        *  tags={"User"},
       
        *  summary="Login user ",
       
       
    
            *  @OA\Parameter(
            *      name="email",
            *      in="query",
            *      required=true,
            *      @OA\Schema(
            *           type="string"
            *      )
            *   ),

            *   @OA\Parameter(
            *      name="password",
            *      in="query",
            *      required=true,
            *      @OA\Schema(
            *           type="string"
            *      )
            *   ),
            *      @OA\Parameter(
            *      name="fcm_token",
            *      in="query",
            *      required=false,
            *      @OA\Schema(
            *           type="string"
            *      )
            *   ),
            *         @OA\Parameter(
            *      name="mobile_type",
            *      in="query",
            *      required=false,
            *      @OA\Schema(
            *           type="string"
            *      )
            *   ),

             *         @OA\Parameter(
            *      name="lang",
            *      in="query",
            *      required=true,
            *      @OA\Schema(
            *           type="string"
            *      )
            *   ),
       
       
        *      @OA\Response(
               *          response=422,
               *          description="Unprocessable Entity",
               *          @OA\JsonContent()
               *       ),
               *      @OA\Response(response=400, description="Bad request"),
               *      @OA\Response(response=200, description="User register"),
               *      @OA\Response(response=404, description="Resource Not Found"),
       
        * )
       
        */
    public function login(Login $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        \Session::put('locale',$request->lang);
        \App::setLocale($request->lang);

        if (auth()->attempt($credentials)) {
            $user = User::find(auth()->id());
            $token=$user->api_token;
            if ($request->fcm_token) {
                DeviceToken::updateOrCreate(['device_type' => $request->mobile_type,

                    'user_id' => auth()->id(),], [
                    'fcm_token' => $request->fcm_token,
                    'device_type' => $request->mobile_type,
                    'user_id' => auth()->id(),
                ]);
            }
            return $this->sendResponse(  new SingleUser(auth()->user()),  __('models/translator.login_successfully'));

        } else {
            $msg = __('api.password_change_successfully');

            $this->data['status'] = 404;
            $this->data['code'] = 0;
            $this->data['respone'] = $msg;
            return $this->sendError(__('models/translator.UnAuthorised'));


        }
    }

    /**
     * 
    * @OA\Post(

        *  path="/api/user/update",
       
        *  operationId="Login",
        *  tags={"User"},
       
        *  summary="update user ",
      * security={{"bearer_token":{}}},
        *  @OA\Parameter(
            *      name="name",
            *      in="query",
            *      required=false,
            *      @OA\Schema(
            *           type="string"
            *      )
            *   ),
            *  @OA\Parameter(
            *      name="email",
            *      in="query",
            *      required=false,
            *      @OA\Schema(
            *           type="string"
            *      )
            *   ),

         
             *   @OA\Parameter(
            *      name="mobile",
            *      in="query",
            *      required=false,
            *      @OA\Schema(
            *           type="integer"
            *      )
            *   ),
        
       
       
        *      @OA\Response(
               *          response=422,
               *          description="Unprocessable Entity",
               *          @OA\JsonContent()
               *       ),
               *      @OA\Response(response=400, description="Bad request"),
               *      @OA\Response(response=200, description="User register"),
               *      @OA\Response(response=404, description="Resource Not Found"),
       
        * )
       
        */
    public function update(Update $request)
    {
        $user = auth()->User();
        
        if (empty($user)) {
            return $this->sendError(__('models/translator.user_not_found'));
        }
        try{

            \Session::put('locale',$user->locale);
            \App::setLocale($user->locale);
        $user->name = $request->name;
        $user->email = $request->email;

        $user_check=User::where('mobile',$request->mobile)->where('id','!=',$user->id)->first();
        if($user_check){
            return $this->sendError(__('models/translator.mobile_already_exist'));
        }
        $user->mobile = $request->mobile;

        // if ($request->avatar) {
        //     $this->saveImage('uploads/', $request->avatar);
        //     $user->avatar = $request->avatar->hashName();
        // }
        // if ( !Hash::check($request->password, $user->password)) {
        //     return $this->sendError('your password incorrect');


        // }

            $user->save();
        return $this->sendResponse(new SingleUser($user), __('models/translator.user_updated_successfully'));

    } catch (\Exception $ex) {
        return $this->sendError($ex->getMessage());
    }
    }

    /**
     * Returns Authenticated User Details
     */
    public function userDetails()
    {
        $user = auth()->user();
        if (empty($user)) {
            return $this->sendError('user  not found');
        }
        return $this->sendResponse(new SingleUser($user), 'data load successfully');

    }

 /**
     * 
    * @OA\Post(

        *  path="/api/user/forgot_password",
       
        *  operationId="forgot_password",
        *  tags={"User"},
       
        *  summary="User Forget Password ",
      * security={{"bearer_token":{}}},
  
            *  @OA\Parameter(
            *      name="email",
            *      in="query",
            *      required=true,
            *      @OA\Schema(
            *           type="string"
            *      )
            *   ),

              *  @OA\Parameter(
            *      name="lang",
            *      in="query",
            *      required=true,
            *      @OA\Schema(
            *           type="string"
            *      )
            *   ),
     
         
        
       
       
        *      @OA\Response(
               *          response=422,
               *          description="Unprocessable Entity",
               *          @OA\JsonContent()
               *       ),
               *      @OA\Response(response=400, description="Bad request"),
               *      @OA\Response(response=200, description="User register"),
               *      @OA\Response(response=404, description="Resource Not Found"),
       
        * )
       
        */
    public function postForgotPassword(ForgetPassword $request)
    {

        $user = User::where('email', $request['email'])->first();

        if (empty($user)) {
            return $this->sendError(__('models/translator.user_not_found'));
        }

        \Session::put('locale',$request->lang);
        \App::setLocale($request->lang);

//        $user->sms_code = rand(000000, 999999);
//        $code = $user->sms_code;
//        $this->send_sms($request['mobile'], $code . 'الكود الخاص بك');
    
        try {
            $data = ['title' => 'your activation code is', 'body' => 222];
          // Mail::To($request['email'])->send(new NotifyEmail($data));

        } catch (\Exception $ex) {
            return $this->sendError(__('models/translator.error_in_sending_email'));
        }
        $user->save();

        return $this->sendSuccess(__('models/translator.email_sent'));


    }

   

    public function postResetPassword(ResetPassword $request)
    {
        $user = User::where('id', $request->user_id)->first();

        if (empty($user)) {
            return $this->sendError(__('models/translator.user_not_found'));
        }

       \Session::put('locale',$user->locale);
        \App::setLocale($user->locale);
        $user->password = bcrypt($request['password']);
        $user->sms_code = null;
        $user->update();

        $msg =    __('models/translator.password_changed_successfully');

        return $this->sendResponse(new SingleUser($user), $msg);

    }


    /**
     * 
    * @OA\Post(

        *  path="/api/user/change_password",
       
        *  operationId="change_password",
        *  tags={"User"},
       
        *  summary="User Change Password ",
      * security={{"bearer_token":{}}},
       
            *  @OA\Parameter(
            *      name="email",
            *      in="query",
            *      required=true,
            *      @OA\Schema(
            *           type="string"
            *      )
            *   ),
                *  @OA\Parameter(
            *      name="password",
            *      in="query",
            *      required=true,
            *      @OA\Schema(
            *           type="string"
            *      )
            *   ),
                *  @OA\Parameter(
            *      name="new_password",
            *      in="query",
            *      required=true,
            *      @OA\Schema(
            *           type="string"
            *      )
            *   ),


         
        
       
       
        *      @OA\Response(
               *          response=422,
               *          description="Unprocessable Entity",
               *          @OA\JsonContent()
               *       ),
               *      @OA\Response(response=400, description="Bad request"),
               *      @OA\Response(response=200, description="User register"),
               *      @OA\Response(response=404, description="Resource Not Found"),
       
        * )
       
        */

    public function postChangePassword(ChangePassword $request)
    {
        
        $user = User::where('email', $request->email)->first();

        if (empty($user)) {
            return $this->sendError('user  not found');
        }

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($credentials)) {
            $user->fill([
                'password' => Hash::make($request->new_password),
            ])->save();

            $msg = 'تم تغيير كلمه المرور بنجاح';
            $this->data['data'] = new SingleUser($user);
            $this->data['status'] = "ok";
            $this->data['message'] = $msg;
//             return response()->json($this->data, 200);
            return $this->sendResponse(['user' => new SingleUser($user)], $msg);


        } else {
            return $this->sendError('password not match old one');
        }


    }


     /**
     * 
 * @OA\Post(

        *  path="/api/user/change_locale",
       
        *  operationId="my order",
        *  tags={"User"},
       
        *  summary="change locale for user ",
  * security={{"bearer_token":{}}},
   
       
        *  @OA\Parameter(
            *      name="lang",
            *      in="query",
            *      required=true,
            *      @OA\Schema(
            *           type="string"
            *      )
            *   ),
   
    *      @OA\Response(
           *          response=422,
           *          description="Unprocessable Entity",
           *          @OA\JsonContent()
           *       ),
           *      @OA\Response(response=400, description="Bad request"),
           *      @OA\Response(response=200, description="language changed"),
           *      @OA\Response(response=404, description="Resource Not Found"),
   
    * )
   
    */
    public function setLocale(Request $request)
    {
        $user=User::whereId(auth()->id())->first();
        
        $user->locale=$request->lang;
        $user->save();

        \Session::put('locale',$request->lang);
        \App::setLocale($request->lang);

        return Response::json(  Lang::get('models/translator.language_changed'));
    }
}
