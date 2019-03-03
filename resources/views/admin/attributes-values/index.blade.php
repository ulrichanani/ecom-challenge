@extends('admin.layouts.app')

@section('title', 'Attribute Values')
@section('desc', 'Manage you attributes values here')

@section('content')

    <attribute-values-page-component
    :attribute_id="{{ $attribute_id }}"></attribute-values-page-component>

@endsection
