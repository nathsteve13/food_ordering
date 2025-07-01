@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Checkout</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($cartItems->count() > 0)
        <form action="{{ route('cart.checkout.process') }}" method="POST">
            @csrf
            <div class="row">
            @foreach ($cartItems as $item)
            @php
                $menu = $item->menu;
                $subtotal = $item->menus_price * $item->quantity;
            @endphp
            <div class="col-md-4 mb-4">
                <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $menu->name }}</h5>
                    <p class="card-text">Harga: Rp{{ number_format($item->menus_price, 0, ',', '.') }}</p>
                    <p class="card-text">Jumlah: {{ $item->quantity }}</p>
                    <p class="card-text">Subtotal: Rp{{ number_format($subtotal, 0, ',', '.') }}</p>
                </div>

                <div class="mt-3">
                    <label for="portion-{{ $item->id }}" class="form-label">Porsi:</label>
                    <input type="number" step="0.01" id="portion-{{ $item->id }}" name="items[{{ $item->id }}][portion]" class="form-control" placeholder="Masukkan jumlah porsi" required>
                </div>
                <div class="mt-3">
                    <label for="notes-{{ $item->id }}" class="form-label">Catatan:</label>
                    <textarea id="notes-{{ $item->id }}" name="items[{{ $item->id }}][notes]" class="form-control" rows="2" placeholder="Tambahkan catatan untuk item ini"></textarea>
                </div>

                @if ($item->ingredients->count() > 0)
                    <h6 class="mt-3">Bahan:</h6>
                    <ul>
                    @foreach ($item->ingredients as $ingredient)
                        <li>{{ $ingredient->ingredient->name }}</li>
                        <input type="hidden" name="items[{{ $item->id }}][ingredients][]" value="{{ $ingredient->ingredient->name }}">
                    @endforeach
                    </ul>
                @endif

                <input type="hidden" name="items[{{ $item->id }}][menu_id]" value="{{ $menu->id }}">
                <input type="hidden" name="items[{{ $item->id }}][quantity]" value="{{ $item->quantity }}">
                <input type="hidden" name="items[{{ $item->id }}][price]" value="{{ $item->menus_price }}">
                </div>
            </div>
            @endforeach
            </div>

            <div class="text-end mb-4">
            <h4>Total: <strong>Rp{{ number_format($total, 0, ',', '.') }}</strong></h4>
            <input type="hidden" name="total" value="{{ $total }}">
            </div>

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
