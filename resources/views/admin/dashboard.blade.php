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
                <canvas id="activeMembersChart"></canvas>
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
                <canvas id="topMemberChart"></canvas>
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
                <canvas id="topMenuChart"></canvas>
            </div>
        </div>

        {{-- 4. Total Pendapatan (Grouped by Month) --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5>4. Total Pendapatan (Grouped by Month)</h5>
            </div>
            <div class="card-body">
                <canvas id="monthlyIncomeChart"></canvas>

                <h6 class="mt-4">Pendapatan Bulanan</h6>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            <th>Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($monthlyIncome as $income)
                            <tr>
                                <td>{{ $income->month }}-{{ $income->year }}</td>
                                <td>{{ number_format($income->total_income, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- 5. Top Selling Menu (Grouped by Month) --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5>5. Top Selling Menu (Grouped by Month)</h5>
            </div>
            <div class="card-body">
                <canvas id="monthlyTopMenuChart"></canvas>

                <h6 class="mt-4">Top Selling Menu Bulanan</h6>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            <th>Menu</th>
                            <th>Total Terjual</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($monthlyTopMenu as $menu)
                            <tr>
                                <td>{{ $menu->month }}-{{ $menu->year }}</td>
                                <td>{{ $menu->name }}</td>
                                <td>{{ $menu->total_quantity }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- 6. Bottom Selling Menu (Grouped by Month) --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5>6. Bottom Selling Menu (Grouped by Month)</h5>
            </div>
            <div class="card-body">
                <canvas id="monthlyBottomMenuChart"></canvas>

                <h6 class="mt-4">Bottom Selling Menu Bulanan</h6>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            <th>Menu</th>
                            <th>Total Terjual</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($monthlyBottomMenu as $menu)
                            <tr>
                                <td>{{ $menu->month }}-{{ $menu->year }}</td>
                                <td>{{ $menu->name }}</td>
                                <td>{{ $menu->total_quantity }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // 1. Anggota Aktif Chart
        var ctx1 = document.getElementById('activeMembersChart').getContext('2d');
        var activeMembersChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: @json($activeMembers->pluck('name')),
                datasets: [{
                    label: 'Anggota Aktif',
                    data: @json($activeMembers->pluck('id')),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // 2. Anggota dengan Transaksi Terbanyak Chart
        var ctx2 = document.getElementById('topMemberChart').getContext('2d');
        var topMemberChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: @json($topMember ? [$topMember->name] : []),
                datasets: [{
                    label: 'Total Transaksi',
                    data: @json($topMember ? [$topMember->total_transactions] : []),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // 3. Menu Paling Banyak Dipesan Chart
        var ctx3 = document.getElementById('topMenuChart').getContext('2d');
        var topMenuChart = new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: @json($topMenu ? [$topMenu->name] : []),
                datasets: [{
                    label: 'Total Dipesan',
                    data: @json($topMenu ? [$topMenu->total_quantity] : []),
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // 4. Total Pendapatan Chart (Monthly)
        var ctx4 = document.getElementById('monthlyIncomeChart').getContext('2d');
        var monthlyIncomeChart = new Chart(ctx4, {
            type: 'line',
            data: {
                labels: @json($monthlyIncome->map(function($item) { return $item->month . '-' . $item->year; })),
                datasets: [{
                    label: 'Total Pendapatan',
                    data: @json($monthlyIncome->pluck('total_income')),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // 5. Top Selling Menu Chart (Monthly)
        var ctx5 = document.getElementById('monthlyTopMenuChart').getContext('2d');
        var monthlyTopMenuChart = new Chart(ctx5, {
            type: 'bar',
            data: {
                labels: @json($monthlyTopMenu->map(function($item) { return $item->month . '-' . $item->year . ' ' . $item->name; })),
                datasets: [{
                    label: 'Top Selling Menu',
                    data: @json($monthlyTopMenu->pluck('total_quantity')),
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // 6. Bottom Selling Menu Chart (Monthly)
        var ctx6 = document.getElementById('monthlyBottomMenuChart').getContext('2d');
        var monthlyBottomMenuChart = new Chart(ctx6, {
            type: 'bar',
            data: {
                labels: @json($monthlyBottomMenu->map(function($item) { return $item->month . '-' . $item->year . ' ' . $item->name; })),
                datasets: [{
                    label: 'Bottom Selling Menu',
                    data: @json($monthlyBottomMenu->pluck('total_quantity')),
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

@endsection
