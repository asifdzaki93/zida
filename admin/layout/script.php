<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="<?php echo $base_url; ?>/assets/vendor/libs/jquery/jquery.js"></script>
<script src="<?php echo $base_url; ?>/assets/vendor/libs/popper/popper.js"></script>
<script src="<?php echo $base_url; ?>/assets/vendor/js/bootstrap.js"></script>
<script src="<?php echo $base_url; ?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="<?php echo $base_url; ?>/assets/vendor/libs/node-waves/node-waves.js"></script>

<script src="<?php echo $base_url; ?>/assets/vendor/libs/hammer/hammer.js"></script>
<script src="<?php echo $base_url; ?>/assets/vendor/libs/i18n/i18n.js"></script>
<script src="<?php echo $base_url; ?>/assets/vendor/libs/typeahead-js/typeahead.js"></script>

<script src="<?php echo $base_url; ?>/assets/vendor/js/menu.js"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="<?php echo $base_url; ?>/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="<?php echo $base_url; ?>/assets/vendor/libs/apex-charts/apexcharts.js"></script>
<script src="<?php echo $base_url; ?>/assets/vendor/libs/chartjs/chartjs.js"></script>
<script src="<?php echo $base_url; ?>/assets/vendor/libs/swiper/swiper.js"></script>
<script src="<?php echo $base_url; ?>/assets/vendor/libs/flatpickr/flatpickr.js"></script>

<!-- Main JS -->
<script src="<?php echo $base_url; ?>/assets/js/main.js"></script>

<!-- Page JS -->
<!-- <script src="<?php echo $base_url; ?>/assets/js/dashboards-crm.js"></script> -->

<script src="<?php echo $base_url; ?>/admin/js/home.js?v=2"></script>
<script src="<?php echo $base_url; ?>/admin/js/penagihan.js?v=2"></script>

<script>
    var base_url = "<?php echo $base_url;?>";
    var try_routing_last = window.location.pathname + window.location.search;
    var try_routing = false;
    var tambah_history = "";
    async function menambah_history() {
        if ((window.location.pathname + window.location.search) != tambah_history) {
            await window.history.pushState('page2', 'Title', tambah_history);
        }
    }
    window.onpopstate = function (event) {
        var pageURL = window.location.href;
        var lastURLSegment = pageURL.substr(pageURL.lastIndexOf('/') + 1);
        loadPage(lastURLSegment);
    }
    async function loadPage(page) {
        await $.ajax({
            url: "jquery_page.php?page=" + page.replace("?", "&"),
            success: function (result) {
                $("#jquery_page").html(result);
            }
        });
        tambah_history = page;
        menambah_history();
        // Initialize chart with monthly data
        updateChart('monthly');

        // Call the function to update performance initially
        updatePerformance('monthly');
        penagihan();
        loadPenjualan();
        loadProduksi(base_url + "admin/data/kirim_hari_ini.php?" + page.split("?")[1]);
        loadHome();
        var flatpickrDate = document.querySelector("#from-datepicker");
        flatpickrDate.flatpickr({
            monthSelectorType: "static"
        });
    };
    var pageURL = window.location.href;
    var lastURLSegment = pageURL.substr(pageURL.lastIndexOf('/') + 1);
    loadPage(lastURLSegment);
</script>

<!-- Page Produksi daftar penjualan -->
<script>
    function loadPenjualan() {

        $('#history').DataTable({
            "order": [
                [0, 'desc']
            ],
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ordering": true,
            "stateSave": true,
            "columnDefs": [{
                    "className": "dt-left",
                    "targets": 2
                },
                {
                    "className": "dt-left",
                    "targets": 3
                },
                {
                    "className": "dt-center",
                    "targets": 4
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
                }
            ],
            "ajax": {
                "url": "<?php echo $base_url; ?>/admin/data/history.php?action=sales_data&user=082322345757",
                "dataType": "json",
                "type": "POST"
            },
            "columns": [{
                    "data": "no"
                },
                {
                    "data": "aksi"
                },
                {
                    "data": "due_date"
                },
                {
                    "data": "status"
                },
                {
                    "data": "totalorder"
                },
                {
                    "data": "note"
                },
                {
                    "data": "image"
                }
            ],
            "buttons": ['pdf', 'excel']
        });
    }

    function loadProduksi(url) {
        $('#kirim_hari_ini').DataTable({
            "order": [
                [0, 'asc']
            ],
            "ajax": {
                "dataSrc": 'orderDetails',
                "url": url,
                "dataType": "json",
            },
            "columns": [{
                    "data": "no"
                },
                {
                    "data": "no_invoice"
                },
                {
                    "data": "costumer"
                },
                {
                    "data": "status"
                },
                {
                    "data": "totalorder"
                },
                {
                    "data": "alamat"
                },
                {
                    "data": "aksi"
                },
            ],
        });
        var productsTable = $('#kirim_hari_ini_products').DataTable({
            "order": [
                [0, 'asc']
            ],
            "ajax": {
                "dataSrc": 'products',
                "url": url,
                "dataType": "json",
            },
            "columns": [{
                    className: 'dt-control',
                    orderable: false,
                    data: null,
                    defaultContent: ''
                },
                {
                    "data": "name_product"
                },
                {
                    "data": "img",
                    "render": function (data) {
                        return "<div class='avatar avatar-md me-2'><a href='" + data +
                            "'><img class='rounded-circle' src='" +
                            data + "'/></a></div>";
                    }
                },
                {
                    "data": "amount"
                }
            ],
        });
        productsTable.on('click', 'td.dt-control', function (e) {
            let tr = e.target.closest('tr');
            let row = productsTable.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
            } else {
                // Open this row
                row.child(row.data().invoices).show();
            }
        });
    };

    function produksiChange(e) {
        e.preventDefault();
        var form = $('#produksiFilter')[0];
        var data = new FormData(form);
        var u = new URLSearchParams(data).toString();
        loadPage("produksi.php?" + u);
        return false;
    }
