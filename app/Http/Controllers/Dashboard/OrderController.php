<?php

namespace App\Http\Controllers\Dashboard;

use App\Product;
use App\Client ;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order ;
class OrderController extends Controller
{
    public function index(Request $request)
    {



        $products = Product::all();

        $clients = Client::all();

        $orders = Order::when($request->search, function ($q) use ($request){

            return $q->whereTranslationLike('name', '%' . $request->search .'%');

        })->when($request->client_id, function ($q) use ($request) {

            return $q->where('client_id' , $request->client_id);

        })->latest()->paginate(5);

        return view('dashboard.orders.index' , compact('products', 'clients','orders'));

    }//End of Index

    public function products(Order $order)
    {
        $products = $order->products;

        return view('dashboard.orders._products', compact('order', 'products'));

    }



    public function destroy(Order $order)
    {
        dd($order->products()->first()->pivot->product_id);

        $order -> delete();

        session()->flash('success', __('site.deleted_successfully'));

        return redirect()->route('dashboard.orders.index');


    }//End of destroy

}//End of controller
