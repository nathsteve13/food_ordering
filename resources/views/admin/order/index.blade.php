@extends('admin_layouts.admin')

@section('content')
    <div class="container">
        <h1>List Order</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Subtotal</th>
                    <th>Discount</th>
                    <th>Total</th>
                    <th>Order Type</th>
                    <th>Payment Type</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $order)
                    <tr>
                        <td>{{ $order->invoice_number }}</td>
                        <td>Rp {{ number_format($order->subtotal) }}</td>
                        <td>Rp {{ number_format($order->discount) }}</td>
                        <td>Rp {{ number_format($order->total) }}</td>
                        <td>{{ ucfirst($order->order_type) }}</td>
                        <td>{{ ucfirst($order->payment_type) }}</td>
                        <td>{{ $order->user->nama ?? '-' }}</td>
                        <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                        <td>{{ ucfirst($order->orderStatus->status_type ?? '-') }}</td>
                        <td>
                            <a href="{{ route('admin.order.edit', $order->invoice_number) }}" class="btn btn-warning btn-sm">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection