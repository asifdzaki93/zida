<?php
include "data/koneksi.php";
include "data/nota_admin.php";
include "data/base_sistem.php";
nota_admin_render($mysqli, $base_url);
?>
<div class="card">
    <div class="card-datatable table-responsive pt-0">
        <table class="invoice-list-table datatables-basic table dt-table dt-responsive display table-striped table-sm"
            style="width:100%">
            <thead>
                <tr>
                    <th></th>
                    <th>#Invoice</th>
                    <th><i class="mdi mdi-trending-up"></i></th>
                    <th>Kostumer</th>
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
</div>

<!-- Modal -->
<div class="modal fade" id="modal_cetak_resi" tabindex="-1" aria-labelledby="modal_cetak_resi_label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_cetak_resi_label">Konfirmasi Mencetak Resi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                Apakah kamu yakin untuk mencetak <b id="modal_cetak_resi_no_invoice"></b>?
            </div>
            <div class="modal-footer">
                <a target=_blank id="modal_cetak_resi_resi" onclick="$('#modal_cetak_resi').modal('hide')"
                    class="btn btn-primary">Cetak Resi</a>
                <a target=_blank id="modal_cetak_resi_invoice" onclick="$('#modal_cetak_resi').modal('hide')"
                    class="btn btn-primary">Cetak Invoice</a>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_selesai_produksi" tabindex="-1" aria-labelledby="modal_selesai_produksi_label"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_selesai_produksi_label">Konfirmasi Mencetak Resi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                Apakah anda suddah mengkonfirmasi bahwa produk <b id="modal_selesai_produksi_no_invoice"></b> sudah
                selesai di produksi?
            </div>
            <div class="modal-footer">
                <button target=_blank onclick="selesaiProduksiKonfirmasi()" class="btn btn-primary">
                    Ok
                </button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_pelunasan" tabindex="-1" aria-labelledby="modal_pelunasan_label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_pelunasan_label">Konfirmasi Pelunasan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                apakah anda sudah menerima dan menghitung ulang pembayaran piutang tersebut?
                silahkan masukkan nominal uang masuk !
            </div>
            <div class="table-responsive">
                <table class="table table-stripped">
                    <thead>
                        <tr>
                            <th></th>
                            <th>NO Invoice</th>
                            <th>Customer</th>
                            <th>Total Order</th>
                            <th>Nominal</th>
                        </tr>
                    </thead>
                    <tbody id="modal_pelunasan_list">
                        <tr>
                            <th><i class="fa fa-spinner"></i></th>
                            <th>NO Invoice</th>
                            <th>Customer</th>
                            <th>Total Order</th>
                            <th>Nominal</th>
                        </tr>
                        <tr>
                            <th><i class="fa fa-check"></i></th>
                            <th>NO Invoice</th>
                            <th>Customer</th>
                            <th>Total Order</th>
                            <th>Nominal</th>
                        </tr>
                        <tr>
                            <th><i class="fa fa-cancel"></i></th>
                            <th>NO Invoice</th>
                            <th>Customer</th>
                            <th>Total Order</th>
                            <th>Nominal</th>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button target=_blank onclick="pelunasanKonfirmasi()" class="btn btn-primary">
                    Ok
                </button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<script>
    sidebarBuka("penjualan", "sistem");

    var dt_invoice = null;
    var selected_invoice = {};

    function select_invoice(no_invoice) {
        if (selected_invoice.hasOwnProperty(no_invoice)) {
            delete selected_invoice[no_invoice];
        } else {
            selected_invoice[no_invoice] = {
                "no_invoice": no_invoice,
                "customer": $("#customer_" + no_invoice).val(),
                "totalorder": $("#totalorder_" + no_invoice).val(),
                "tagihan": $("#tagihan_" + no_invoice).val()
            }
        }
        var selected_invoice_count = Object.keys(selected_invoice).length;
        if (selected_invoice_count == 0) {
            $("#selected_invoice_count").html("");
        } else {
            $("#selected_invoice_count").html("(" + selected_invoice_count + ")");
        }
    }

    var pelunasan_object = {};

    function pelunasan() {
        $("#modal_pelunasan_list").html("");
        pelunasan_object = selected_invoice;
        pelunasan_list = Object.values(pelunasan_object);
        for (var i = 0; i < pelunasan_list.length; i++) {
            $("#modal_pelunasan_list").append(
                $("<tr></tr>").attr("id", "pelunasan_list_" + pelunasan_list[i].no_invoice).append(
                    $("<td></td>").attr("id", "pelunasan_list_" + pelunasan_list[i].no_invoice + "_status"),
                    $("<td></td>").html(pelunasan_list[i].no_invoice),
                    $("<td></td>").html(pelunasan_list[i].customer),
                    $("<td></td>").html(pelunasan_list[i].totalorder),
                    $("<td></td>").attr("id", "pelunasan_list_" + pelunasan_list[i].no_invoice + "_form").html(
                        $("<input>").attr("class", "form-control").attr("type", "number")
                        .attr("id", "pelunasan_list_" + pelunasan_list[i].no_invoice + "_tagihan")
                        .attr("value", "0")
                    ),
                )
            );
        }
        $("#modal_pelunasan").modal("show");
    }

    async function pelunasanKonfirmasi() {
        pelunasan_list = Object.values(pelunasan_object);
        for (var i = 0; i < pelunasan_list.length; i++) {
            await prosesPelunasan(pelunasan_list[i].no_invoice);
        }
        dt_invoice.ajax.reload();
        if (Object.values(pelunasan_object).length == 0) {
            $("#modal_pelunasan").modal("hide");
        }
    }
    async function prosesPelunasan(no_invoice) {
        if (!pelunasan_object.hasOwnProperty(no_invoice)) {
            $('#pelunasan_list_' + no_invoice).remove();
            return;
        }
        var nominal = $("#pelunasan_list_" + no_invoice + "_tagihan").val();
        if (nominal != pelunasan_object[no_invoice].tagihan) {
            $('#pelunasan_list_' + no_invoice + "_status")
                .html('<td><i class="fa fa-cancel"></i></th>');
            alert("Nominal " + no_invoice + " tidak sesuai dengan sisa tagihan");
            return;
        }
        var data = {
            "catatan": "",
            "nominal": nominal,
            "no_invoice": no_invoice
        };
        await $.ajax({
            url: "<?php echo $base_url; ?>/admin/data/add_payment.php",
            data: data,
            method: "post",
            success: function (resultX) {
                if (resultX == "success") {
                    $('#pelunasan_list_' + no_invoice).remove();
                    delete pelunasan_object[no_invoice];
                } else {
                    $('#pelunasan_list_' + no_invoice + "_status")
                        .html('<td><i class="fa fa-cancel"></i></th>');
                    alert(resultX);
                }
            }
        });
    }


    function cetakResi() {
        $("#modal_cetak_resi_no_invoice").html(Object.keys(selected_invoice).join(", "))
        $("#modal_cetak_resi_resi").attr("href", "<?php echo $base_url ?>admin/cetak_resi.php?no_invoice=" +
            Object.keys(selected_invoice).join(","))
        $("#modal_cetak_resi_invoice").attr("href", "<?php echo $base_url ?>admin/cetak_invoice.php?no_invoice=" +
            Object.keys(selected_invoice).join(","))
        $("#modal_cetak_resi").modal("show");
    }

    function selesaiProduksi() {
        $("#modal_selesai_produksi").modal("show");
        $("#modal_selesai_produksi_no_invoice").html(Object.keys(selected_invoice).join(", "));
    }

    async function selesaiProduksiKonfirmasi() {
        $("#modal_selesai_produksi").modal("hide");
        var no_invoice = Object.keys(selected_invoice).join(",");
        var data = {
            "no_invoice": no_invoice
        };
        await $.ajax({
            url: "<?php echo $base_url; ?>/admin/data/selesai_produksi.php",
            data: data,
            method: "post",
            success: function (resultX) {
                if (resultX == "success") {
                    dt_invoice.ajax.reload();
                } else {
                    alert(resultX);
                }
            }
        });
    }

    $(function () {
        // Variable declaration for table
        var dt_invoice_table = $('.invoice-list-table');

        // Invoice datatable
        if (dt_invoice_table.length) {
            dt_invoice = dt_invoice_table.DataTable({
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
                        "targets": 4
                    },
                    {
                        "className": "dt-left",
                        "targets": 3
                    },
                    {
                        "className": "dt-center",
                        "targets": 6
                    },
                    {
                        "responsivePriority": 1,
                        targets: 0
                    },
                    {
                        "responsivePriority": 2,
                        targets: 1
                    },
                    {
                        "responsivePriority": 3,
                        targets: 2
                    },
                    {
                        "responsivePriority": 14,
                        targets: 3
                    },
                    {
                        "responsivePriority": 5,
                        targets: 4
                    },
                    {
                        "responsivePriority": 6,
                        targets: 5
                    },
                    {
                        "className": "text-nowrap",
                        "targets": 4
                    },
                    {
                        "className": "text-nowrap",
                        "targets": 6
                    },
                ],
                ajax: {
                    "url": "<?php echo $base_url; ?>/admin/data/history.php",
                    "data": function (d) {
                        d.action = "sales_data";
                        d.status = $("#status_invoice").val();
                        d.date = $("#filter_tanggal").val();
                    },
                    "type": "POST"
                },
                columns: [{
                        "data": "checkbox"
                    },
                    {
                        "data": "no_invoice"
                    },
                    {
                        "data": "trend"
                    },
                    {
                        "data": "customer"
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
                    '<"col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-3"l<"dt-action-buttons invoice_aksi d-flex text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3"B>>' +
                    '<"col-12 col-md-6 d-flex align-items-center justify-content-end flex-column flex-md-row pe-3 gap-md-3"f<"invoice_status d-flex mb-3 mb-md-0">>' +
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
                // Buttons with Dropdown
                buttons: [{
                    text: '<i class="mdi mdi-plus me-md-1"></i><span class="d-lg-inline-block d-none"> Transaksi</span>',
                    className: 'btn btn-primary',
                    action: function (e, dt, button, config) {
                        alert("Belum ada fitur menambahkan invoice")
                    }
                }],
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
                    $('<div></div>').attr('class', "dropdown ms-2 d-grid").html(
                        '<button type="button" class="btn btn-primary dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
                        '<i class="mdi mdi-dots-vertical"></i> <span class="d-lg-inline-block d-none"> Aksi</span><b class="ms-1" id=selected_invoice_count></b>' +
                        '</button>' +
                        '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">' +
                        '<a class="dropdown-item" href="javascript:;" onclick="cetakResi()">Cetak Resi</a>' +
                        '<a class="dropdown-item" href="javascript:;" onclick="pelunasan()">Pelunasan</a>' +
                        '<a class="dropdown-item" href="javascript:;" onclick="selesaiProduksi()">Selesai Produksi</a>' +
                        '</div>').appendTo('.invoice_aksi');
                }
            });
        }
        // On each datatable draw, initialize tooltip
        dt_invoice_table.on('draw.dt', function () {

            var tooltipTriggerList = [].slice.call(document.querySelectorAll(
                '[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    boundary: document.body
                });
            });
            $(".checkbox_invoice").each(function (index) {
                var no_invoice = $(this).val();
                if (selected_invoice.hasOwnProperty(no_invoice)) {
                    $(this).prop('checked', true);
                }
            })

        });
    });
</script>