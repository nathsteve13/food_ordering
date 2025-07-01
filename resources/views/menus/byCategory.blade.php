@extends('layouts.app')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="mb-4">
                <a href="{{ route('home') }}" class="btn btn-secondary mt-3">Back to home</a>
            </div>
            <h2 class="mb-4">Categories: {{ $category->name }}</h2>
            @if ($menus->isEmpty())
                <p class="text-muted">No menu items found in this category.</p>
            @else
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                    @foreach ($menus as $menu)
                        <div class="col">
                            @include('partials.product-card', ['menu' => $menu])
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection