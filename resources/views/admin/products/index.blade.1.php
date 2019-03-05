@extends('admin.layouts.app')

@section('title', 'All products')
@section('desc', 'This all all the products of your store')

@section('content')

    <div class="card">
        <div class="card-body">
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col">
                        {{--<h3 class="mt-2 mb-3">
                            List of all products :
                        </h3>--}}
                        {{--<div class="mb-3">
                            <a class="btn btn-link" :href="`/admin/departments/`">
                                <i class="fa fa-arrow-left"></i> Go back to departments</a>
                        </div>--}}

                        @if($products->isEmpty())
                            <h6>There's no category yet in this department</h6>
                        @else
                            <table class="table dataTable">
                                <thead>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Discounted Price</th>
                                <th>Display</th>
                                <th class="actions"></th>
                                </thead>
                                <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->description }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->discounted_price }}</td>
                                        <td>{{ $product->display === 0 ? 'Hide' : 'Show' }}</td>
                                        <td class="actions">
                                            <div>
                                                <a class="btn btn-primary btn-sm mb-1"
                                                   href="{{ route('admin.products.edit', $product) }}">
                                                    Edit</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            <!-- /NAV -->
            </section>
        </div>
    </div>

    <!-- NAV -->
    @if($products->isNotEmpty())
        <div class="row mt-3">
            <div class="col">
                {{ $products->links() }}
            </div>
        </div>
    @endif

@endsection
