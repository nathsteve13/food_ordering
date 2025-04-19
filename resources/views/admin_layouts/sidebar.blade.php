<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{route('admin.dashboard')}}" class="brand-link">
            <img src="{{ asset('admin/assets/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image opacity-75 shadow" />
            <span class="brand-text fw-light">FOOD APP</span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column">
                <!-- Define sidebar items here -->
                <li class="nav-item menu-open">
                    <a href="{{route('admin.dashboard')}}" class="nav-link active">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <!-- Add more sidebar menu items as needed -->
                <li class="nav-item menu-open">
                    <a href="{{route('admin.food.index')}}" class="nav-link active">
                        <i class="nav-icon bi bi-basket"></i>
                        <p>Foods</p>
                    </a>
                </li>
                <li class="nav-item menu-open">
                    <a href="{{ route('admin.category.index')}}" class="nav-link active">
                        <i class="nav-icon bi bi-tags"></i>
                        <p>Categories</p>
                    </a>
                </li>
                <li class="nav-item menu-open">
                    <a href="{{ route('admin.order.index')}}" class="nav-link active">
                        <i class="nav-icon bi bi-cart"></i>
                        <p>Order</p>
                    </a>
                </li>
                <li class="nav-item menu-open">
                    <a href="{{ route('admin.reports.index')}}" class="nav-link active">
                        <i class="nav-icon bi bi-book"></i>
                        <p>Data Report</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
