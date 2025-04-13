@extends('layouts.app')
@section('content')
    <div class="container">
        <form method="GET" action="#" class="d-flex align-items-center mb-4">
            <input type="text" name="query" class="form-control me-2" placeholder="Search for products...">
            <button type="button" class="btn btn-primary" onclick="alert('Search functionality not implemented yet!')">
                <i class="fas fa-search"></i> Search
            </button>
        </form>

        <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">

            @for ($i = 0; $i < 10; $i++)
                @include('partials.product-card')
            @endfor

        </div>
    </div>
@endsection
