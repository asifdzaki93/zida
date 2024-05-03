<div class="nav-align-top mb-4">
    <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
        <li class="nav-item">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-home" aria-controls="navs-pills-justified-home" aria-selected="true">
                <i class="tf-icons mdi  mdi-baguette me-1"></i> Produk
                <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger ms-1">3</span>
            </button>
        </li>
        <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-profile" aria-controls="navs-pills-justified-profile" aria-selected="false">
                <i class="tf-icons mdi mdi-package-variant-closed-check me-1"></i> Paket
            </button>
        </li>
        <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-messages" aria-controls="navs-pills-justified-messages" aria-selected="false">
                <i class="tf-icons mdi mdi-account-outline me-1"></i> Pelanggan
            </button>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
            <table class="invoice-list-table datatables-basic table dt-table dt-responsive display table-striped table-sm" style="width:100%">
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
        <div class="tab-pane fade" id="navs-pills-justified-profile" role="tabpanel">
            <p>
                Donut dragée jelly pie halvah. Danish gingerbread bonbon cookie wafer candy oat cake ice
                cream. Gummies halvah tootsie roll muffin biscuit icing dessert gingerbread. Pastry ice cream
                cheesecake fruitcake.
            </p>
            <p class="mb-0">
                Jelly-o jelly beans icing pastry cake cake lemon drops. Muffin muffin pie tiramisu halvah
                cotton candy liquorice caramels.
            </p>
        </div>
        <div class="tab-pane fade" id="navs-pills-justified-messages" role="tabpanel">
            <p>
                Oat cake chupa chups dragée donut toffee. Sweet cotton candy jelly beans macaroon gummies
                cupcake gummi bears cake chocolate.
            </p>
            <p class="mb-0">
                Cake chocolate bar cotton candy apple pie tootsie roll ice cream apple pie brownie cake. Sweet
                roll icing sesame snaps caramels danish toffee. Brownie biscuit dessert dessert. Pudding jelly
                jelly-o tart brownie jelly.
            </p>
        </div>
    </div>
</div>

<!-- Tabs -->




<script>
    function get_status_invoice() {
        return $("#status_invoice").val();
    }
    $(function() {
        // Variable declaration for table
        var dt_invoice_table = $('.invoice-list-table');

        // Invoice datatable
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
                    "data": function(d) {
                        d.action = "sales_data";
                        d.status = get_status_invoice();
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
                    '<"col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-3"l<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3"B>>' +
                    '<"col-12 col-md-6 d-flex align-items-center justify-content-end flex-column flex-md-row pe-3 gap-md-3"f<"invoice_status mb-3 mb-md-0">>' +
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
                    text: '<i class="mdi mdi-plus me-md-1"></i><span class="d-md-inline-block d-none"> Transaksi</span>',
                    className: 'btn btn-primary',
                    action: function(e, dt, button, config) {
                        alert("Belum ada fitur menambahkan invoice")
                    }
                }],
                // For responsive popup
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function(row) {
                                var data = row.data();
                                return 'Details of ' + data['full_name'];
                            }
                        }),
                        type: 'column',
                        renderer: function(api, rowIdx, columns) {
                            var data = $.map(columns, function(col, i) {
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
                initComplete: function() {
                    var column = this;
                    var select = $(
                            '<select id="status_invoice" class="form-select"><option value=""> Cari Status </option></select>'
                        )
                        .appendTo('.invoice_status').on('change', function() {
                            dt_invoice.ajax.reload();
                        });
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
        }
        // On each datatable draw, initialize tooltip
        dt_invoice_table.on('draw.dt', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll(
                '[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    boundary: document.body
                });
            });
        });

    });
</script>