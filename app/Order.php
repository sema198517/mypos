<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function client()
    {

        return $this->belongsTo(Client::class);

    }//end of user

    public function products(){

        return $this->belongsToMany(Product::class, 'product_order')->withPivot('quantity');

    }//end of product

    /* public function  getTotalPrice(){

     $total_price = $this->sale_price - $this->purchase_price;

     $profit_percent = $profit * 100 / $this->purchase_price;

     return number_format($profit_percent,2) ;

 }//End of get Profit Percent*/

}
