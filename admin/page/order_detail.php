<?php
require_once 'data/koneksi.php'; // Menggunakan file koneksi yang sama
include "data/produksi2.php";
$data = getOrderData($mysqli);
$order = $data["orderDetails"];
$products = $data["products"];
$note = explode(", ", $order["note"]);
$status_tagihan = $order["totalpay"] >= $order["totalorder"] ? "Lunas" : "Belum Lunas";
$editing = ($_GET["editing"]??"")=="true";
?>

<div class="row invoice-preview">
    <!-- Invoice -->
    <div class="col-xl-9 col-md-8 col-12 mb-md-0 mb-4">
        <div class="card invoice-preview-card">
            <div class="card-body">
                <div class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column">
                    <div class="mb-xl-0 pb-3">
                        <div class="d-flex svg-illustration align-items-center gap-2 mb-4">
                            <img src="<?php echo $base_url; ?>assets//img/branding/ZIEDA.png" width=180>
                            <span class="h4 mb-0 app-brand-text fw-bold"></span>
                        </div>
                        <p class="mb-1">Jl. Jambian 21 Kelurahan Sokorejo, Kecamatan Limpung</p>
                        <p class="mb-1">Kab. Batang, Jawa Tengah-Indonesia.</p>
                        <p class="mb-0">ziedabakeryandcake@gmail.com, 082322345757</p>
                    </div>
                    <div>
                        <input type=hidden id=no_invoice value="<?php echo $order["no_invoice"]; ?>">
                        <h5>INVOICE <?php echo $order["no_invoice"]; ?></h5>
                        <div class="mb-1">
                            <span>Pemesanan:</span>
                            <span><?php echo $order["date"]; ?></span>
                        </div>
                        <div>
                            <span>Pengiriman:</span>
                            <span><?php echo $order["due_date"]; ?></span>
                        </div>
                        <div>
                            <?php echo $note[1] ?? ""; ?>
                        </div>
                        <div>
                            <?php echo $note[0] ?? ""; ?>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-0">
            <div class="card-body">
                <div class="d-flex justify-content-between flex-wrap">
                    <div class="col-6">
                        <h6 class="pb-2">Kepada Yth:</h6>
                        <p class="mb-1"><?php echo $order["customer_name"]; ?></p>
                        <p class="mb-1"><?php echo $order["customer_address"]; ?></p>
                        <p class="mb-1"><?php echo $order["customer_telephone"]; ?></p>
                    </div>
                    <div class="col-6">
                        <h6 class="pb-2">Pembayaran:</h6>
                        <table>
                            <tbody>
                                <tr>
                                    <td class="pe-3 fw-medium">Tagihan:</td>
                                    <td><?php echo "Rp " . number_format($order["totalorder"], 0, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td class="pe-3 fw-medium">Status Tagihan:</td>
                                    <td class="<?php echo $status_tagihan == "Lunas" ? "" : "text-danger" ?>">
                                        <?php echo $status_tagihan; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pe-3 fw-medium">Operator:</td>
                                    </td>
                                    <td><?php echo $order["operator"]; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table m-0">
                    <thead class="table-light border-top">
                        <tr>
                            <th colspan=2>Item</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($products as $product) {
                        ?>
                        <tr>
                            <td class="text-nowrap" width=2>
                                <?php
                                if($editing){
                                ?>
                                <button onclick="hapusProduk('<?php echo $product["id_sales"];?>')"
                                    class="btn btn-icon btn-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                                <?php
                                }
                                ?>
                                <div class='avatar avatar-md' style="display:inline-grid">
                                    <a href="<?php echo $product["img"]; ?>" target=_blank>
                                        <img class='rounded-circle' src="<?php echo $product["img"]; ?>" />
                                    </a>
                                </div>
                            <td class="text-left" style="padding-left:0;">
                                <b id="product_<?php echo $product["id_sales"];?>_name">
                                    <?php echo $product["name_product"]; ?>
                                </b>
                            </td>
                            <td class="text-nowrap">
                                <b>
                                    <?php echo "Rp " . number_format($product["price"], 0, ',', '.'); ?>
                                </b>
                            </td>
                            <td class="text-nowrap">
                                <?php
                                if($editing){
                                ?>
                                <input type=hidden id="product_<?php echo $product["id_sales"];?>_price"
                                    value="<?php echo $product["price"];?>">
                                <input type=number onchange="hitungHarga('<?php echo $product["id_sales"];?>')"
                                    class="form-control" name="product_<?php echo $product["id_sales"];?>_amount"
                                    id="product_<?php echo $product["id_sales"];?>_amount"
                                    value="<?php echo $product["amount"]; ?>">
                                <?php
                                }else{
                                ?>
                                <b><?php echo $product["amount"]; ?></b>
                                <?php
                                }
                                ?>
                            </td>
                            <td class="text-nowrap">
                                <input type=hidden class="product_totalprice"
                                    id="product_<?php echo $product["id_sales"];?>_totalprice"
                                    value="<?php echo $product["totalprice"];?>">
                                <b id="product_<?php echo $product["id_sales"];?>_totalprice_formated">
                                    <?php echo "Rp " . number_format($product["totalprice"], 0, ',', '.'); ?>
                                </b>
                            </td>
                        </tr>
                        <?php
                        if (isset($product["childproduct"]))
                            foreach ($product["childproduct"] as $cp) {
                        ?>

                        <tr>
                            <td class="text-nowrap" colspan=2>- <?php echo $cp["name_product"]; ?></td>
                            <td class="text-nowrap">
                                <input id="childproduct_<?php echo $cp["id_packagesproduct"]; ?>_perpaket" type=hidden
                                    value="<?php echo $cp["perpaket"]; ?>">
                            </td>
                            <td class="text-nowrap childproduct_<?php echo $product["id_sales"];?>_amount"
                                id="childproduct_<?php echo $cp["id_packagesproduct"]; ?>_amount">
                                <?php echo $cp["amount"]; ?>
                            </td>
                            <td class="text-nowrap"></td>
                        </tr>
                        <?php
                            }
                        }
                        if($editing){
                        ?>
                        <tr>
                            <td colspan=2>
                                <button type="button" class="btn btn-primary waves-effect waves-light"
                                    data-bs-toggle="modal" data-bs-target="#tambah_produk">
                                    <i class="mdi mdi-plus me-1"></i> Tambah Produk
                                </button>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <td colspan="3" class="align-top px-4 py-5">
                                <p class="mb-2">
                                    <span class="me-1 fw-semibold">Operator :</span>
                                    <span><?php echo $order["operator_name"]; ?></span>
                                </p>
                                <span>Terima kasih. kami tunggu belanja anda kembali</span>
                            </td>
                            <td class="text-end px-4 py-5">
                                <p class="mb-2">Total:</p>
                                <p class="mb-2">Dibayar:</p>
                                <p class="mb-0">Tagihan:</p>
                            </td>
                            <td class="px-4 py-5">
                                <input type=hidden id=totalorder value="<?php echo $order["totalorder"];?>">
                                <p class="fw-semibold mb-2 text-nowrap text-end" id=totalorder_formated>
                                    <?php echo "Rp " . number_format($order["totalorder"], 0, ',', '.'); ?> </p>
                                <input type=hidden id=totalpay value="<?php echo $order["totalpay"];?>">
                                <p class="fw-semibold mb-2 text-nowrap text-end">
                                    <?php echo "Rp " . number_format($order["totalpay"], 0, ',', '.'); ?>
                                </p>
                                <p id=totalsubtract
                                    class="fw-semibold mb-0 text-nowrap text-end <?php echo $status_tagihan == "Lunas" ? "" : "text-danger" ?>">
                                    <?php echo "Rp " . number_format($order["totalpay"] - $order["totalorder"], 0, ',', '.'); ?>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <span class="fw-bold">Catatan :</span>
                        <span><?php echo str_replace("Catatan : ", "", $note[2]) ?? ""; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Invoice -->

    <!-- Invoice Actions -->
    <div class="col-xl-3 col-md-4 col-12 invoice-actions">
        <div class="card">
            <div class="card-body">
                <button class="btn btn-primary d-grid w-100 mb-3 waves-effect waves-light" data-bs-toggle="offcanvas"
                    data-bs-target="#sendInvoiceOffcanvas">
                    <span class="d-flex align-items-center justify-content-center text-nowrap"><i
                            class="mdi mdi-send-outline scaleX-n1-rtl me-1"></i>Send Invoice</span>
                </button>
                <!-- <button class="btn btn-outline-secondary d-grid w-100 mb-3 waves-effect">Download</button> -->
                <a class="btn btn-outline-secondary d-grid w-100 mb-3 waves-effect" target="_blank"
                    href="cetak_invoice.php?no_invoice=<?php echo $_GET["no_invoice"]??''?>">
                    Cetak
                </a>
                <a href="./app-invoice-edit.html" class="btn btn-outline-secondary d-grid w-100 mb-3 waves-effect">
                    Edit Invoice
                </a>
                <button class="btn btn-success d-grid w-100 waves-effect waves-light" data-bs-toggle="offcanvas"
                    data-bs-target="#addPaymentOffcanvas">
                    <span class="d-flex align-items-center justify-content-center text-nowrap"><i
                            class="mdi mdi-currency-usd me-1"></i>Add Payment</span>
                </button>
            </div>
        </div>
    </div>
    <!-- /Invoice Actions -->
</div>

<!-- Modal -->
<div class="modal fade" id="tambah_produk" tabindex="-1" aria-labelledby="tambah_produk_label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambah_produk_label">Tambah Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
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
            </div>
            <div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th colspan=2>
                                Produk
                            </th>
                            <th>
                                Harga
                            </th>
                            <th>
                                Paket
                            </th>
                            <th>
                                Pilih
                            </th>
                        </tr>
                    </thead>
                    <tbody id="search_product_list">
                        <tr>
                            <td colspan=5>Tidak Ada Produk</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="hapus_produk" tabindex="-1" aria-labelledby="hapus_produk_label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hapus_produk_label">Hapus Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <input id=hapus_produk_id type=hidden>
                Apakah kamu yakin untuk menghapus <b id="hapus_produk_nama"></b> dari daftar?
            </div>
            <div class="modal-footer">
                <button type="button" onclick="hapusProdukKonfirmasi()" class="btn btn-primary"
                    data-bs-dismiss="modal">Konfirmasi</button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<script>
    function formatRupiah(angka) {
        var tag = "Rp ";
        if (angka < 0) {
            angka *= -1;
            tag = "Rp -";
        }
        var number_string = angka.toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return tag + rupiah;
    }

    function hitungHarga(id) {
        var amount = $("#product_" + id + "_amount").val();
        $("#product_" + id + "_totalprice").val($("#product_" + id + "_price").val() * amount);
        $("#product_" + id + "_totalprice_formated").html(formatRupiah($("#product_" + id + "_totalprice").val()));
        $(".childproduct_" + id + "_amount").each(function (index) {
            var childid = $(this).attr("id");
            childid = childid.replace("_amount", "");
            $("#" + childid + "_amount").html($("#" + childid + "_perpaket").val() * amount);
        })
        hitungHargaAll();
    }

    function hitungHargaAll() {
        var totalorder = 0;
        $(".product_totalprice").each(function (index) {
            totalorder += $(this).val();
        })
        $("#totalorder").val(totalorder);
        $("#totalorder").html(formatRupiah(totalorder));
        $("#totalsubtract").html(formatRupiah($("#totalpay").val() - totalorder));
    }

    async function cariProduk() {
        $("#search_product_list").html("<tr><td colspan=5>Tidak Ada Produk</td></tr>");
        var name_product = $("#search_product_name").val();
        var packages = $("#search_product_packages").val();
        await $.ajax({
            url: "<?php echo $base_url;?>/admin/data/cari_produk.php?name_product=" + name_product +
                "&packages=" + packages,
            success: function (resultX) {
                var result = resultX.products;
                $("#search_product_list").html("");
                for (var i = 0; i < result.length; i++) {
                    $("#search_product_list").append(
                        $("<tr></tr>").append(
                            $("<td></td>").html(
                                $("<div></div>").attr("class", "avatar avatar-md").html(
                                    $("<a></a>").attr("target", "_blank").attr("href", result[i]
                                        .img)
                                    .html(
                                        $("<img>").attr("class", "rounded-circle").attr("src",
                                            result[i]
                                            .img)
                                    )
                                )
                            ),
                            $("<td></td>").append(result[i].name_product),
                            $("<td></td>").attr("class", "text-nowrap").append(formatRupiah(result[
                                i].selling_price)),
                            $("<td></td>").append(result[i].packages),
                            $("<td></td>").html(
                                $("<button></button>").attr("class", "btn btn-primary").attr(
                                    "onclick", "pilihProduct('" + result[i].id_product + "')").html(
                                    "+")
                            ),
                        )
                    );
                }
            }
        });
    }
    cariProduk();

    async function pilihProduct(id) {
        $("#tambah_produk").modal("hide");
        var no_invoice = $("#no_invoice").val();
        await $.ajax({
            url: "<?php echo $base_url;?>/admin/data/tambah_produk.php?no_invoice=" + no_invoice +
                "&id_product=" + id,
            success: function (resultX) {
                if (resultX == "success") {
                    refreshPage();
                } else {
                    alert(resultX);
                }
            }
        });
    }

    function hapusProduk(id) {
        $("#hapus_produk").modal("show");
        $("#hapus_produk_id").val(id);
        $("#hapus_produk_nama").html($("#product_" + id + "_name").html());
    }
    async function hapusProdukKonfirmasi() {
        $("#hapus_produk").modal("hide");
        var id_sales = $("#hapus_produk_id").val();
        await $.ajax({
            url: "<?php echo $base_url;?>/admin/data/hapus_produk.php?id_sales=" + id_sales,
            success: function (resultX) {
                if (resultX == "success") {
                    refreshPage();
                } else {
                    alert(resultX);
                }
            }
        });
    }
</script>