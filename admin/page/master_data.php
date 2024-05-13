<div class="card mb-4">
    <div class="card-body">
        <div class="input-group input-group-merge">
            <span class="input-group-text" id="basic-addon-search31"><i class="fa fa-search"></i></span>
            <input type="text" class="form-control" placeholder="Cari..." aria-label="Cari..."
                aria-describedby="basic-addon-search31" id="cari_master_data" onchange="cariMasterData()" />
            <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                aria-expanded="false"><i class="fa fa-cog"></i></button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <label class="dropdown-item">
                        <input type=radio value="" name="tipe" checked=checked onclick="cariMasterData()">
                        Aktif
                    </label>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <label class="dropdown-item">
                        <input type=radio value="semua" name="tipe" onclick="cariMasterData()">
                        Semua
                    </label>
                </li>
                <li>
                    <label class="dropdown-item">
                        <input type=radio value="dihapus" name="tipe" onclick="cariMasterData()">
                        Dihapus
                    </label>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="nav-align-top mb-4 h-100">
    <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
        <li class="nav-item">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                data-bs-target="#navs-pills-justified-home" aria-controls="navs-pills-justified-home"
                aria-selected="true">
                <i class="tf-icons mdi  mdi-baguette me-1"></i> Produk
                <span class="badge rounded-pill bg-danger ms-1" id="produk_list_count">0</span>
            </button>
        </li>
        <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                data-bs-target="#navs-pills-justified-profile" aria-controls="navs-pills-justified-profile"
                aria-selected="false">
                <i class="tf-icons mdi mdi-package-variant-closed-check me-1"></i> Paket
                <span class="badge rounded-pill bg-danger ms-1" id="paket_list_count">0</span>
            </button>
        </li>
        <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                data-bs-target="#navs-pills-justified-messages" aria-controls="navs-pills-justified-messages"
                aria-selected="false">
                <i class="tf-icons mdi mdi-account-outline me-1"></i> Pelanggan
                <span class="badge rounded-pill bg-danger ms-1" id="pelanggan_data_count">0</span>
            </button>
        </li>
    </ul>
    <div class="tab-content p-0">
        <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
            <table id="produk-list-table"
                class="datatables-basic table dt-table dt-responsive display table-striped table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kategori</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Stock</th>
                        <th class="cell-fit">Aksi</th>

                    </tr>
                </thead>
                <tbody>
                    <!-- List Data Menggunakan DataTable -->
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="navs-pills-justified-profile" role="tabpanel">
            <table id="paket-list-table"
                class="datatables-basic table dt-table dt-responsive display table-striped table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kategori</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Stock</th>
                        <th class="cell-fit">Aksi</th>

                    </tr>
                </thead>
                <tbody>
                    <!-- List Data Menggunakan DataTable -->
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="navs-pills-justified-messages" role="tabpanel">
            <div class="">
                <table id="pelanggan-list-table"
                    class="datatables-basic table dt-table dt-responsive display table-striped table-sm"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Pelanggan</th>
                            <th>Telepon</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data Pelanggan akan dimasukkan oleh DataTable -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Tabs -->




