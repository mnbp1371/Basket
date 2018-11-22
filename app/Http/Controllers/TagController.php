<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{

    public function store(Request $request){

        $tag= new Tag();
        $tag->name=$request->tagname;
        $tag->save();
        return back();

    }

    public function index(Tag $tag){

        $posts=$tag->post;
        return view('post',compact('posts'));

    }
}
