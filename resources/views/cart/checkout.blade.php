@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Checkout</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (count($cart) > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Menu</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cart as $id => $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>Rp{{ number_format($item['price'], 0, ',', '.') }}</td>
                        <td>
                            {{-- Tombol tambah dan kurang quantity --}}
                            <button type="button" class="update-qty btn btn-outline-secondary" data-id="{{ $id }}" data-action="decrease">-</button>
                            <span id="qty-{{ $id }}">{{ $item['quantity'] }}</span>
                            <button type="button" class="update-qty btn btn-outline-secondary" data-id="{{ $id }}" data-action="increase">+</button>
                        </td>   
                        <td id="subtotal-{{ $id }}">Rp{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                        <td>
                            {{-- Tombol hapus menu dari cart --}}
                            <a href="{{ route('cart.remove', $id) }}" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i> Hapus
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-end mb-4">
            {{-- Menampilkan total semua harga --}}
            <h4>Total: <strong id="total-amount">
                Rp{{ number_format(collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']), 0, ',', '.') }}
            </strong></h4>
        </div>

        {{-- Form untuk checkout --}}
        <form action="{{ route('cart.checkout.process') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="user_id" class="form-label">Pilih User</label>
                <select name="user_id" id="user_id" class="form-select" required>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="order_type" class="form-label">Tipe Pesanan</label>
                <select name="order_type" id="order_type" class="form-select" required>
                    @foreach ($orderTypes as $type)
                        <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="payment_type" class="form-label">Metode Pembayaran</label>
                <select name="payment_type" id="payment_type" class="form-select" required>
                    @foreach ($paymentTypes as $type)
                        <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Proses Checkout</button>
        </form>
    @else
        <p>Keranjang kamu kosong.</p>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Kirim request ke server untuk update quantity di session cart
    const updateServerQty = (id, quantity) => {
        fetch("{{ route('cart.updateQuantity') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ id, quantity })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Update quantity tampilan
                document.getElementById(`qty-${id}`).innerText = quantity;
                // Update subtotal per menu
                document.getElementById(`subtotal-${id}`).innerText = 'Rp' + data.subtotal.toLocaleString('id-ID');
                // Update total semua harga
                document.getElementById('total-amount').innerText = 'Rp' + data.total.toLocaleString('id-ID');
            }
        });
    };

    // Event listener untuk semua tombol + dan -
    document.querySelectorAll('.update-qty').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.dataset.id; // ambil ID menu
            const action = this.dataset.action; // increase atau decrease
            const qtyEl = document.getElementById(`qty-${id}`); // elemen <span> quantity
            let currentQty = parseInt(qtyEl.innerText); // ambil value angka

            if (action === 'increase') currentQty++;
            else if (action === 'decrease') currentQty = Math.max(1, currentQty - 1);

            // Update ke server dan tampilan
            updateServerQty(id, currentQty);
        });
    });
});
</script>
@endpush
