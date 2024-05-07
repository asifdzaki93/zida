<?php
function nota_admin_render($mysqli, $base_url)
{
    $time = date("H");
    $selamat = "Pagi";
    if ($time >= 12 && $time < 15) {
        $selamat = "Siang";
    } else
if ($time >= 15 && $time < 19) {
        $selamat = "Sore";
    } else
if ($time >= 19 && $time < 04) {
        $selamat = "Malam";
    }
    include("data/function.php");
    $percentageChange = getPercentageChange($mysqli);
    $icon = getPercentageChangeIcon($percentageChange);

    $sales_hari_ini = getTotalSalesDay($mysqli);
?>
<div class="row gy-4 mb-4">
    <!-- Gamification Card -->
    <div class="col-md-12 col-lg-8">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-md-6 order-2 order-md-1">
                    <div class="card-body">
                        <h4 class="card-title pb-xl-2">Selamat <?php echo $selamat ?><strong> Admin !</strong>🎉</h4>
                        <p class="mb-0">Ada <span class="fw-semibold"><?php echo $sales_hari_ini; ?> Nota
                            </span>😎 masuk hari ini.</p>
                        <p>Cek Selengkapnya, klik tombol dibawah.</p>
                        <a href="javascript:;" onclick="loadPage('pengiriman.php?harian=true')"
                            class="btn btn-primary">Selengkapnya</a>
                    </div>
                </div>
                <div class="col-md-6 text-center text-md-end order-1 order-md-2">
                    <div class="card-body pb-0 px-0 px-md-4 ps-0">
                        <img src="<?php echo $base_url; ?>/assets/img/illustrations/illustration-john-light.png"
                            height="180" alt="View Profile"
                            data-app-light-img="illustrations/illustration-john-light.png"
                            data-app-dark-img="illustrations/illustration-john-dark.png" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Gamification Card -->

    <!-- Sessions line chart -->
    <div class="col-lg-2 col-sm-6">
        <div class="card h-100">
            <div class="card-header pb-0">
                <div class="d-flex align-items-end mb-1 flex-wrap gap-2">
                    <h4 class="mb-0 me-2" id="data_minggu_ini">Rp 0</h4>
                    <p class="mb-0 text-success" id="kenaikan_data_minggu_ini">0%</p>
                </div>
                <span class=" d-block mb-2 text-muted">Minggu Ini</span>
            </div>
            <div class="card-body">
                <div id="sessions"></div>
            </div>
        </div>
    </div>
    <!--/ Sessions line chart -->

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
                        <p class="mb-0 text-<?php echo $icon["color"]; ?> me-1"><?php echo $percentageChange; ?>%</p>
                        <i class="mdi mdi-chevron-up text-success"></i>
                    </div>
                </div>
                <div class="card-info mt-4 pt-1 mt-lg-1 mt-xl-4">
                    <h5 class="mb-2"><?php echo $sales_hari_ini; ?></h5>
                    <p class="text-muted mb-lg-2 mb-xl-3">Total Pesanan</p>
                    <div class="badge bg-label-secondary rounded-pill">Hari Ini</div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Statistics Total Order -->
</div>
<script>
    function formatRupiah(angkaX) {
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
            currency: "IDR"
        }).format(angkaX);
    }

    function formatRupiahMinimize($angkaX) {
        var formatted = formatRupiah($angkaX);
        var titik = formatted.split(".");
        var singkatan = "";
        if (titik.length == 2) {
            singkatan = "Rb";
        }
        if (titik.length == 3) {
            singkatan = "Jt";
        }
        return titik[0] + " " + singkatan;
    }

    async function renderSessionChart() {
        await $.ajax({
            url: "<?php echo $base_url; ?>admin/data/chart-data2.php?timeframe=weekly",
            success: function (resultX) {
                var dataMinggu = resultX.pemasukan;
                var data_sekarang = dataMinggu[dataMinggu.length - 1];
                var data_kemarin = dataMinggu[dataMinggu.length - 2];
                var kenaikan_data_sekarang = Math.floor((data_sekarang - data_kemarin) / data_kemarin *
                    100);
                $("#data_minggu_ini").html(formatRupiahMinimize(data_sekarang));
                $("#kenaikan_data_minggu_ini").attr("class", kenaikan_data_sekarang < 0 ?
                        "mb-0 text-danger" :
                        "mb-0 text-success")
                    .html(kenaikan_data_sekarang + "%");

                var labels = resultX.labels;
                var sessionsChartEl = document.querySelector('#sessions'),
                    sessionsChartConfig = {
                        labels: resultX.labels,
                        chart: {
                            height: 102,
                            type: 'line',
                            parentHeightOffset: 0,
                            toolbar: {
                                show: false
                            }
                        },
                        grid: {
                            borderColor: labelColor,
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
                        colors: [config.colors.info],
                        stroke: {
                            width: 3
                        },
                        series: [{
                            name: "Pendapatan ",
                            data: dataMinggu
                        }],
                        tooltip: {
                            shared: false,
                            intersect: true,
                            x: {
                                show: false
                            }
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
                            enabled: true,
                            x: {
                                formatter: function (value) {
                                    return value;
                                }
                            },
                            y: {
                                formatter: function (value) {
                                    return formatRupiah(value);
                                }
                            }
                        },
                        markers: {
                            size: 6,
                            strokeWidth: 3,
                            strokeColors: 'transparent',
                            strokeWidth: 3,
                            colors: ['transparent'],
                            discrete: [{
                                seriesIndex: 0,
                                dataPointIndex: 6,
                                fillColor: cardColor,
                                strokeColor: config.colors.info,
                                size: 6,
                                shape: 'circle'
                            }],
                            hover: {
                                size: 7
                            }
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

                if (typeof sessionsChartEl !== undefined && sessionsChartEl !== null) {
                    var sessionsChart = new ApexCharts(sessionsChartEl, sessionsChartConfig);
                    sessionsChart.render();
                }

            }
        });

    }
    renderSessionChart();
</script>
<?php
}
?>