</script>

<script>
    function openInvoice(noInvoice) {
        window.location.href = 'https://pro.kasir.vip/pdf/invoice.php?no_invoice=' + noInvoice;
    }

    function openMaterials(noInvoice) {
        window.location.href = 'https://pro.kasir.vip/pdf/material.php?no_invoice=' + noInvoice;
    }
</script>

<!-- Page Produksi pojok kanan atas -->
<script>
    // Ensure that the document is fully loaded before initializing the chart
    document.addEventListener("DOMContentLoaded", function () {
        const sessionsChartEl = document.querySelector('#sessions');
        if (sessionsChartEl) {
            const sessionsChartConfig = {
                chart: {
                    height: 102,
                    type: 'line',
                    parentHeightOffset: 0,
                    toolbar: {
                        show: false
                    }
                },
                grid: {
                    borderColor: '#D1D5DB', // Sesuaikan dengan warna yang ada di CSS Anda
                    strokeDashArray: 6,
                    xaxis: {
                        lines: {
                            show: true
                        }
                    },
                    yaxis: {
                        lines: {
                            show: false
                        }
                    },
                    padding: {
                        top: -15,
                        left: -7,
                        right: 7,
                        bottom: -15
                    }
                },
                colors: ['#00B4D8'], // Warna garis, sesuaikan dengan kebutuhan Anda
                stroke: {
                    width: 3
                },
                series: [{
                    data: [0, 20, 5, 30, 15, 45, 25] // 7 data points
                }],
                markers: {
                    size: 6,
                    colors: ['transparent'],
                    strokeColors: 'transparent',
                    strokeWidth: 3,
                    hover: {
                        size: 7
                    },
                    discrete: [{
                        seriesIndex: 0,
                        dataPointIndex: 6,
                        fillColor: '#ffffff', // Sesuaikan dengan warna yang ada di CSS Anda
                        strokeColor: '#00B4D8', // Harus sama dengan warna garis
                        size: 6,
                        shape: 'circle'
                    }]
                },
                xaxis: {
                    labels: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    axisBorder: {
                        show: false
                    }
                },
                yaxis: {
                    labels: {
                        show: false
                    }
                },
                tooltip: {
                    enabled: false
                },
                responsive: [{
                        breakpoint: 1441,
                        options: {
                            chart: {
                                height: 70
                            }
                        }
                    },
                    {
                        breakpoint: 1310,
                        options: {
                            chart: {
                                height: 90
                            }
                        }
                    },
                    {
                        breakpoint: 1189,
                        options: {
                            chart: {
                                height: 70
                            }
                        }
                    },
                    {
                        breakpoint: 1025,
                        options: {
                            chart: {
                                height: 73
                            }
                        }
                    },
                    {
                        breakpoint: 992,
                        options: {
                            chart: {
                                height: 102
                            }
                        }
                    }
                ]
            };

            const sessionsChart = new ApexCharts(sessionsChartEl, sessionsChartConfig);
            sessionsChart.render();
        }
    });
</script>
<!-- Page Produksi daftar penjualan -->
<script>
    $(function () {
        $('#packing').DataTable({
            "order": [
                [0, 'desc']
            ],
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ordering": true,
            "stateSave": true,
            "columnDefs": [{
                    "className": "dt-left",
                    "targets": 2
                },
                {
                    "className": "dt-left",
                    "targets": 3
                },
                {
                    "className": "dt-center",
                    "targets": 4
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
                }
            ],
            "ajax": {
                "url": "<?php echo $base_url; ?>admin/data/masrizal.php?action=sales_data&user=082322345757",
                "dataType": "json",
                "type": "POST"
            },
            "columns": [{
                    "data": "no"
                },
                {
                    "data": "no_invoice"
                },
                {
                    "data": "due_date"
                },
                {
                    "data": "status"
                },
                {
                    "data": "totalorder"
                },
                {
                    "data": "note"
                },
                {
                    "data": "image"
                }
            ],
            "buttons": ['pdf', 'excel']
        });
    });
</script>