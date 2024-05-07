<div class="nav-align-top mb-4 h-100">
    <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
        <li class="nav-item">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                data-bs-target="#navs-pills-justified-home" aria-controls="navs-pills-justified-home"
                aria-selected="true">
                <i class="tf-icons mdi  mdi-baguette me-1"></i> Produk
                <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger ms-1">3</span>
            </button>
        </li>
        <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                data-bs-target="#navs-pills-justified-profile" aria-controls="navs-pills-justified-profile"
                aria-selected="false">
                <i class="tf-icons mdi mdi-package-variant-closed-check me-1"></i> Paket
            </button>
        </li>
        <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                data-bs-target="#navs-pills-justified-messages" aria-controls="navs-pills-justified-messages"
                aria-selected="false">
                <i class="tf-icons mdi mdi-account-outline me-1"></i> Pelanggan
            </button>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
            <table
                class="produk-list-table datatables-basic table dt-table dt-responsive display table-striped table-sm"
                style="width:100%">
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
            <table class="paket-list-table datatables-basic table dt-table dt-responsive display table-striped table-sm"
                style="width:100%">
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
                <table
                    class="pelanggan-list-table datatables-basic table dt-table dt-responsive display table-striped table-sm"
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

    function get_status_invoice() {
        return $("#status_invoice").val();
    }

    $(function () {
        var dt_invoice_table = $('.produk-list-table');

        // DataTable untuk menampilkan daftar produk
        if (dt_invoice_table.length) {
            var dt_invoice = dt_invoice_table.DataTable({
                order: [
                    [0, 'desc']
                ],
                processing: true,
                responsive: true,
                serverSide: true,
                ordering: true,
                stateSave: true,
                ajax: {
                    "url": "<?php echo $base_url; ?>/admin/data/produk_list.php",
                    "data": function (d) {
                        d.action = "produk_data";
                        d.status = get_status_invoice();
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
            });
        }
    });
</script>

<script>
    function get_status_invoice() {
        return $("#status_invoice").val();
    }

    $(function () {
        var dt_invoice_table = $('.paket-list-table');

        // DataTable untuk menampilkan daftar produk
        if (dt_invoice_table.length) {
            var dt_invoice = dt_invoice_table.DataTable({
                order: [
                    [0, 'desc']
                ],
                processing: true,
                responsive: true,
                serverSide: true,
                ordering: true,
                stateSave: true,
                ajax: {
                    "url": "<?php echo $base_url; ?>/admin/data/produk_list.php",
                    "data": function (d) {
                        d.action = "paket_data";
                        d.status = get_status_invoice();
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
            });
        }
    });
</script>
<script>
    function get_status_customer() {
        return $("#status_customer").val();
    }

    $(function () {
        var dt_customer_table = $('.pelanggan-list-table');

        // DataTable untuk menampilkan daftar pelanggan
        if (dt_customer_table.length) {
            var dt_customer = dt_customer_table.DataTable({
                order: [
                    [0, 'desc']
                ],
                processing: true,
                responsive: true,
                serverSide: true,
                ordering: true,
                stateSave: true,
                ajax: {
                    "url": "<?php echo $base_url; ?>/admin/data/produk_list.php",
                    "data": function (d) {
                        d.action = "pelanggan_data";
                        d.status = get_status_customer();
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
            });
        }
    });
</script>