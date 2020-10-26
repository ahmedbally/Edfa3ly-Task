<?php

use App\Presenters\BillPresenter;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\Config;

class CreateBillTest extends TestCase
{
    /**
     * @dataProvider parserProvider
     */
    public function testParse($currency,$cart,$res){

    }

    public function parserProvider()
    {
        return[
            ['USD',['T-shirt'],['subtotal'=>'$10','taxes'=>'$20','discounts'=>0]],


        ];
    }
}
