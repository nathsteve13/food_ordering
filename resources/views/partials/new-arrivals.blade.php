@if($recentMenus->count())
    @foreach ($recentMenus as $menu)
        <div class="swiper-slide">
            <div class="card p-3 rounded-4 shadow border-0 h-100">
                @php
                    $imagePath = $menu->images->isNotEmpty()
                        ? asset('storage/' . $menu->images->first()->image_path)
                        : asset('images/categories/makanan_penutup.jpg');
                @endphp

                <img src="{{ $imagePath }}" alt="{{ $menu->name }}" class="img-fluid rounded mb-3" style="object-fit: cover; height: 180px; width: 100%;">

                <div class="card-body py-0">
                    <p class="text-muted mb-1">{{ $menu->name }}</p>
                    <h5 class="card-title">{{ $menu->description }}</h5>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="swiper-slide">
        <div class="text-center text-muted py-5">
            Tidak ada menu baru dalam 7 hari terakhir.
        </div>
    </div>
@endif