<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasCart" aria-labelledby="My Cart">
    <div class="offcanvas-header justify-content-center">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="order-md-last">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-primary">Your cart</span>
                <span class="badge bg-primary rounded-pill">
                    {{ session('cart') ? count(session('cart')) : 0 }}
                </span>
            </h4>

            <ul class="list-group mb-3">
                @php $total = 0; @endphp
                @if(session('cart') && count(session('cart')) > 0)
                    @foreach(session('cart') as $id => $item)
                        @php $total += $item['price'] * $item['quantity']; @endphp
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">{{ $item['name'] }}</h6>
                                <small class="text-body-secondary">{{ $item['quantity'] }} pcs</small>
                            </div>
                            <span class="text-body-secondary">Rp{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                        </li>
                    @endforeach
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total</span>
                        <strong>Rp{{ number_format($total, 0, ',', '.') }}</strong>
                    </li>
                @else
                    <li class="list-group-item text-center">Cart is empty.</li>
                @endif
            </ul>

            <a href="{{ route('cart.checkout.form') }}" class="w-100 btn btn-primary btn-lg">
                Continue to checkout
            </a>
        </div>
    </div>
</div>
