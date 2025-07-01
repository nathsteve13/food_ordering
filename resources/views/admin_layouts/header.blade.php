<!-- resources/views/layouts/header.blade.php -->
<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
            <li class="nav-item d-none d-md-block"><a href="{{ route('admin.category.index') }}" class="nav-link">Category</a></li>
            <li class="nav-item d-none d-md-block"><a href="{{ route('admin.food.index') }}" class="nav-link">Food</a></li>
            <li class="nav-item d-none d-md-block"><a href="{{ route('admin.order.index') }}" class="nav-link">Order</a></li>
            <li class="nav-item d-none d-md-block"><a href="{{ route('admin.dashboard') }}" class="nav-link">Data Report</a></li>
        </ul>
        <ul class="navbar-nav ms-auto">
            <!-- Display username here -->
            @auth
            <li class="nav-item">
                <span class="nav-link">Welcome, {{ Auth::user()->name }}</span>
            </li>
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link btn btn-link" style="border: none; background: none;">Logout</button>
                </form>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link" href="{{ route('loginForm') }}">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('registerForm') }}">Register</a>
            </li>
            @endauth
        </ul>
    </div>
</nav>
