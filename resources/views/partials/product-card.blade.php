<div class="col">
    <div class="product-item h-100 d-flex flex-column">
        <figure class="image-container mb-2" style="height: 180px; overflow: hidden;">
            <a href="{{ route('menus.show', $menu->id) }}" title="{{ $menu->name }}">
                @php
                    $imagePath = $menu->images->isNotEmpty()
                        ? asset('storage/' . $menu->images->first()->image_path)
                        : asset('images/categories/makanan_penutup.jpg');
                @endphp

                <img src="{{ $imagePath }}" alt="{{ $menu->name }}" class="tab-image w-100 h-100"
                     style="object-fit: cover;">
            </a>
        </figure>

        <h3 class="mb-1">
            <a href="{{ route('menus.show', $menu->id) }}" class="text-dark text-decoration-none">{{ $menu->name }}</a>
        </h3>

        <span class="qty text-muted small">{{ $menu->stock }} pcs</span>
        <span class="price fw-bold">Rp{{ number_format($menu->price, 0, ',', '.') }}</span>
    </div>
</div>
