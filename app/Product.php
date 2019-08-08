<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use \Dimsav\Translatable\Translatable;


    protected $guarded = [];

    public $translatedAttributes = ['name','description'];

    protected $appends = ['image_path'];


    public function getImagepathAttribute()
    {

        return asset('uploads/product_images/' . $this->image);

    }//End of get Image path

   /* public function  getProfitPercentAttribute(){

        $profit = $this->sale_price - $this->purchase_price;

        $profit_percent = $profit * 100 / $this->purchase_price;

        return number_format($profit_percent,2) ;

    }//End of get Profit Percent*/

    public function category(){

        return $this->belongsTo(Category::class);
    }//end of category

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'product_order');

    }//end of orders
}
