<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @foreach($posts as $post)
        <meta name="description" content="{{$post->description}}">
        <meta name="keywords" content="{{$post->keywords}}">
    @endforeach
    <title>Document</title>
</head>
<body>
<a href="/showbasket">Show-bASKET </a>
{{Session::has('cart') ? Session::get('cart')->totalQty : null }}
<hr>


@foreach($posts as $post)
    <h2> {{$post->title}}  </h2>
    <br>
    cost:
    {{$post->cost}}
    <br>
    <img src='{{url('uploads/'.$post->image)}}' height="200" width="300" alt="khabar aks nadarad">
    <br>
    <a href='{{url('post/'.$post->urltitle)}}'>
        {!! str_limit($post->content, 10) !!}
    </a>
    <br>
    <br>

    <br>

    <a href="/{{$post->id}}/session"> aded to sabad </a>


    <br><br>

    @auth
        @can('posts.update',\Illuminate\Support\Facades\Auth::user())
            <form action="/post/{{$post->urltitle}}/edit">
                {{csrf_field()}}
                <input type="submit" value="edit">
            </form>
        @endcan
    @endauth

    @auth
        @can('posts.delete',\Illuminate\Support\Facades\Auth::user())
            <br>
            <form action="/post/{{$post->urltitle}}" method="post">
                {{csrf_field()}} {{method_field('delete')}}
                <input type="submit" value="delete">
            </form>
        @endcan
    @endauth
    <hr>

@endforeach


</body>
</html>


