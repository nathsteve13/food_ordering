@extends('layouts.app')

@section('content')
    <section class="py-5">
        <div class="container">
            {{-- Tombol Back --}}
            <div class="mb-4">
                <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                    ← Kembali ke Halaman Utama
                </a>
            </div>

            {{-- Judul Kategori --}}
            <h2 class="mb-4">Kategori: {{ $category->name }}</h2>

            {{-- Menu List --}}
            @if ($menus->isEmpty())
                <p class="text-muted">Tidak ada menu dalam kategori ini.</p>
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