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
                <h3>150</h3>

                <p>Kategori</p>
            </div>
            <div class="icon">
                <i class="fas fa-cube"></i>
            </div>
            <a href="#" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>

                <p>Projek</p>
            </div>
            <div class="icon">
                <i class="fas fa-folder"></i>
            </div>
            <a href="#" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>44</h3>

                <p>Projek Pending</p>
            </div>
            <div class="icon">
                <i class="fas fa-folder"></i>
            </div>
            <a href="#" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>65</h3>

                <p>Kontak Masuk Baru</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>

<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>150</h3>

                <p>Total Donasi</p>
            </div>
            <div class="icon">
                <i class="fas fa-donate"></i>
            </div>
            <a href="#" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>

                <p>Donasi Belum Dikonfirmasi</p>
            </div>
            <div class="icon">
                <i class="fas fa-donate"></i>
            </div>
            <a href="#" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>44</h3>

                <p>Donasi Dikonfirmasi</p>
            </div>
            <div class="icon">
                <i class="fas fa-donate"></i>
            </div>
            <a href="#" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>65</h3>

                <p>Projek Dicairkan</p>
            </div>
            <div class="icon">
                <i class="fas fa-donate"></i>
            </div>
            <a href="#" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>

<!-- /.row -->
<div class="row">
    <!-- Left col -->
    <section class="col-lg-12 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-line mr-1"></i>
                    Laporan donasi dan pencairan
                </h3>
            </div><!-- /.card-header -->
            <div class="card-body text-center pb-0">
                01 Januari 2022 s/d 31 Januari 2022
            </div>
            <div class="card-body pt-0">
                <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
            </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.Left col -->
    <div class="col-lg-7">


        <!-- TABLE: LATEST ORDERS -->
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
                                <th>Order ID</th>
                                <th>Item</th>
                                <th>Status</th>
                                <th>Popularity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a href="pages/examples/invoice.html">OR9842</a></td>
                                <td>Call of Duty IV</td>
                                <td><span class="badge badge-success">Shipped</span></td>
                                <td>
                                    <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="pages/examples/invoice.html">OR1848</a></td>
                                <td>Samsung Smart TV</td>
                                <td><span class="badge badge-warning">Pending</span></td>
                                <td>
                                    <div class="sparkbar" data-color="#f39c12" data-height="20">90,80,-90,70,61,-83,68
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="pages/examples/invoice.html">OR7429</a></td>
                                <td>iPhone 6 Plus</td>
                                <td><span class="badge badge-danger">Delivered</span></td>
                                <td>
                                    <div class="sparkbar" data-color="#f56954" data-height="20">90,-80,90,70,-61,83,63
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="pages/examples/invoice.html">OR7429</a></td>
                                <td>Samsung Smart TV</td>
                                <td><span class="badge badge-info">Processing</span></td>
                                <td>
                                    <div class="sparkbar" data-color="#00c0ef" data-height="20">90,80,-90,70,-61,83,63
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="pages/examples/invoice.html">OR1848</a></td>
                                <td>Samsung Smart TV</td>
                                <td><span class="badge badge-warning">Pending</span></td>
                                <td>
                                    <div class="sparkbar" data-color="#f39c12" data-height="20">90,80,-90,70,61,-83,68
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="pages/examples/invoice.html">OR7429</a></td>
                                <td>iPhone 6 Plus</td>
                                <td><span class="badge badge-danger">Delivered</span></td>
                                <td>
                                    <div class="sparkbar" data-color="#f56954" data-height="20">90,-80,90,70,-61,83,63
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="pages/examples/invoice.html">OR9842</a></td>
                                <td>Call of Duty IV</td>
                                <td><span class="badge badge-success">Shipped</span></td>
                                <td>
                                    <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <div class="card">
          <div class="card-header border-transparent">
              <h3 class="card-title">Top 10 donatur bulan ini</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
              <div class="table-responsive">
                  <table class="table m-0">
                      <thead>
                          <tr>
                              <th>Order ID</th>
                              <th>Item</th>
                              <th>Status</th>
                              <th>Popularity</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr>
                              <td><a href="pages/examples/invoice.html">OR9842</a></td>
                              <td>Call of Duty IV</td>
                              <td><span class="badge badge-success">Shipped</span></td>
                              <td>
                                  <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td><a href="pages/examples/invoice.html">OR1848</a></td>
                              <td>Samsung Smart TV</td>
                              <td><span class="badge badge-warning">Pending</span></td>
                              <td>
                                  <div class="sparkbar" data-color="#f39c12" data-height="20">90,80,-90,70,61,-83,68
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td><a href="pages/examples/invoice.html">OR7429</a></td>
                              <td>iPhone 6 Plus</td>
                              <td><span class="badge badge-danger">Delivered</span></td>
                              <td>
                                  <div class="sparkbar" data-color="#f56954" data-height="20">90,-80,90,70,-61,83,63
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td><a href="pages/examples/invoice.html">OR7429</a></td>
                              <td>Samsung Smart TV</td>
                              <td><span class="badge badge-info">Processing</span></td>
                              <td>
                                  <div class="sparkbar" data-color="#00c0ef" data-height="20">90,80,-90,70,-61,83,63
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td><a href="pages/examples/invoice.html">OR1848</a></td>
                              <td>Samsung Smart TV</td>
                              <td><span class="badge badge-warning">Pending</span></td>
                              <td>
                                  <div class="sparkbar" data-color="#f39c12" data-height="20">90,80,-90,70,61,-83,68
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td><a href="pages/examples/invoice.html">OR7429</a></td>
                              <td>iPhone 6 Plus</td>
                              <td><span class="badge badge-danger">Delivered</span></td>
                              <td>
                                  <div class="sparkbar" data-color="#f56954" data-height="20">90,-80,90,70,-61,83,63
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td><a href="pages/examples/invoice.html">OR9842</a></td>
                              <td>Call of Duty IV</td>
                              <td><span class="badge badge-success">Shipped</span></td>
                              <td>
                                  <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63
                                  </div>
                              </td>
                          </tr>
                      </tbody>
                  </table>
              </div>
              <!-- /.table-responsive -->
          </div>
          <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- right col (We are only adding the ID to make the widgets sortable)-->
    <section class="col-lg-5 connectedSortable">

        <!-- Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie mr-1"></i>
                    Pengguna
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <canvas id="sales-chart-canvas" height="150" style="height: 150px;"></canvas>
                    </div>
                    <div class="col-md-6">
                        <ul class="chart-legend clearfix">
                            <li><i class="far fa-circle text-danger"></i> Donatur</li>
                            <li><i class="far fa-circle text-success"></i> Subscriber Baru</li>
                            <li><i class="far fa-circle text-warning"></i> User Baru</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card -->

        <div class="card">
            <div class="card-header">
              <h3 class="card-title">Notifikasi terbaru</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <ul class="products-list product-list-in-card pl-2 pr-2">
                <li class="item">
                  <div class="product-img">
                    <img src="/AdminLTE/dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                  </div>
                  <div class="product-info">
                    <a href="javascript:void(0)" class="product-title">Samsung TV
                      <span class="badge badge-warning float-right">$1800</span></a>
                    <span class="product-description">
                      Samsung 32" 1080p 60Hz LED Smart HDTV.
                    </span>
                  </div>
                </li>
                <!-- /.item -->
                <li class="item">
                  <div class="product-img">
                    <img src="/AdminLTE/dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                  </div>
                  <div class="product-info">
                    <a href="javascript:void(0)" class="product-title">Bicycle
                      <span class="badge badge-info float-right">$700</span></a>
                    <span class="product-description">
                      26" Mongoose Dolomite Men's 7-speed, Navy Blue.
                    </span>
                  </div>
                </li>
                <!-- /.item -->
                <li class="item">
                  <div class="product-img">
                    <img src="/AdminLTE/dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                  </div>
                  <div class="product-info">
                    <a href="javascript:void(0)" class="product-title">
                      Xbox One <span class="badge badge-danger float-right">
                      $350
                    </span>
                    </a>
                    <span class="product-description">
                      Xbox One Console Bundle with Halo Master Chief Collection.
                    </span>
                  </div>
                </li>
                <!-- /.item -->
                <li class="item">
                  <div class="product-img">
                    <img src="/AdminLTE/dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                  </div>
                  <div class="product-info">
                    <a href="javascript:void(0)" class="product-title">PlayStation 4
                      <span class="badge badge-success float-right">$399</span></a>
                    <span class="product-description">
                      PlayStation 4 500GB Console (PS4)
                    </span>
                  </div>
                </li>
                <!-- /.item -->
              </ul>
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center">
              <a href="javascript:void(0)" class="uppercase">View All Products</a>
            </div>
            <!-- /.card-footer -->
          </div>
    </section>
    <!-- right col -->
