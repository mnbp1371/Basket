<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" />
    <script type="text/javascript" src="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>
    <title>index</title>
</head>
<body>

    <form action="/post/{{$posts->urltitle}}" method="post" enctype="multipart/form-data">
        {{method_field('put')}}
        {{csrf_field()}}

        title:<br>
        <input type="text" name="title"  value="{{$posts->title}}"><br>
        urltitle: <br>
        <input type="text" name="urltitle"  value="{{$posts->urltitle}}"><br>
        <br>
        <input type="file" name="image">
        <br>
        description: <br>
        <textarea name="description" cols="10" rows="5">{{$posts->description}} </textarea>
        <hr>
        keywords: <br>
        <textarea name="keywords" cols="10" rows="5"> {{$posts->keywords}} </textarea>

        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

                <strong>Details:</strong>

                <textarea class="form-control summernote" name="content"> {!! $posts->content !!}</textarea>

            </div>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">

            <button type="submit" class="btn btn-primary">Submit</button>

        </div>



        <br><br>
        <select name="tag[]" multiple >
            @foreach($tags as $tag)
                <option value="{{$tag->id}}" @if($posts->hasSelected($tag->id)) selected @endif>{{$tag->name}}</option >
            @endforeach
        </select>


    </form>


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <script type="text/javascript">

        $(document).ready(function() {

            $('.summernote').summernote({

                height: 300,

            });

        });

    </script>
</body>

</html>