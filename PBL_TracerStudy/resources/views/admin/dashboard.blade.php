@extends('layouts.template')

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <!-- PROFESI -->
        <div class="col-lg-6 col-md-12 mt-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-0">Grafik Sebaran Profesi Lulusan</h6>
                    <p class="text-sm">10 profesi tertinggi + kategori Lainnya</p>
                    <div class="pe-2">
                        <canvas id="chart-profesi" class="chart-canvas" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- INSTANSI -->
        <div class="col-lg-6 col-md-12 mt-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-0">Grafik Sebaran Jenis Instansi</h6>
                    <p class="text-sm">Kategori: Pendidikan Tinggi, Instansi Pemerintah, Swasta, BUMN</p>
                    <div class="pe-2">
                        <canvas id="chart-instansi" class="chart-canvas" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
       <!-- TABEL KEPUASAN -->
        <div class="col-12 mt-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-0">Tabel Penilaian Kepuasan Pengguna Lulusan</h6>
                    <p class="text-sm">Persentase hasil input pengguna lulusan</p>
                    <a href="{{ url('/dashboard-export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i> Export
                    Excel</a>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Jenis Kemampuan</th>
                                    <th>Sangat Baik (%)</th>
                                    <th>Baik (%)</th>
                                    <th>Cukup (%)</th>
                                    <th>Kurang (%)</th>
                                    <th>Sangat Kurang (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalSB = $totalB = $totalC = $totalK = $totalSK = 0;
                                @endphp
                                @foreach($kriteriaChartData as $index => $item)
                                    @php
                                        $data = $item['data'];
                                        $total = array_sum($data);

                                        $sb = $total ? ($data['Sangat Baik'] / $total * 100) : 0;
                                        $b  = $total ? ($data['Baik'] / $total * 100) : 0;
                                        $c  = $total ? ($data['Cukup'] / $total * 100) : 0;
                                        $k  = $total ? ($data['Kurang'] / $total * 100) : 0;
                                        $sk = $total ? ($data['Sangat Kurang'] / $total * 100) : 0;

                                        $totalSB += $sb;
                                        $totalB  += $b;
                                        $totalC  += $c;
                                        $totalK  += $k;
                                        $totalSK += $sk;
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $item['label'] }}</td>
                                        <td class="text-center">{{ number_format($sb, 2) }}</td>
                                        <td class="text-center">{{ number_format($b, 2) }}</td>
                                        <td class="text-center">{{ number_format($c, 2) }}</td>
                                        <td class="text-center">{{ number_format($k, 2) }}</td>
                                        <td class="text-center">{{ number_format($sk, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="text-center fw-bold">
                                    <td colspan="2">Jumlah Rata-Rata</td>
                                    <td>{{ number_format($totalSB / count($kriteriaChartData), 2) }}</td>
                                    <td>{{ number_format($totalB / count($kriteriaChartData), 2) }}</td>
                                    <td>{{ number_format($totalC / count($kriteriaChartData), 2) }}</td>
                                    <td>{{ number_format($totalK / count($kriteriaChartData), 2) }}</td>
                                    <td>{{ number_format($totalSK / count($kriteriaChartData), 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Grafik Kepuasan Pengguna Lulusan -->
        <div class="col-lg-4 col-md-12 mt-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-0">Grafik Kepuasan Pengguna Lulusan</h6>
                    <select id="kriteriaSelect" class="form-select mb-3">
                        @foreach(array_keys($kriteriaChartData) as $key)
                            <option value="{{ $key }}">{{ $kriteriaChartData[$key]['label'] }}</option>
                        @endforeach
                    </select>
                    <canvas id="kriteriaChart" height="200"></canvas>
                </div>
            </div>
        </div>
        </div>
@endsection

    @section('scripts')
        <script>
            // PROFESI
            var ctxProfesi = document.getElementById("chart-profesi").getContext("2d");
            new Chart(ctxProfesi, {
                type: "pie",
                data: {
                    labels: {!! json_encode($profesiLabels) !!},
                    datasets: [{
                        label: "Jumlah",
                        backgroundColor: [
                            "#43A047", "#FF9800", "#E91E63", "#3F51B5", "#009688",
                            "#9C27B0", "#00BCD4", "#8BC34A", "#FFC107", "#795548", "#607D8B"
                        ],
                        data: {!! json_encode($profesiData) !!}
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: "top" } }
                }
            });

            // INSTANSI
            var ctxInstansi = document.getElementById("chart-instansi").getContext("2d");
            new Chart(ctxInstansi, {
                type: "pie",
                data: {
                    labels: {!! json_encode($instansiLabels) !!},
                    datasets: [{
                        label: "Jumlah",
                        backgroundColor: ["#2196F3", "#FF5722", "#9C27B0", "#4CAF50", "#FFEB3B"],
                        data: {!! json_encode($instansiData) !!}
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: "top" } }
                }
            });
             // Kepuasan per kriteria
            const kriteriaChartData = {!! json_encode($kriteriaChartData) !!};

            const ctxKriteria = document.getElementById('kriteriaChart').getContext('2d');
            let chartInstance;

            function renderChart(id) {
                const data = kriteriaChartData[id].data;
                const labels = Object.keys(data);
                const values = Object.values(data);

                if (chartInstance) chartInstance.destroy();

                chartInstance = new Chart(ctxKriteria, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: kriteriaChartData[id].label,
                            backgroundColor: ["#4CAF50", "#FFC107", "#FF9800", "#F44336", "#9E9E9E"],
                            data: values
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: "top" }
                        }
                    }
                });
            }

            // Initial chart
            const defaultId = Object.keys(kriteriaChartData)[0];
            renderChart(defaultId);

            // Dropdown listener
            document.getElementById('kriteriaSelect').addEventListener('change', function () {
                renderChart(this.value);
            });

        </script>
    @endsection