</div>
<!-- /.row (main row) -->
@endsection

@push('scripts_vendor')
<script src="{{ asset('/AdminLTE/plugins/daterangepicker/daterangepicker.js') }}"></script>
@endpush

@push('scripts')
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script>
    var salesChartCanvas = document.getElementById('revenue-chart-canvas').getContext('2d')
    var salesChartData = {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        datasets: [{
                label: 'Donasi',
                backgroundColor: 'rgba(10, 123,255, .9)',
                borderColor: 'rgba(10, 123, 255, .8)',
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(10, 123, 255, 1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(10, 123, 255, 1)',
                data: [28, 48, 40, 19, 86, 27, 90, 40, 19, 86, 27, 90]
            },
            {
                label: 'Pencairan',
                backgroundColor: 'rgba(210, 214, 222, .9)',
                borderColor: 'rgba(210, 214, 222, .8)',
                pointColor: 'rgba(210, 214, 222, 1)',
                pointStrokeColor: '#c1c7d1',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(220,220,220,1)',
                data: [65, 59, 80, 81, 56, 55, 40, 65, 59, 80, 81, 56]
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

    // Donut Chart
    var pieChartCanvas = $('#sales-chart-canvas').get(0).getContext('2d')
    var pieData = {
        labels: [
            'Donatur',
            'Subscriber Baru',
            'User Baru'
        ],
        datasets: [{
            data: [30, 12, 20],
            backgroundColor: ['#f56954', '#00a65a', '#f39c12']
        }]
    }
    var pieOptions = {
        legend: {
            display: false
        },
        maintainAspectRatio: false,
        responsive: true
    }
    // Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    // eslint-disable-next-line no-unused-vars
    var pieChart = new Chart(pieChartCanvas, { // lgtm[js/unused-local-variable]
        type: 'doughnut',
        data: pieData,
        options: pieOptions
    })
</script>
@endpush