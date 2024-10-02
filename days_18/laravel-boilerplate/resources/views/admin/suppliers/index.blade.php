@extends('admin.layouts.admin')

@section('title', __('views.admin.suppliers.index.title'))

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-12 text-right">
                <a href="{{ route('admin.suppliers.create') }}" class="btn btn-primary">Create</a>
            </div>        
        </div>

        <div class="row">

            <table class="table table-striped table-bordered dt-responsive nowrap"  cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>@sortablelink('name', __('views.admin.suppliers.index.table_header_0'),['page' => $suppliers->currentPage()])</th>
                        <th>@sortablelink('contact_person',  __('views.admin.suppliers.index.table_header_1'),['page' => $suppliers->currentPage()])</th>
                        <th>@sortablelink('email', __('views.admin.suppliers.index.table_header_2'),['page' => $suppliers->currentPage()])</th>
                        <th>@sortablelink('phone', __('views.admin.suppliers.index.table_header_3'),['page' => $suppliers->currentPage()])</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($suppliers as $supplier)
                        <tr>
                            <td>{{ $supplier->name }}</td>
                            <td>{{ $supplier->contact_person }}</td>
                            <td>{{ $supplier->email }}</td>
                            <td>{{ $supplier->phone }}</td>
                            <td>
                                <a class="btn btn-xs btn-primary" href="{{ route('admin.suppliers.show', [$supplier->id]) }}" data-toggle="tooltip" data-placement="top" data-title="{{ __('views.admin.suppliers.index.show') }}">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a class="btn btn-xs btn-info" href="{{ route('admin.suppliers.edit', [$supplier->id]) }}" data-toggle="tooltip" data-placement="top" data-title="{{ __('views.admin.suppliers.index.edit') }}">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a href="{{ route('admin.suppliers.destroy', [$supplier->id]) }}" class="btn btn-xs btn-danger user_destroy" data-toggle="tooltip" data-placement="top" data-title="{{ __('views.admin.suppliers.index.delete') }}">
                                    <i class="fa fa-trash"></i>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $suppliers->links() }}
    </div>
@endsection
