<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Http\Request;

class AdminPanelController extends Controller
{


    public function __construct()
    {
        $this->middleware('admin');

    }

    public function indexuser()
    {

        $users=User::orderBy('rol_id','ASC')->get();

        return view('adminpanel',compact('users'));

    }

    public function indexstore(Request $request,$id)
    {
        $user =User::find($id);
        $user->rol_id = $request->permission;
        $user->save();
        return back();


    }

    public function showposts($id)
    {
        $user= User::find($id);
        $posts= $user->posts;
        return view('showposts',compact('posts'));

    }



    public function destroyuser(Post $post ,$id)
    {
        $users = User::find($id);
        $users->delete();
        return back();
    }
}
