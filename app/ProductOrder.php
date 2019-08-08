<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    public $table="product_order";

    protected $fillable = ['quantity'];

}
