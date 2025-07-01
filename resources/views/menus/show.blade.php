@extends('layouts.app')

@section('content')
    <section class="py-5">
        <div class="container">
            <h1>{{ $menu->name }}</h1>
            <p class="text-muted">Category: {{ $menu->category->name ?? 'Unknown' }}</p>

            <div class="row">
                <div class="col-md-6">
                    {{-- Gambar utama --}}
                    @if($menu->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $menu->images->first()->image_path) }}" class="img-fluid rounded"
                            alt="{{ $menu->name }}">
                    @else
                        <img src="{{ asset('images/categories/makanan_penutup.jpg') }}" class="img-fluid rounded"
                            alt="Default image">
                    @endif

                    {{-- Gambar tambahan --}}
                    {{-- <div class="mt-3 d-flex flex-wrap gap-2">
                        @foreach ($menu->images as $image)
                            <img src="{{ asset('storage/' . $image->image_path) }}" class="rounded" width="100" height="100"
                                alt="Image">
                        @endforeach
                    </div> --}}
                </div>

                <div class="col-md-6">
                    <h4>Description</h4>
                    <p>{{ $menu->description }}</p>

                    <h4>Nutrition Fact</h4>
                    <p>{{ $menu->nutrition_fact }}</p>

                    <h4>Price</h4>
                    <p>Rp {{ number_format($menu->price, 0, ',', '.') }}</p>

                    <h4>Stock</h4>
                    <p>{{ $menu->stock }} pcs</p>

                    <h4>Ingredients</h4>
                    <form action="{{ route('cart.add', $menu->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">

                        @if($menu->ingredients->isNotEmpty())
                            <ul class="list-unstyled">
                                @foreach ($menu->ingredients as $ingredient)
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" name="ingredients[]"
                                            value="{{ $ingredient->pivot->id }}" id="ingredient-{{ $ingredient->pivot->id }}" checked>
                                        <label class="form-check-label" for="ingredient-{{ $ingredient->pivot->id }}">
                                            {{ $ingredient->name }}
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        <button type="submit" class="btn btn-primary mt-3">Add to Cart</button>
                        <a href="{{ route('home') }}" class="btn btn-secondary mt-3">Back to home</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection