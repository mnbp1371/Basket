<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>show</title>

</head>
    <body>
        <h3>title:</h3>
        {{$posts->title}}
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
    </body>
</html>