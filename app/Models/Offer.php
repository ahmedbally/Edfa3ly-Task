<?php


namespace App\Models;


class Offer extends Model
{
    protected $primaryKey='on';
    protected $fillable=['cart','currency','on','value','percentage','rules'];

    /**
     * count occurrence of every product in cart
     * @return array ["T-shirt":2,"Jacket":1]
     */
    public function counting(){
        return array_count_values(array_map(function ($product){
            return $product->getKey();
        },$this->cart));
    }

    /**
     * get product from cart,make item in cart unique to get only one object
     * @param $key
     * @return mixed
     */
    public function product($key)
    {
         $products_in_cart=array_filter(array_unique($this->cart, SORT_REGULAR), function ($item) use ($key) {
            return $item->getKey()==$key;
        });
        return array_shift($products_in_cart);
    }

    /**
     * check rules of the offer on cart by subtract it from cart counting
     * @param $cart
     * @return bool
     */
    public function check_rules(&$cart){
        foreach($this->rules as $key=>$value){
            //check if rule key ex:T-shirt is in cart counting
            if (!isset($cart[$key]))
                return false;
            //after this line for example counting will be ["T-shirt":1,"Jacket":1]
            $cart[$key]-=$value;
            //if counting less than 0 means that offer not available
            if ($cart[$key]<0) return false;
        }
        return true;
    }

    /**
     * apply offer to the cart
     * @return Discount|false return false when not applicable or Discount object if applicable
     */
    public function apply()
    {
        $discount=0;
        $cart=$this->counting();
        //making sure that item that have offer in cart to be applicable
        if (!isset($cart[$this->on]))
            return false;
        $product=$this->product($this->on);
        //for every occurrence check rules
        for($item=0;$item < $cart[$this->on];$item++){
            if ($this->check_rules($cart)){
                //calculate offer discount
                if ($this->percentage)
                    $discount-=$product->price * ($this->value/100); //percentage
                else
                    $discount-=$product->price - $this->currency->convert($this->value); //fixed value converted to locale
            }
        }

        //if total is zero that mean offer not applicable
        if (!$discount) return false;
        return  new Discount([
            'discount'=>$discount,
            'product'=>$product,
            'value'=>$this->value,
            'percentage'=>$this->percentage,
        ]);

    }

}
