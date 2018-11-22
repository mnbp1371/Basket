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
    <form action="/post" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        title:<br>
        <input type="text" name="title" ><br>
        <hr>
        <input type="file" name="image">
        <hr>
        urltitle:<br>
        <input type="text" name="urltitle">
        <hr>
        description: <br>
        <textarea name="description" cols="10" rows="5"></textarea>
        <hr>
        keywords: <br>
        <textarea name="keywords" cols="10" rows="5"></textarea>
        <br>tag:
        <select name="tag[]" multiple>
            @foreach($tags as $tag)
                <option value="{{$tag->id}}">{{$tag->name}}</option>
            @endforeach
        </select>


        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

                <strong>Details:</strong>

                <textarea class="form-control summernote" name="content"></textarea>

            </div>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">

            <button type="submit" class="btn btn-primary">Submit</button>

        </div>



        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


    </form>
    <br><br>

    <form action="/tag" method="post">
        {{csrf_field()}}

        <input type="text" name="tagname" >
        <input type="submit" >

    </form>


    <script type="text/javascript">

        $(document).ready(function() {

            $('.summernote').summernote({

                height: 300,

            });

        });

    </script>
</body>

</html>