@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Edit Pesanan</h2>
    <form action="{{ route('order.update', $order->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label">Customer</label>
            <select name="customer_id" class="form-control" required>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" {{ $order->customer_id == $customer->id ? 'selected' : '' }}>
                        {{ $customer->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ $order->tanggal }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Total</label>
            <input type="number" name="total" class="form-control" value="{{ $order->total }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control
