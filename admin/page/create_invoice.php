<?php
require_once 'data/koneksi.php'; // Menggunakan file koneksi yang sama
$sift = [];
$siftX = $mysqli->query("select * from sift order by name_sift asc");
while ($row = $siftX->fetch_assoc()) {
    array_push($sift, $row["name_sift"]);
}
?>

<div class="row invoice-preview">
    <div class="col-md-8 col-12 mb-md-0 mb-4">
        <div class="card">
            <div class="card-header">
                <img src="<?php echo $base_url; ?>/assets/img/branding/ZIEDA.png" width=180>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon41"><i class="fa fa-search"></i></span>
                            <input id="search_product_name" type="text" class="form-control" placeholder="Cari Produk"
                                onchange="cariProduk()">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" id="search_product_packages" onchange="cariProduk()">
                            <option value="">Semua Produk</option>
                            <option value="YES">Paket</option>
                            <option value="NO">Bukan Paket</option>
                        </select>

                    </div>
                </div>
                <hr />
                <div class="row" id="search_product_list"></div>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Invoice</h5>
                <button type="button" class="btn btn-sm btn-secondary" onclick="bersihkan()">Bersihkan</button>
            </div>
            <div class="p-2" id="produkDibeli">

            </div>
            <div class="table-responsive">
                <table class="table m-0 table-striped">
                    <tbody>
                        <tr>
                            <td>Order</td>
                            <td id="totalorder" class="text-success">Rp 0</td>
                        </tr>
                        <tr>
                            <td>Bayar</td>
                            <td><input class="form-control" id="totalbayar" type="number" onchange="hitungSemua()"></td>
                        </tr>
                        <tr>
                            <td>Sisa</td>
                            <td id="tagihansisa" class="text-success">Rp 0</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-body">
                <small class="text-small text-muted text-uppercase align-middle">Customer</small>
                <select id="select_customer" class="form-control mb-2"></select>
                <small class="text-small text-muted text-uppercase align-middle">Operator</small>
                <select id="select_operator" class="form-control mb-2"></select>
                <small class="text-small text-muted text-uppercase align-middle">Jatuh Tempo</small>
                <input id="from-datepicker" class="form-control mb-2">
                <small class="text-small text-muted text-uppercase align-middle">Jenis Pengiriman</small>
                <select id="jenis_pengiriman" class="form-control mb-2">
                    <?php
                    foreach ($sift as $s) {
                        echo "<option value='" . $s . "'>" . $s . "</option>";
                    }
                    ?>
                </select>
                <small class="text-small text-muted text-uppercase align-middle">Jam Acara</small>
                <input class="form-control mb-2" id=jam_acara type="time" value="">
                <small class="text-small text-muted text-uppercase align-middle">Catatan</small>
                <textarea id="catatan" class="form-control"></textarea>
            </div>
            <div class="card-footer d-flex">
                <button type="button" onclick="selesaiBuat()" class="btn btn-primary">Buat</button>
                <button type="button" onclick="loadPage('penjualan.php')" class="btn btn-danger ms-2">Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="selesai_buat" tabindex="-1" aria-labelledby="selesai_buat_label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="selesai_buat_label">Konfirmasi Pembuatan Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                Apakah kamu yakin untuk menyimpan data?
            </div>
            <div class="modal-footer">
                <button type="button" onclick="selesaiBuatKonfirmasi()" class="btn btn-primary">Konfirmasi</button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Edit Ulang</button>
                <button type="button" onclick="loadPage('penjualan.php')" class="btn btn-danger"
                    data-bs-dismiss="modal">Kembali Ke Penjualan</button>
            </div>
        </div>
    </div>
</div>

