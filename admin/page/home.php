<?php
include "data/koneksi.php";
include("data/function.php");
$totalBayar     = getTotalBayar($mysqli, $bulan1, $bulan2);
$totalPreOrderP = getTotalPreOrderPengiriman($mysqli, $bulan1, $bulan2);
$totalPreOrderM = getTotalPreOrderMasuk($mysqli, $bulan1, $bulan2);
$totalTransP    = getTotalTransPengiriman($mysqli, $bulan1, $bulan2);
$totalTransM    = getTotalTransMasuk($mysqli, $bulan1, $bulan2);
$totalTransMin  = getTotalTransMinus($mysqli, $bulan1, $bulan2);
$countTransP    = getCountTransPengiriman($mysqli, $bulan1, $bulan2);
$countPreOrderP = getCountPrePengiriman($mysqli, $bulan1, $bulan2);
$countTransM    = getCountTransMasuk($mysqli, $bulan1, $bulan2);
$countPreOrderM = getCountPreMasuk($mysqli, $bulan1, $bulan2);
$countAllM      = getCountAllMasuk($mysqli, $bulan1, $bulan2);
$countMinus     = getCountMinus($mysqli, $bulan1, $bulan2);

$selisih = $totalPreOrderP - $totalBayar;

// Cek apakah $totalPreOrderP tidak nol sebelum melakukan pembagian
if ($totalPreOrderP != 0) {
    $lunas1 = ($selisih / $totalPreOrderP) * 100;
    $lunas2 = ($totalBayar / $totalPreOrderP) * 100;
} else {
    // Menetapkan nilai default atau menangani kasus pembagi nol
    $lunas1 = 0;  // Bisa juga diset ke nilai lain yang masuk akal dalam konteks aplikasi Anda
    $lunas2 = 0;  // Bisa juga diset ke nilai lain yang masuk akal dalam konteks aplikasi Anda
}

$percentageChange = getPercentageChange($mysqli);
$icon = getPercentageChangeIcon($percentageChange);
?>
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
                    <small class="me-2"><?= getTotalSalesDay($mysqli); ?> Transaksi Hari Ini</small>
                    <div class="d-flex align-items-center text-<?= $icon['color']; ?>">
                        <p class="mb-0"><?= $percentageChange ?>%</p>
                        <?= '<i class="' . $icon['arrowIcon'] . '"></i>'; ?>
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
                        <h5 class="mb-0"><?= getCurrentCustomers($mysqli); ?></h5>
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
                        <h5 class="mb-0"><?= getCurrentStaff($mysqli); ?></h5>
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
                        <h5 class="mb-0"><?= getCurrentPackages($mysqli); ?></h5>
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
                        <h5 class="mb-0"><?= getCurrentProducts($mysqli); ?></h5>
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
                            <div class="badge bg-label-primary rounded-pill lh-xs">
                                <?= number_format($countPreOrderP, 0, ',', '.') ?> Pesanan</div>
                        </div>
                        <div class="d-flex align-items-end flex-wrap gap-1">
                            <h6 class="mb-0 me-2 text-primary">
                                <strong><?= 'Rp.' . number_format($totalPreOrderP, 0, ',', '.') ?></strong>
                            </h6>
                            <small class="">Diterima: <?= number_format($lunas2, 0, ',', '.'); ?>%</small><small class="text-success"><?= '(Rp.' . number_format($totalBayar, 0, ',', '.') . ')' ?></small>
                        </div>
                    </div>
                </div>
                <div class="col-6 text-end d-flex align-items-end justify-content-center">
                    <div class="card-body pb-0 pt-3 position-absolute bottom-0">
                        <img src="<?php echo $base_url; ?>/assets/img/illustrations/card-ratings-illustration.png" alt="Ratings" width="95" />
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
                            <div class="badge bg-label-danger rounded-pill lh-xs">
                                <?= number_format($countMinus, 0, ',', '.') ?> Nota Tempo</div>
                        </div>
                        <div class="d-flex align-items-end flex-wrap gap-1">
                            <h6 class="mb-0 me-2 text-primary">
                                <strong><?= 'Rp.' . number_format($totalPreOrderP, 0, ',', '.') ?></strong>
                            </h6>
                            <small class="">Piutang: <?= number_format($lunas1, 0, ',', '.'); ?>%</small>
                            <small class="text-danger"><?= '(Rp.' . number_format($selisih, 0, ',', '.') . ')' ?></small>
                        </div>
                    </div>
                </div>
                <div class="col-6 text-end d-flex align-items-end justify-content-center">
                    <div class="card-body pb-0 pt-3 position-absolute bottom-0">
                        <img src="<?php echo $base_url; ?>/assets/img/illustrations/card-session-illustration.png" alt="Ratings" width="81" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Sessions -->
