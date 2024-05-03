<div class="row gy-4 mb-4">
    <!-- Gamification Card -->
    <div class="col-md-12 col-lg-8">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-md-6 order-2 order-md-1">
                    <div class="card-body">
                        <h4 class="card-title pb-xl-2">Selamat Pagi<strong> Admin !</strong>🎉</h4>
                        <p class="mb-0">Kamu memiliki <span class="fw-semibold">68 Nota </span>😎 masuk hari ini.</p>
                        <p>Cek Selengkapnya, klik tombol dibawah ini.</p>
                        <a href="javascript:;" class="btn btn-primary">Selengkapnya</a>
                    </div>
                </div>
                <div class="col-md-6 text-center text-md-end order-1 order-md-2">
                    <div class="card-body pb-0 px-0 px-md-4 ps-0">
                        <img src="../../assets/img/illustrations/illustration-john-light.png" height="180"
                            alt="View Profile" data-app-light-img="illustrations/illustration-john-light.png"
                            data-app-dark-img="illustrations/illustration-john-dark.png" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Gamification Card -->

    <!-- Statistics Total Order -->
    <div class="col-lg-2 col-sm-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                    <div class="avatar">
                        <div class="avatar-initial bg-label-primary rounded">
                            <i class="mdi mdi-cart-plus mdi-24px"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <p class="mb-0 text-success me-1">+22%</p>
                        <i class="mdi mdi-chevron-up text-success"></i>
                    </div>
                </div>
                <div class="card-info mt-4 pt-1 mt-lg-1 mt-xl-4">
                    <h5 class="mb-2">155k</h5>
                    <p class="text-muted mb-lg-2 mb-xl-3">Total Orders</p>
                    <div class="badge bg-label-secondary rounded-pill">Last 4 Month</div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Statistics Total Order -->

    <!-- Sessions line chart -->
    <div class="col-lg-2 col-sm-6">
        <div class="card h-100">
            <div class="card-header pb-0">
                <div class="d-flex align-items-end mb-1 flex-wrap gap-2">
                    <h4 class="mb-0 me-2">$38.5k</h4>
                    <p class="mb-0 text-success">+62%</p>
                </div>
                <span class="d-block mb-2 text-muted">Sessions</span>
            </div>
            <div class="card-body">
                <div id="sessions"></div>
            </div>
        </div>
    </div>
    <!--/ Sessions line chart -->
</div>

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
<script>
    function get_status_invoice() {
        return $("#status_invoice").val();
    }
    $(function () {
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
                    "data": function (d) {
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
                    text: '<i class="mdi mdi-plus me-md-1"></i><span class="d-md-inline-block d-none">Tambah Invoice</span>',
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
        dt_invoice_table.on('draw.dt', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll(
                '[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    boundary: document.body
                });
            });
        });

    });
</script>