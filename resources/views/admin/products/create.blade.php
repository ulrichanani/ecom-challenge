@extends('admin.layouts.app')

@section('title', 'Products')
@section('desc', 'Create new product')

@section('content')

    <div class="card">
        <div class="card-body">
            <!-- Main content -->
            <section class="content">
                <div class="row mb-5">
                    <div class="col">
                        {!! Form::open([
                        'url' => route('admin.products.store'),
                        'files' => true
                        ]) !!}

                            <div class="row">
                                <!-- Name -->
                                <div class="col-md-6 form-group">
                                    <label for="name" class="control-label">Name</label>
                                    {!! Form::text('name', null, [
                                    'class' => "form-control" . ($errors->has('name') ? ' is-invalid' : ''),
                                    'maxlength' => 100,
                                    'required'
                                    ]) !!}
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <!-- Price -->
                                <div class="col-md-6 form-group">
                                    <label for="price" class="control-label">Price</label>
                                    {!! Form::number('price', null, [
                                    'class' => "form-control" . ($errors->has('price') ? ' is-invalid' : ''),
                                    'required',
                                    'step' => '0.01'
                                    ]) !!}
                                    @if ($errors->has('price'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <!-- Product discounted price -->
                                <div class="col-md-6 form-group">
                                    <label for="discounted_price" class="control-label">
                                        Product discounted price</label>
                                    {!! Form::number('discounted_price', null, [
                                    'class' => "form-control" . ($errors->has('discounted_price') ? ' is-invalid' : ''),
                                    'step' => '0.01'
                                    ]) !!}
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <!-- Display option -->
                                <div class="col-md-6 form-group">
                                    <label for="display" class="control-label">Display option</label>
                                    {!! Form::select('display', \App\Models\Product::DISPLAY_OPTIONS, null, [
                                    'class' => "form-control select2" . ($errors->has('display') ? ' is-invalid' : ''),
                                    ]) !!}
                                    @if ($errors->has('display'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('display') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <!-- Attributes -->
                                <div class="col-md-6 form-group">
                                    <label for="attributes[]" class="control-label">Attributes</label>
                                    {!! Form::select('attributes[]', \App\Models\Attribute::getAllWithValues(), null, [
                                    'class' => "form-control select2" . ($errors->has('attributes') ? ' is-invalid' : ''),
                                    'multiple',
                                    ]) !!}
                                    @if ($errors->has('attributes'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('attributes') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <!-- Categories -->
                                <div class="col-md-6 form-group">
                                    <label for="categories[]" class="control-label">Categories</label>
                                    {!! Form::select('categories[]', \App\Models\Category::getNamesAndIds(), null, [
                                    'class' => "form-control select2" . ($errors->has('categories') ? ' is-invalid' : ''),
                                    'multiple',
                                    'required'
                                    ]) !!}
                                    @if ($errors->has('categories'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('categories') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <!-- Thumbnail -->
                                <div class="col-md-6 form-group">
                                    <label for="thumbnail" class="control-label">
                                        Thumbnail</label>
                                    {!! Form::file('thumbnail', [
                                    'class' => "form-control" . ($errors->has('thumbnail') ? ' is-invalid' : ''),
                                    'required'
                                    ]) !!}
                                    @if ($errors->has('thumbnail'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('thumbnail') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <!-- Image 1 -->
                                <div class="col-md-6 form-group">
                                    <label for="image" class="control-label">
                                        Image 1</label>
                                    {!! Form::file('image', [
                                    'class' => "form-control" . ($errors->has('image') ? ' is-invalid' : ''),
                                    'required'
                                    ]) !!}
                                    @if ($errors->has('image'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <!-- Image 2 -->
                                <div class="col-md-6 form-group">
                                    <label for="image_2" class="control-label">
                                        Image 2</label>
                                    {!! Form::file('image_2', [
                                    'class' => "form-control" . ($errors->has('image_2') ? ' is-invalid' : ''),
                                    ]) !!}
                                    @if ($errors->has('image_2'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('image_2') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <!-- Description -->
                                <div class="col-md-6 form-group">
                                    <label for="description" class="control-label">Description</label>
                                    {!! Form::textarea('description', null, [
                                    'class' => "form-control" . ($errors->has('name') ? ' is-invalid' : '')
                                    ]) !!}
                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="col-12">
                                    <input type="submit" value="Save" class="btn btn-primary">
                                </div>
                            </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </section>
        </div>
    </div>

@endsection
