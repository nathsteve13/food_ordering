@extends('layouts.app')

@section('content')
    <section class="py-5">
        <div class="container">
            <h1>{{ $cartItem->menu->name }}</h1>
            <p class="text-muted">Category: {{ $cartItem->menu->category->name ?? 'Unknown' }}</p>

            <div class="row">
                <div class="col-md-6">
                    {{-- Gambar utama --}}
                    @if($cartItem->menu->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $cartItem->menu->images->first()->image_path) }}"
                             class="img-fluid rounded"
                             alt="{{ $cartItem->menu->name }}">
                    @else
                        <img src="{{ asset('images/categories/makanan_penutup.jpg') }}"
                             class="img-fluid rounded"
                             alt="Default image">
                    @endif
                </div>

                <div class="col-md-6">
                    <h4>Description</h4>
                    <p>{{ $cartItem->menu->description }}</p>

                    <h4>Nutrition Fact</h4>
                    <p>{{ $cartItem->menu->nutrition_fact }}</p>

                    <h4>Price</h4>
                    <p>Rp {{ number_format($cartItem->menu->price, 0, ',', '.') }}</p>

                    <h4>Stock</h4>
                    <p>{{ $cartItem->menu->stock }} pcs</p>

                    <h4>Ingredients</h4>
                    <form action="{{ route('cart.update.ingredients', $cartItem->id) }}" method="POST">
                        @csrf

                        @if($cartItem->menu->ingredients->isNotEmpty())
                            <ul class="list-unstyled">
                                @foreach ($cartItem->menu->ingredients as $ingredient)
                                    @php
                                        $checked = $cartItem->ingredients->contains('menu_has_ingredient_id', $ingredient->pivot->id);
                                    @endphp
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                               name="ingredients[]"
                                               value="{{ $ingredient->pivot->id }}"
                                               id="ingredient-{{ $ingredient->pivot->id }}"
                                               {{ $checked ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ingredient-{{ $ingredient->pivot->id }}">
                                            {{ $ingredient->name }}
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
                        <a href="{{ route('cart.index') }}" class="btn btn-secondary mt-3">Kembali ke Cart</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
