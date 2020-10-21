<?php


namespace App\Models;


class Currency extends Model
{
    protected $primaryKey='currency';
    protected $fillable=['currency','value'];

    public function convert($price){
        return $price*$this->value;
    }
}
