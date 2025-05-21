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
</script>
@endsection
