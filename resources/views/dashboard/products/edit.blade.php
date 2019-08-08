@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.products')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li><a href="{{ route('dashboard.products.index') }}"> @lang('site.products')</a></li>
                <li class="active">@lang('site.edit')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">@lang('site.edit')</h3>
                </div><!-- end of box header -->
                <div class="box-body">

                    @include('partials._errors')

                    <form action="{{ route('dashboard.products.update' , $product->id) }}" method="post" enctype="multipart/form-data">

                        {{ csrf_field() }}
                        {{ method_field('put') }}

                        <div class="form-group">

                            <label>@lang('site.categories')</label>

                            <select name="category_id" class="form-control">

                                <option value="">@lang('site.all_categories')</option>

                                @foreach ($categories as $category)

                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>

                                @endforeach

                            </select>
                        </div>

                        @foreach (config('translatable.locales') as $locale)

                            <div class="form-group">
                                {{-- site.ar.name--}}
                                <label>@lang('site.' . $locale . '.name')</label>
                                {{-- ar[name]--}}
                                <input type="text" name="{{ $locale }}[name]" class="form-control" value="{{ $product->name }}">
                            </div>

                            <div class="form-group">
                                {{-- site.ar.description--}}
                                <label>@lang('site.' . $locale . '.description')</label>
                                {{-- ar[description]--}}
                                <textarea  name="{{ $locale }}[description]" class="form-control ckeditor" >{{ $product->description }}</textarea>
                            </div>

                        @endforeach

                        <div class="form-group">

                            <label>@lang('site.image')</label>

                            <input type="file" name="image" class="form-control image"><!-- image & image-preview are id for doing proses by jQuery in app file -->

                        </div>

                        <div class="form-group">

                            <img src="{{ $product->image_path }}" style="width: 50px;" class="img-thumbnail image-preview" alt="">

                        </div>



                        <div class="form-group">

                            <label>@lang('site.price')</label>

                            <input type="number" name="sale_price" step="0.01"  class="form-control image" value="{{ $product->sale_price}}">

                        </div>


                        <div class="form-group">

                            <label>@lang('site.quantity')</label>

                            <input type="number" name="stock" class="form-control image" value="{{ $product->quantity}}">

                        </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.edit')</button>
                        </div>

                    </form><!-- end of form -->

                </div><!-- end of box body -->

            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
