<?php
namespace App\Traits;

use App\Models\Currency;
use App\Models\Offer;
use App\Models\Product;
use Illuminate\Support\Facades\Config;
use RuntimeException;

trait LoadData
{
    /**
     * Load products with price in locale price
     * @param Currency $currency current currency
     * @return Product[] list of products as Product object
     */
    public function getProducts(Currency $currency){
        $init_products = config('app.init_products');
        return array_map(function ($value) use($currency) {
            $value['price']= $currency->convert((float)$value['price']);
            return new Product($value);
        },$init_products);
    }

    /**
     * Load offers
     * @return Offer[] list of products as Product object
     */
    public function getOffers(){
        $init_offers = Config::get('app.init_offers');
        return array_map(function ($value) {
            return new Offer($value);
        },$init_offers);
    }
    /**
     * @return Currency[] list of currencies as Currency object
     */
    public function getCurrencies(){
        $currencies= Config::get('app.init_currencies');
        $currencies=array_map(function ($value) {
            return new Currency($value);
        },$currencies);
        return $currencies;
    }

    /**
     *
     * @param $selected_currency string user input selected currency
     * @return mixed return user selected currency as Currency object
     * @throws RuntimeException return exception if  user input is wrong
     */
    public function getCurrency($selected_currency){
        $currencies= $this->getCurrencies();
        $currency = array_filter($currencies, function ($item_currency) use ($selected_currency) {
            return $item_currency->getKey() == $selected_currency;
        });
        $currency = array_shift($currency);
        if (!$currency) {
            throw new RuntimeException('Not Found Currency');
        }
        return $currency;
    }
    public function getTax(){
        return Config::get('app.tax');
    }
}
