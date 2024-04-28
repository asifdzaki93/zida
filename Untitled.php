<?php
include("function.php");
include("header.php");
?>
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row gy-4 mb-4">
            <!-- Sales Overview-->
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h4 class="mb-2">Gambaran Umum</h4>
                            <div class="dropdown">
                                <!-- <button class="btn p-0" type="button" id="salesOverview" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical mdi-24px"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="salesOverview">
                                    <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Share</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Update</a>
                                </div> -->
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <small class="me-2"><?= getTotalSalesDay($connect); ?> Transaksi Hari Ini</small>
                            <div class="d-flex align-items-center text-<?= $color; ?>">
                                <p class="mb-0"><?= getPercentageChange($connect); ?>%</p>
                                <?= '<i class="' . $arrowIcon . '"></i>'; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body d-flex justify-content-between flex-wrap gap-3">
                        <div class="d-flex gap-2">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-primary rounded">
                                    <i class="mdi mdi-account-outline mdi-24px"></i>
                                </div>
                            </div>
                            <div class="card-info">
                                <h5 class="mb-0"><?= getCurrentCustomers($connect); ?></h5>
                                <small class="text-muted">Pelangan</small>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-info rounded">
                                    <i class="mdi mdi-briefcase-account mdi-24px"></i>
                                </div>
                            </div>
                            <div class="card-info">
                                <h5 class="mb-0"><?= getCurrentStaff($connect); ?></h5>
                                <small class="text-muted">Petugas</small>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-warning rounded">
                                    <i class="mdi mdi-package-variant-closed-check mdi-24px"></i>
                                </div>
                            </div>
                            <div class="card-info">
                                <h5 class="mb-0"><?= getCurrentPackages($connect); ?></h5>
                                <small class="text-muted">Paket</small>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-info rounded">
                                    <i class="mdi mdi-baguette mdi-24px"></i>
                                </div>
                            </div>
                            <div class="card-info">
                                <h5 class="mb-0"><?= getCurrentProducts($connect); ?></h5>
                                <small class="text-muted">Produk</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Sales Overview-->

            <!-- Ratings -->
            <div class="col-lg-3 col-sm-6">
                <div class="card h-100">
                    <div class="row">
                        <div class="col-6">
                            <div class="card-body">
                                <div class="card-info mb-3 py-2 mb-lg-1 mb-xl-3">
                                    <h5 class="mb-3 mb-lg-2 mb-xl-3 text-nowrap">Pengiriman Hari Ini</h5>
                                    <div class="badge bg-label-primary rounded-pill lh-xs"><?= number_format($countPreOrderP, 0, ',', '.') ?> Pesanan</div>
                                </div>
                                <div class="d-flex align-items-end flex-wrap gap-1">
                                    <h6 class="mb-0 me-2 text-primary"><strong><?= 'Rp.' . number_format($totalPreOrderP, 0, ',', '.') ?></strong></h6>
                                    <small class="">Diterima: <?= number_format($lunas2, 0, ',', '.'); ?>%</small><small class="text-success"><?= '(Rp.' . number_format($totalBayar, 0, ',', '.') . ')' ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 text-end d-flex align-items-end justify-content-center">
                            <div class="card-body pb-0 pt-3 position-absolute bottom-0">
                                <img src="assets/img/illustrations/card-ratings-illustration.png" alt="Ratings" width="95" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Ratings -->

            <!-- Sessions -->


            <div class="col-lg-3 col-sm-6">
                <div class="card h-100">
                    <div class="row">
                        <div class="col-6">
                            <div class="card-body">
                                <div class="card-info mb-3 py-2 mb-lg-1 mb-xl-3">
                                    <h5 class="mb-3 mb-lg-2 mb-xl-3 text-nowrap">Penagihan Hari Ini</h5>
                                    <div class="badge bg-label-danger rounded-pill lh-xs"><?= number_format($countMinus, 0, ',', '.') ?> Nota Tempo</div>
                                </div>
                                <div class="d-flex align-items-end flex-wrap gap-1">
                                    <h6 class="mb-0 me-2 text-primary"><strong><?= 'Rp.' . number_format($totalPreOrderP, 0, ',', '.') ?></strong></h6>
                                    <small class="">Piutang: <?= number_format($lunas1, 0, ',', '.'); ?>%</small>
                                    <small class="text-danger"><?= '(Rp.' . number_format($selisih, 0, ',', '.') . ')' ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 text-end d-flex align-items-end justify-content-center">
                            <div class="card-body pb-0 pt-3 position-absolute bottom-0">
                                <img src="assets/img/illustrations/card-session-illustration.png" alt="Ratings" width="81" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Sessions -->
        </div>


        <div class="row gy-4">
            <!-- Weekly Overview Chart -->
            <div class="col-lg-9 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-1">Grafik Transaksi</h5>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="weeklyOverviewDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical mdi-24px"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="weeklyOverviewDropdown">
                                    <a class="dropdown-item" href="#" onclick="updateChart('weekly');">Minggu Ini</a>
                                    <a class="dropdown-item" href="#" onclick="updateChart('monthly');">Bulan Ini</a>
                                    <a class="dropdown-item" href="#" onclick="updateChart('yearly');">Tahun Ini</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="weeklyOverviewChart"></div>
                        <div class="mt-1">
                            <div class="d-flex align-items-center gap-3">
                                <h3 id="percentage" class="mb-0"></h3>

                                <p id="performance" class="mb-0 text-muted">Your sales performance is ... 😎 compared to the previous period</p>
                            </div>

                            <div class="d-grid mt-3">
                                <button class="btn btn-primary" type="button">Details</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Weekly Overview Chart -->

            <script>
                let currentChart = null; // Global reference to the chart instance

                function updateChart(timeframe) {
                    fetch('chart-data2.php?timeframe=' + timeframe) // Dynamic URL based on selected timeframe
                        .then(response => response.json())
                        .then(data => {
                            const chartOptions = {
                                chart: {
                                    type: 'line',
                                    height: 350,
                                    toolbar: {
                                        show: false
                                    }
                                },
                                series: [{
                                        name: 'Pemasukan',
                                        type: 'line',
                                        data: data.pemasukan,
                                        color: '#556ee6' // Blue for Pemasukan
                                    },
                                    {
                                        name: 'Pengeluaran',
                                        type: 'bar',
                                        data: data.pengeluaran,
                                        color: '#34C38F' // Green for Pengeluaran
                                    },
                                    {
                                        name: 'Belanja Produk',
                                        type: 'bar',
                                        data: data.belanjaProduk,
                                        color: '#f46a6a' // Red for Belanja Produk
                                    }
                                ],
                                plotOptions: {
                                    bar: {
                                        borderRadius: 5,
                                        columnWidth: '40%'
                                    }
                                },
                                markers: {
                                    size: 5,
                                    strokeWidth: 2,
                                    fillOpacity: 1,
                                    strokeOpacity: 1,
                                    strokeColors: '#fff'
                                },
                                stroke: {
                                    width: [2, 0, 0], // Width 2 for line, 0 for bars
                                    curve: 'smooth'
                                },
                                dataLabels: {
                                    enabled: false
                                },
                                legend: {
                                    show: true,
                                    position: 'top',
                                    horizontalAlign: 'center'
                                },
                                grid: {
                                    strokeDashArray: 5
                                },
                                xaxis: {
                                    categories: data.labels,
                                    tickPlacement: 'on'
                                },
                                yaxis: {
                                    labels: {
                                        formatter: function(val) {
                                            if (val >= 1000000) {
                                                return Math.floor(val / 1000000) + ' Jt';
                                            } else if (val >= 1000) {
                                                return Math.floor(val / 1000) + 'K';
                                            }
                                            return val;
                                        },
                                        style: {
                                            fontSize: '12px'
                                        }
                                    }
                                },
                                responsive: [{
                                    breakpoint: 1000,
                                    options: {
                                        plotOptions: {
                                            bar: {
                                                horizontal: false
                                            }
                                        },
                                        legend: {
                                            position: "bottom"
                                        }
                                    }
                                }]
                            };

                            // Destroy previous chart instance if exists
                            if (currentChart) {
                                currentChart.destroy();
                            }

                            // Create new chart instance
                            const chartElement = document.querySelector('#weeklyOverviewChart');
                            currentChart = new ApexCharts(chartElement, chartOptions);
                            currentChart.render();
                        })
                        .catch(error => console.error('Error loading the chart data:', error));
                }

                // Initialize chart with monthly data
                updateChart('monthly');

                function updatePerformance(timeframe) {
                    fetch(`chart-data2.php?timeframe=${timeframe}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Retrieve the sales data for the current timeframe
                            const salesData = data.pemasukan;

                            // Calculate the sales performance change compared to the previous period
                            const currentPeriodSales = salesData[salesData.length - 1]; // Sales for the current period
                            const previousPeriodSales = salesData[salesData.length - 2]; // Sales for the previous period
                            const performanceChange = currentPeriodSales - previousPeriodSales;
                            const performancePercentage = ((performanceChange / previousPeriodSales) * 100).toFixed(2);

                            function formatRupiah(angka) {
                                var reverse = angka.toString().split('').reverse().join('');
                                var ribuan = reverse.match(/\d{1,3}/g);
                                ribuan = ribuan.join('.').split('').reverse().join('');
                                return ribuan;
                            }


                            // Determine whether sales performance increased or decreased
                            let performanceText;
                            if (performanceChange > 0) {
                                performanceText = `Kinerja Penjualan Hari ini Meningkat Rp. ${formatRupiah(performanceChange)} dibanding kemarin. 😎`;
                            } else if (performanceChange < 0) {
                                performanceText = `Kinerja Penjualan Hari ini Menurun Rp. ${formatRupiah(Math.abs(performanceChange))} dibanding kemarin. 😕`;
                            } else {
                                performanceText = `Kinerja Penjualan Hari ini masih sama dibanding kemarin. 😐`;
                            }

                            // Update the performance element with the calculated text
                            const performanceElement = document.querySelector('#performance');
                            if (performanceElement) {
                                performanceElement.textContent = performanceText;
                            }

                            // Mendapatkan elemen dengan ID tertentu
                            const h3Element = document.getElementById('percentage');

                            // Misalkan kita punya variabel yang menyimpan persentase yang ingin ditampilkan

                            // Mengubah teks di dalam elemen
                            h3Element.textContent = performancePercentage + '%';

                        })
                        .catch(error => {
                            console.error('Error loading performance data:', error);
                        });
                }


                // Call the function to update performance initially
                updatePerformance('monthly'); // You can change the timeframe as needed
            </script>

            <div class="col-lg-3 col-sm-12">
                <!-- Total Visits -->
                <div class="">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between flex-wrap gap-2">
                                <p class="d-block mb-2 text-muted">Penjualan</p>
                                <div class="d-flex text-success">
                                    <p class="me-1"><?= number_format($countAllM, 0, ',', '.') ?> Transaksi</p>

                                </div>
                            </div>
                            <h5 class="mb-1"><?= 'Rp.' . number_format($totalTransM, 0, ',', '.') ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="row mt-3">
                                <div class="col-4">
                                    <div class="d-flex gap-2 align-items-center mb-2">
                                        <div class="avatar avatar-xs flex-shrink-0">
                                            <div class="avatar-initial rounded bg-label-warning">
                                                <i class="mdi mdi-package-variant-closed-check mdi-14px"></i>
                                            </div>
                                        </div>
                                        <small class="mb-0 text-muted">PreOrder</small>
                                    </div>
                                    <h4 class="mb-0 pt-1 text-nowrap"><?= number_format(($totalPreOrderM / $totalTransM) * 100, 0, ',', '.') ?>%</h4>
                                    <small class="text-muted text-nowrap"><?= number_format($totalPreOrderM, 0, ',', '.') ?></small>
                                </div>
                                <div class="col-4">
                                    <div class="divider divider-vertical">
                                        <div class="divider-text">
                                            <span class="badge-divider-bg bg-label-secondary">VS</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 text-end pe-lg-0 pe-xl-2">
                                    <div class="d-flex gap-2 justify-content-end align-items-center mb-2">
                                        <small class="mb-0 text-muted">Stock</small>
                                        <div class="avatar avatar-xs flex-shrink-0">
                                            <div class="avatar-initial rounded bg-label-primary">
                                                <i class="mdi mdi-baguette mdi-14px"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h4 class="mb-0 pt-1 text-nowrap"><?= number_format((($totalTransM - $totalPreOrderM) / $totalTransM) * 100, 0, ',', '.') ?>%</h4>
                                    <small class="text-muted text-nowrap"><?= number_format(($totalTransM - $totalPreOrderM), 0, ',', '.') ?></small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mt-2 pt-1">
                                <div class="progress w-100 rounded" style="height: 10px">
                                    <div class="progress-bar bg-warning" style="width: <?= number_format(($totalPreOrderM / $totalTransM) * 100, 0, ',', '.') ?>%" role="progressbar" aria-valuenow="<?= number_format(($totalPreOrderM / $totalTransM) * 100, 0, ',', '.') ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: <?= number_format((($totalTransM - $totalPreOrderM) / $totalTransM) * 100, 0, ',', '.') ?>%" aria-valuenow="<?= number_format((($totalTransM - $totalPreOrderM) / $totalTransM) * 100, 0, ',', '.') ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-4">
                                    <div class="d-flex gap-2 align-items-center mb-2">
                                        <div class="avatar avatar-xs flex-shrink-0">
                                            <div class="avatar-initial rounded bg-label-success">
                                                <i class="mdi mdi-cash mdi-14px"></i>
                                            </div>
                                        </div>
                                        <small class="mb-0 text-muted">Diterima</small>
                                    </div>
                                    <h4 class="mb-0 pt-1 text-nowrap"><?= number_format((($totalTransM - $totalTransMin) / $totalTransM) * 100, 0, ',', '.') ?>%</h4>
                                    <small class="text-muted text-nowrap"><?= number_format(($totalTransM - $totalTransMin), 0, ',', '.') ?></small>
                                </div>
                                <div class="col-4">
                                    <div class="divider divider-vertical">
                                        <div class="divider-text">
                                            <span class="badge-divider-bg bg-label-secondary">VS</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 text-end pe-lg-0 pe-xl-2">
                                    <div class="d-flex gap-2 justify-content-end align-items-center mb-2">
                                        <small class="mb-0 text-muted">Piutang</small>
                                        <div class="avatar avatar-xs flex-shrink-0">
                                            <div class="avatar-initial rounded bg-label-primary">
                                                <i class="mdi mdi-currency-usd-off mdi-14px"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h4 class="mb-0 pt-1 text-nowrap"><?= number_format(($totalTransMin / $totalTransM) * 100, 0, ',', '.') ?>%</h4>
                                    <small class="text-muted text-nowrap"><?= number_format($totalTransMin, 0, ',', '.') ?></small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mt-2 pt-1">
                                <div class="progress w-100 rounded" style="height: 10px">
                                    <div class="progress-bar bg-warning" style="width: <?= number_format((($totalTransM - $totalTransMin) / $totalTransM) * 100, 0, ',', '.') ?>%" role="progressbar" aria-valuenow="<?= number_format((($totalTransM - $totalTransMin) / $totalTransM) * 100, 0, ',', '.') ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: <?= number_format(($totalTransMin / $totalTransM) * 100, 0, ',', '.') ?>%" aria-valuenow="<?= number_format(($totalTransMin / $totalTransM) * 100, 0, ',', '.') ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between flex-wrap gap-2">
                                <p class="d-block mb-2 text-muted">Estimasi Uang Masuk</p>
                            </div>
                            <h5 class="mb-1"><?= 'Rp.' . number_format((($totalTransM - $totalTransMin) + $selisih), 0, ',', '.') ?></h5>
                            <div>
                                <div class="row mt-3">
                                    <div class="col-4">
                                        <div class="d-flex gap-2 align-items-center mb-2">
                                            <div class="avatar avatar-xs flex-shrink-0">
                                                <div class="avatar-initial rounded bg-label-success">
                                                    <i class="mdi mdi-cash mdi-14px"></i>
                                                </div>
                                            </div>
                                            <small class="mb-0 text-muted">Penerimaan</small>
                                        </div>
                                        <h4 class="mb-0 pt-1 text-nowrap"><?= number_format(($totalTransM - $totalTransMin) / (($totalTransM - $totalTransMin) + $selisih) * 100, 0, ',', '.') ?>%</h4>
                                        <small class="text-muted text-nowrap"><?= number_format(($totalTransM - $totalTransMin), 0, ',', '.') ?></small>
                                    </div>
                                    <div class="col-4">
                                        <div class="divider divider-vertical">
                                            <div class="divider-text">
                                                <span class="badge-divider-bg bg-label-secondary">VS</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 text-end pe-lg-0 pe-xl-2">
                                        <div class="d-flex gap-2 justify-content-end align-items-center mb-2">
                                            <small class="mb-0 text-muted">Penagihan</small>
                                            <div class="avatar avatar-xs flex-shrink-0">
                                                <div class="avatar-initial rounded bg-label-primary">
                                                    <i class="mdi mdi-currency-usd-off mdi-14px"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="mb-0 pt-1 text-nowrap"><?= number_format(($selisih / (($totalTransM - $totalTransMin) + $selisih)) * 100, 0, ',', '.') ?>%</h4>
                                        <small class="text-muted text-nowrap"><?= number_format($selisih, 0, ',', '.') ?></small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mt-2 pt-1">
                                    <div class="progress w-100 rounded" style="height: 10px">
                                        <div class="progress-bar bg-warning" style="width: <?= number_format(($totalTransM - $totalTransMin) / (($totalTransM - $totalTransMin) + $selisih) * 100, 0, ',', '.') ?>%" role="progressbar" aria-valuenow="<?= number_format(($totalTransM - $totalTransMin) / (($totalTransM - $totalTransMin) + $selisih) * 100, 0, ',', '.') ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: <?= number_format(($selisih / (($totalTransM - $totalTransMin) + $selisih)) * 100, 0, ',', '.') ?>%" aria-valuenow="<?= number_format(($selisih / (($totalTransM - $totalTransMin) + $selisih)) * 100, 0, ',', '.') ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Total Visits -->



            </div>
        </div>

        <!-- / Content -->

    </div>
    <!-- Pastikan Anda memuat library ApexCharts sebelum skrip ini -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        // Ensure that the document is fully loaded before initializing the chart
        document.addEventListener("DOMContentLoaded", function() {
            const sessionsChartEl = document.querySelector('#sessions');
            if (sessionsChartEl) {
                const sessionsChartConfig = {
                    chart: {
                        height: 102,
                        type: 'line',
                        parentHeightOffset: 0,
                        toolbar: {
                            show: false
                        }
                    },
                    grid: {
                        borderColor: '#D1D5DB', // Sesuaikan dengan warna yang ada di CSS Anda
                        strokeDashArray: 6,
                        xaxis: {
                            lines: {
                                show: true
                            }
                        },
                        yaxis: {
                            lines: {
                                show: false
                            }
                        },
                        padding: {
                            top: -15,
                            left: -7,
                            right: 7,
                            bottom: -15
                        }
                    },
                    colors: ['#00B4D8'], // Warna garis, sesuaikan dengan kebutuhan Anda
                    stroke: {
                        width: 3
                    },
                    series: [{
                        data: [0, 20, 5, 30, 15, 45, 25] // 7 data points
                    }],
                    markers: {
                        size: 6,
                        colors: ['transparent'],
                        strokeColors: 'transparent',
                        strokeWidth: 3,
                        hover: {
                            size: 7
                        },
                        discrete: [{
                            seriesIndex: 0,
                            dataPointIndex: 6,
                            fillColor: '#ffffff', // Sesuaikan dengan warna yang ada di CSS Anda
                            strokeColor: '#00B4D8', // Harus sama dengan warna garis
                            size: 6,
                            shape: 'circle'
                        }]
                    },
                    xaxis: {
                        labels: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        },
                        axisBorder: {
                            show: false
                        }
                    },
                    yaxis: {
                        labels: {
                            show: false
                        }
                    },
                    tooltip: {
                        enabled: false
                    },
                    responsive: [{
                            breakpoint: 1441,
                            options: {
                                chart: {
                                    height: 70
                                }
                            }
                        },
                        {
                            breakpoint: 1310,
                            options: {
                                chart: {
                                    height: 90
                                }
                            }
                        },
                        {
                            breakpoint: 1189,
                            options: {
                                chart: {
                                    height: 70
                                }
                            }
                        },
                        {
                            breakpoint: 1025,
                            options: {
                                chart: {
                                    height: 73
                                }
                            }
                        },
                        {
                            breakpoint: 992,
                            options: {
                                chart: {
                                    height: 102
                                }
                            }
                        }
                    ]
                };

                const sessionsChart = new ApexCharts(sessionsChartEl, sessionsChartConfig);
                sessionsChart.render();
            }
        });
    </script>



    <?php include("footer.php"); ?>