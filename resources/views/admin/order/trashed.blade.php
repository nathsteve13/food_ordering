@extends('admin_layouts.admin')

@section('content')
    <div class="container">
        <h1>Trashed Order List</h1>

        <a href="{{ route('admin.order.index') }}" class="btn btn-secondary mb-3">Back to Order List</a>

        @if ($orders->isEmpty())
            <div class="alert alert-info">No trashed orders found.</div>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Invoice</th>
                        <th>User</th>
                        <th>Total</th>
                        <th>Order Type</th>
                        <th>Payment Type</th>
                        <th>Deleted At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->invoice_number }}</td>
                            <td>{{ $order->user->name ?? '-' }}</td>
                            <td>{{ $order->total }}</td>
                            <td>{{ $order->order_type }}</td>
                            <td>{{ $order->payment_type }}</td>
                            <td>{{ $order->deleted_at->format('d M Y H:i') }}</td>
                            <td>
                                <form action="{{ route('admin.order.restore', $order->invoice_number) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-success btn-sm"
                                        onclick="return confirm('Restore this order?')">Restore</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection