@extends('admin_layouts.admin')

@section('content')
    <div class="container">
        <h1>List Order</h1>

        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createOrderModal">
            Create Order
        </button>

        <a href="{{ route('admin.order.trashed') }}" class="btn btn-outline-secondary mb-3">Deleted Order</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Subtotal</th>
                    <th>Discount</th>
                    <th>Total</th>
                    <th>Order Type</th>
                    <th>Payment Type</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $order)
                    <tr>
                        <td>{{ $order->invoice_number }}</td>
                        <td>Rp {{ number_format($order->subtotal) }}</td>
                        <td>Rp {{ number_format($order->discount) }}</td>
                        <td>Rp {{ number_format($order->total) }}</td>
                        <td>{{ ucfirst($order->order_type) }}</td>
                        <td>{{ ucfirst($order->payment_type) }}</td>
                        <td>{{ $order->user->name ?? '-' }}</td>
                        <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <select class="form-select form-select-sm d-inline-block w-auto me-1 status-dropdown"
                                data-invoice="{{ $order->invoice_number }}">
                                <option selected disabled>Pilih status</option>
                                @foreach (['pending', 'proccessed', 'ready'] as $status)
                                    <option value="{{ $status }}" {{ optional($order->orderStatus)->status_type === $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-success update-status-btn"
                                data-invoice="{{ $order->invoice_number }}">Update</button>
                            <button class="btn btn-info btn-sm" onclick="showDetailModal('{{ $order->invoice_number }}')">
                                Detail
                            </button>
                            <form action="{{ route('admin.order.destroy', $order->invoice_number) }}" method="POST"
                                style="display:inline;"
                                onsubmit="return confirm('Are you sure you want to delete this order?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="detailModalBody">
                    <p>Loading...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Order Modal -->
    <div class="modal fade" id="createOrderModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('admin.orders.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create New Order</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <!-- invoice, customer, subtotal, discount, total, order & payment type -->
                            <div class="col-md-6">
                                <label class="form-label">Invoice #</label>
                                <input type="text" name="invoice_number" value="{{ old('invoice_number') }}"
                                    class="form-control @error('invoice_number') is-invalid @enderror">
                                @error('invoice_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Customer</label>
                                <select name="users_id" class="form-select @error('users_id') is-invalid @enderror">
                                    <option disabled selected>Choose…</option>
                                    @foreach ($customers as $c)
                                        <option value="{{ $c->id }}" {{ old('users_id') == $c->id ? 'selected' : '' }}>
                                            {{ $c->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('users_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Subtotal</label>
                                <input type="number" name="subtotal" value="{{ old('subtotal') }}"
                                    class="form-control @error('subtotal') is-invalid @enderror">
                                @error('subtotal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Discount</label>
                                <input type="number" name="discount" value="{{ old('discount', 0) }}"
                                    class="form-control @error('discount') is-invalid @enderror">
                                @error('discount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Total</label>
                                <input type="number" name="total" value="{{ old('total') }}"
                                    class="form-control @error('total') is-invalid @enderror">
                                @error('total')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Order Type</label>
                                <select name="order_type" class="form-select @error('order_type') is-invalid @enderror">
                                    <option disabled selected>Choose…</option>
                                    @foreach ($orderTypes as $t)
                                        <option value="{{ $t }}" {{ old('order_type') == $t ? 'selected' : '' }}>
                                            {{ ucfirst($t) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('order_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Payment Type</label>
                                <select name="payment_type" class="form-select @error('payment_type') is-invalid @enderror">
                                    <option disabled selected>Choose…</option>
                                    @foreach ($paymentTypes as $p)
                                        <option value="{{ $p }}" {{ old('payment_type') == $p ? 'selected' : '' }}>
                                            {{ ucfirst($p) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('payment_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        <h5>Order Items</h5>
                        <table class="table" id="items-table">
                            <thead>
                                <tr>
                                    <th>Menu</th>
                                    <th>Portion</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                    <th>Notes</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="item-row">
                                    <td>
                                        <select name="items[0][menus_id]" class="form-select">
                                            <option disabled selected>Choose…</option>
                                            @foreach ($menus as $m)
                                                <option value="{{ $m->id }}">{{ $m->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="text" name="items[0][portion]" class="form-control"></td>
                                    <td><input type="number" name="items[0][quantity]" class="form-control"></td>
                                    <td><input type="number" name="items[0][total]" class="form-control"></td>
                                    <td><input type="text" name="items[0][notes]" class="form-control"></td>
                                    <td><button type="button" class="btn btn-danger remove-item">–</button></td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" id="add-item" class="btn btn-secondary">Add Item</button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Order</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let idx = 1;
        document.getElementById('add-item').addEventListener('click', () => {
            const tpl = document.querySelector('.item-row');
            const tr = tpl.cloneNode(true);
            tr.querySelectorAll('select, input').forEach(el => {
                const name = el.getAttribute('name')
                    .replace(/\[0\]/, `[${idx}]`);
                el.setAttribute('name', name);
                el.value = '';
            });
            document.querySelector('#items-table tbody').append(tr);
            idx++;
        });

        document.addEventListener('click', e => {
            if (e.target.classList.contains('remove-item')) {
                const rows = document.querySelectorAll('.item-row');
                if (rows.length > 1) e.target.closest('tr').remove();
            }
        });

        function showDetailModal(invoiceNumber) {
            fetch(`/admin/order/detail/${invoiceNumber}`)
                .then(response => response.json())
                .then(data => {
                    let html = `<table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Menu</th>
                                                <th>Portion</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                                <th>Notes</th>
                                            </tr>
                                        </thead>
                                        <tbody>`;
                    data.details.forEach(item => {
                        html += `<tr>
                                        <td>${item.menu.name}</td>
                                        <td>${item.portion}</td>
                                        <td>${item.quantity}</td>
                                        <td>Rp ${item.total}</td>
                                        <td>${item.notes ?? '-'}</td>
                                    </tr>`;
                    });
                    html += `</tbody></table>`;

                    html += `<h5>Order Status History</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Status</th>
                                            <th>Updated At</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;
                    console.log('Order Status History:', data.transactions);
                    if (data.transactions.length > 0) {
                        data.transactions.forEach(transaction => {
                            html += `<tr>
                                            <td>${transaction.status_type}</td>
                                            <td>${new Date(transaction.created_at).toLocaleString('id-ID', { dateStyle: 'medium', timeStyle: 'short' })}</td>
                                        </tr>`;
                        });
                    } else {
                        html += `<tr>
                                        <td colspan="2">No status history available</td>
                                    </tr>`;
                    }

                    html += `</tbody></table>`;

                    document.getElementById('detailModalBody').innerHTML = html;
                    new bootstrap.Modal(document.getElementById('detailModal')).show();
                })
                .catch(error => {
                    console.error('Error fetching detail:', error);
                    document.getElementById('detailModalBody').innerHTML = '<p>Failed to load data.</p>';
                    new bootstrap.Modal(document.getElementById('detailModal')).show();
                });
        }
    </script>

    <script>
        $(document).ready(function () {
            $('.update-status-btn').on('click', function () {
                var invoiceNumber = $(this).data('invoice');
                var selectedStatus = $('.status-dropdown[data-invoice="' + invoiceNumber + '"]').val();

                $.ajax({
                    type: 'PATCH',
                    url: '/admin/order/status/update/' + invoiceNumber,
                    data: {
                        _token: '{{ csrf_token() }}',
                        status_type: selectedStatus
                    },
                    success: function (data) {
                        alert(data.message);
                    },
                    error: function (xhr, status, error) {
                        console.error('Error updating status:', error);
                        alert('Gagal memperbarui status.');
                    }
                });
            });
        });
    </script>
@endpush
