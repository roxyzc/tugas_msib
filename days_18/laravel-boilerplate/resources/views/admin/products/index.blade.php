@extends('admin.layouts.admin')

@section('title', __('views.admin.products.index.title'))

@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-12 text-right">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">{{ __('Create') }}</a>
            </div>        
        </div>
        <div class="row">
            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>@sortablelink('name', __('views.admin.products.index.table_header_0'), ['page' => $products->currentPage()])</th>
                    <th>@sortablelink('sku', __('views.admin.products.index.table_header_1'), ['page' => $products->currentPage()])</th>
                    <th>@sortablelink('price', __('views.admin.products.index.table_header_2'), ['page' => $products->currentPage()])</th>
                    <th>@sortablelink('stock', __('views.admin.products.index.table_header_3'), ['page' => $products->currentPage()])</th>
                    <th>@sortablelink('created_at', __('views.admin.products.index.table_header_4'), ['page' => $products->currentPage()])</th>
                    <th>@sortablelink('updated_at', __('views.admin.products.index.table_header_5'), ['page' => $products->currentPage()])</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->sku }}</td>
                        <td>{{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->created_at->format('d M Y H:i') }}</td>
                        <td>{{ $product->updated_at->format('d M Y H:i') }}</td>
                        <td>
                            <a class="btn btn-xs btn-primary" href="{{ route('admin.products.show', [$product->id]) }}" data-toggle="tooltip" data-placement="top" data-title="{{ __('views.admin.products.index.show') }}">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a class="btn btn-xs btn-info" href="{{ route('admin.products.edit', [$product->id]) }}" data-toggle="tooltip" data-placement="top" data-title="{{ __('views.admin.products.index.edit') }}">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a href="{{ route('admin.products.destroy', [$product->id]) }}" class="btn btn-xs btn-danger user_destroy" data-toggle="tooltip" data-placement="top" data-title="{{ __('views.admin.products.index.delete') }}">
                                <i class="fa fa-trash"></i>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="pull-right">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
