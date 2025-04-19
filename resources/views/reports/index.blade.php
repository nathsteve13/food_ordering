@extends('admin_layouts.admin')

@section('content')
    <div class="container">
        <h1 class="mb-4">Data Report</h1>

        {{-- 1. Anggota Aktif --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5>1. Anggota Aktif (30 Hari Terakhir)</h5>
            </div>
            <div class="card-body">
                @if ($activeMembers->count())
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activeMembers as $index => $member)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->email }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted">Tidak ada anggota aktif.</p>
                @endif
            </div>
        </div>

        {{-- 2. Anggota dengan Transaksi Terbanyak --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5>2. Anggota dengan Transaksi Terbanyak</h5>
            </div>
            <div class="card-body">
                @if ($topMember)
                    <p><strong>{{ $topMember->name }}</strong> - {{ $topMember->total_transactions }} transaksi</p>
                @else
                    <p class="text-muted">Tidak ada data.</p>
                @endif
            </div>
        </div>

        {{-- 3. Menu Paling Banyak Dipesan --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5>3. Menu Paling Banyak Dipesan</h5>
            </div>
            <div class="card-body">
                @if ($topMenu)
                    <p><strong>{{ $topMenu->name }}</strong> - Total dipesan: {{ $topMenu->total_quantity }}</p>
                @else
                    <p class="text-muted">Tidak ada data menu.</p>
                @endif
            </div>
        </div>
    </div>
@endsection