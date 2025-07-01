@extends('admin_layouts.admin')

@section('content')
    <div class="container">
        <h1>List Order</h1>

        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createOrderModal"
            onclick="generateInvoiceNumber()">
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
                                @php
                                    $currentStatus = $order->orderStatus->status_type ?? 'pending';
                                @endphp
                                @foreach (['pending', 'proccessed', 'ready'] as $status)
                                    <option value="{{ $status }}" {{ $currentStatus === $status ? 'selected' : '' }}>
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

    <!-- Modal Create Order -->
    <div class="modal fade" id="createOrderModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <form action="{{ route('admin.orders.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create New Order</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Invoice #</label>
                                <input type="text" name="invoice_number" class="form-control" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Customer</label>
                                <select name="users_id" class="form-select">
                                    <option disabled selected>Pilih Customer</option>
                                    @foreach ($customers as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Subtotal</label>
                                <input type="number" name="subtotal" class="form-control" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Discount (%)</label>
                                <input type="text" name="discount" class="form-control" placeholder="Contoh: 10%">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Total</label>
                                <input type="number" name="total" class="form-control" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Order Type</label>
                                <select name="order_type" class="form-select">
                                    <option disabled selected>Pilih</option>
                                    @foreach ($orderTypes as $t)
                                        <option value="{{ $t }}">{{ ucfirst($t) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Payment Type</label>
                                <select name="payment_type" class="form-select">
                                    <option disabled selected>Pilih</option>
                                    @foreach ($paymentTypes as $p)
                                        <option value="{{ $p }}">{{ ucfirst($p) }}</option>
                                    @endforeach
                                </select>
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
                                    <th>Subtotal</th>
                                    <th>Total</th>
                                    <th>Notes</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="item-row">
                                    <td>
                                        <select name="items[0][menus_id]" class="form-select menu-select"
                                            onchange="updateItemPrice(this)">
                                            <option disabled selected>Pilih</option>
                                            @foreach ($menus as $m)
                                                <option value="{{ $m->id }}" data-price="{{ $m->price }}">{{ $m->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="text" name="items[0][portion]" class="form-control"></td>
                                    <td><input type="number" name="items[0][quantity]" class="form-control"></td>
                                    <td><input type="number" name="items[0][subtotal]" class="form-control" readonly></td>
                                    <td><input type="number" name="items[0][total]" class="form-control" readonly></td>
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
        function generateInvoiceNumber() {
            const date = new Date();
            const yyyy = date.getFullYear();
            const mm = String(date.getMonth() + 1).padStart(2, '0');
            const dd = String(date.getDate()).padStart(2, '0');
            fetch('/api/invoice-latest-number')
                .then(res => res.json())
                .then(data => {
                    const sequence = String(data.next_number).padStart(4, '0');
                    document.querySelector('input[name="invoice_number"]').value = `INV-${yyyy}-${mm}-${dd}-${sequence}`;
                });
        }

        function parseDiscount(input) {
            if (input.includes('%')) {
                return parseFloat(input.replace('%', '')) / 100;
            }
            return parseFloat(input);
        }

        function recalculateItemTotal(row) {
            const qty = parseFloat(row.querySelector('[name$="[quantity]"]').value) || 0;
            const price = parseFloat(row.querySelector('[name$="[subtotal]"]').value) || 0;
            const totalField = row.querySelector('[name$="[total]"]');
            totalField.value = qty * price;
            recalculateSubtotal();
        }

        function recalculateSubtotal() {
            const totalInputs = document.querySelectorAll('input[name$="[total]"]');
            let subtotal = 0;
            totalInputs.forEach(input => subtotal += parseFloat(input.value || 0));
            document.querySelector('input[name="subtotal"]').value = subtotal;
            recalculateFinalTotal();
        }

        function recalculateFinalTotal() {
            const subtotal = parseFloat(document.querySelector('input[name="subtotal"]').value || 0);
            const discountRaw = document.querySelector('input[name="discount"]').value;
            const discount = parseDiscount(discountRaw);
            const total = subtotal - (subtotal * discount);
            document.querySelector('input[name="total"]').value = total;
        }

        function updateItemPrice(select) {
            const price = parseFloat(select.selectedOptions[0].dataset.price || 0);
            const row = select.closest('tr');
            row.querySelector('[name$="[subtotal]"]').value = price;
            recalculateItemTotal(row);
        }

        let idx = 1;
        document.getElementById('add-item').addEventListener('click', () => {
            const tpl = document.querySelector('.item-row');
            const tr = tpl.cloneNode(true);
            tr.querySelectorAll('select, input').forEach(el => {
                const name = el.getAttribute('name').replace('[0]', `[${idx}]`);
                el.setAttribute('name', name);
                if (!el.classList.contains('menu-select')) el.value = '';
            });
            document.querySelector('#items-table tbody').append(tr);
            idx++;
        });

        document.addEventListener('click', e => {
            if (e.target.classList.contains('remove-item')) {
                const rows = document.querySelectorAll('.item-row');
                if (rows.length > 1) e.target.closest('tr').remove();
                recalculateSubtotal();
            }
        });

        document.addEventListener('input', function (e) {
            if (e.target.matches('[name$="[quantity]"]') || e.target.matches('[name$="[subtotal]"]')) {
                recalculateItemTotal(e.target.closest('tr'));
            }
            if (e.target.name === 'discount') {
                recalculateFinalTotal();
            }
        });
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
                    }
                });
            });
        });
    </script>
@endpush