</div>

<div class="row gy-4 mb-4">
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
                            <a class="dropdown-item" href="javascript:;" onclick="updateChart('weekly');">Minggu Ini</a>
                            <a class="dropdown-item" href="javascript:;" onclick="updateChart('monthly');">Bulan Ini</a>
                            <a class="dropdown-item" href="javascript:;" onclick="updateChart('yearly');">Tahun Ini</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="weeklyOverviewChart"></div>
                <div class="mt-1">
                    <div class="d-flex align-items-center gap-3">
                        <h3 id="percentage" class="mb-0"></h3>

                        <p id="performance" class="mb-0 text-muted">Your sales performance is ... 😎 compared to the
                            previous period</p>
                    </div>

                    <div class="d-grid mt-3">
                        <button class="btn btn-primary" type="button">Details</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Weekly Overview Chart -->

    <div class="col-lg-3 col-sm-12">
        <!-- Total Visits -->
        <div class="">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between flex-wrap gap-2">
                        <p class="d-block mb-2 text-muted">Penjualan</p>
                        <div class="d-flex text-success">
                            <p class="me-1">0 Transaksi</p>

                        </div>
                    </div>
                    <h5 class="mb-1">Rp.0</h5>
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
                            <h4 class="mb-0 pt-1 text-nowrap">0%</h4>
                            <small class="text-muted text-nowrap">0</small>
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
                            <h4 class="mb-0 pt-1 text-nowrap">0%</h4>
                            <small class="text-muted text-nowrap">0</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mt-2 pt-1">
                        <div class="progress w-100 rounded" style="height: 10px">
                            <div class="progress-bar bg-warning" style="width: 0%" role="progressbar" aria-valuenow="nan" aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuenow="nan" aria-valuemin="0" aria-valuemax="100"></div>
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
                            <h4 class="mb-0 pt-1 text-nowrap">0%</h4>
                            <small class="text-muted text-nowrap">0</small>
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
                            <h4 class="mb-0 pt-1 text-nowrap">0%</h4>
                            <small class="text-muted text-nowrap">0</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mt-2 pt-1">
                        <div class="progress w-100 rounded" style="height: 10px">
                            <div class="progress-bar bg-warning" style="width: 0%" role="progressbar" aria-valuenow="nan" aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuenow="nan" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between flex-wrap gap-2">
                        <p class="d-block mb-2 text-muted">Estimasi Uang Masuk</p>
                    </div>
                    <h5 class="mb-1">Rp.27.448.000</h5>
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
                                <h4 class="mb-0 pt-1 text-nowrap">0%</h4>
                                <small class="text-muted text-nowrap">0</small>
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
                                <h4 class="mb-0 pt-1 text-nowrap">0%</h4>
                                <small class="text-muted text-nowrap">27.448.000</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mt-2 pt-1">
                            <div class="progress w-100 rounded" style="height: 10px">
                                <div class="progress-bar bg-warning" style="width: 0%" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- Doughnut Chart -->
<div class="col-lg-3 col-12">
    <div class="card h-100">
        <h5 class="card-header">Estimasi Uang Masuk</h5>
        <div class="card-body">
            <canvas id="doughnutChart" class="chartjs mb-4" data-height="350"></canvas>
            <ul class="doughnut-legend d-flex justify-content-around ps-0 mb-2 pt-1">
                <li class="ct-series-0 d-flex flex-column">
                    <h5 class="mb-0 fw-bold">Pemasukan</h5>
                    <span id="incomeColor" class="badge badge-dot my-2 cursor-pointer rounded-pill" style="width: 35px; height: 6px"></span>
                    <div id="incomePercentage" class="text-muted">80 %</div>
                </li>
                <li class="ct-series-1 d-flex flex-column">
                    <h5 class="mb-0 fw-bold">Penagihan</h5>
                    <span id="billingColor" class="badge badge-dot my-2 cursor-pointer rounded-pill" style="width: 35px; height: 6px"></span>
                    <div id="billingPercentage" class="text-muted">10 %</div>
                </li>

            </ul>
            <button id="detailButton" class="btn btn-secondary w-100" type="button">detail</button>

        </div>
        <div class="card-footer">
            <small>* Informasi ini mencakup penjualan tunai, DP order, dan penagihan.</small>
        </div>
    </div>
</div>
<!-- /Doughnut Chart -->


<script>
    updateChart('monthly');
    updatePerformance('monthly');
    loadHome();

    var doughnutChartVar = null;

    fetch(baseUrl + 'admin/data/home-chart.php')
        .then(response => response.json())
        .then(data => {
            const doughnutChart = document.getElementById('doughnutChart');
            if (doughnutChart) {
                const incomePercentageElement = document.getElementById('incomePercentage');
                const billingPercentageElement = document.getElementById('billingPercentage');
                const incomeColorElement = document.getElementById('incomeColor');
                const billingColorElement = document.getElementById('billingColor');
                const detailButton = document.getElementById('detailButton');

                const totalIncome = parseInt(data.totalIncome, 10);
                const totalBilling = parseInt(data.totalBilling, 10);
                const totalAmount = totalIncome + totalBilling;

                //const incomePercentage = ((totalIncome / totalAmount) * 100).toFixed(2);
                //const billingPercentage = ((totalBilling / totalAmount) * 100).toFixed(2);

                // Update text and background color
                incomePercentageElement.innerText = `Rp. ${totalIncome.toLocaleString()}`;
                billingPercentageElement.innerText = `Rp. ${totalBilling.toLocaleString()}`;
                detailButton.innerText = `Rp. ${totalAmount.toLocaleString()}`;
                incomeColorElement.style.backgroundColor = colors[0];
                billingColorElement.style.backgroundColor = colors[1];
                let chartStatus = Chart.getChart("doughnutChart"); // <canvas> id
                if (chartStatus != undefined) {
                    chartStatus.destroy();
                }
                doughnutChartVar = new Chart(doughnutChart, {
                    type: 'doughnut',
                    data: {
                        labels: ['Pemasukan', 'Penagihan'],
                        datasets: [{
                            data: [totalIncome, totalBilling],
                            backgroundColor: colors,
                            borderWidth: 0,
                            pointStyle: 'rectRounded'
                        }]
                    },
                    options: {
                        responsive: true,
                        animation: {
                            duration: 500
                        },
                        cutout: '68%',
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        const label = tooltipItem.chart.data.labels[tooltipItem
                                            .dataIndex];
                                        const value = tooltipItem.raw;
                                        const percentage = ((value / totalAmount) * 100).toFixed(2);
                                        return `${label}: ${value} (${percentage} %)`;
                                    }
                                },
                                rtl: isRtl,
                                backgroundColor: cardColor,
                                titleColor: headingColor,
                                bodyColor: legendColor,
                                borderWidth: 1,
                                borderColor: borderColor
                            }
                        }
                    }
                });

                // Handle button click to show total amount
                detailButton.addEventListener('click', function() {
                    alert(`Total Estimasi Uang Masuk: Rp ${totalAmount.toLocaleString()}`);
                });
            }
        })
        .catch(error => console.error('Error loading the chart data:', error));
</script>