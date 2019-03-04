@extends('admin.layouts.app')

@section('title', 'Categories')
@section('desc', 'Manage you products categories here')

@section('content')

    <products-page-component
    :category_id="{{ $category_id }}"></products-page-component>

@endsection
