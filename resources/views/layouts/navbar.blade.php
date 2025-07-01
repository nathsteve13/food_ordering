<header>
    <div class="container-fluid">
        <div class="row py-3 border-bottom">

            <div class="col-sm-4 col-lg-3 text-center text-sm-start">
                <div class="main-logo">
                    <a href="index.html">
                        <img src="images/logo.png" alt="logo" class="img-fluid">
                    </a>
                </div>
            </div>
            <div class="col-sm-8 col-lg-9 d-flex justify-content-end align-items-center mt-3">
                @if(Auth::check())
                    <form action="{{ route('logout') }}" method="POST" class="d-inline me-2">
                        @csrf
                        <button type="submit" class="btn btn-danger rounded-pill px-4 py-2">Logout</button>
                    </form>
                    <a href="{{ route('cart.index') }}" class="btn btn-success rounded-pill px-4 py-2">
                        Cart
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary rounded-pill px-4 py-2 ms-auto">
                        Login
                    </a>
                @endif
            </div>

        </div>

    </div>
</header>
