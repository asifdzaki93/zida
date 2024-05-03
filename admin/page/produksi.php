<?php
include "data/koneksi.php";
include "data/nota_admin.php";
include "data/base_sistem.php";
nota_admin_render($mysqli,$base_url);
?>

<div class="card">
    <div class="card-body">
        <form class="row" onsubmit="return produksiChange(event);" id="produksiFilter">
            <div class="col-md-4">
                <div class="input-group input-group-lg">
                    <span class="input-group-text">Tanggal</span>
                    <input onchange="produksiChange(event)" type="text" id=from-datepicker class="form-control"
                        name="due_date" placeholder="Tanggal"
                        value="<?php echo $_GET["due_date"] ?? Date("Y-m-d") ?>" />
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group input-group-lg">
                    <span class="input-group-text">Waktu</span>
                    <select onchange="produksiChange(event)" class="form-control" name="jenis_pengiriman">
                        <option value="Pagi"
                            <?php echo ($_GET["jenis_pengiriman"]??"") == "Pagi" ? "selected=selected" : "" ?>>
                            Pagi
                        </option>
                        <option value="Sore"
                            <?php echo ($_GET["jenis_pengiriman"]??"") == "Sore" ? "selected=selected" : "" ?>>
                            Sore
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-md-4 d-flex justify-content-end">
                <button class="btn btn-primary mx-1">
                    <span><i class="fa fa-search"></i> Filter</span>
                </button>
                <a href="rekap_produksi.php?due_date=<?php echo $_GET["due_date"] ?? Date("Y-m-d") ?>&jenis_pengiriman=<?php echo $_GET["jenis_pengiriman"] ?? "Pagi" ?>"
                    class="btn btn-secondary">
                    <span><i class="mdi mdi-file-pdf-box me-1"></i> Export</span>
                </a>
            </div>
        </form>
    </div>
</div>
<br>
<div class="row mt-4">
    <div class="col-lg-6 col-md-12">
        <div class="card">
            <div class="card-header text-center">
                <h3>Orderan</h3>
            </div>
            <div class="card-body">
                <div class="card-datatable table-responsive pt-0">
                    <table id="kirim_hari_ini"
                        class="datatables-basic table dt-table dt-responsive display table-striped table-sm"
                        style="width:100%">
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
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="card">
            <div class="card-header text-center">
                <h3>Produk Diproses</h3>
            </div>
            <div class="card-body">
                <div class="card-datatable table-responsive pt-0">
                    <table id="kirim_hari_ini_products"
                        class="datatables-basic table dt-table dt-responsive display table-striped table-sm"
                        style="width:100%">
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
    </div>
</div>

<script>
    var base_url = "<?php echo $base_url;?>";
    var pageURL = window.location.href;
    var page = pageURL.substr(pageURL.lastIndexOf('/') + 1);
    loadProduksi(base_url + "admin/data/kirim_hari_ini.php?" + page.split("?")[1]);
</script>