<script>
    $("#select_customer").select2({
        ajax: {
            url: "<?php echo $base_url;?>/admin/data/cari_customer.php",
            type: "GET",
            data: function (params) {

                var queryParameters = {
                    search: params.term
                }
                return queryParameters;
            },
        }
    });
    $("#select_operator").select2({
        ajax: {
            url: "<?php echo $base_url;?>/admin/data/cari_operator.php",
            type: "GET",
            data: function (params) {

                var queryParameters = {
                    search: params.term
                }
                return queryParameters;
            },
        }
    });

    function formatRupiah(angkaX) {
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
            currency: "IDR"
        }).format(angkaX);
    }

    function bersihkan() {
        $("#produkDibeli").html("");
        hitungSemua();
    }

    function hitungSemua() {
        var total = 0;
        $(".product_total").each(function (index) {
            total += $(this).val() * 1;
        })
        $("#totalorder").html(formatRupiah(total));
        total -= $("#totalbayar").val() * 1;
        $("#tagihansisa").html(formatRupiah(total));
    }

    function hitungProduct(id) {
        $("#product_" + id + "_amount_label").html($("#product_" + id + "_amount").val())
        total = $("#product_" + id + "_amount").val() * $("#product_" + id + "_selling_price").val();

        $("#product_" + id + "_total").val(total);
        $("#product_" + id + "_total_label").html(formatRupiah(total))
        hitungSemua();
    }

    function pilihProduct(id) {
        var amountterpilih = $("#product_" + id + "_amount").val();
        if (amountterpilih == null) {
            amountterpilih = 0;
            var productwidget = '' +
                '<div class="w-100 ms-2">' +
                '<small>' + $("#dataproduct_" + id + "_name").val() + '</small>' +
                '<p class="text-xs block" x-text="priceFormat(item.price)">' + formatRupiah($("#dataproduct_" + id +
                    "_selling_price").val()) +
                '</p>' +
                '</div>';
            $("#produkDibeli").append(
                $("<div></div>").attr("id", "product_" + id).attr('class',
                    "product_dibeli bg-light rounded w-100 p-2 mb-2 d-flex justify-content-between").append(
                    $.parseHTML('<img width=64 height=64 class="rounded" src="' + $("#dataproduct_" + id + "_img")
                        .val() + '">'),
                    $.parseHTML(productwidget),
                    $("<input>").attr("id", "product_" + id + "_selling_price")
                    .attr("type", "hidden").val($("#dataproduct_" + id + "_selling_price").val()),
                    $("<input>").attr("id", "product_" + id + "_total")
                    .attr("type", "hidden").attr("class", "product_total"),
                    $("<input>").attr("id",
                        "product_" + id + "_amount")
                    .attr("type", "hidden"),
                    $("<div></div>").attr("class", "btn-group").append(
                        $.parseHTML(
                            '<button type="button" class="btn btn-sm btn-primary btn-icon" ' +
                            'onclick=\'hapusProduk("' + id + '")\'' +
                            '><span class = "fa fa-subtract"> </span></button>'
                        ),
                        $.parseHTML(
                            '<button type="button" class="btn btn-sm btn-white btn-icon" ' +
                            ' id="product_' + id + '_amount_label">1</button>'
                        ),
                        $.parseHTML(
                            '<button type="button" class="btn btn-sm btn-primary btn-icon" ' +
                            'onclick=\'pilihProduct("' + id + '")\'' +
                            '><span class = "fa fa-add"> </span></button>'
                        ),

                    )
                )
            );
        }
        $("#product_" + id + "_amount").val(amountterpilih * 1 + 1)
        hitungProduct(id);
    }

    function hapusProduk(id) {
        var amountterpilih = $("#product_" + id + "_amount").val();
        if (amountterpilih > 1) {
            $("#product_" + id + "_amount").val(amountterpilih * 1 - 1)
            hitungProduct(id);
        } else {
            $("#product_" + id).remove();
        }
    }

    async function cariProduk() {
        $("#search_product_list").html("<tr><td colspan=5>Tidak Ada Produk</td></tr>");
        var name_product = $("#search_product_name").val();
        var packages = $("#search_product_packages").val();
        await $.ajax({
            url: "<?php echo $base_url; ?>/admin/data/cari_produk.php?name_product=" + name_product +
                "&packages=" + packages,
            success: function (resultX) {
                var result = resultX.products;
                $("#search_product_list").html("");
                for (var i = 0; i < result.length; i++) {
                    $("#search_product_list").append(
                        $("<div></div>").attr("class", "col-md-6 mb-2").append(
                            $("<input>").attr("type", "hidden").attr("id", "dataproduct_" +
                                result[
                                    i]
                                .id_product + "_name").attr("value", result[i].name_product),
                            $("<input>").attr("type", "hidden").attr("id", "dataproduct_" +
                                result[
                                    i]
                                .id_product + "_img").attr("value", result[i].img),
                            $("<input>").attr("type", "hidden").attr("id", "dataproduct_" +
                                result[
                                    i]
                                .id_product + "_selling_price").attr("value", result[i]
                                .selling_price),
                            $("<div></div>").attr("class", "card h-100").append(
                                $("<div></div>").attr("class", "card-body d-flex h-100").append(
                                    $("<div></div>").attr("class", "avatar avatar-xl")
                                    .html(
                                        $("<img>").attr("class", "rounded").attr("src",
                                            result[i]
                                            .img),
                                    ), $("<div></div>").attr("class", "ms-2").append(
                                        $("<b></b>").attr("class", "text-success").html(
                                            formatRupiah(
                                                result[
                                                    i].selling_price)),
                                        $("<h5></h5>").attr("class", "text-primary").html(
                                            result[i]
                                            .name_product),
                                        $("<small></small>").html("Package : " +
                                            result[i]
                                            .packages),
                                    ),
                                ),
                                $("<div></div>").attr("class", "card-footer").append(
                                    $("<button></button>").attr("class",
                                        "btn btn-primary")
                                    .attr(
                                        "onclick", "pilihProduct('" + result[i].id_product +
                                        "')")
                                    .html(
                                        "Tambahkan")
                                )
                            )
                        )
                    );
                }
            }
        });
    }
    cariProduk();

    async function hapusProdukKonfirmasi() {
        $("#hapus_produk").modal("hide");
        var id_sales = $("#hapus_produk_id").val();
        await $.ajax({
            url: "<?php echo $base_url; ?>/admin/data/hapus_produk.php?id_sales=" + id_sales,
            success: function (resultX) {
                if (resultX == "success") {
                    refreshPage();
                } else {
                    alert(resultX);
                }
            }
        });
    }

    function selesaiBuat() {
        $("#selesai_buat").modal("show");
    }
    async function selesaiBuatKonfirmasi() {
        $("#selesai_buat").modal("hide");
        var customer = $("#select_customer").val();
        if (customer == null || customer == "") {
            alert("Kustomer belum terisi!");
            return;
        }
        var operator = $("#select_operator").val();
        if (operator == null || operator == "") {
            alert("Operator belum terisi!");
            return;
        }
        var product_dibeli = [];
        $(".product_dibeli").each(function (index) {
            var id = $(this).attr("id").replace("product_", "");
            var amount = $("#product_" + id + "_amount").val();
            product_dibeli.push(id.toString() + ":" + amount.toString())
        })
        var data = {
            "id_customer": customer,
            "operator": operator,
            "catatan": $("#catatan").val(),
            "due_date": $("#from-datepicker").val(),
            "jenis_pengiriman": $("#jenis_pengiriman").val(),
            "jam_acara": $("#jam_acara").val(),
            "totalpay": $("#totalbayar").val(),
            "product_dibeli": product_dibeli.join(",")
        };
        await $.ajax({
            url: "<?php echo $base_url; ?>/admin/data/create_invoice.php",
            data: data,
            method: "post",
            success: function (resultX) {
                var result = resultX.split("|")[0];
                var no_invoice = resultX.split("|")[1];
                if (result == "success" && no_invoice != null) {
                    loadPage("order_detail.php?no_invoice=" + no_invoice);
                } else {
                    alert(resultX);
                }
            }
        });
    }
</script>