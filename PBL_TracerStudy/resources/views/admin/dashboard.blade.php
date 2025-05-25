@extends('layouts.template')

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-lg-4 col-md-6 mt-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-0">Website Views</h6>
                    <p class="text-sm">Last Campaign Performance</p>
                    <div class="pe-2">
                        <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
                    </div>
                    <hr class="dark horizontal">
                    <div class="d-flex">
                        <i class="material-symbols-rounded text-sm my-auto me-1">schedule</i>
                        <p class="mb-0 text-sm">Campaign sent 2 days ago</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mt-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-0">Daily Sales</h6>
                    <p class="text-sm">Sales distribution</p>
                    <div class="pe-2">
                        <canvas id="chart-pie" class="chart-canvas" height="170"></canvas>
                    </div>
                    <hr class="dark horizontal">
                    <div class="d-flex">
                        <i class="material-symbols-rounded text-sm my-auto me-1">schedule</i>
                        <p class="mb-0 text-sm">Updated 4 min ago</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mt-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-0">Completed Tasks</h6>
                    <p class="text-sm">Last Campaign Performance</p>
                    <div class="pe-2">
                        <canvas id="chart-line-tasks" class="chart-canvas" height="170"></canvas>
                    </div>
                    <hr class="dark horizontal">
                    <div class="d-flex">
                        <i class="material-symbols-rounded text-sm my-auto me-1">schedule</i>
                        <p class="mb-0 text-sm">Just updated</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            <h6>Tabel Rata-Rata Masa Tunggu</h6>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-info">
                        <tr>
                            <th>Tahun Lulus</th>
                            <th>Jumlah Lulusan</th>
                            <th>Jumlah Lulusan yang Terlacak</th>
                            <th>Rata-rata Waktu Tunggu (Bulan)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalLulusan = 0;
                            $totalTerlacak = 0;
                            $totalMasaTunggu = 0;
                            $totalPengisiMasaTunggu = 0;
                        @endphp
                        @if (isset($masaTunggu))
                            @foreach ($masaTunggu as $row)
                                <tr>
                                    <td>{{ $row['tahun_lulus'] }}</td>
                                    <td>{{ $row['jumlah_lulusan'] }}</td>
                                    <td>{{ $row['jumlah_terlacak'] }}</td>
                                    <td>{{ number_format($row['rata_rata_masa_tunggu'], 2) }}</td>
                                </tr>
                                @php
                                    $totalLulusan += $row['jumlah_lulusan'];
                                    $totalTerlacak += $row['jumlah_terlacak'];
                                    $totalMasaTunggu += $row['total_masa_tunggu'];
                                    $totalPengisiMasaTunggu += $row['pengisi_masa_tunggu'];
                                @endphp
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot class="table-secondary">
                        <tr>
                            <th>Jumlah</th>
                            <th>{{ $totalLulusan }}</th>
                            <th>{{ $totalTerlacak }}</th>
                            <th>
                                {{ $totalPengisiMasaTunggu > 0 ? number_format($totalMasaTunggu / $totalPengisiMasaTunggu, 2) : 0 }}
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Bar Chart
        var ctx1 = document.getElementById("chart-bars").getContext("2d");
        new Chart(ctx1, {
            type: "bar",
            data: {
                labels: ["M", "T", "W", "T", "F", "S", "S"],
                datasets: [{
                    label: "Views",
                    backgroundColor: "#43A047",
                    data: [50, 45, 22, 28, 50, 60, 76],
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true
                    },
                    x: {
                        beginAtZero: true
                    },
                },
            },
        });

        // Pie Chart
        var ctx2 = document.getElementById("chart-pie").getContext("2d");
        new Chart(ctx2, {
            type: "pie",
            data: {
                labels: ["Electronics", "Clothing", "Home Appliances"],
                datasets: [{
                    label: "Sales",
                    backgroundColor: ["#43A047", "#FF9800", "#E91E63"],
                    data: [40, 30, 30],
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: "top"
                    },
                },
            },
        });

        // Line Chart
        var ctx3 = document.getElementById("chart-line-tasks").getContext("2d");
        new Chart(ctx3, {
            type: "line",
            data: {
                labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Tasks",
                    borderColor: "#43A047",
                    data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
                    fill: false,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true
                    },
                    x: {
                        beginAtZero: true
                    },
                },
            },
        });
    </script>
@endsection
