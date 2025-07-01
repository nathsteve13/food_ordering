<!DOCTYPE html>
<html lang="en">
@include('layouts.header')

<body>

    @include('layouts.svg-symbols')

    @include('layouts.offcanvas-cart')

    @include('layouts.offcanvas-search')


    @include('layouts.navbar')

    <main>
        @yield('content')
    </main>

    @include('layouts.footer')

    <script src="js/jquery-1.11.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <script src="js/plugins.js"></script>
    <script src="js/script.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.product-item').forEach(item => {
                const minus = item.querySelector('.quantity-left-minus');
                const plus = item.querySelector('.quantity-right-plus');
                const input = item.querySelector('input[name="quantity"]');

                minus?.addEventListener('click', function (e) {
                    e.preventDefault();
                    let qty = parseInt(input.value);
                    if (qty > 1) input.value = qty - 1;
                });

                plus?.addEventListener('click', function (e) {
                    e.preventDefault();
                    let qty = parseInt(input.value);
                    input.value = qty + 1;
                });
            });
        });
    </script>
</body>

</html>
