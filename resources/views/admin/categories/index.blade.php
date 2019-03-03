@extends('admin.layouts.app')

@section('title', 'Categories')
@section('desc', 'Manage you products categories here')

@section('content')

    <categories-page-component
    :department_id="{{ $department_id }}"></categories-page-component>

@endsection
