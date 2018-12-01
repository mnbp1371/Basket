<?php

namespace App\Http\Controllers;

use App\Basket;
use App\Cart;
use App\Order;
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
use Session;

 class PostController extends Controller
{

         public function __construct()
     {
         $this->middleware('checkPermission')->except('removeshop','index', 'show','showbasket','session','checkout','showshops','reducebyone'); //this function can work for evrybody
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
            'cost' => 'required',
        ]);


        $news = new Post;
        $news->title = $request->title;
        $news->content = $request->content;
        $news->cost = $request->cost;
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
            'cost' => 'required',
        ]);
        $posts = Post::find($post->id);
        $posts->title = $request->title;
        $posts->content = $request->content;
        $posts->cost = $request->cost;
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

    // session

     public function session(Request $request,$id)
     {

         $post=Post::find($id);
         $oldCart=Session::has('cart') ? Session::get('cart'):null;
         $cart= new Cart($oldCart);
         $cart->add($post,$post->id);

         $request->session()->put('cart',$cart);
         $basketFinder = User::find(\auth()->id())->baskets->first();
         if($basketFinder == null){
             $ahmadi = new Basket;
             $ahmadi->cart= serialize($cart);
             $ahmadi->user_id= \auth()->id();
             $ahmadi->save();


         }else{
             $basketId = User::find(\auth()->id())->baskets->first()->id;
             $a = Basket::find($basketId);
             $a->cart= serialize($cart);
             $a->user_id= \auth()->id();
             $a->save();


         }





         //dd($request->session()->get('cart'));
         return back();
     }


     public function showbasket()
     {



        if(! Session::has('cart')){
            return view('showbasket',['posts'=>null]);

        }

        $oldCart = Session::get('cart');
        $cart =new Cart($oldCart);
        //return view('showbasket',['posts'=>$cart->items,'totalCost'=>$cart->totalPrice]);


         $baskets= Auth:: user()->baskets;
         // dd($orders);
         $baskets->transform(function ($basket,$key){
             $basket->cart=unserialize($basket->cart);
             return $basket;
         });
         $a = array();

         foreach($baskets as $basket){
             $a = $basket;
         }

        // dd($a);

        return view('showbaskets',compact('a'));

     }
     public function checkout(){
             $oldcart = Session::get('cart');
             $cart= new Cart($oldcart);
             $order= new Order;
             $order->cart= serialize($cart);
             $order->user_id= \auth()->id();
             $order->save();
             Session::forget('cart');
             return redirect('post');
     }

     public function showshops(){
             $orders= Auth:: user()->orders;
          // dd($orders);
         $orders->transform(function ($order,$key){
             $order->cart=unserialize($order->cart);
             return $order;
         });
         $a = array();

          foreach($orders as $order){
            $a = $order;
         }
        return view('showshops',['a'=>$a]);
     }
        public function reducebyone($id){

            $oldCart=Session::has('cart') ? Session::get('cart'):null;
            $cart= new Cart($oldCart);
            $cart->reducebyone($id);
            if(count($cart->items )> 0)
            {
                Session::put('cart',$cart);
                ///
                $basketId = User::find(\auth()->id())->baskets->first()->id;
                $basket = Basket::find($basketId);
                $basket->cart= serialize($cart);
                $basket->user_id= \auth()->id();
                $basket->save();
                ///
                return back();
            }else{
                Session::forget('cart');
                //
                $basketId = User::find(\auth()->id())->baskets->first()->id;
                $basketd = Basket::find($basketId);
                $basketd->cart= serialize($cart);
                $basketd->user_id= \auth()->id();
                $basketd->save();

                return back();
            }
        }

        public function removeshop($id){
            $oldCart=Session::has('cart') ? Session::get('cart'):null;
            $cart= new Cart($oldCart);
            $cart->removeshop($id);
            if(count($cart->items )> 0)
            {
                Session::put('cart',$cart);
                $basketId = User::find(\auth()->id())->baskets->first()->id;
                $basket = Basket::find($basketId);
                $basket->cart= serialize($cart);
                $basket->user_id= \auth()->id();
                $basket->save();
                return back();
            }else{
                Session::forget('cart');
                $basketId = User::find(\auth()->id())->baskets->first()->id;
                $basketd = Basket::find($basketId);
                $basketd->cart= serialize($cart);
                $basketd->user_id= \auth()->id();
                $basketd->save();
                return back();
            }


        }
 }
