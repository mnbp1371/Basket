
@if(Session::has('cart'))
    @foreach($posts as $post)
       number of product:
        {{$post['qty']}}
        <br>
       titl:

        {{$post['item']['title']}}}
       <br>
       {{$post['item']['id']}}
        <br>
       <img src='{{url('uploads/'.$post['item']['image'])}}' alt="">
       <br>
       cost:
        {{$post['cost']}}
       <br>
       <a href="/reducebyone/{{$post['item']['id']}}">remove one item </a>
       <br>
       <a href="/removeshop/{{$post['item']['id']}}">remove all </a>


           <hr>





    @endforeach
    <hr>
    total cost:
<h1>{{$totalCost}}</h1>
@endif

@if(!Session('cart') == null)
    <form action="/checkout" method="post">
        {{csrf_field()}}
        <input type="submit">
    </form>
    @else
    <h2><a href="/post"> sabaaad </a> sabaaad kahiilst</h2>
@endif