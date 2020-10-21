<?php


namespace App\Models;


class Product extends Model
{
    protected $primaryKey='name';
    protected $fillable=['name','price'];
}
