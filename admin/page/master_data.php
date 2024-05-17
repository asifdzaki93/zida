<?php
include 'data/koneksi.php';
$q = $mysqli->query(
    'SELECT id_category as value, name_category as label from category where status = "0" order by name_category asc'
);
$kategori = [];
while ($row = $q->fetch_assoc()) {
    array_push($kategori, $row);
}
$optionKategori = json_encode($kategori);
?>

<div class="card mb-4">
    <div class="card-body">
        <div class="input-group input-group-merge">
            <span class="input-group-text" id="basic-addon-search31"><i class="fa fa-search"></i></span>
            <input type="text" class="form-control" placeholder="Cari..." aria-label="Cari..." aria-describedby="basic-addon-search31" id="cari_master_data" onchange="cariMasterData()" />
            <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-cog"></i></button>
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

<div class="card mb-4" id="product_packages" style="display:none">
    <div class="card-header">
        <h5>Isi Paket "<b id="product_packages_title"></b>"</h5>
        <button type="button" id="product_packages_add" class="btn btn-primary" onclick="">
            <i class="fa fa-add mx-2"></i> Tambah Isi Paket
        </button>
    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="packages_product_content"></tbody>
        </table>
    </div>
    <div class="card-footer">
        <button type="button" class="btn btn-danger" onclick="product_packages_tutup()">Tutup</button>
    </div>
</div>
<!-- Tabs -->

<div class="nav-align-top mb-4 h-100">
    <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
        <li class="nav-item">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-home" aria-controls="navs-pills-justified-home" aria-selected="true">
                <i class="tf-icons mdi  mdi-baguette me-1"></i> Produk
                <span class="badge rounded-pill bg-danger ms-1" id="produk_list_count">0</span>
            </button>
        </li>
        <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-profile" aria-controls="navs-pills-justified-profile" aria-selected="false">
                <i class="tf-icons mdi mdi-package-variant-closed-check me-1"></i> Paket
                <span class="badge rounded-pill bg-danger ms-1" id="paket_list_count">0</span>
            </button>
        </li>
        <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-messages" aria-controls="navs-pills-justified-messages" aria-selected="false">
                <i class="tf-icons mdi mdi-account-outline me-1"></i> Pelanggan
                <span class="badge rounded-pill bg-danger ms-1" id="pelanggan_data_count">0</span>
            </button>
        </li>
    </ul>
    <div class="tab-content p-0">
        <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
            <table id="produk-list-table" class="invoice-list-table datatables-basic table dt-table dt-responsive display table-striped table-sm" style="width:100%">
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
            <table id="paket-list-table" class="invoice-list-table datatables-basic table dt-table dt-responsive display table-striped table-sm" style="width:100%">
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
                <table id="pelanggan-list-table" class="invoice-list-table datatables-basic table dt-table dt-responsive display table-striped table-sm" style="width:100%">
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

<!-- Modal -->
<div class="modal fade" id="crud_master_data" tabindex="-1" aria-labelledby="crud_master_data_title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crud_master_data_title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form onsubmit="return crud_master_data_onsubmit(event);" id=crud_master_data_content class="row"></form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="crud_master_data_process()" id="crud_master_data_button">Buka</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Kembali</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="customer" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card">
                <div class="card-body text-center">
                    <div class="dropdown btn-pinned">
                        <button type="button" class="btn dropdown-toggle hide-arrow p-0" data-bs-dismiss="modal" aria-expanded="false">
                            <i class="mdi mdi-close mdi-24px text-muted"></i>
                        </button>
                    </div>
                    <div class="mb-2 text-center d-flex justify-content-center">
                        <div class="avatar avatar-xl">
                            <span class="avatar-initial rounded-circle bg-label-info" id="customer_initial">AA</span>
                        </div>
                    </div>
                    <h5 class="mb-1 card-title" id="customer_name_customer"></h5>
                    <p class="text-muted mb-1" id="customer_telephone"></p>
                    <p class="text-muted" id="customer_address"></p>
                </div>
                <div class="card-datatable table-responsive pt-0">
                    <table id="pelanggan-invoice-table" class="datatables-basic table dt-table dt-responsive display table-striped table-sm" style="width:100%">
                        <thead>
                            <tr>
                                <th>#Invoice</th>
                                <th><i class="mdi mdi-trending-up"></i></th>
                                <th>Total</th>
                                <th class="text-truncate">Dibuat</th>
                                <th>Tagihan</th>
                                <th class="cell-fit">Aksi</th>

                            </tr>
                        </thead>
                        <tbody>
                            <!-- List Data Menggunakan DataTable -->
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="d-flex align-items-center justify-content-center">
                        <a target="_blank" href="" id="customer_email_link" class="btn btn-primary d-flex align-items-center me-3 waves-effect waves-light">
                            <i class="mdi mdi-account-check-outline me-1"></i>
                            <span id="customer_email"></span>
                        </a>
                        <a target="_blank" href="" id="customer_telephone_link" class="btn btn-outline-secondary waves-effect me-3">
                            <i class="mdi mdi-whatsapp me-1"></i>
                            <span id="customer_telephone_2"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- Modal -->

