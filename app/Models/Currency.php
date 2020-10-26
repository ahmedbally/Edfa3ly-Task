<?php


namespace App\Models;


class Currency extends Model
{
    protected $primaryKey='currency';
    protected $fillable=['currency','symbol','position','value'];

    /**
     * convert currencies ex: USD to EGP
     * @param $price float
     * @return float
     */
    public function convert(float $price){
        return (float)$price*$this->value;
    }

    /**
     * format prices to required format ex : 409 e£
     * @param float $price
     * @return string
     */
    public function format(float $price){
        $sign=$price < 0 ?'-':'';
        if ($this->position=='right'){
            return $sign.number_format(abs($price),3).' '.$this->symbol;
        }elseif ($this->position=='left'){
            return $sign.$this->symbol.number_format(abs($price),3);
        }else{
            return $sign.$price;
        }

    }
}
