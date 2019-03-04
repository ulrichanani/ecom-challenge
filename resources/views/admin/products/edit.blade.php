@extends('admin.layouts.app')

@section('title', 'Products')
@section('desc', 'Manage you products here')

@section('content')

    <product-edit-component
    :product_id="{{ $product_id }}"></product-edit-component>

@endsection
