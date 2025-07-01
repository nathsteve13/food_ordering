<section class="py-5 overflow-hidden">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-12 d-flex justify-content-between align-items-center">
                <h2 class="section-title">🔥 Best Selling Products</h2>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
            @forelse ($bestSellingMenus->take(3) as $menu)
                @include('partials.product-card', ['menu' => $menu])
            @empty
                <div class="col-12">
                    <div class="alert alert-warning text-center">Belum ada produk terlaris.</div>
                </div>
            @endforelse
        </div>
    </div>
</section>
