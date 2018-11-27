@foreach($posts as $post)
    title: {{$post->title}}
    <br> <br> imag:<br>
    <img src='{{url('uploads/'.$post->image)}}' height="200" width="300" alt="khabar aks nadarad">
    <br><br>
    <a href={{url('post/'.$post->urltitle)}}>
        {!! str_limit($post->content, 10) !!}
    </a>
    <br>


            <br>
            <form action={{url('post/'.$post->urltitle)}} method="post">
                {{csrf_field()}} {{method_field('delete')}}
                <input type="submit" value="delete">
            </form>

    <hr>
@endforeach