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
                    <input onchange="produksiChange(event)" type="text" id=from-datepicker class="form-control"
                        name="due_date" placeholder="Tanggal"
                        value="<?php echo $_GET["due_date"] ?? Date("Y-m-d") ?>" />
                    <!-- <input type="text" id="multicol-username" class="form-control" placeholder="john.doe" /> -->
                    <label for="from-datepicker">Tanggal</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-merge">
                    <div class="form-floating form-floating-outline">
                        <!-- <input type="text" id="multicol-email" class="form-control" placeholder="john.doe" aria-label="john.doe" aria-describedby="multicol-email2" /> -->
                        <select onchange="produksiChange(event)" class="form-control" name="waktu" id="waktu">
                            <option value="Pagi"
                                <?php echo ($_GET["waktu"] ?? "") == "Pagi" ? "selected=selected" : "" ?>>
                                Pagi
                            </option>
                            <option value="Sore"
                                <?php echo ($_GET["waktu"] ?? "") == "Sore" ? "selected=selected" : "" ?>>
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
            <a id="export_produksi" href="rekap_produksi.php" class="btn btn-secondary" target=_blank>
                <span><i class="mdi mdi-file-pdf-box me-1"></i> Export</span>
            </a>
        </div>
    </form>
</div>

<div class="nav-align-top mb-4">
    <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
        <li class="nav-item">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                data-bs-target="#navs-pills-justified-home" aria-controls="navs-pills-justified-home"
                aria-selected="true">
                <i class="tf-icons mdi mdi-cart-arrow-right me-1"></i> Nota
                <span id="jumlah_nota" class="badge rounded-pill bg-danger ms-1">0</span>
            </button>
        </li>
        <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                data-bs-target="#navs-pills-justified-profile" aria-controls="navs-pills-justified-profile"
                aria-selected="false">
                <i class="tf-icons mdi mdi-cookie-settings me-1"></i> Produk
                <span id="jumlah_produk" class="badge rounded-pill bg-danger ms-1">0</span>
            </button>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
            <table id="kirim_hari_ini"
                class="datatables-basic table dt-table dt-responsive display table-striped table-sm" style="width:100%">
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
            <table id="kirim_hari_ini_products"
                class="datatables-basic table dt-table dt-responsive display table-striped table-sm" style="width:100%">
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
    sidebarBuka("produksi", "sistem");

    var base_url = "<?php echo $base_url; ?>";
    var pageURL = window.location.href;
    var page = pageURL.substr(pageURL.lastIndexOf('/') + 1);

    var hari_ini_table = $('#kirim_hari_ini').DataTable({
        "order": [
            [0, 'asc']
        ],
        "ajax": {
            "dataSrc": 'orderDetails',
            "url": "<?php echo $base_url; ?>/admin/data/kirim_hari_ini.php",
            "data": function (d) {
                d.due_date = $("#from-datepicker").val();
                d.waktu = $("#waktu").val();
            },
            "dataType": "json",
        },
        "columns": [{
                "data": "no"
            },
            {
                "data": "no_invoice"
            },
            {
                "data": "costumer"
            },
            {
                "data": "status"
            },
            {
                "data": "totalorder"
            },
            {
                "data": "alamat"
            },
            {
                "data": "aksi"
            },
        ],
        "drawCallback": function () {
            try {
                $('#jumlah_nota').html(hari_ini_table.data().count());
            } catch (e) {
                $('#jumlah_nota').html(0);
            }
        }
    });
    var productsTable = $('#kirim_hari_ini_products').DataTable({
        "order": [
            [0, 'asc']
        ],
        "ajax": {
            "dataSrc": 'products',
            "url": "<?php echo $base_url; ?>/admin/data/kirim_hari_ini.php",
            "data": function (d) {
                d.due_date = $("#from-datepicker").val();
                d.waktu = $("#waktu").val();
            },
            "dataType": "json",
        },
        "columns": [{
                className: 'dt-control',
                orderable: false,
                data: null,
                defaultContent: ''
            },
            {
                "data": "name_product"
            },
            {
                "data": "img",
                "render": function (data) {
                    return "<div class='avatar avatar-md me-2'><a target=_blank href='" + data +
                        "'><img class='rounded-circle' src='" +
                        data + "'/></a></div>";
                }
            },
            {
                "data": "amount"
            }
        ],
        "drawCallback": function () {
            try {
                $('#jumlah_produk').html(productsTable.data().count());
            } catch (e) {
                $('#jumlah_produk').html(0);
            }
        }
    });
    productsTable.on('click', 'td.dt-control', function (e) {
        let tr = e.target.closest('tr');
        let row = productsTable.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
        } else {
            // Open this row
            row.child(row.data().invoices).show();
        }
    });

    function produksiChange(e) {
        e.preventDefault();
        hari_ini_table.ajax.reload();
        productsTable.ajax.reload();
        $("#export_produksi").attr("href", "rekap_produksi.php?waktu=" + $("#waktu").val() + "&due_date=" +
            $("#from-datepicker").val());
        return false;
    }
</script>