<script>
    sidebarBuka("master-data");
    var dom = '<"row ms-2 me-3"' +
        '<"col-12 d-flex align-items-center justify-content-between gap-3"l<"dt-action-buttons invoice_aksi d-flex text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3"B>>' +
        '>t' +
        '<"row mx-2"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>';

    function cariMasterData() {
        if (produk_list != null) {
            produk_list.ajax.reload();
        }
        if (paket_list != null) {
            paket_list.ajax.reload();
        }
        if (pelanggan_data != null) {
            pelanggan_data.ajax.reload();
        }
    }


    function inputPencarian() {
        var result = $("#cari_master_data").val();
        if (result == null || result == "") {
            return "";
        }
        return result;
    }

    function inputTipe() {
        var result = $('input[name="tipe"]:checked').val();
        if (result == null || result == "") {
            return "";
        }
        return result;
    }

    function tambahProduk() {

    }

    function tambahPaket() {

    }

    function tambahCustomer() {

    }
    var produk_list = $('#produk-list-table').DataTable({
        order: [
            [0, 'desc']
        ],
        processing: true,
        responsive: true,
        serverSide: true,
        ordering: true,
        stateSave: true,
        dom: dom,
        buttons: [{
            text: '<i class="mdi mdi-plus me-md-1"></i><span class="d-lg-inline-block d-none"> Produk</span>',
            className: 'btn btn-primary',
            action: function (e, dt, button, config) {
                tambahProduk();
            }
        }],
        ajax: {
            "url": "<?php echo $base_url; ?>/admin/data/produk_list.php",
            "data": function (d) {
                d.action = "produk_data";
                d.cari = inputPencarian();
                d.tipe = inputTipe();
            },
            "type": "POST"
        },
        columns: [{
                "data": "id_product"
            },
            {
                "data": "id_category"
            },
            {
                "data": "name_product"
            },
            {
                "data": "selling_price"
            },
            {
                "data": "stock"
            },
            {
                "data": "aksi"
            }
        ],
        drawCallback: function () {
            try {
                $('#produk_list_count').html(produk_list.page.info().recordsTotal);
            } catch (e) {
                $('#produk_list_count').html(0);
            }
        }
    });
    var paket_list = $('#paket-list-table').DataTable({
        order: [
            [0, 'desc']
        ],
        processing: true,
        responsive: true,
        serverSide: true,
        ordering: true,
        stateSave: true,
        dom: dom,
        buttons: [{
            text: '<i class="mdi mdi-plus me-md-1"></i><span class="d-lg-inline-block d-none"> Paket</span>',
            className: 'btn btn-primary',
            action: function (e, dt, button, config) {
                tambahPaket();
            }
        }],
        ajax: {
            "url": "<?php echo $base_url; ?>/admin/data/produk_list.php",
            "data": function (d) {
                d.action = "paket_data";
                d.cari = inputPencarian();
                d.tipe = inputTipe();
            },
            "type": "POST"
        },
        columns: [{
                "data": "id_product"
            },
            {
                "data": "id_category"
            },
            {
                "data": "name_product"
            },
            {
                "data": "selling_price"
            },
            {
                "data": "stock"
            },
            {
                "data": "aksi"
            }
        ],
        drawCallback: function () {
            try {
                $('#paket_list_count').html(paket_list.page.info().recordsTotal);
            } catch (e) {
                $('#paket_list_count').html(0);
            }
        }
    });
    var pelanggan_data = $('#pelanggan-list-table').DataTable({
        order: [
            [0, 'desc']
        ],
        processing: true,
        responsive: true,
        serverSide: true,
        ordering: true,
        stateSave: true,
        dom: dom,
        buttons: [{
            text: '<i class="mdi mdi-plus me-md-1"></i><span class="d-lg-inline-block d-none"> Pelanggan</span>',
            className: 'btn btn-primary',
            action: function (e, dt, button, config) {
                tambahCustomer();
            }
        }],
        ajax: {
            "url": "<?php echo $base_url; ?>/admin/data/produk_list.php",
            "data": function (d) {
                d.action = "pelanggan_data";
                d.cari = inputPencarian();
                d.tipe = inputTipe();
            },
            "type": "POST"
        },
        columns: [{
                "data": "id_customer"
            },
            {
                "data": "name_customer"
            },
            {
                "data": "telephone"
            },
            {
                "data": "email"
            },
            {
                "data": "address"
            },
            {
                "data": "aksi"
            }
        ],
        drawCallback: function () {
            try {
                $('#pelanggan_data_count').html(pelanggan_data.page.info().recordsTotal);
            } catch (e) {
                $('#pelanggan_data_count').html(0);
            }
        }
    });
</script>