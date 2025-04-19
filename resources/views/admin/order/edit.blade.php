@extends('admin_layouts.admin')

@section('content')
    <div class="container">
        <h2>Edit Order Status</h2>
        <form action="{{ route('admin.order.update', $order->invoice_number) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Invoice</label>
                <input type="text" class="form-control" value="{{ $order->invoice_number }}" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Customer</label>
                <select name="customer_id" class="form-control" disabled>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" {{ $order->customer_id == $customer->id ? 'selected' : '' }}>
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="{{ $order->created_at ? $order->created_at->format('Y-m-d') : '' }}" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Total</label>
                <input type="number" name="total" class="form-control" value="{{ $order->total }}" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Status Pemesanan</label>
                <select name="status_type" class="form-control">
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" {{ $order->orderStatus && $order->orderStatus->status_type == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Status</button>
        </form>
    </div>
@endsection