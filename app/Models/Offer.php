<?php


namespace App\Models;


class Offer extends Model
{
    protected $primaryKey='on';
    protected $fillable=['cart','currency','on','value','percentage','rules'];

    /**
     * count occurrence of every product in cart
     * @return array
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
     * check rules of the offer on cart
     * @param $cart
     * @return bool
     */
    public function check_rules(&$cart){
        foreach($this->rules as $key=>$value){
            if (!isset($cart[$key]))
                return false;
            $cart[$key]-=$value;
            if ($cart[$key]<0) return false;
        }
        return true;
    }

    /**
     * apply offer to the cart
     * @return Discount
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
                    $discount-=$product->price * ($this->value/100);
                else
                    $discount-=$product->price - $this->currency->convert($this->value);
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
        return [
            'discount_value'=>$discount,
            'discount'=>$this->currency->format($discount),
            'product'=>$product,
            'value'=>$this->percentage?$this->value.'%':$this->currency->format($this->currency->convert($this->value))
        ];
    }

}
