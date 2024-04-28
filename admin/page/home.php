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

</div>