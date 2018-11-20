<?php

namespace App\Http\Controllers;

use App\Post;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use Keraken\Zaman\Facades\Zaman;
use Hekmatinasser\Verta\Verta;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

 class PostController extends Controller
{


     public function getSummernote()

     {

         return view('summernote');

     }

     /**

      * Show the application dashboard.

      *

      * @return \Illuminate\Http\Response

      */

     public function postSummernote(Request $request)

     {

         $this->validate($request, [

             'detail' => 'required',

         ]);

         $detail=$request->input('detail');

         $dom = new \DomDocument();

         $dom->loadHtml($detail, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

         $images = $dom->getElementsByTagName('img');

         foreach($images as $k => $img){

             $data = $img->getAttribute('src');

             list($type, $data) = explode(';', $data);

             list(, $data)      = explode(',', $data);

             $data = base64_decode($data);

             $image_name= "/upload/" . time().$k.'.png';

             $path = public_path() . $image_name;

             file_put_contents($path, $data);

             $img->removeAttribute('src');

             $img->setAttribute('src', $image_name);

         }

         $detail = $dom->saveHTML();

         dd($detail);

     }



    public function index()
    {
        $posts = Post::orderBy('id','DESC')->get();
        return view('post',compact('posts'));

    }


    public function create()
    {
        return view('create');
    }



    public function store(Request $request)
    {

         $request->validate([
            'title' => 'required|max:100',
            'content' => 'required|unique:posts|min:100',
            'urltitle' => 'required',
            'image' => 'required',
            'description' => 'required',
            'keywords' => 'required',
        ]);


        $news = new Post;
        $news->title = $request->title;
        $news->content = $request->content;
        $news->urltitle = $request->urltitle;
        $news->description = $request->description;
        $news->keywords = $request->keywords;

        $news->image = basename($request->image);
        $news->save();
        $name = "post-" . $news->id . "." . $request->file('image')->getClientOriginalExtension(); //image


        $cover = $request->file('image');

        Storage::disk('public')->put($name,  File::get($cover));
        $news->image = $name; //insert name image to database
        $news->save();
        return back();

    }


    public function show(Post $post)
    {

        $posts = Post::find($post->id);
        return view('show',compact('posts'));

    }



    public function edit(Post $post)
    {
        $posts = Post::find($post->id);
        return view('edit',compact('posts'));

    }



    public function update(Request $request, Post $post)
    {


        $request->validate([
            'title' => 'required|max:100',
            'content' => 'required|min:100',
            'urltitle' => 'required',
            'description' => 'required',
            'keywords' => 'required',
            'image' => 'required',
        ]);
        $posts = Post::find($post->id);
        $posts->title = $request->title;
        $posts->content = $request->content;
        $posts->urltitle = $request->urltitle;
        $posts->image = basename($request->image);
        $posts->description = $request->description;
        $posts->keywords = $request->keywords;
        $posts->save();

        $name = "post-" . $posts->id . "." . $request->file('image')->getClientOriginalExtension(); //image
        $cover = $request->file('image');

        Storage::disk('public')->put($name,  File::get($cover));



        $posts->image = $name; //insert name image to database
        $posts->save();

    }



    public function destroy(Post $post)
    {
        $posts = Post::find($post->id);
        $posts->delete();
        return back();
    }
}
