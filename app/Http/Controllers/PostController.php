<?php

namespace App\Http\Controllers;

use App\Post;
use App\Rol;
use App\Tag;
use App\User;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Keraken\Zaman\Facades\Zaman;
use Hekmatinasser\Verta\Verta;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

 class PostController extends Controller
{

         public function __construct()
     {
         $this->middleware('checkPermission')->except('index', 'show'); //this function can work for evrybody
        // $this->middleware('permission'); //this function can work for evrybody

        //print Auth::user();
        //print Auth::user()->id;

       // print Auth::user();
         //$user=User::find(1);
        //Auth::user()

         //$r= Auth::user()->rol_id();
         //echo $r ;
         //$a=$user->id;
        //echo $a ;

           //


       // $rol_id= Auth::user();
       // dd($rol_id);

       // if($rol_id == 1) {
          //  $this->middleware('auth')->except('index', 'show', 'create');
      //  }elseif($rol_id == 3){$this->middleware('auth')->except('index','show'); //this function can work for evrybody
        // }

       // $a = auth()::user;
       // dd($a);


     }


     public function getSummernote()

     {

         return view('summernote');

     }


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
        $tags=Tag::all();
        return view('post',compact('posts','tags'));

    }


    public function create()
    {
        $tags=Tag::all();
        return view('create',compact('tags'));
    }



    public function store(Request $request)
    {

         $request->validate([
            'title' => 'required|max:100',
            'content' => 'required|unique:posts|min:2',
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
        $news->user_id = \auth()->id();
        $news->image = basename($request->image);
        $news->save();

        //\auth()->user()->post_id =1;
        //$user = User::find(\auth()->id());
       // $user->post_id = $news->id;
        //$user->save();


      //  dd($news->id);


        $name = "post-" . $news->id . "." . $request->file('image')->getClientOriginalExtension(); //image


        $cover = $request->file('image');

        Storage::disk('public')->put($name,  File::get($cover));
        $news->image = $name; //insert name image to database
        $news->save();
        $news->tag()->sync($request->tag);
        return back();

    }


    public function show(Post $post)
    {
       //$a = User::find(1);
        //dd($a->posts);
        $posts = Post::find($post->id);


        $users = User::find($post->user_id);

        return view('show',compact('posts','users'));

    }



    public function edit(Post $post)
    {
        $posts = Post::find($post->id);
        $tags= Tag::all();
        return view('edit',compact('posts','tags'));

    }



    public function update(Request $request, Post $post)
    {


        $request->validate([
            'title' => 'required|max:100',
            'content' => 'required',
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
        $posts->tag()->sync($request->tag);

        return Redirect('post');
    }



    public function destroy(Post $post)
    {
        $posts = Post::find($post->id);
        $posts->delete();
        return back();
    }
}
