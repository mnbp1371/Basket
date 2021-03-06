<?php

namespace App;

class Cart {
   public $items = null;
   public $totalQty = 0;
   public $totalPrice = 0;

    public function __construct($oldCart)
    {
        if($oldCart){
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
        }
    }


    public function add($item , $id)
    {
        $storedItem  = ['qty'=>0 ,'cost'=>$item->cost , 'item'=>$item];
        if ($this->items){
            if (array_key_exists($id , $this->items)){
                $storedItem = $this->items[$id];
            }
        }

        $storedItem['qty']++;
        $storedItem['cost'] = $item->cost * $storedItem['qty'];
        $this-> items[$id] = $storedItem;
        $this-> totalQty++;
        $this-> totalPrice +=$item->cost;
    }


    public function reducebyone($id){

        $this->items[$id]['qty']--;
        $this->items[$id]['cost']-= $this->items[$id]['item']['cost'];
        $this->totalQty--;
        $this->totalPrice -= $this->items[$id]['item']['cost'];
        if( $this->items[$id]['qty']<= 0){
           unset($this->items[$id]);
        }
    }



    public function removeshop($id){
        $this->totalQty = ($this->totalQty)-($this->items[$id]['qty']);
        $this->items[$id]['qty']-=$this->items[$id]['qty'];
        $this->totalPrice -= $this->items[$id]['cost'];


            unset($this->items[$id]);
    }


}

