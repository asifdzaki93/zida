<?php
include "data/koneksi.php";
include "data/nota_admin.php";
include "data/base_sistem.php";
nota_admin_render($mysqli, $base_url);
?>


<!-- Multi Column with Form Separator -->
<div class="card mb-4">
    <h5 class="card-header">Lihat Produksi Berdasar Tanggal Kirim</h5>
    <form class="card-body" onsubmit="return produksiChange(event);" id="produksiFilter">
        <h6>- Pilih Tanggal & Waktu</h6>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="form-floating form-floating-outline">
                    <input onchange="produksiChange(event)" type="text" id=from-datepicker class="form-control" name="due_date" placeholder="Tanggal" value="<?php echo $_GET["due_date"] ?? Date("Y-m-d") ?>" />
                    <!-- <input type="text" id="multicol-username" class="form-control" placeholder="john.doe" /> -->
                    <label for="from-datepicker">Tanggal</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-merge">
                    <div class="form-floating form-floating-outline">
                        <!-- <input type="text" id="multicol-email" class="form-control" placeholder="john.doe" aria-label="john.doe" aria-describedby="multicol-email2" /> -->
                        <select onchange="produksiChange(event)" class="form-control" name="jenis_pengiriman" id="waktu">
                            <option value="Pagi" <?php echo ($_GET["jenis_pengiriman"] ?? "") == "Pagi" ? "selected=selected" : "" ?>>
                                Pagi
                            </option>
                            <option value="Sore" <?php echo ($_GET["jenis_pengiriman"] ?? "") == "Sore" ? "selected=selected" : "" ?>>
                                Sore
                            </option>
                        </select>
                        <label for="waktu">Waktu Kirim</label>
                    </div>
                    <!-- <span class="input-group-text" id="multicol-email2">@example.com</span> -->
                </div>
            </div>
        </div>
        <div class="pt-4">
            <button class="btn btn-primary mx-1">
                <span><i class="fa fa-search"></i> Filter</span>
            </button>
            <a href="rekap_produksi.php?due_date=<?php echo $_GET["due_date"] ?? Date("Y-m-d") ?>&jenis_pengiriman=<?php echo $_GET["jenis_pengiriman"] ?? "Pagi" ?>" class="btn btn-secondary">
                <span><i class="mdi mdi-file-pdf-box me-1"></i> Export</span>
            </a>
        </div>
    </form>
</div>


<!-- <div class="card">
    <form class="row" onsubmit="return produksiChange(event);" id="produksiFilter">
        <div class="card-body">
            <div class="col-md-4">
                <div class="input-group input-group-lg">
                    <span class="input-group-text">Tanggal</span>
                    <input onchange="produksiChange(event)" type="text" id=from-datepicker class="form-control" name="due_date" placeholder="Tanggal" value="<?php echo $_GET["due_date"] ?? Date("Y-m-d") ?>" />
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group input-group-lg">
                    <span class="input-group-text">Waktu</span>
                    <select onchange="produksiChange(event)" class="form-control" name="jenis_pengiriman">
                        <option value="Pagi" <?php echo ($_GET["jenis_pengiriman"] ?? "") == "Pagi" ? "selected=selected" : "" ?>>
                            Pagi
                        </option>
                        <option value="Sore" <?php echo ($_GET["jenis_pengiriman"] ?? "") == "Sore" ? "selected=selected" : "" ?>>
                            Sore
                        </option>
                    </select>
                </div>
            </div>


        </div>
        <div class="card-footer">
            <button class="btn btn-primary mx-1">
                <span><i class="fa fa-search"></i> Filter</span>
            </button>
            <a href="rekap_produksi.php?due_date=<?php echo $_GET["due_date"] ?? Date("Y-m-d") ?>&jenis_pengiriman=<?php echo $_GET["jenis_pengiriman"] ?? "Pagi" ?>" class="btn btn-secondary">
                <span><i class="mdi mdi-file-pdf-box me-1"></i> Export</span>
            </a>
        </div>
    </form>
</div>
<br> -->


<div class="nav-align-top mb-4">
    <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
        <li class="nav-item">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-home" aria-controls="navs-pills-justified-home" aria-selected="true">
                <i class="tf-icons mdi mdi-cart-arrow-right me-1"></i> Nota
                <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger ms-1">3</span>
            </button>
        </li>
        <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-profile" aria-controls="navs-pills-justified-profile" aria-selected="false">
                <i class="tf-icons mdi mdi-cookie-settings me-1"></i> Produk
            </button>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
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
        <div class="tab-pane fade" id="navs-pills-justified-profile" role="tabpanel">
            <table id="kirim_hari_ini_products" class="datatables-basic table dt-table dt-responsive display table-striped table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th style="width:1%"></th>
                        <th style="width:38%">Nama</th>
                        <th style="width:10%">Img</th>
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




<script>
    var base_url = "<?php echo $base_url; ?>";
    var pageURL = window.location.href;
    var page = pageURL.substr(pageURL.lastIndexOf('/') + 1);
    loadProduksi(base_url + "admin/data/kirim_hari_ini.php?" + page.split("?")[1]);
</script>