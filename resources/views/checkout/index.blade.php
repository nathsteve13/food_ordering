@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Your Cart</h2>

    <div class="row row-cols-1 g-4">
        @forelse ($cartDetails as $item)
            @php
                $menu = $item->menu;
                $image = $menu->images->first()->image_path ?? 'images/default.jpg';
                $subtotal = $item->menus_price * $item->quantity;
                $ingredients = $item->ingredients;
            @endphp

            <div class="col">
                <div class="card shadow-sm">
                    <div class="row g-0">
                        <div class="col-md-3">
                            <img src="{{ asset('storage/' . $image) }}" class="img-fluid rounded-start" alt="{{ $menu->name }}">
                        </div>
                        <div class="col-md-9">
                            <div class="card-body">
                                <h5 class="card-title">{{ $menu->name }}</h5>
                                <p>Price: Rp {{ number_format($item->menus_price, 0, ',', '.') }}</p>
                                <p>Quantity: {{ $item->quantity }}</p>
                                <p>Subtotal: Rp {{ number_format($subtotal, 0, ',', '.') }}</p>

                                @if ($ingredients->count())
                                    <p class="mt-2 mb-1 fw-bold">Ingredients:</p>
                                    <ul>
                                        @foreach ($ingredients as $ing)
                                            <li>{{ $ing->ingredient->name ?? 'Unknown' }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Your cart is empty.</p>
        @endforelse

        @if ($cart)
        <div class="text-end mt-4">
            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf

                {{-- Bisa tambahkan input hidden subtotal, total, dsb. --}}
                <input type="hidden" name="subtotal" value="{{ $cart->quantity * $cart->menus_price }}">
                <input type="hidden" name="discount" value="0">
                <input type="hidden" name="total" value="{{ $cart->quantity * $cart->menus_price }}">

                {{-- Tambahkan opsi order_type dan payment_type --}}
                <div class="mb-3">
                    <label>Order Type</label>
                    <select name="order_type" class="form-select" required>
                        <option value="dinein">Dine In</option>
                        <option value="takeaway">Take Away</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Payment Type</label>
                    <select name="payment_type" class="form-select" required>
                        <option value="qris">QRIS</option>
                        <option value="credit">Credit Card</option>
                        <option value="debit">Debit Card</option>
                        <option value="e-wallet">E-Wallet</option>
                    </select>
                </div>

                {{-- Tambahkan cart_items sebagai JSON array --}}
                <input type="hidden" name="cart_items[0][menu_id]" value="{{ $cart->menus_id }}">
                <input type="hidden" name="cart_items[0][portion]" value="default">
                <input type="hidden" name="cart_items[0][quantity]" value="{{ $cart->quantity }}">
                <input type="hidden" name="cart_items[0][total]" value="{{ $cart->menus_price * $cart->quantity }}">
                <input type="hidden" name="cart_items[0][notes]" value="">

                {{-- Jika ingin mengirim ingredient exclusion --}}
                @foreach ($ingredients as $index => $ing)
                    <input type="hidden" name="cart_items[0][excludes][{{ $index }}][ingredient_id]" value="{{ $ing->ingredient->id }}">
                @endforeach

                <button type="submit" class="btn btn-primary">Proceed to Checkout</button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection
