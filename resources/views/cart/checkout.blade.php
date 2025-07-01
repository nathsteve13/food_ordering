@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Checkout</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($cartItems->count() > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Menu</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cartItems as $item)
                    @php
                        $menu = $item->menu;
                        $subtotal = $item->menus_price * $item->quantity;
                    @endphp
                    <tr>
                        <td>{{ $menu->name }}</td>
                        <td>Rp{{ number_format($item->menus_price, 0, ',', '.') }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rp{{ number_format($subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-end mb-4">
            <h4>Total: <strong>Rp{{ number_format($total, 0, ',', '.') }}</strong></h4>
        </div>

        <form action="{{ route('cart.checkout.process') }}" method="POST">
            @csrf
            <select name="order_type" class="form-select" required>
                <option value="">-- Pilih Tipe --</option>
                @foreach ($orderTypes as $type)
                    <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                @endforeach
            </select>

            <select name="payment_type" class="form-select" required>
                <option value="">-- Pilih Metode --</option>
                @foreach ($paymentTypes as $type)
                    <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                @endforeach
            </select>


            <button type="submit" class="btn btn-primary">Proses Checkout</button>
        </form>
    @else
        <p class="text-muted">Keranjang kamu kosong.</p>
    @endif
</div>
@endsection