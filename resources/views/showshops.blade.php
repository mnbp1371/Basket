@foreach($a->cart->items as $b)
   {{$b['cost']}}<br>
   {{$b['qty']}}<br>
   {{$b['item']['title']}}<br>
   <hr>
@endforeach






