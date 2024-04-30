<div class="row gy-4 mb-4">
    <!-- Gamification Card -->
    <div class="col-md-12 col-lg-8">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-md-6 order-2 order-md-1">
                    <div class="card-body">
                        <h4 class="card-title pb-xl-2">Selamat Pagi<strong> Admin !</strong>🎉</h4>
                        <p class="mb-0">Kamu memiliki <span class="fw-semibold">68 Pesanan </span>😎 kirim hari ini.</p>
                        <p>Cek Selengkapnya, klik tombol dibawah ini.</p>
                        <a href="javascript:;" class="btn btn-primary">Selengkapnya</a>
                    </div>
                </div>
                <div class="col-md-6 text-center text-md-end order-1 order-md-2">
                    <div class="card-body pb-0 px-0 px-md-4 ps-0">
                        <img src="<?php echo $base_url; ?>/assets/img/illustrations/illustration-john-light.png" height="180" alt="View Profile" data-app-light-img="illustrations/illustration-john-light.png" data-app-dark-img="illustrations/illustration-john-dark.png" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Gamification Card -->

    <!-- Statistics Total Order -->
    <div class="col-lg-2 col-sm-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                    <div class="avatar">
                        <div class="avatar-initial bg-label-primary rounded">
                            <i class="mdi mdi-cart-plus mdi-24px"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <p class="mb-0 text-success me-1">+22%</p>
                        <i class="mdi mdi-chevron-up text-success"></i>
                    </div>
                </div>
                <div class="card-info mt-4 pt-1 mt-lg-1 mt-xl-4">
                    <h5 class="mb-2">155k</h5>
                    <p class="text-muted mb-lg-2 mb-xl-3">Total Orders</p>
                    <div class="badge bg-label-secondary rounded-pill">Last 4 Month</div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Statistics Total Order -->

    <!-- Sessions line chart -->
    <div class="col-lg-2 col-sm-6">
        <div class="card h-100">
            <div class="card-header pb-0">
                <div class="d-flex align-items-end mb-1 flex-wrap gap-2">
                    <h4 class="mb-0 me-2">$38.5k</h4>
                    <p class="mb-0 text-success">+62%</p>
                </div>
                <span class="d-block mb-2 text-muted">Sessions</span>
            </div>
            <div class="card-body">
                <div id="sessions"></div>
            </div>
        </div>
    </div>
    <!--/ Sessions line chart -->
</div>

<div class="card">
    <div class="card-body">
        <form class="row">
            <div class="col-md-4">
                <div class="input-group input-group-lg">
                    <span class="input-group-text">Tanggal</span>
                    <input type="text" id=from-datepicker class="form-control" name="due_date" placeholder="Tanggal" value="<?php echo $_GET["due_date"] ?? Date("Y-m-d") ?>" />
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group input-group-lg">
                    <span class="input-group-text">Waktu</span>
                    <select class="form-control" name="jenis_pengiriman">
                        <option value="Pagi">Pagi</option>
                        <option value="Sore" <?php echo $_GET["jenis_pengiriman"] == "Sore" ? "selected=selected" : "" ?>>
                            Sore
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-md-4 d-flex justify-content-end">
                <button class="btn btn-primary mx-1">
                    <span><i class="fa fa-search"></i> Filter</span>
                </button>
                <a href="rekap_produksi.php?due_date=<?php echo $_GET["due_date"] ?? Date("Y-m-d") ?>&jenis_pengiriman=<?php echo $_GET["jenis_pengiriman"] ?? "Pagi" ?>" class="btn btn-secondary">
                    <span><i class="mdi mdi-file-pdf-box me-1"></i> Export</span>
                </a>
            </div>
        </form>
    </div>
</div>
<br>
<div class="card">
    <div class="card-header text-center">
        <h3>Orderan</h3>
    </div>
    <div class="card-body">
        <div class="card-datatable table-responsive pt-0">
            <table id="kirim_hari_ini" class="datatables-basic table dt-table dt-responsive display table-striped table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th style="width:2%" class="sort-numeric">No</th>
                        <th style="width:18%">ID Transaksi</th>
                        <th style="width:20%">Costumer</th>
                        <th style="width:15%">Status</th>
                        <th style="width:15%">Total Order</th>
                        <th style="width:25%">Alamat</th>
                        <th style="width:15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- List Data Menggunakan DataTable -->
                </tbody>
            </table>
        </div>
    </div>
</div>
<br>
<div class="card">
    <div class="card-header text-center">
        <h3>Produk Diproses</h3>
    </div>
    <div class="card-body">
        <div class="card-datatable table-responsive pt-0">
            <table id="kirim_hari_ini_products" class="datatables-basic table dt-table dt-responsive display table-striped table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th style="width:18%">Nama</th>
                        <th style="width:10%">Img</th>
                        <th style="width:20%">Invoices</th>
                        <th style="width:15%">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- List Data Menggunakan DataTable -->
                </tbody>
            </table>

        </div>
    </div>
</div>