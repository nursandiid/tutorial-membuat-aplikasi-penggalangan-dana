@extends('layouts.app')

@section('title', 'Dashboard')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('/AdminLTE/plugins/daterangepicker/daterangepicker.css') }}">
@endpush

@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ format_uang($jumlahProjek) }}</h3>

                <p>Projek</p>
            </div>
            <div class="icon">
                <i class="fas fa-folder"></i>
            </div>
            <a href="{{ route('campaign.index') }}" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ format_uang($jumlahProjekPending) }}</h3>

                <p>Projek Pending</p>
            </div>
            <div class="icon">
                <i class="fas fa-folder"></i>
            </div>
            <a href="{{ route('campaign.index', ['status' => 'pending']) }}" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>Rp. {{ format_uang($totalDonasi) }}</h3>

                <p>Total Donasi</p>
            </div>
            <div class="icon">
                <i class="fas fa-donate"></i>
            </div>
            <a href="{{ route('donation.index', ['status' => 'confirmed']) }}" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>Rp. {{ format_uang($totalProjekDicairkan) }}</h3>

                <p>Total Dicairkan</p>
            </div>
            <div class="icon">
                <i class="fas fa-hand-holding-usd"></i>
            </div>
            <a href="{{ route('cashout.index', ['status' => 'success']) }}" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
<!-- /.row -->

<!-- /.row -->
<div class="row">
    <!-- Left col -->
    <section class="col-lg-8 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-line mr-1"></i>
                    Laporan donasi dan pencairan {{ date('Y') }}
                </h3>
            </div><!-- /.card-header -->
            <div class="card-body text-center pb-0">
                {{ tanggal_indonesia(date('Y-01-01')) }} s/d {{ tanggal_indonesia(date('Y-12-31')) }}
            </div>
            <div class="card-body pt-0">
                <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
            </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.Left col -->
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">10 projek populer bulan ini</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th>Judul</th>
                                <th>Status</th>
                                <th>Jumlah Donasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($projekPopuler as $key => $item)
                            <tr>
                                <td><a href="{{ route('campaign.show', $item->id) }}">{{ $key+1 }}</a></td>
                                <td>{{ $item->title }}</td>
                                <td><span class="badge badge-{{ $item->statusColor() }}">{{ $item->status }}</span></td>
                                <td>{{ $item->donations_count }}x</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4">Tidak tersedia</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
<!-- /.row (main row) -->
@endsection

@push('scripts_vendor')
<script src="{{ asset('/AdminLTE/plugins/daterangepicker/daterangepicker.js') }}"></script>
@endpush

@push('scripts')
<script>
    var salesChartCanvas = document.getElementById('revenue-chart-canvas').getContext('2d')
    var salesChartData = {
        labels: @json($listBulan),
        datasets: [{
                label: 'Donasi',
                backgroundColor: 'rgba(10, 123,255, .9)',
                borderColor: 'rgba(10, 123, 255, .8)',
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(10, 123, 255, 1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(10, 123, 255, 1)',
                data: @json($listDonasi)
            },
            {
                label: 'Pencairan',
                backgroundColor: 'rgba(210, 214, 222, .9)',
                borderColor: 'rgba(210, 214, 222, .8)',
                pointColor: 'rgba(210, 214, 222, 1)',
                pointStrokeColor: '#c1c7d1',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(220,220,220,1)',
                data: @json($listPencairan)
            }
        ]
    }
    var salesChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
    }

    // This will get the first returned node in the jQuery collection.
    // eslint-disable-next-line no-unused-vars
    var salesChart = new Chart(salesChartCanvas, { // lgtm[js/unused-local-variable]
        type: 'line',
        data: salesChartData,
        options: salesChartOptions
    })
</script>
@endpush