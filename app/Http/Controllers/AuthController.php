<?php

namespace App\Http\Controllers;

use App\User;
use App\Detail;
use App\Admin;
use App\Comment;

use App\Post;

use Carbon\Traits\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Response;
use Auth;
use Illuminate\Support\Facades\Http;


class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserDetail(Request $request, $id)
    {
        $users = DB::table('users')
        -> join('details','details.detail_id','=','users.detail_id')
        ->where('users.user_id',$id)
        -> get();        
        return response()->json($users);


    }
    



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    /** 
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
 
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userLogin(Request $request)
    {
        // $email = ($request->input("email"));
        // $password = $request->input("password");


        $users = User::all()->where('email', $request->email);
        $count = $users->count();
        if ($count == 0) {
            return response()->json([
                'message' => 'Your Credential is wrong',
                'count' => $count,
                401
                ]);
            }
            else{
            $data = DB::table('users')
                    ->where('email',$request->email)
                        -> get();
            foreach ($data as $data) {
                $hashed_pw = $data->password;
            }
            foreach ($users as $dat) {
                    
                $detail_id = $dat->detail_id;


            }
            if(Hash::check($request->password, $hashed_pw)){

        
                $data = DB::table('users')
                -> join('details','details.detail_id','=','users.detail_id')
                ->where('details.detail_id',$detail_id)
                -> get();
                foreach ($data as $dat) {
                    $first_name = $dat->first_name;
                    $user_id = $dat->user_id;

                    // Session::put('first_name',$dat->first_name);
                    // Session::put('user_id',$dat->user_id);
                }
                    return response()->json([
                    'message' => 'accepted',
                    'first_name'=>$first_name,
                    'user_id'=> $user_id
                    
                    ]);
                
            }else{
                return response()->json(['message' => 'invalid password',401]);
            }
        
                
                 
                 //return dump($data);
            }
            
    }
    
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function signUp(Request $request){
        $details= new Detail;

        $details->first_name =  $request->first_name;
        $details->save();
        $detail_ids = DB::table('details')->get()->last()->detail_id;
        
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'detail_id' => $detail_ids
        ]);
        return response()->json([$user]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function adminLogin(Request $request)
    {
        $admin = Admin::all()->where('username',  $request->username)->where('password',$request->password);
        $count = $admin->count();
        if ($count == 0) {
            return Redirect::to(URL::previous())->with('message', 'Invalid  Username and or Passwords');
            }
            else{
                return response()->json(['message' => 'masuk']);
    }



}

  



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
   

  
}
