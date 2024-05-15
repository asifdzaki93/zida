<!-- Modal -->
<div class="modal fade" id="buka_invoice" tabindex="-1" aria-labelledby="buka_invoice_label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="buka_invoice_label">Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div id=buka_invoice_content></div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="bukaInvoice()">Buka</button>
                <a class="btn btn-secondary" onclick="$('#buka_invoice').modal('hide');" target=_blank id="buka_invoice_cetak">
                    Cetak
                </a>
                <a class="btn btn-success" onclick="$('#buka_invoice').modal('hide');" target=_blank id="buka_invoice_resi">
                    Resi
                </a>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

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
<script src="<?php echo $base_url; ?>/assets/vendor/libs/fullcalendar/fullcalendar.js"></script>
<script src="<?php echo $base_url; ?>/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="<?php echo $base_url; ?>/assets/vendor/libs/apex-charts/apexcharts.js"></script>
<script src="<?php echo $base_url; ?>/assets/vendor/libs/chartjs/chartjs.js"></script>
<script src="<?php echo $base_url; ?>/assets/vendor/libs/swiper/swiper.js"></script>
<script src="<?php echo $base_url; ?>/assets/vendor/libs/flatpickr/flatpickr.js"></script>
<script src="<?php echo $base_url; ?>/assets/vendor/libs/moment/moment.js"></script>
<script src="<?php echo $base_url; ?>/assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.js"></script>
<script src="<?php echo $base_url; ?>/assets/vendor/libs/select2/select2.js"></script>

<!-- Main JS -->
<script src=" <?php echo $base_url; ?>/assets/js/main.js"></script>

<!-- Page JS -->
<!-- <script src="<?php echo $base_url; ?>/assets/js/dashboards-crm.js"></script> -->

<script>
    const colors = ['#6667AB', '#5CB85C']; // Example colors for the chart segments
    var base_url = "<?php echo $base_url; ?>";
    var try_routing_last = window.location.pathname + window.location.search;
    var try_routing = false;
    var tambah_history = "";
    var tambah_history_index = 0;
    async function menambah_history() {
        if ((window.location.pathname + window.location.search) != tambah_history) {
            await window.history.pushState('page' + tambah_history_index, 'Title', tambah_history);
            tambah_history_index++;
        }
    }
    window.onpopstate = function(event) {
        var pageURL = window.location.href;
        var lastURLSegment = pageURL.substr(pageURL.lastIndexOf('/') + 1);
        loadPage(lastURLSegment);
    }
    async function loadPage(page) {
        $(".tooltip").remove();
        await $.ajax({
            url: "jquery_page.php?page=" + page.replace("?", "&"),
            success: function(result) {
                $("#jquery_page").html(result);
            }
        });
        tambah_history = page;
        menambah_history();
        var flatpickrDate = document.querySelector("#from-datepicker");
        if (flatpickrDate !== null) {
            flatpickrDate.flatpickr({});
        }
    };

    function refreshPage() {
        var pageURL = window.location.href;
        var lastURLSegment = pageURL.substr(pageURL.lastIndexOf('/') + 1);
        loadPage(lastURLSegment);
    }
    refreshPage();

    function sidebarBuka(id_aktif, id_buka = "") {
        var aktif = id_aktif.split(",");
        $(".menu-item").removeClass("active");
        for (var i = 0; i < aktif.length; i++) {
            $("#menu-" + aktif[i]).addClass("active");
        }
        $(".menu-item").removeClass("open");
        var buka = id_buka.split(",");
        for (var i = 0; i < buka.length; i++) {
            $("#menu-" + buka[i]).addClass("open");
        }
    }
</script>

<script>
    var invoice_terpilih = "";

    function bukaInvoice() {
        $("#buka_invoice").modal("hide");
        loadPage("order_detail.php&no_invoice=" + invoice_terpilih);
    }

    async function open_invoice(no_invoice) {
        invoice_terpilih = no_invoice;
        $("#buka_invoice").modal("show");
        $("#buka_invoice_resi").attr("href", "<?php echo $base_url ?>/admin/cetak_resi.php?no_invoice=" +
            no_invoice)
        $("#buka_invoice_cetak").attr("href",
            "<?php echo $base_url ?>/admin/cetak_invoice.php?no_invoice=" +
            no_invoice)
        await $.ajax({
            url: "<?php echo $base_url; ?>/admin/jquery_page.php?page=order_detail.php&no_invoice=" +
                no_invoice +
                "&is_modal_request=true",
            success: function(resultX) {
                $("#buka_invoice_content").html(resultX);
            }
        });
    }

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
    document.addEventListener("DOMContentLoaded", function() {
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
    $(function() {
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

    $('.form-select').selectpicker();
</script>