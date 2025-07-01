@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Your Cart</h2>

    <div class="row row-cols-1 g-4">
        @forelse ($cartItems as $item)
            @php
                $menu = $item->menu;
                $image = $menu->images->first()->image_path ?? 'images/default.jpg';
                $subtotal = $item->menus_price * $item->quantity;
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
                                <p>Subtotal: Rp {{ number_format($subtotal, 0, ',', '.') }}</p>

                                <form action="{{ route('cart.updateQuantity') }}" method="POST" class="d-inline-flex align-items-center gap-2">
                                    @csrf
                                    <input type="hidden" name="cart_id" value="{{ $item->id }}">

                                    <button type="submit" name="quantity" value="{{ $item->quantity - 1 }}" class="btn btn-outline-secondary btn-sm" {{ $item->quantity <= 1 ? 'disabled' : '' }}>−</button>
                                    <span>{{ $item->quantity }}</span>
                                    <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" class="btn btn-outline-secondary btn-sm">+</button>
                                </form>

                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Remove item?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger ms-2">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Your cart is empty.</p>
        @endforelse
    </div>
</div>
@endsection
