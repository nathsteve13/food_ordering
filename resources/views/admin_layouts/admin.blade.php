<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>@yield('title', 'Food App | Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS." />
    <meta name="keywords" content="bootstrap 5, admin dashboard, vanilla js" />

    <!-- ✅ Fonts & Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css" />

    <!-- ✅ Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- ✅ Custom App CSS -->
    <link rel="stylesheet" href="{{ asset('admin/css/adminlte.css') }}" />
    @stack('styles')
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        @include('admin_layouts.header')

        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
            @include('admin_layouts.sidebar')
        </aside>

        <main class="app-main mt-2 p-4">
            @yield('content')
        </main>
    </div>

    <!-- ✅ JS Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"></script>

    <script src="{{ asset('admin/js/adminlte.js') }}"></script>
    @stack('scripts')
</body>

</html>
