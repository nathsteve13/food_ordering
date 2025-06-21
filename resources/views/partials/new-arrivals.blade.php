@if($recentMenus->count())
    @foreach ($recentMenus as $menu)
        <div class="swiper-slide">
            <div class="card mb-3 p-3 rounded-4 shadow border-0">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="{{ asset('storage/' . $menu->image_path) }}" class="img-fluid rounded"
                            alt="{{ $menu->name }}">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body py-0">
                            <p class="text-muted mb-0">{{ $menu->name }}</p>
                            <h5 class="card-title">{{ $menu->description }}</h5>
                        </div>
                    </div>
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