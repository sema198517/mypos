<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        $categories = Category::when($request->search, function ($q) use ($request){

            return $q->whereTranslationLike('name', '%' . $request->search .'%');

        })->latest()->paginate(5);

        return view('dashboard.categories.index',compact('categories'));
    }


    public function create()
    {

        return view('dashboard.categories.create');

    }//end of create



    public function store(Request $request)
    {
        $rules = [];

        foreach (config('translatable.locales') as $locale){

            //ar. *
            //name ar or en required
            //name ar or en unique

            $rules += [$locale . '.name' => ['required' ,Rule::unique('category_translations','name')]];
        }//End of foreach

        $request->validate($rules);

        Category::create($request->all());
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.categories.index');

    }//end of store





    public function edit(Category $category)
    {
        return view('dashboard.categories.edit',compact('category'));
    }//End of Edit



    public function update(Request $request, Category $category)
    {
        $rules = [];

        foreach (config('translatable.locales') as $locale){

            //ar. *
            //name ar or en required
            //name ar or en unique

            $rules += [$locale . '.name' => ['required' ,Rule::unique('category_translations','name')->ignore($category->id , 'category_id')]];
        }//End of foreach

        $request->validate($rules);

        $category->update($request->all());
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.categories.index');


    }//End of Update


    public function destroy(Category $category)
    {

        $category -> delete();

        session()->flash('success', __('site.deleted_successfully'));

        return redirect()->route('dashboard.categories.index');


    }//End of Destroy

}//End of controller
