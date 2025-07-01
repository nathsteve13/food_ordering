@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Checkout</h1>
    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            @foreach($cartDetails as $cartItem)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $cartItem->menu->name }}</h5>
                        <p class="card-text">Ingredients:</p>
                        <ul>
                            @foreach($cartItem->ingredients as $ingredient)
                                <li>{{ $ingredient->ingredient->name }}</li>
                            @endforeach
                        </ul>
                        <p class="card-text">Price: ${{ $cartItem->menu->price }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary">Place Order</button>
    </form>
</div>
@endsection
