@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.products')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li><a href="{{ route('dashboard.products.index') }}"> @lang('site.products')</a></li>
                <li class="active">@lang('site.add')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">@lang('site.add')</h3>
                </div><!-- end of box header -->
                <div class="box-body">

                    @include('partials._errors')

                    <form action="{{ route('dashboard.products.store') }}" method="post" enctype="multipart/form-data">

                        {{ csrf_field() }}
                        {{ method_field('post') }}

                        <div class="form-group">

                            <label>@lang('site.categories')</label>

                            <select name="category_id" class="form-control">

                                <option value="">@lang('site.all_categories')</option>

                                @foreach ($categories as $category)

                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>

                                @endforeach

                            </select>

                        </div>

                        @foreach (config('translatable.locales') as $locale)

                            <div class="form-group">
                                {{-- site.ar.name--}}
                                <label>@lang('site.' . $locale . '.name')</label>
                                {{-- ar[name]--}}
                                <input type="text" name="{{ $locale }}[name]" class="form-control" value="{{ old($locale . '.name') }}">
                            </div>

                            <div class="form-group">
                                {{-- site.ar.description--}}
                                <label>@lang('site.' . $locale . '.description')</label>
                                {{-- ar[description]--}}
                                <textarea  name="{{ $locale }}[description]" class="form-control ckeditor" >{{ old($locale . '.description') }}</textarea>
                            </div>

                        @endforeach

                        <div class="form-group">

                            <label>@lang('site.image')</label>

                            <input multiple="multiple" type="file" name="image[]" class="form-control image"><!-- image & image-preview are id for doing proses by jQuery in app file -->

                        </div>

                        <div class="form-group">

                            <img src="{{ asset('uploads/product_images/default.png') }}" style="width: 50px;" class="img-thumbnail image-preview" alt="">

                        </div>



                        <div class="form-group">

                            <label>@lang('site.price')</label>

                            <input type="number" name="sale_price" step="0.01" class="form-control image" value="{{old('price')}}">

                        </div>


                        <div class="form-group">

                            <label>@lang('site.quantity')</label>

                            <input type="number" name="quantity" class="form-control image" value="{{old('quantity')}}">

                        </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</button>
                        </div>

                    </form><!-- end of form -->

                </div><!-- end of box body -->

            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
