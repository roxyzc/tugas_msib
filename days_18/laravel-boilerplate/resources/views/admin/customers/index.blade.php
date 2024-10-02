@extends('admin.layouts.admin')

@section('title', __('views.admin.customers.index.title'))

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-12 text-right">
                <a href="{{ route('admin.customers.create') }}" class="btn btn-primary">Create</a>
            </div>        
        </div>

        <div class="row">

            <table class="table table-striped table-bordered dt-responsive nowrap"  cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>@sortablelink('name', __('views.admin.customers.index.table_header_0'),['page' => $customers->currentPage()])</th>
                        <th>@sortablelink('email', __('views.admin.customers.index.table_header_1'),['page' => $customers->currentPage()])</th>
                        <th>@sortablelink('phone', __('views.admin.customers.index.table_header_2'),['page' => $customers->currentPage()])</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $customer)
                        <tr>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>
                                <a class="btn btn-xs btn-primary" href="{{ route('admin.customers.show', [$customer->id]) }}" data-toggle="tooltip" data-placement="top" data-title="{{ __('views.admin.customers.index.show') }}">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a class="btn btn-xs btn-info" href="{{ route('admin.customers.edit', [$customer->id]) }}" data-toggle="tooltip" data-placement="top" data-title="{{ __('views.admin.customers.index.edit') }}">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a href="{{ route('admin.customers.destroy', [$customer->id]) }}" class="btn btn-xs btn-danger user_destroy" data-toggle="tooltip" data-placement="top" data-title="{{ __('views.admin.customers.index.delete') }}">
                                    <i class="fa fa-trash"></i>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $customers->links() }}
    </div>
@endsection
