@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2>My Orders</h2>
        @forelse($transactions as $transaction)
            <div class="card mb-4">
                <div class="card-header">
                    <strong>Invoice:</strong> {{ $transaction->invoice_number }}<br>
                    <strong>Order Type:</strong> {{ ucfirst($transaction->order_type) }}<br>
                    <strong>Payment Type:</strong> {{ ucfirst($transaction->payment_type) }}<br>
                    <a href="#" class="text-decoration-underline text-primary fw-semibold" data-bs-toggle="modal"
                        data-bs-target="#statusModal-{{ $transaction->invoice_number }}">
                        {{ ucfirst($transaction->orderStatus->status ?? 'Pending') }}
                    </a>
                </div>
                <div class="card-body">
                    @foreach($transaction->details as $detail)
                        <div class="d-flex align-items-start mb-3 border-bottom pb-2">
                            <img src="{{ asset('storage/' . ($detail->menu->images->first()->image_path ?? 'default.jpg')) }}"
                                alt="{{ $detail->menu->name }}" width="80" height="80" class="me-3 rounded">

                            <div>
                                <h5>{{ $detail->menu->name }}</h5>
                                <p class="mb-1"><strong>Portion:</strong> {{ $detail->portion }}</p>
                                <p class="mb-1"><strong>Quantity:</strong> {{ $detail->quantity }}</p>
                                <p class="mb-1"><strong>Notes:</strong> {{ $detail->notes ?? '-' }}</p>

                                @php
                                    $defaultIngredients = $detail->menu->ingredients;
                                    $excludedIds = $detail->excludedIngredients->pluck('ingredient.id');
                                    $includedIngredients = $defaultIngredients->whereNotIn('id', $excludedIds);
                                @endphp
                                <p class="mb-1"><strong>Ordered Ingredients:</strong>
                                    @if($includedIngredients->isEmpty())
                                        All ingredients removed
                                    @else
                                        {{ $includedIngredients->pluck('name')->implode(', ') }}
                                    @endif
                                </p>

                                <p><strong>Subtotal:</strong> Rp {{ number_format($detail->total, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                    <div><strong>Total Transaction:</strong> Rp {{ number_format($transaction->total, 0, ',', '.') }}</div>
                </div>
            </div>

            <div class="modal fade" id="statusModal-{{ $transaction->invoice_number }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5>Status Tracking</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            @forelse($transaction->statusHistory as $status)
                                <p>{{ ucfirst($status->status) }} - {{ $status->created_at }}</p>
                            @empty
                                <p>No status history available.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p>No orders found.</p>
        @endforelse
    </div>
@endsection