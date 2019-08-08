<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Category;
use App\Client;
use App\Order;
use App\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {


    }//End of index

    public function create(Client $client)
    {
         $categories = Category::with('products')->get();

        return view ('dashboard.clients.orders.create', compact('client','categories'));

    }//End of create

    public function store(Request $request, Client $client)
    {



       $request->validate([

           'products' => 'required|array',
         //  'quantities' => 'required|array',
       ]);

       $order = $client->orders()->create([]);

        $order->products()->attach($request->products);


        $total_price = 0 ;

       foreach($request->products as $id=>$quantity)
       {

            $product = Product::FindOrFail($id);



           $total_price += $product->sale_price * $quantity['quantity'];


           $product->update([

               'quantity' => $product->quantity - $quantity['quantity']
           ]);

       }//end of foreach

        $order->update([

            'total_price' => $total_price
        ]);
        session()->flash('success',__('site.added_successfully'));

        return redirect()->route('dashboard.orders.index');

    }//End of store

    public function edit(Client $client, Order $order)
    {


    }//End of edit

    public function update(Request $request, Client $client, Order $order)
    {


    }//End of update

    public function destroy(Client $client, Order $order)
    {


    }//End of destroy

}//End of controller
