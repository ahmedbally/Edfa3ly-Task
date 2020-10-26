<?php


namespace App\Models;


class Discount extends Model
{
    protected $primaryKey=null;
    protected $fillable=['discount','product','value','percentage'];
}
