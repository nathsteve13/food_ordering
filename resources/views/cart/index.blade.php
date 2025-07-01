@extends('layouts.app')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<div class="container py-5">
    <h2 class="mb-4">Your Cart</h2>

    <div class="row row-cols-1 g-4">
        @forelse ($cartItems as $item)
            @php
                $menu = $item->menu;
                $image = $menu?->images->first()->image_path ?? 'images/default.jpg';
                $subtotal = $item->menus_price * $item->quantity;
            @endphp

            <div class="col">
                <div class="card shadow-sm">
                    <div class="row g-0">
                        <div class="col-md-3">
                            <img src="{{ asset('storage/' . $image) }}" class="img-fluid rounded-start" alt="{{ $menu->name ?? 'Unknown' }}">
                        </div>
                        <div class="col-md-9">
                            <div class="card-body">
                                <h5 class="card-title">{{ $menu->name ?? 'Menu tidak ditemukan' }}</h5>

                                {{-- Ingredient list --}}
                                @if ($item->ingredients->isNotEmpty())
                                    <ul class="mb-2 text-muted small">
                                        @foreach ($item->ingredients as $ingredient)
                                            <li>{{ $ingredient->ingredient->name ?? '-' }}</li>
                                        @endforeach
                                    </ul>
                                @endif

                                <p>Price: Rp {{ number_format($item->menus_price, 0, ',', '.') }}</p>
                                <p>Subtotal: Rp {{ number_format($subtotal, 0, ',', '.') }}</p>

                                {{-- Quantity buttons --}}
                                <form action="{{ route('cart.updateQuantity') }}" method="POST" class="d-inline-flex align-items-center gap-2">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $item->id }}">

                                    <button type="submit" name="quantity" value="{{ $item->quantity - 1 }}" class="btn btn-outline-secondary btn-sm" {{ $item->quantity <= 1 ? 'disabled' : '' }}>−</button>
                                    <span>{{ $item->quantity }}</span>
                                    <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" class="btn btn-outline-secondary btn-sm">+</button>
                                </form>

                                {{-- Delete --}}
                                <form action="{{ route('cart.remove', $item->id) }}" method="GET" class="d-inline" onsubmit="return confirm('Remove item?')">
                                    <button class="btn btn-sm btn-danger ms-2">🗑️</button>
                                </form>

                                {{-- Edit --}}
                                @if ($menu)
                                    <a href="{{ route('cart.edit', $item->id) }}" class="btn btn-sm btn-outline-primary ms-2">Edit</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Your cart is empty.</p>
        @endforelse
        {{-- Tombol Back to Home --}}
        <div class="mt-3">
            <a href="{{ route('home') }}" class="btn btn-secondary">← Back to Home</a>
        </div>
    </div>

    {{-- Total dan Checkout --}}
    @if ($cartItems->count())
        <div class="mt-4 text-end">
            <h4>Total: Rp {{ number_format($total, 0, ',', '.') }}</h4>
            <a href="{{ route('cart.checkout.form') }}" class="btn btn-success mt-2">Checkout</a>
        </div>
    @endif
</div>
@endsection
