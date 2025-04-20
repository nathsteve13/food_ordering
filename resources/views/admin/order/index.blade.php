@extends('admin_layouts.admin')

@section('content')
    <div class="container">
        <h1>List Order</h1>
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
                        <td>{{ ucfirst($order->orderStatus->status_type ?? '-') }}</td>
                        <td>
                            <a href="{{ route('admin.order.edit', $order->invoice_number) }}"
                                class="btn btn-warning btn-sm">Edit</a>
                            <button class="btn btn-info btn-sm"
                                onclick="showDetailModal('{{ $order->invoice_number }}')">
                                Detail
                            </button>

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
@endsection

@push('scripts')
    <script>
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
                    data.forEach(item => {
                        html += `<tr>
                                <td>${item.menu.name}</td>
                                <td>${item.portion}</td>
                                <td>${item.qty}</td>
                                <td>Rp ${item.total}</td>
                                <td>${item.notes ?? '-'}</td>
                            </tr>`;
                    });
                    html += `</tbody></table>`;

                    document.getElementById('detailModalBody').innerHTML = html;
                    new bootstrap.Modal(document.getElementById('detailModal')).show();
                })
                .catch(error => {
                    console.error('Error fetching detail:', error);
                    document.getElementById('detailModalBody').innerHTML = '<p>Gagal memuat data.</p>';
                    new bootstrap.Modal(document.getElementById('detailModal')).show();
                });
        }
    </script>
@endpush
