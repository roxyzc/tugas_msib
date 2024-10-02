@extends('admin.layouts.admin')

@section('content')
    <div class="container">
        <h1 class="text-center">'Supplier Details'</h1>

        <div class="row">
            <div class="col-md-12">
                <a href="{{ route('admin.suppliers.edit', $supplier->id) }}" class="btn btn-warning mb-3">Edit Supplier</a>
                <a href="{{ route('admin.suppliers') }}" class="btn btn-secondary mb-3">Back to Suppliers</a>
            </div>
        </div>

        <table class="table table-striped">
            <tbody>
                <tr>
                    <th>Name</th>
                    <td>{{ $supplier->name }}</td>
                </tr>
                <tr>
                    <th>Contact Person</th>
                    <td>{{ $supplier->contact_person }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>
                        @if($supplier->email)
                            <a href="mailto:{{ $supplier->email }}">{{ $supplier->email }}</a>
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{ $supplier->phone }}</td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>{{ $supplier->address ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $supplier->created_at->format('d M Y H:i') }} ({{ $supplier->created_at->diffForHumans() }})</td>
                </tr>
                <tr>
                    <th>Updated At</th>
                    <td>{{ $supplier->updated_at->format('d M Y H:i') }} ({{ $supplier->updated_at->diffForHumans() }})</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
