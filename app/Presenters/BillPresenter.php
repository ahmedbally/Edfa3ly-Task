<?php


namespace App\Presenters;

use App\Traits\LoadData;
use RuntimeException;

class BillPresenter extends Presenter
{
    use LoadData;
    private $products;
    private $offers;
    private $currency;
    private $cart;
    private $tax;

    private $taxes=0;
    private $subtotal=0;
    private $total=0;
    private $discounts=[];

    /**
     * BillPresenter constructor.
     * @param $currency string user input of selected currency
     * @param $cart array user input of bought products
     */
    public function __construct(string $currency, array $cart)
    {
        $this->cart=$cart;
        $this->currency=$this->getCurrency($currency);
        $this->products=$this->getProducts($this->currency);
        $this->offers=$this->getOffers();
        $this->tax= $this->getTax();
    }

    /**
     * Parse user input of bought products
     * @throws RuntimeException
     */
    public function parseCart()
    {
        $products=$this->products;
        $this->cart = array_map(function ($item) use ($products) {
            $cart_item=array_filter($products, function ($product) use ($item) {
                return $product->getKey() == $item;
            });
            $cart_item = array_shift($cart_item);
            if (!$cart_item) {
                throw new RuntimeException('Not Found Cart Item '.$item);
            };
            return $cart_item;
        }, $this->cart);
    }

    /**
     * calculate subtotal
     */
    public function calculateSubTotal(){
        $this->subtotal = array_reduce($this->cart,function ($sum,$item){
            return $sum + $item->price;
        });
    }

    /**
     *calculate offers discounts by apply offer to cart
     */
    public function calculateOffer(){
        foreach ($this->offers as $offer){
            $offer->fill(['cart'=>$this->cart,'currency'=>$this->currency]);
            if($offer_result=$offer->apply())
                $this->discounts[]=$offer_result;
        }
    }
    /**
     * get calculated subtotal to be printed
     * @return string formatted value
     */
    public function getSubTotal(){
        return (string)$this->currency->format($this->subtotal);
    }
    public function calculateTaxes(){
        $this->taxes= $this->subtotal * ($this->tax/100);
    }
    /**
     * get calculated taxes to be printed
     * @return string formatted value
     */
    public function getTaxes(){
        return (string)$this->currency->format($this->taxes);
    }

    /**
     * get discount to be printed and calculate total
     * @return array formated discount
     */
    public function getDiscounts(){
        $this->total+=$this->subtotal+$this->taxes;
        return (array) array_map(function ($discount){
            $this->total+=$discount->discount;
            $discount->discount=$this->currency->format($discount->discount);
            $discount->value=$discount->percentage?
                $discount->value.'%':
                $this->currency->format($this->currency->convert($discount->value));
            return $discount;
        },$this->discounts);
    }

    /**
     * format total to be printed
     * @return string
     */
    public function getTotal(){
        return (string)$this->currency->format($this->total);
    }
}
