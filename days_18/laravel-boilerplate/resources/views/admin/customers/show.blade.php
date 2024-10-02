@extends('admin.layouts.admin')

@section('content')
    <div class="container">
        <h1 class="text-center">'Customer Details'</h1>

        <div class="row">
            <div class="col-md-12">
                <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-warning mb-3">Edit Customer</a>
                <a href="{{ route('admin.customers') }}" class="btn btn-secondary mb-3">Back to Customers</a>
            </div>
        </div>

        <table class="table table-striped">
            <tbody>
                <tr>
                    <th>Name</th>
                    <td>{{ $customer->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>
                        @if($customer->email)
                            <a href="mailto:{{ $customer->email }}">{{ $customer->email }}</a>
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{ $customer->phone }}</td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $customer->created_at->format('d M Y H:i') }} ({{ $customer->created_at->diffForHumans() }})</td>
                </tr>
                <tr>
                    <th>Updated At</th>
                    <td>{{ $customer->updated_at->format('d M Y H:i') }} ({{ $customer->updated_at->diffForHumans() }})</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
