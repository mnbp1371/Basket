<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>show</title>

</head>
<body>
<h3>title:</h3>
{{$posts->title}}
<hr>
writer:
<br> {{$users->name}}
<hr>
COst:
<br> {{$posts->cost}}
<br>
<hr>
<h3>image:</h3>
<img src="{{url('uploads/'.$posts->image)}}" height="100" width="100">
<hr>
<h3>content:</h3>
{!! $posts->content !!}
<hr>
<h3>date:</h3>
{{$posts->created_at}}
<hr>
tags: <br>
@foreach($posts->tag as $tag)
    <a href="{{url('post')}}">   {{$tag->name}} </a>
    <br>
@endforeach
<hr>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<form action="/comment/{{$posts->id}}" method="post">
    {{csrf_field()}}
    username:
    <input type="text" name="username"><br>
    comment:
    <textarea name="body" cols="30" rows="3"></textarea>
    <input type="submit">
</form>


<hr>
<hr>
@foreach($posts->comments as $comment)
    {{$comment->username}}
    <br>
    {{$comment->body}}
    <br>
    {{$comment->created_at}}
    <hr>

@endforeach


</body>
</html>