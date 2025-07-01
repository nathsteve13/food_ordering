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

        {{-- <div class="mt-auto d-flex align-items-center justify-content-between pt-2">
            <div class="input-group product-qty" style="max-width: 110px;">
                <span class="input-group-btn">
                    <button type="button" class="quantity-left-minus btn btn-danger btn-number" data-type="minus">
                        <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                    </button>
                </span>
                <input type="text" name="quantity" class="form-control input-number text-center" value="1">
                <span class="input-group-btn">
                    <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus">
                        <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                    </button>
                </span>
            </div>
        </div>
    </div>
</div>
