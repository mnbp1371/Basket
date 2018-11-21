<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function storecomment(Request $request,$id ){


        $request->validate([
            'username' => 'required',
            'body' => 'required',
        ]);

        $post = Post::find($id);
        $post->comments()->create([
            "username"=> $request->username,
            "body"=> $request->body,
        ]);

         $post->save();

      return back();

    }


    public function showcomment(){




    }




}
