@extends('admin.layouts.app')

@section('title', "Categorie's Products")
@section('desc', 'List of the products of this category')

@section('content')

    <category-products-page-component :category_id="{{ $category_id }}"></category-products-page-component>

@endsection
