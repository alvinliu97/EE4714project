<?php
    class CartItem {
        public $counterd;
        public $color;
        public $size;
        public $quantity;

        public function __construct($counterd, $color, $size, $quantity) {
            $this->id = $counterd;
            $this->color = $color;
            $this->size = $size;
            $this->quantity = $quantity;
        }
    }

    function get_item_index_in_cart (CartItem $countertem , $cart_array) {
        for ($counter = 0 ; $counter < sizeof($cart_array); $counter++) {
            $cart_item = $cart_array[$counter];
            if (($cart_item->id == $countertem->id) && ($cart_item->color == $countertem->color) && ($cart_item->size == $countertem->size)) {
                return $counter;
            }
        }
        return -1;
    }