<script>
    sidebarBuka("master-data");
    var dom = '<"row ms-2 me-3"' +
        '<"col-12 d-flex align-items-center justify-content-between gap-3"l<"dt-action-buttons [dom_aksi] d-flex text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3"B>>' +
        '>t' +
        '<"row mx-2"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>';
    var optionKategori = JSON.parse('<?php echo $optionKategori; ?>');

    var id_product_selected = "";

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
        if (id_product_selected != "") {
            load_packages();
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

    function showGenerateDeskripsi() {
        if ($("#form_data_online").val() == 1) {
            $("#generate_deskripsi").removeClass("d-none");
        } else {
            $("#generate_deskripsi").addClass("d-none");
        }
    }
    async function generateDeskripsi(id) {
        $("#generate_deskripsi").html("Memuat...");
        await $.ajax({
            url: "<?php echo $base_url; ?>/admin/data/crud_master_data.php?tipe=produk_generate_deskripsi&id_product=" + id,
            success: function(d) {
                if (d.result == "success") {
                    $("#form_data_description").val(d.data);
                }
            }
        });
        $("#generate_deskripsi").html("Generate Ulang Dengan AI");
    }
    async function crudProduk(id, read_only, packages, title, tipe, button) {
        var data = {};
        var generator = '';
        if (id != "") {
            await $.ajax({
                url: "<?php echo $base_url; ?>/admin/data/crud_master_data.php?tipe=produk_read&id_product=" + id,
                success: function(d) {
                    if (d.result == "success") {
                        data = d.data;
                    }
                }
            });
            generator = "<a id='generate_deskripsi' class='btn btn-sm btn-secondary' onclick=\"generateDeskripsi('" +
                id + "')\" href='javascript:;'>Generate Dengan AI</a>";
        }
        var input_form_group = [{
                class: "col-md-12",
                array: [{
                        type: "hidden",
                        name: "id_product",
                        value: data.id_product ?? ""
                    },
                    {
                        type: "hidden",
                        name: "tipe",
                        value: tipe
                    },
                ]
            },
            {
                class: "col-md-12",
                read_only: read_only,
                array: [{
                        type: "hidden",
                        name: "packages",
                        value: packages
                    },
                    {
                        label: "Nama Barang",
                        value: data.name_product ?? "",
                        name: "name_product"
                    },
                    {
                        label: "Gambar",
                        type: "file",
                        value: data.img ?? "",
                        name: "img"
                    },
                    {
                        label: "Kategori",
                        type: "select",
                        option: optionKategori,
                        value: data.id_category ?? "",
                        name: "id_category"
                    },
                    {
                        label: "Kode Barang",
                        value: data.codeproduct ?? "",
                        name: "codeproduct"
                    },
                ]
            },
            {
                class: "col-md-6",
                read_only: read_only,
                array: [{
                        label: "Harga Beli",
                        type: "number",
                        value: data.purchase_price ?? "",
                        name: "purchase_price"
                    },
                    {
                        label: "Harga Jual",
                        type: "number",
                        value: data.selling_price ?? "",
                        name: "selling_price"
                    },
                    {
                        label: "Harga Grosir",
                        type: "number",
                        value: data.wholesale_price ?? "",
                        name: "wholesale_price"
                    },
                    {
                        label: "Pajak",
                        type: "number",
                        value: data.tax ?? "",
                        name: "tax"
                    },
                    {
                        label: "Online",
                        type: "select",
                        onchange: "showGenerateDeskripsi()",
                        option: [{
                                label: "Online",
                                value: "1",
                            },
                            {
                                label: "Offline",
                                value: "0",
                            },
                        ],
                        value: data.online ?? "",
                        name: "online"
                    },
                ],
            },
            {
                class: "col-md-6",
                read_only: read_only,
                array: [{
                        label: "Stok",
                        type: "number",
                        value: data.stock ?? "",
                        name: "stock"
                    },
                    {
                        label: "Unit",
                        value: data.unit ?? "",
                        name: "unit"
                    },
                    {
                        label: "Minimal Stok",
                        type: "number",
                        value: data.minimalstock ?? "",
                        name: "minimalstock"
                    },
                    {
                        label: "Alert Stok",
                        type: "number",
                        value: data.alertstock ?? "",
                        name: "alertstock"
                    },
                    {
                        label: "Minimal Pembelian",
                        type: "number",
                        value: data.minimum_purchase ?? "",
                        name: "minimum_purchase"
                    },
                ]
            },
            {
                class: "col-md-12",
                read_only: read_only,
                array: [{
                        label: "Ada Stok",
                        type: "select",
                        option: [{
                                label: "Ada",
                                value: "1",
                            },
                            {
                                label: "Tidak",
                                value: "0",
                            },
                        ],
                        value: data.have_stock ?? "",
                        name: "have_stock"
                    },
                    {
                        label: "Deskripsi",
                        type: "textarea",
                        generator: generator,
                        value: data.description ?? "",
                        name: "description"
                    },
                ]
            },
        ]
        crud_master_data_open(input_form_group, title, button);
        showGenerateDeskripsi();
    }

    function tambahProduk() {
        crudProduk("", false, "NO", "Tambah Produk", "produk_create", "Tambah");
    }

    async function lihat_produk(id) {
        crudProduk(id, true, "NO", "Lihat Paket", "produk_read", "");
    }

    async function edit_produk(id) {
        crudProduk(id, false, "NO", "Edit Produk", "produk_update", "Edit");
    }

    async function hapus_produk(id) {
        crudProduk(id, true, "NO", "Hapus Produk", "produk_delete", "Hapus");
    }

    async function restore_produk(id) {
        crudProduk(id, true, "NO", "Pulihkan Produk", "produk_restore", "Pulihkan");
    }

    function tambahPaket() {
        crudProduk("", false, "YES", "Tambah Paket", "produk_create", "Tambah");
    }

    async function lihat_paket(id) {
        crudProduk(id, true, "YES", "Lihat Paket", "produk_read", "");
    }

    async function edit_paket(id) {
        crudProduk(id, false, "YES", "Edit Paket", "produk_update", "Edit");
    }

    async function hapus_paket(id) {
        crudProduk(id, true, "YES", "Hapus Paket", "produk_delete", "Hapus");
    }

    async function restore_paket(id) {
        crudProduk(id, true, "YES", "Pulihkan Paket", "produk_restore", "Pulihkan");
    }

    async function crudCustomer(id, read_only, title, tipe, button) {
        var data = {};
        if (id != "") {
            await $.ajax({
                url: "<?php echo $base_url; ?>/admin/data/crud_master_data.php?tipe=customer_read&id_customer=" + id,
                success: function(d) {
                    if (d.result == "success") {
                        data = d.data;
                    }
                }
            });
        }
        var input_form_group = [{
                class: "col-md-12",
                read_only: read_only,
                array: [{
                        label: "Nama Pelanggan",
                        name: "name_customer",
                        value: data.name_customer ?? ""
                    },
                    {
                        type: "email",
                        name: "email",
                        label: "Email",
                        value: data.email ?? ""
                    },
                    {
                        label: "Nomor HP",
                        name: "telephone",
                        value: data.telephone ?? ""
                    },
                    {
                        type: "textarea",
                        label: "Alamat",
                        name: "address",
                        value: data.address ?? ""
                    },
                ]
            },
            {
                class: "col-md-12",
                array: [{
                        type: "hidden",
                        name: "id_customer",
                        value: data.id_customer ?? ""
                    },
                    {
                        type: "hidden",
                        name: "tipe",
                        value: tipe
                    },
                ]
            },
        ]
        crud_master_data_open(input_form_group, title, button);
    }

    function tambahCustomer() {
        crudCustomer("", false, "Tambah Pelanggan", "customer_create", "Tambah");
    }
    var telephone_selected = "";
    async function lihat_customer(id) {
        telephone_selected = "";
        await $.ajax({
            url: "<?php echo $base_url; ?>/admin/data/crud_master_data.php?tipe=customer_read&id_customer=" + id,
            success: function(d) {
                if (d.result == "success") {
                    data = d.data;
                    $("#customer_name_customer").html(data.name_customer);
                    $("#customer_address").html(data.address);
                    $("#customer_email").html(data.email);
                    $("#customer_telephone").html(data.telephone);
                    $("#customer_telephone_2").html(data.telephone);

                    $("#customer_email_link").attr("href","mailto:"+data.email);
                    $("#customer_telephone_link").attr("href","wa.me/"+data.telephone);

                    $("#customer_initial").html((fullname=>fullname.map((n, i)=>(i==0||i==fullname.length-1)&&n[0]).filter(n=>n).join(""))
(data.name_customer.split(" ")));
                    $("#customer").modal("show");
                    telephone_selected = data.telephone;
                    dt_invoice.ajax.reload();
                }
            }
        });
    }

    async function edit_customer(id) {
        crudCustomer(id, false, "Edit Pelanggan", "customer_update", "Edit");
    }

    async function hapus_customer(id) {
        crudCustomer(id, true, "Hapus Pelanggan", "customer_delete", "Hapus");
    }

    async function restore_customer(id) {
        crudCustomer(id, true, "Pulihkan Pelanggan", "customer_restore", "Pulihkan");
    }

    async function lihat_packages(id_product, name_product) {
        $("#product_packages").attr("style", "");
        $("#product_packages_title").html(name_product);
        $("#product_packages_add").attr("onclick", "tambah_packages('" + id_product + "')");
        id_product_selected = id_product;
        load_packages();
    }
    async function load_packages() {
        $("#packages_product_content").html("");
        await $.ajax({
            url: "<?php echo $base_url; ?>/admin/data/crud_master_data.php?tipe=packages_read&id_product_parent=" + id_product_selected,
            success: function(d) {
                if (d.result == "success") {
                    var data = d.data;
                    data.forEach(element => {
                        $("#packages_product_content").append(
                            $("<tr></tr>").attr("id", "packages_" + element.id_packagesproduct).append(
                                $("<input>")
                                .attr("type", "hidden")
                                .attr("id", "id_product_" + element.id_packagesproduct)
                                .attr("value", element.id_product),
                                $("<input>")
                                .attr("type", "hidden")
                                .attr("id", "name_product_" + element.id_packagesproduct)
                                .attr("value", element.name_product),
                                $("<input>")
                                .attr("type", "hidden")
                                .attr("id", "amount_" + element.id_packagesproduct)
                                .attr("value", element.amount),
                                $("<input>")
                                .attr("type", "hidden")
                                .attr("id", "price_" + element.id_packagesproduct)
                                .attr("value", element.price),
                                $("<td></td>").html(element.name_product),
                                $("<td></td>").html(element.amount),
                                $("<td></td>").html(element.price),
                                $("<td></td>").append(
                                    $("<div></div>").attr("class", "d-flex align-items-center").append(
                                        $("<a></a>").attr("href", "javascript:;")
                                        .attr("onclick", "tambah_packages('','" + element.id_packagesproduct + "')").html(
                                            '<i class="fa fa-edit mx-1"></i>'
                                        ),
                                        $("<a></a>").attr("href", "javascript:;")
                                        .attr("onclick", "hapus_packages('" + element.id_packagesproduct + "')").html(
                                            '<i class="mdi mdi-delete-outline mdi-20px mx-1"></i>'
                                        )
                                    )
                                )
                            )
                        );
                    });
                }
            }
        });
    }

    function product_packages_tutup() {
        $("#product_packages").attr("style", "display:none")
    }
    async function tambah_packages(id_product_parent, id_packagesproduct = '') {
        var amount = 0;
        var name_product = '';
        var price = 0;
        var tipe = 'packages_create';
        var button = 'Tambah';
        var id_product = '';
        var selectProduct = {
            label: "Produk",
            name: "id_product",
            type: "select",
            option: [],
        };
        if (id_packagesproduct != '') {
            amount = $("#amount_" + id_packagesproduct).val();
            name_product = $("#name_product_" + id_packagesproduct).val();
            price = $("#price_" + id_packagesproduct).val();
            tipe = 'packages_update';
            button = 'Edit';
            id_product = $("#id_product_" + id_packagesproduct).val();
            var selectProduct = {
                name: "id_product",
                type: "hidden",
                value: id_product
            };
        }
        var title = button + ' Paket ' + $("#product_packages_title").html();
        var input_form_group = [{
                class: "col-md-12",
                array: [
                    selectProduct,
                    {
                        type: "number",
                        name: "amount",
                        label: "Jumlah " + name_product,
                        value: amount
                    },
                ]
            },
            {
                class: "col-md-12",
                array: [{
                        type: "hidden",
                        name: "id_packagesproduct",
                        value: id_packagesproduct ?? ""
                    },
                    {
                        type: "hidden",
                        name: "id_product_parent",
                        value: id_product_parent
                    },
                    {
                        type: "hidden",
                        name: "tipe",
                        value: tipe
                    },
                ]
            },
        ]
        crud_master_data_open(input_form_group, title, button);
        if (id_packagesproduct == "") {
            $("#form_data_id_product").select2({
                ajax: {
                    url: "<?php echo $base_url; ?>/admin/data/cari_produk_no_paket.php",
                    type: "GET",
                    data: function(params) {

                        var queryParameters = {
                            search: params.term
                        }
                        return queryParameters;
                    },
                },
                dropdownParent: $("#crud_master_data")
            });
        }
    }
    async function hapus_packages(id) {
        await $.ajax({
            url: "<?php echo $base_url; ?>/admin/data/crud_master_data.php?tipe=packages_delete&id_packagesproduct=" + id,
            success: function(d) {
                if (d.result == "success") {
                    $('#packages_' + id).remove();
                }
            }
        });
    }

    function crud_master_data_open(input_form_group = [], title = "Tambah Produk", button = "Tambah") {
        $("#crud_master_data").modal("show");
        $("#crud_master_data_title").html(title);
        $("#crud_master_data_button").attr("disabled", false);
        if (button == "") {
            $("#crud_master_data_button").attr("style", "display:none !important;");
        } else {
            $("#crud_master_data_button").attr("style", "");
        }
        $("#crud_master_data_button").html(button);
        $("#crud_master_data_content").html("");
        for (var x = 0; x < input_form_group.length; x++) {
            $("#crud_master_data_content").append(
                $("<div></div>").attr("class", input_form_group[x].class).attr("id", "crud_master_data_content_" + x)
            );
            var input_form_array = input_form_group[x].array;
            var read_only = input_form_group[x].read_only == true;
            for (var i = 0; i < input_form_array.length; i++) {
                var input_form = input_form_array[i];
                if (input_form.label != null) {
                    $("#crud_master_data_content_" + x).append(
                        $.parseHTML('<small class="text-small text-muted text-uppercase align-middle">' + input_form.label + '</small>')
                    );
                }
                if (read_only) {
                    if (input_form.type == "select") {
                        var options = "";

                        for (var j = 0; j < input_form.option.length; j++) {
                            var option = input_form.option[j];
                            if (option.value == input_form.value) {
                                $("#crud_master_data_content_" + x).append(
                                    $("<p></p>").append(option.label)
                                );
                            }
                        }
                    }
                    if (input_form.type == "file") {
                        $("#crud_master_data_content_" + x).append(
                            $("<div></div>").attr("class", "w-px-50").html(
                                $("<img>").attr("class", "w-100").attr("src", input_form.value)
                            )
                        );
                    } else {
                        $("#crud_master_data_content_" + x).append(
                            $("<p></p>").append(input_form.value)
                        )
                    }
                } else {
                    if (input_form.type == "select") {
                        var options = "";

                        for (var j = 0; j < input_form.option.length; j++) {
                            var option = input_form.option[j];
                            if (option.value == input_form.value) {
                                options += "<option selected=selected value='" + option.value + "'>" + option.label + "</option>";
                            } else {
                                options += "<option value='" + option.value + "'>" + option.label + "</option>";
                            }
                        }
                        $("#crud_master_data_content_" + x).append(
                            $("<select></select>")
                            .attr("class", "form-control mb-2")
                            .attr("id", "form_data_" + input_form.name)
                            .attr("onchange", input_form.onchange ?? '')
                            .attr("name", input_form.name)
                            .html(options)
                        );
                    } else if (input_form.type == "textarea") {
                        $("#crud_master_data_content_" + x).append(
                            $.parseHTML(input_form.generator ?? ""),
                            $("<textarea></textarea>")
                            .attr("class", "form-control mb-2")
                            .attr("name", input_form.name)
                            .attr("id", "form_data_" + input_form.name)
                            .attr("placeholder", input_form.placeholder ?? "")
                            .html(input_form.value ?? "")
                        )
                    } else {
                        $("#crud_master_data_content_" + x).append(
                            $("<input>")
                            .attr("class", input_form.type == "hidden" ? "" : "form-control mb-2")
                            .attr("type", input_form.type)
                            .attr("id", "form_data_" + input_form.name)
                            .attr("name", input_form.name)
                            .attr("placeholder", input_form.placeholder ?? "")
                            .attr("value", input_form.value ?? "")
                        );
                    }
                }
            }
        }
    }

    function crud_master_data_onsubmit(e) {
        e.preventDefault();
        crud_master_data_process()
        return false;
    }
    async function crud_master_data_process() {
        var form = $('#crud_master_data_content')[0]; // You need to use standard javascript object here
        var formData = new FormData(form);
        if ($('#form_data_img').length > 0) {
            formData.append('img', $('#form_data_img')[0].files[0]);
        }
        $("#crud_master_data_button").attr("disabled", true);
        $("#crud_master_data_button").html("proses...");
        await $.ajax({
            url: "<?php echo $base_url; ?>/admin/data/crud_master_data.php",
            data: formData,
            type: 'POST',
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false, // NEEDED, DON'T OMIT THIS
            success: function(data) {
                if (data.result == "success") {
                    cariMasterData();
                    $("#crud_master_data").modal("hide");
                } else {
                    alert(data.title ?? "Error");
                    $("#crud_master_data_button").attr("disabled", false);
                    $("#crud_master_data_button").html("Coba Lagi");
                }
            }
        });
        return false;
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
        dom: dom.replace("[dom_aksi]","aksi_product"),
        buttons: [{
            text: '<i class="mdi mdi-plus me-md-1"></i><span class="d-lg-inline-block d-none"> Produk</span>',
            className: 'btn btn-primary',
            action: function(e, dt, button, config) {
                tambahProduk();
            }
        }],
        ajax: {
            "url": "<?php echo $base_url; ?>/admin/data/produk_list.php",
            "data": function(d) {
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
        initComplete: function(){
            $('<div></div>').attr('class', "dropdown ms-2 d-grid").html(
            '<button type="button" class="btn btn-primary dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
            '<i class="mdi mdi-dots-vertical"></i> <span class="d-lg-inline-block d-none"> Aksi</span><b class="ms-1" id=selected_product_count></b>' +
            '</button>' +
            '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">' +
            '<a class="dropdown-item" href="javascript:;" onclick="cetakBarcodeProduct()">Cetak Barcode</a>' +
            '</div>').appendTo('.aksi_product');
        },
        drawCallback: function() {
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
        dom: dom.replace("[dom_aksi]","aksi_packages"),
        buttons: [{
            text: '<i class="mdi mdi-plus me-md-1"></i><span class="d-lg-inline-block d-none"> Paket</span>',
            className: 'btn btn-primary',
            action: function(e, dt, button, config) {
                tambahPaket();
            }
        }],
        ajax: {
            "url": "<?php echo $base_url; ?>/admin/data/produk_list.php",
            "data": function(d) {
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
        initComplete:function(){
            $('<div></div>').attr('class', "dropdown ms-2 d-grid").html(
            '<button type="button" class="btn btn-primary dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
            '<i class="mdi mdi-dots-vertical"></i> <span class="d-lg-inline-block d-none"> Aksi</span><b class="ms-1" id=selected_packages_count></b>' +
            '</button>' +
            '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">' +
            '<a class="dropdown-item" href="javascript:;" onclick="cetakBarcodePackages()">Cetak Barcode</a>' +
            '</div>').appendTo('.aksi_packages');
        },
        drawCallback: function() {
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
            action: function(e, dt, button, config) {
                tambahCustomer();
            }
        }],
        ajax: {
            "url": "<?php echo $base_url; ?>/admin/data/produk_list.php",
            "data": function(d) {
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
        drawCallback: function() {
            try {
                $('#pelanggan_data_count').html(pelanggan_data.page.info().recordsTotal);
            } catch (e) {
                $('#pelanggan_data_count').html(0);
            }
        }
    });

    
    var dt_invoice = $('#pelanggan-invoice-table').DataTable({
        order: [
            [5, 'desc']
        ],
        processing: true,
        responsive: true,
        serverSide: true,
        ordering: true,
        stateSave: true,
        columnDefs: [{
                "className": "dt-left",
                "targets": 3
            },
            {
                "className": "dt-left",
                "targets": 2
            },
            {
                "className": "dt-center",
                "targets": 4
            },
            {
                "responsivePriority": 2,
                targets: 0
            },
            {
                "responsivePriority": 3,
                targets: 1
            },
            {
                "responsivePriority": 14,
                targets: 2
            },
            {
                "className": "text-nowrap",
                "targets": 3
            },
            {
                "className": "text-nowrap",
                "targets": 4
            },
        ],
        ajax: {
            "url": "<?php echo $base_url; ?>/admin/data/history.php",
            "data": function (d) {
                d.action = "sales_data";
                d.telephone = telephone_selected;
                d.status = $("#status_invoice").val();
                d.date = $("#filter_tanggal").val();
            },
            "type": "POST"
        },
        columns: [{
                "data": "no_invoice"
            },
            {
                "data": "trend"
            },
            {
                "data": "total"
            },
            {
                "data": "date"
            },
            {
                "data": "tagihan"
            },
            {
                "data": "aksi"
            }
        ],
        dom: '<"row ms-2 me-3"' +
            '<"col-12 col-md-3 d-flex align-items-center justify-content-center justify-content-md-start gap-3"l<"dt-action-buttons invoice_aksi d-flex text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3"B>>' +
            '<"col-12 col-md-9 d-flex align-items-center justify-content-end flex-column flex-md-row pe-3 gap-md-3"f<"invoice_status d-flex mb-3 mb-md-0">>' +
            '>t' +
            '<"row mx-2"' +
            '<"col-sm-12 col-md-6"i>' +
            '<"col-sm-12 col-md-6"p>' +
            '>',
        language: {
            sLengthMenu: 'Show _MENU_',
            search: '',
            searchPlaceholder: 'Cari Invoice'
        },
        buttons: [],
        // For responsive popup
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function (row) {
                        var data = row.data();
                        return 'Details of ' + data['full_name'];
                    }
                }),
                type: 'column',
                renderer: function (api, rowIdx, columns) {
                    var data = $.map(columns, function (col, i) {
                        return col.title !==
                            '' // ? Do not show row in modal popup if title is blank (for check box)
                            ?
                            '<tr data-dt-row="' +
                            col.rowIndex +
                            '" data-dt-column="' +
                            col.columnIndex +
                            '">' +
                            '<td>' +
                            col.title +
                            ':' +
                            '</td> ' +
                            '<td>' +
                            col.data +
                            '</td>' +
                            '</tr>' :
                            '';
                    }).join('');

                    return data ? $('<table class="table"/><tbody />').append(data) : false;
                }
            }
        },
        initComplete: function () {
            var column = this;
            var select = $(
                    '<select id="status_invoice" class="form-select"><option value=""> Cari Status </option></select>'
                )
                .appendTo('.invoice_status').on('change', function () {
                    dt_invoice.ajax.reload();
                });
            $('<input>').attr('id', "filter_tanggal").attr('class', 'form-control ms-2')
                .attr("placeholder", "Tanggal")
                .appendTo('.invoice_status').on('change', function () {
                    dt_invoice.ajax.reload();
                });
            var filter_tanggal = document.querySelector("#filter_tanggal");
            if (filter_tanggal !== null) {
                filter_tanggal.flatpickr({});
            }

            var option = [{
                    "label": "Semua Data",
                    "value": ""
                },
                {
                    "label": "Paid Off",
                    "value": "paid off"
                },
                {
                    "label": "Pre Order",
                    "value": "pre order"
                },
                {
                    "label": "finish",
                    "value": "finish"
                },
                {
                    "label": "Cancel",
                    "value": "cancel"
                }
            ];
            for (var i = 0; i < option.length; i++) {
                select.append('<option value="' + option[i].value +
                    '" class="text-capitalize">' + option[i].label +
                    '</option>');
            }
        }
    });
    var selected_product = {};
    var selected_packages = {};
    function select_product(codeproduct){
        if (selected_product.hasOwnProperty(codeproduct)) {
            delete selected_product[codeproduct];
        } else {
            selected_product[codeproduct] = {
                "codeproduct": codeproduct
            }
        }
        var selected_product_count = Object.keys(selected_product).length;
        if (selected_product_count == 0) {
            $("#selected_product_count").html("");
        } else {
            $("#selected_product_count").html("(" + selected_product_count + ")");
        }
    }
    async function cetakBarcodeProduct(){
        alert("Sedang mencetak barcode produk");
        var value=Object.keys(selected_product).join(",");
        await $.ajax({
            url: "<?php echo $base_url; ?>/admin/cetak_barcode.php?"+value,
            success: function(data) {
                if (data.result == "success") {
                    alert("Pencetakan barcode produk berhasil");
                    $("#crud_master_data").modal("hide");
                } else {
                    alert(data.title ?? "Error");
                    $("#crud_master_data_button").attr("disabled", false);
                    $("#crud_master_data_button").html("Coba Lagi");
                }
            }
        });
    }
    function select_packages(codeproduct){
        if (selected_packages.hasOwnProperty(codeproduct)) {
            delete selected_packages[codeproduct];
        } else {
            selected_packages[codeproduct] = {
                "codeproduct": codeproduct
            }
        }
        var selected_packages_count = Object.keys(selected_packages).length;
        if (selected_packages_count == 0) {
            $("#selected_packages_count").html("");
        } else {
            $("#selected_packages_count").html("(" + selected_packages_count + ")");
        }
    }
    async function cetakBarcodePackages(){
        alert("Sedang mencetak barcode paket");
        var value=Object.keys(selected_packages).join(",");
        await $.ajax({
            url: "<?php echo $base_url; ?>/admin/cetak_barcode.php?"+value,
            success: function(data) {
                if (data.result == "success") {
                    alert("Pencetakan barcode paket berhasil");
                    $("#crud_master_data").modal("hide");
                } else {
                    alert(data.title ?? "Error");
                    $("#crud_master_data_button").attr("disabled", false);
                    $("#crud_master_data_button").html("Coba Lagi");
                }
            }
        });
    }
    // On each datatable draw, initialize tooltip
    produk_list.on('draw.dt', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll(
            '[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                boundary: document.body
            });
        });
        $(".checkbox_product").each(function (index) {
            var kodeproduk = $(this).val();
            if (selected_product.hasOwnProperty(kodeproduk)) {
                $(this).prop('checked', true);
            }
        })
    });
    paket_list.on('draw.dt', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll(
            '[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                boundary: document.body
            });
        });
        $(".checkbox_packages").each(function (index) {
            var kodeproduk = $(this).val();
            if (selected_packages.hasOwnProperty(kodeproduk)) {
                $(this).prop('checked', true);
            }
        })
    });
    pelanggan_data.on('draw.dt', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll(
            '[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                boundary: document.body
            });
        });
    });
    dt_invoice_table.on('draw.dt', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll(
            '[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                boundary: document.body
            });
        });
    });
</script>