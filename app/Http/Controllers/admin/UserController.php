<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderTranslator;
use App\Models\TranslationChat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laracasts\Flash\Flash;
use Spatie\Permission\Contracts\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::role(['operation manager', 'translator','checker','customer service','accounting'])->get();
        
         $data = [
              'category_name' => '',
              'page_name' => 'orders_page',
              'has_scrollspy' => 0,
              'scrollspy_offset' => '',
          ];
  
         return view('admin.user', compact('users'))->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
           
            $user=User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password)
            ]);
            if($user)
            {
         
                switch($request->role){
                    case 1 : 
                        $user->assignRole('translator');
                        break;
                    case 2 : 
                          $user->assignRole('checker');
                          break;
                    case 3 : 
                        $user->assignRole('customer service');
                        break;
                    case 4 : 
                        $user->assignRole('operation manager');
                        break;
                    case 5 : 
                        $user->assignRole('accounting');
                        break;
                }
                return ['success' => true, 'message' => 'user create !!'];
            } else {
                return ['success' => false, 'message' => 'error'];
            }


        }catch(\Throwable $th)
        {
            return ['success' => false, 'message' => $th];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try{
           if($request->password!=''){
          
            $user=User::whereId($request->id)->update([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password)
            ]);
        } else {
            $user=User::whereId($request->id)->update([
                'name'=>$request->name,
                'email'=>$request->email,
               
            ]);
        }
    //     $user=User::find($request->id);
    //     dd($user->getRoleNames());
    //   //  $role = Role::findByName('writer');
    //    dd($user->removeRole($user->getRoleNames()));
    //         if($user)
    //         {
        
                switch($request->role){
                    case 1 : 
                        $user->assignRole('translator');
                        break;
                    case 2 : 
                          $user->assignRole('checker');
                          break;
                    case 3 : 
                        $user->assignRole('customer service');
                        break;
                    case 4 : 
                        $user->assignRole('operation manager');
                        break;
                    case 5 : 
                        $user->assignRole('accounting');
                        break;
                }
                return ['success' => true, 'message' => 'user create !!'];
            


        }catch(\Throwable $th)
        {
            return ['success' => false, 'message' => $th];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
     
        $user=User::find($request->id);

      $user->delete();

      return ['success' => true, 'message' => 'deleted'];
    }

    public function chat(Request $request)
    {

     

      $orders=Order::with('user')->get();
      $orders->map(function($item){
 
        switch($item->status){
            case 'n': 
                $item->status='under review';
                break;
            case 'ca': 
                $item->status='cancel';
                break;
            case 'p': 
                $item->status='processing';
                break;
            case 'up': 
                $item->status='waiting customer to approve price';
                break;
            case 'ap':
                $item->status='processing';
                break;
            case 'ur': 
                $item->status='processing';
                break;
            case 'c': 
                $item->status='complete';
                break;
            case 'a': 
                $item->status='processing';
                break;
            case 'uc': 
                $item->status='processing';
                break;
        }
    });
      
       $data = [
            'category_name' => 'datatable',
            'page_name' => 'orders_page',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

       return view('admin.order.index', compact('orders'))->with($data);

    }


    public function getChat(Request $request)
    {
        $chats=TranslationChat::where('order_id',$request->order_id)->get();
         $user=User::find($request->user_id);
        if($chats->count()>0){
            $data = [
                'category_name' => 'datatable',
                'page_name' => 'chat',
                'has_scrollspy' => 0,
                'scrollspy_offset' => '',
            ];
    
           return view('admin.order.chat',compact('chats','user'))->with($data);
        } else {
            Flash::success('no messages !');

      return redirect(route('admin.chat.index'));
        }
     
    }
}
