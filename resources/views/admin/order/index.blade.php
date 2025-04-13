@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Daftar Pesanan</h2>
    <a href="{{ route('admin.order.create') }}" class="btn btn-primary mb-3">Tambah Pesanan</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Customer</th>
                <th>Tanggal</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $order)
            <tr>
                <td>{{ $order->customer->nama }}</td>
                <td>{{ $order->tanggal }}</td>
                <td>Rp {{ number_format($order->total) }}</td>
                <td>{{ $order->status }}</td>
                <td>
                    <a href="{{ route('order.edit', $order->id) }}" class="btn btn-warning btn-sm">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
