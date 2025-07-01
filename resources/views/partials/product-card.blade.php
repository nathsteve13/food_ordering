<div class="col">
    <div class="product-item">
        <figure>
            <a href="{{ route('menus.show', $menu->id) }}" title="{{ $menu->name }}">
                @php
                    $imagePath = $menu->images->isNotEmpty()
                        ? asset($menu->images->first()->image_path)
                        : asset('images/categories/makanan_penutup.jpg');
                @endphp

                <img src="{{ $imagePath }}" alt="{{ $menu->name }}" class="tab-image">
            </a>
        </figure>

        <h3>
            <a href="{{ route('menus.show', $menu->id) }}" class="text-dark">{{ $menu->name }}</a>
        </h3>

        <span class="qty">{{ $menu->stock }} Unit</span>
        <span class="price">Rp{{ number_format($menu->price, 0, ',', '.') }}</span>

        <div class="d-flex align-items-center justify-content-between">
            <div class="input-group product-qty">
                <span class="input-group-btn">
                    <button type="button" class="quantity-left-minus btn btn-danger btn-number" data-type="minus">
                        <svg width="16" height="16">
                            <use xlink:href="#minus"></use>
                        </svg>
                    </button>
                </span>
                <input type="text" id="quantity" name="quantity" class="form-control input-number" value="1">
                <span class="input-group-btn">
                    <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus">
                        <svg width="16" height="16">
                            <use xlink:href="#plus"></use>
                        </svg>
                    </button>
                </span>
            </div>
        </div>
    </div>
</div>