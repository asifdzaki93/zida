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
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
<script>
    sidebarBuka("master-data");
    var dom = '<"row ms-2 me-3"' +
        '<"col-12 d-flex align-items-center justify-content-between gap-3"l<"dt-action-buttons invoice_aksi d-flex text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3"B>>' +
        '>t' +
        '<"row mx-2"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>';
    var optionKategori = JSON.parse('<?php echo $optionKategori; ?>');

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

    async function crudProduk(id,read_only,packages,title,tipe,button){
        var data = {};
        if(id!=""){
            await $.ajax({
                url:  "<?php echo $base_url; ?>/admin/data/crud_master_data.php?tipe=produk_read&id_product="+id,
                success: function (d){
                    if(d.result=="success"){
                        data = d.data;
                    }
                }
            });
        }
        var input_form_group = [
            {
                class:"col-md-12",
                array:[
                    {
                        type:"hidden",
                        name:"id_product",
                        value:data.id_product??""
                    },
                    {
                        type:"hidden",
                        name:"tipe",
                        value:tipe
                    },
                ]
            },
            {
                class:"col-md-12",
                read_only:read_only,
                array:[
                    {
                        type:"hidden",
                        name:"packages",
                        value:packages
                    },
                    {
                        label:"Nama Barang",
                        value:data.name_product??"",
                        name:"name_product"
                    },
                    {
                        label:"Gambar",
                        type:"file",
                        value:data.img??"",
                        name:"img"
                    },
                    {
                        label:"Kategori",
                        type:"select",
                        option: optionKategori,
                        value:data.id_category??"",
                        name:"id_category"
                    },
                    {
                        label:"Kode Barang",
                        value:data.codeproduct??"",
                        name:"codeproduct"
                    },
                ]
            },
            {
                class:"col-md-6",
                read_only:read_only,
                array:[
                    {
                        label:"Harga Beli",
                        type:"number",
                        value:data.purchase_price??"",
                        name:"purchase_price"
                    },
                    {
                        label:"Harga Jual",
                        type:"number",
                        value:data.selling_price??"",
                        name:"selling_price"
                    },
                    {
                        label:"Harga Grosir",
                        type:"number",
                        value:data.wholesale_price??"",
                        name:"wholesale_price"
                    },
                    {
                        label:"Pajak",
                        type:"number",
                        value:data.tax??"",
                        name:"tax"
                    },
                    {
                        label:"Online",
                        type:"select",
                        option:[
                            {
                                label:"Online",
                                value:"1",
                            },
                            {
                                label:"Offline",
                                value:"0",
                            },
                        ],
                        value:data.online??"",
                        name:"online"
                    },
                ],
            },
            {
                class:"col-md-6",
                read_only:read_only,
                array:[
                    {
                        label:"Stok",
                        type:"number",
                        value:data.stock??"",
                        name:"stock"
                    },
                    {
                        label:"Unit",
                        value:data.unit??"",
                        name:"unit"
                    },
                    {
                        label:"Minimal Stok",
                        type:"number",
                        value:data.minimalstock??"",
                        name:"minimalstock"
                    },
                    {
                        label:"Alert Stok",
                        type:"number",
                        value:data.alertstock??"",
                        name:"alertstock"
                    },
                    {
                        label:"Minimal Pembelian",
                        type:"number",
                        value:data.minimum_purchase??"",
                        name:"minimum_purchase"
                    },
                ]
            },
            {
                class:"col-md-12",
                read_only:read_only,
                array:[
                    {
                        label:"Ada Stok",
                        type:"select",
                        option:[
                            {
                                label:"Ada",
                                value:"1",
                            },
                            {
                                label:"Tidak",
                                value:"0",
                            },
                        ],
                        value:data.have_stock??"",
                        name:"have_stock"
                    },
                    {
                        label:"Deskripsi",
                        type:"textarea",
                        value:data.description??"",
                        name:"description"
                    },
                ]
            },
        ]
        crud_master_data_open(input_form_group,title,button);
    }
    function tambahProduk() {
        crudProduk("",false,"NO","Tambah Produk","produk_create","Tambah");
    }

    async function lihat_produk(id){
        crudProduk(id,true,"NO","Tambah Paket","produk_read","");
    }

    async function edit_produk(id){
        crudProduk(id,false,"NO","Edit Produk","produk_update","Edit");
    }

    async function hapus_produk(id){
        crudProduk(id,true,"NO","Hapus Produk","produk_delete","Hapus");
    }

    function tambahPaket() {
        crudProduk("",false,"YES","Tambah Paket","produk_create","Tambah");
    }

    async function lihat_paket(id){
        crudProduk(id,true,"YES","Tambah Paket","produk_read","");
    }

    async function edit_paket(id){
        crudProduk(id,false,"YES","Edit Produk","produk_update","Edit");
    }

    async function hapus_paket(id){
        crudProduk(id,true,"YES","Hapus Produk","produk_delete","Hapus");
    }

    function tambahCustomer() {

    }

    function crud_master_data_open(input_form_group = [],title="Tambah Produk",button="Tambah"){
        $("#crud_master_data").modal("show");
        $("#crud_master_data_title").html(title);
        $("#crud_master_data_button").attr("disabled",false);
        $("#crud_master_data_button").html(button);
        $("#crud_master_data_content").html("");
        for(var x=0;x<input_form_group.length;x++){
            $("#crud_master_data_content").append(
                $("<div></div>").attr("class",input_form_group[x].class).attr("id","crud_master_data_content_"+x)
            );
            var input_form_array = input_form_group[x].array;
            var read_only = input_form_group[x].read_only==true;
            for(var i=0;i<input_form_array.length;i++){
                var input_form = input_form_array[i];
                if(input_form.label!=null){
                    $("#crud_master_data_content_"+x).append(
                        $.parseHTML('<small class="text-small text-muted text-uppercase align-middle">'+input_form.label+'</small>')
                    );
                }
                if(read_only){
                    if(input_form.type=="select"){
                        var options = "";

                        for(var j=0;j<input_form.option.length;j++){
                            var option=input_form.option[j];
                            if(option.value==input_form.value){
                                $("#crud_master_data_content_"+x).append(
                                    $("<p></p>").append(option.label)
                                );
                            }
                        }
                    }
                    if(input_form.type=="file"){
                        $("#crud_master_data_content_"+x).append(
                            $("<div></div>").attr("class","w-px-50").html(
                                $("<img>").attr("class","w-100").attr("src",input_form.value)
                            )
                        );
                    }else{
                        $("#crud_master_data_content_"+x).append(
                            $("<p></p>").append(input_form.value)
                        )
                    }
                }
                else{
                    if(input_form.type=="select"){
                        var options = "";

                        for(var j=0;j<input_form.option.length;j++){
                            var option=input_form.option[j];
                            if(option.value==input_form.value){
                                options+="<option selected=selected value='"+option.value+"'>"+option.label+"</option>";
                            }else{
                                options+="<option value='"+option.value+"'>"+option.label+"</option>";
                            }
                        }
                        $("#crud_master_data_content_"+x).append(
                            $("<select></select>")
                                .attr("class","form-control mb-2")
                                .attr("name",input_form.name)
                                .html(options)
                        );
                    }else if(input_form.type=="textarea"){
                        $("#crud_master_data_content_"+x).append(
                            $("<textarea></textarea>")
                                .attr("class","form-control mb-2")
                                .attr("name",input_form.name)
                                .attr("placeholder",input_form.placeholder??"")
                                .html(input_form.value??"")
                        )
                    }else{
                        $("#crud_master_data_content_"+x).append(
                            $("<input>")
                                .attr("class",input_form.type=="hidden"?"":"form-control mb-2")
                                .attr("type",input_form.type)
                                .attr("id","form_data_"+input_form.name)
                                .attr("name",input_form.name)
                                .attr("placeholder",input_form.placeholder??"")
                                .attr("value",input_form.value??"")
                        );
                    }
                }
            }
        }
    }
    function crud_master_data_onsubmit(e){
        e.preventDefault();
        crud_master_data_process()
        return false;
    }
    async function crud_master_data_process(){
        var form = $('#crud_master_data_content')[0]; // You need to use standard javascript object here
        var formData = new FormData(form);
        if($('#form_data_img').length>0){
            formData.append('img', $('#form_data_img')[0].files[0]); 
        }
        $("#crud_master_data_button").attr("disabled",true);
        $("#crud_master_data_button").html("proses...");
        await $.ajax({
            url:  "<?php echo $base_url; ?>/admin/data/crud_master_data.php",
            data: formData,
            type: 'POST',
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false, // NEEDED, DON'T OMIT THIS
            success: function (data){
                if(data.result=="success"){
                    cariMasterData();
                    $("#crud_master_data").modal("hide");
                }else{
                    alert(data.title??"Error");
                    $("#crud_master_data_button").attr("disabled",false);
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