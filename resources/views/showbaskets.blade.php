
@if(Session::has('cart'))
    @foreach($a->cart->items as $b)
        {{$b['cost']}}<br>
        {{$b['qty']}}<br>
        {{$b['item']['title']}}<br>
        <br>
        <br>
        <a href="/reducebyone/{{$b['item']['id']}}">remove one item </a>
        <br>
        <a href="/removeshop/{{$b['item']['id']}}">remove all </a>

        <hr>
    @endforeach
    <hr>{{$a->cart->totalPrice}}
@endif







