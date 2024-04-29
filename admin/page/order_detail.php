<?php
require_once 'data/koneksi.php'; // Menggunakan file koneksi yang sama
include "data/produksi2.php";
$data = getOrderData($mysqli);
$order = $data["orderDetails"];
$products = $data["products"];
$note = explode(", ", $order["note"]);
$status_tagihan = $order["totalpay"] >= $order["totalorder"] ? "Lunas" : "Belum Lunas";
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
                        <tr>
                            <td class="text-nowrap" colspan=2><b><?php echo $products["name_product"]; ?></b></td>
                            <td class="text-nowrap">
                                <b>
                                    <?php echo "Rp " . number_format($products["price"], 0, ',', '.'); ?>
                                </b>
                            </td>
                            <td class="text-nowrap"><b><?php echo $products["amount"]; ?></b></td>
                            <td class="text-nowrap">
                                <b>
                                    <?php echo "Rp " . number_format($products["totalprice"], 0, ',', '.'); ?>
                                </b>
                            </td>
                        </tr>
                        <?php
                        if (isset($products["childproduct"]))
                            foreach ($products["childproduct"] as $cp) {
                        ?>

                            <tr>
                                <td class="text-nowrap" colspan=2>- <?php echo $cp["name_product"]; ?></td>
                                <td class="text-nowrap"></td>
                                <td class="text-nowrap"><?php echo $cp["amount"]; ?></td>
                                <td class="text-nowrap"></td>
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
                                <p class="fw-semibold mb-2 text-end">
                                    <?php echo "Rp " . number_format($order["totalorder"], 0, ',', '.'); ?>
                                </p>
                                <p class="fw-semibold mb-2 text-end">
                                    <?php echo "Rp " . number_format($order["totalpay"], 0, ',', '.'); ?>
                                </p>
                                <p class="fw-semibold mb-0 text-end <?php echo $status_tagihan == "Lunas" ? "" : "text-danger" ?>">
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
                <button class="btn btn-primary d-grid w-100 mb-3 waves-effect waves-light" data-bs-toggle="offcanvas" data-bs-target="#sendInvoiceOffcanvas">
                    <span class="d-flex align-items-center justify-content-center text-nowrap"><i class="mdi mdi-send-outline scaleX-n1-rtl me-1"></i>Send Invoice</span>
                </button>
                <button class="btn btn-outline-secondary d-grid w-100 mb-3 waves-effect">Download</button>
                <a class="btn btn-outline-secondary d-grid w-100 mb-3 waves-effect" target="_blank" href="./app-invoice-print.html">
                    Print
                </a>
                <a href="./app-invoice-edit.html" class="btn btn-outline-secondary d-grid w-100 mb-3 waves-effect">
                    Edit Invoice
                </a>
                <button class="btn btn-success d-grid w-100 waves-effect waves-light" data-bs-toggle="offcanvas" data-bs-target="#addPaymentOffcanvas">
                    <span class="d-flex align-items-center justify-content-center text-nowrap"><i class="mdi mdi-currency-usd me-1"></i>Add Payment</span>
                </button>
            </div>
        </div>
    </div>
    <!-- /Invoice Actions -->
</div>