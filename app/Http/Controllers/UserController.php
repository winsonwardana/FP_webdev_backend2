<?php

namespace App\Http\Controllers;


use App\User;
use App\Detail;
use App\Post;
use App\Comment;

use Carbon\Traits\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('posts')
            ->orderBy('post_id','DESC')
            -> get();
    // dump($data);
    return view ("welcome", compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $email = ($request->input("email"));
        $password = $request->input("password");


        $users = User::all()->where('email',  $email);
        $count = $users->count();
        if ($count == 0) {
            return Redirect::to(URL::previous())->with('message', 'Invalid  Username and or Passwords');
            }
            else{
            $data = DB::table('users')
                    ->where('email',$email)
                        -> get();
            foreach ($data as $data) {
                $hashed_pw = $data->password;
            }
            foreach ($users as $dat) {
                    
                $detail_id = $dat->detail_id;


            }
            if(Hash::check($password, $hashed_pw)){

        
                $data = DB::table('users')
                -> join('details','details.detail_id','=','users.detail_id')
                ->where('details.detail_id',$detail_id)
                -> get();
                foreach ($data as $dat) {
                    
                    Session::put('first_name',$dat->first_name);
                    Session::put('user_id',$dat->user_id);
                    

                    
                }
                return Redirect::to('/');
            }else{
                return Redirect::to(URL::previous())->with('message', 'Invalid  Username and or Passwords');
            }
        
                
                 
                 //return dump($data);
            }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $details= new Detail;
        $details->first_name =  $request->input('name');
        $details->save();
        $detail_ids = DB::table('details')->get()->last()->detail_id;
        
        User::create([
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'detail_id' => $detail_ids
        ]);

        return view('login');
    }

    public function detail($id){
        $post = DB::table('posts')
        ->where('post_id',$id)
        -> get();        

        $comments = DB::table('comments')
        ->join('users','users.user_id','=','comments.user_id')
        // ->join('posts','users.post_id','=','comments.post_id')
        ->join('details','details.detail_id','=','users.detail_id')
        ->where('comments.post_id',$id)
        
        ->get();
         return view('detailpost', compact('post','comments'));
        //dump($comments);


    }

    public function createcomment(Request $request, $id)
    {
        Comment::create([ 
            'user_id' =>$request->session()->get('user_id'),
            'post_id'=> $id,
            'comment' =>  $request->input('comment')
        ]);
        return Redirect::to("/detail/$id");
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
    public function update(Request $request, $id)
    {
       
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

    public function logout(Request $request) {
        Session::flush();
        $request->session()->regenerate();
        // $request->session()->flush();
        return Redirect::to("/");
    }
}
