@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 1200px;">
    <h2 class="mb-5 fw-bold text-center text-primary">🛒 Checkout Pesanan Anda</h2>

    @if (session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if ($cartItems->count() > 0)
        <form action="{{ route('cart.checkout.process') }}" method="POST">
            @csrf

            <div class="row g-4 justify-content-center">
                @foreach ($cartItems as $item)
                    @php
                        $menu = $item->menu;
                        $subtotal = $item->menus_price * $item->quantity;
                    @endphp
                    <div class="col-md-6 col-lg-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">{{ $menu->name }}</h5>
                                <span class="badge bg-success mb-2">Jumlah: {{ $item->quantity }}</span>
                                <p>Harga: <strong class="text-primary">Rp{{ number_format($item->menus_price, 0, ',', '.') }}</strong></p>
                                <p>Subtotal: <strong class="text-danger">Rp{{ number_format($subtotal, 0, ',', '.') }}</strong></p>

                                <div class="mb-2">
                                    <label class="form-label small">Porsi:</label>
                                    <input type="number" step="0.01" name="items[{{ $item->id }}][portion]" class="form-control form-control-sm" placeholder="Contoh: 1.5" required>
                                </div>

                                <div class="mb-2">
                                    <label class="form-label small">Catatan:</label>
                                    <textarea name="items[{{ $item->id }}][notes]" class="form-control form-control-sm" rows="2" placeholder="Tambahkan catatan (opsional)"></textarea>
                                </div>

                                @if ($item->ingredients->count() > 0)
                                    <div class="mb-2">
                                        <label class="form-label small fw-bold">Bahan:</label>
                                        <ul class="ps-3 small">
                                            @foreach ($item->ingredients as $ingredient)
                                                <li>{{ $ingredient->ingredient->name }}</li>
                                                <input type="hidden" name="items[{{ $item->id }}][ingredients][]" value="{{ $ingredient->ingredient->name }}">
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <input type="hidden" name="items[{{ $item->id }}][menu_id]" value="{{ $menu->id }}">
                                <input type="hidden" name="items[{{ $item->id }}][quantity]" value="{{ $item->quantity }}">
                                <input type="hidden" name="items[{{ $item->id }}][price]" value="{{ $item->menus_price }}">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <hr class="my-5">

            <!-- ORDER TYPE & PAYMENT -->
            <div class="row justify-content-center mb-3">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Tipe Pesanan</label>
                    <select name="order_type" class="form-select shadow-sm" required>
                        <option value="">-- Pilih Tipe --</option>
                        @foreach ($orderTypes as $type)
                            <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Metode Pembayaran</label>
                    <select name="payment_type" class="form-select shadow-sm" required>
                        <option value="">-- Pilih Metode --</option>
                        @foreach ($paymentTypes as $type)
                            <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- ✅ TOTAL + BUTTON -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center px-2 mt-4 bg-light rounded shadow-sm p-3">
                <div class="mb-3 mb-md-0">
                    <h4 class="fw-bold text-dark m-0" style="font-size: 1.5rem;">
                        Total: <span class="text-primary">Rp{{ number_format($total, 0, ',', '.') }}</span>
                    </h4>
                    <input type="hidden" name="total" value="{{ $total }}">
                </div>
                <div>
                    <button type="submit" class="btn btn-success btn-lg px-4 shadow">
                        <i class="bi bi-cart-check me-1"></i> Proses Checkout
                    </button>
                </div>
            </div>
        </form>
    @else
        <div class="alert alert-warning text-center">Keranjang kamu kosong. Silakan pilih menu terlebih dahulu.</div>
    @endif
</div>
@endsection