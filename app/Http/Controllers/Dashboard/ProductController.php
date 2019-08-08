<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Order;
use App\Product;
use App\ProductOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;


class ProductController extends Controller
{

    public function index(Request $request)
    {
        $categories = Category::all();

        $products = Product::when($request->search, function ($q) use ($request){

            return $q->whereTranslationLike('name', 'like', '%' . $request->search .'%');

        })->when($request->category_id, function ($q) use ($request) {

            return $q->where('category_id' , $request->category_id);

        })->latest()->paginate(5);

        return view('dashboard.products.index',compact('categories','products'));

    }



    public function create()
    {
        $categories = Category::all();

        return view('dashboard.products.create', compact('categories'));

    }



    public function store(Request $request)
    {


        $rules = [

            'category_id' => 'required'
        ];

        foreach (config('translatable.locales') as $locale){

            $rules += [$locale . '.name' => ['required' ,Rule::unique('product_translations','name')]];

            $rules += [$locale . '.description' => 'required'];

        }//End of foreach

        $rules += [


            'sale_price' => 'required',
            'quantity' => 'required'

        ];

        $request->validate($rules);

        $request_data=$request->all();

             $images = $request->file('image');

        if( $images) {

            foreach ( $images as $image ):

                Image::make($image)->resize(300, null, function ($constraint) {

                    $constraint->aspectRatio();

                })->save(public_path('uploads/product_images/' . $image->hashName()));

                $request_data['image'] = $image->hashName();

            endforeach; //End Of Foreach

        }//End of If

        Product::create($request_data);

        session()->flash('success',__('site.added_successfully'));

        return redirect()->route('dashboard.products.index');


    }//end of store





    public function edit(Product $product)
    {

        $categories = Category::all();

        return view('dashboard.products.edit',compact('categories','product'));


    }//End of Edit




    public function update(Request $request, Product $product)
    {
        $rules = [

            'category_id' => 'required'
        ];

        foreach (config('translatable.locales') as $locale){

            $rules += [$locale . '.name' => ['required' ,Rule::unique('product_translations','name')->ignore($product->id, 'product_id')]];

            $rules += [$locale . '.description' => 'required'];

        }//End of foreach

        $rules += [


            'sale_price' => 'required',
            'quantity' => 'required'

        ];

        $request->validate($rules);

        $request_data=$request->all();


        if($request->image) {

            if ($product->image != 'default.png') {

                Storage::disk('public_uploads')->delete('/product_images/' . $product->image);

            }//end of inner if

            Image::make($request->image)->resize(300, null, function ($constraint){

                $constraint->aspectRatio();

            })->save(public_path('uploads/product_images/' . $request->image->hashName()));

            $request_data['image'] = $request->image->hashName();

        }//End of If

        $product->update($request_data);

        session()->flash('success',__('site.updated_successfully'));

        return redirect()->route('dashboard.products.index');

    }//End of update



    public function destroy(Product $product )
    {




       if(empty($product->orders()->first()->pivot->product_id)) {


            if ($product->image != 'default.png') {

                Storage::disk('public_uploads')->delete('/product_images/' . $product->image);

            }//end of if

            $product->delete();

            session()->flash('success', __('site.deleted_successfully'));

            return redirect()->route('dashboard.products.index');
       }
        else
        {
            session()->flash('success', __('site.no_delete'));

            return redirect()->route('dashboard.products.index');

        }

    }//End of destroy
}
