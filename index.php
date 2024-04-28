<?php
include("function.php");
include("header.php");
$_SESSION['title'] = 'Dashboard';
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
                  <h4 class="mb-0 pt-1 text-nowrap"><?= ($totalPreOrderM == 0) ? 0 : number_format(($totalPreOrderM / $totalTransM) * 100, 0, ',', '.') ?>%</h4>
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
                  <h4 class="mb-0 pt-1 text-nowrap"><?= ($totalPreOrderM == 0) ? 0 : number_format((($totalTransM - $totalPreOrderM) / $totalTransM) * 100, 0, ',', '.') ?>%</h4>
                  <small class="text-muted text-nowrap"><?= number_format(($totalTransM - $totalPreOrderM), 0, ',', '.') ?></small>
                </div>
              </div>
              <div class="d-flex align-items-center mt-2 pt-1">
                <div class="progress w-100 rounded" style="height: 10px">
                  <div class="progress-bar bg-warning" style="width: <?= ($totalPreOrderM == 0) ? 0 :  number_format(($totalPreOrderM / $totalTransM) * 100, 0, ',', '.') ?>%" role="progressbar" aria-valuenow="<?= number_format(($totalPreOrderM / $totalTransM) * 100, 0, ',', '.') ?>" aria-valuemin="0" aria-valuemax="100"></div>
                  <div class="progress-bar bg-primary" role="progressbar" style="width: <?= ($totalPreOrderM == 0) ? 0 : number_format((($totalTransM - $totalPreOrderM) / $totalTransM) * 100, 0, ',', '.') ?>%" aria-valuenow="<?= number_format((($totalTransM - $totalPreOrderM) / $totalTransM) * 100, 0, ',', '.') ?>" aria-valuemin="0" aria-valuemax="100"></div>
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
                  <h4 class="mb-0 pt-1 text-nowrap"><?= ($totalPreOrderM == 0) ? 0 : number_format((($totalTransM - $totalTransMin) / $totalTransM) * 100, 0, ',', '.') ?>%</h4>
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
                  <h4 class="mb-0 pt-1 text-nowrap"><?= ($totalPreOrderM == 0) ? 0 : number_format(($totalTransMin / $totalTransM) * 100, 0, ',', '.') ?>%</h4>
                  <small class="text-muted text-nowrap"><?= number_format($totalTransMin, 0, ',', '.') ?></small>
                </div>
              </div>
              <div class="d-flex align-items-center mt-2 pt-1">
                <div class="progress w-100 rounded" style="height: 10px">
                  <div class="progress-bar bg-warning" style="width: <?= ($totalPreOrderM == 0) ? 0 : number_format((($totalTransM - $totalTransMin) / $totalTransM) * 100, 0, ',', '.') ?>%" role="progressbar" aria-valuenow="<?= number_format((($totalTransM - $totalTransMin) / $totalTransM) * 100, 0, ',', '.') ?>" aria-valuemin="0" aria-valuemax="100"></div>
                  <div class="progress-bar bg-primary" role="progressbar" style="width: <?= ($totalPreOrderM == 0) ? 0 : number_format(($totalTransMin / $totalTransM) * 100, 0, ',', '.') ?>%" aria-valuenow="<?= number_format(($totalTransMin / $totalTransM) * 100, 0, ',', '.') ?>" aria-valuemin="0" aria-valuemax="100"></div>
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
                    <h4 class="mb-0 pt-1 text-nowrap"><?= ($totalPreOrderM == 0) ? 0 : number_format(($totalTransM - $totalTransMin) / (($totalTransM - $totalTransMin) + $selisih) * 100, 0, ',', '.') ?>%</h4>
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
                    <h4 class="mb-0 pt-1 text-nowrap"><?= ($totalPreOrderM == 0) ? 0 : number_format(($selisih / (($totalTransM - $totalTransMin) + $selisih)) * 100, 0, ',', '.') ?>%</h4>
                    <small class="text-muted text-nowrap"><?= number_format($selisih, 0, ',', '.') ?></small>
                  </div>
                </div>
                <div class="d-flex align-items-center mt-2 pt-1">
                  <div class="progress w-100 rounded" style="height: 10px">
                    <div class="progress-bar bg-warning" style="width: <?= ($totalPreOrderM == 0) ? 0 : number_format(($totalTransM - $totalTransMin) / (($totalTransM - $totalTransMin) + $selisih) * 100, 0, ',', '.') ?>%" role="progressbar" aria-valuenow="<?= number_format(($totalTransM - $totalTransMin) / (($totalTransM - $totalTransMin) + $selisih) * 100, 0, ',', '.') ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    <div class="progress-bar bg-primary" role="progressbar" style="width: <?= n($totalPreOrderM == 0) ? 0 : umber_format(($selisih / (($totalTransM - $totalTransMin) + $selisih)) * 100, 0, ',', '.') ?>%" aria-valuenow="<?= number_format(($selisih / (($totalTransM - $totalTransMin) + $selisih)) * 100, 0, ',', '.') ?>" aria-valuemin="0" aria-valuemax="100"></div>
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

  <?php include("footer.php"); ?>