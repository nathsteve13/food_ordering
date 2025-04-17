@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ asset($product['image']) }}" alt="{{ $product['title'] }}" class="img-fluid">
        </div>
        <div class="col-md-6">
            <h2>{{ $product['title'] }}</h2>
            <p>{{ $product['description'] }}</p>
            <p><strong>Quantity:</strong> {{ $product['qty'] }}</p>
            <p><strong>Rating:</strong> ⭐ {{ $product['rating'] }}</p>
            <h4 class="text-success">${{ number_format($product['price'], 2) }}</h4>

            <div class="d-flex mt-3">
                <input type="number" class="form-control w-25 me-3" value="1">
                <button class="btn btn-primary">Add to Cart</button>
            </div>
        </div>
    </div>
</div>
@endsection
