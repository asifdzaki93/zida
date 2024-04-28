<!-- Footer -->
<footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl">
        <div class="footer-container d-flex align-items-center justify-content-between py-3 flex-md-row flex-column">
            <div class="mb-2 mb-md-0">
                ©
                <script>
                    document.write(new Date().getFullYear());
                </script>
                , Dibuat Dengan <span class="text-danger">❤️</span> Oleh
                <a href="https://pixinvent.com" target="_blank" class="footer-link fw-medium">As-If Tech</a>
            </div>
            <div>
                <a href="https://demos.pixinvent.com/materialize-html-admin-template/documentation/" target="_blank" class="footer-link me-4">Dokumentasi</a>
            </div>
        </div>
    </div>
</footer>
<!-- / Footer -->



<div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
</div>
<!-- / Layout page -->
</div>

<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>

<!-- Drag Target Area To SlideIn Menu On Small Screens -->
<div class="drag-target"></div>
</div>
<!-- / Layout wrapper -->

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="assets/vendor/libs/jquery/jquery.js"></script>
<script src="assets/vendor/libs/popper/popper.js"></script>
<script src="assets/vendor/js/bootstrap.js"></script>
<script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="assets/vendor/libs/node-waves/node-waves.js"></script>

<script src="assets/vendor/libs/hammer/hammer.js"></script>
<script src="assets/vendor/libs/i18n/i18n.js"></script>
<script src="assets/vendor/libs/typeahead-js/typeahead.js"></script>

<script src="assets/vendor/js/menu.js"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="assets/vendor/libs/apex-charts/apexcharts.js"></script>
<script src="assets/vendor/libs/swiper/swiper.js"></script>

<!-- Main JS -->
<script src="assets/js/main.js"></script>

<!-- Page JS -->
<script src="assets/js/dashboards-analytics.js"></script>

<!-- footer.php -->
<script>
    let currentChart = null; // Global reference to the chart instance

    function updateChart(timeframe) {
        fetch('chart-data2.php?timeframe=' + timeframe) // Dynamic URL based on selected timeframe
            .then(response => response.json())
            .then(data => {
                const chartOptions = {
                    chart: {
                        type: 'line',
                        height: 350,
                        toolbar: {
                            show: false
                        }
                    },
                    series: [{
                            name: 'Pemasukan',
                            type: 'line',
                            data: data.pemasukan,
                            color: '#556ee6' // Blue for Pemasukan
                        },
                        {
                            name: 'Pengeluaran',
                            type: 'bar',
                            data: data.pengeluaran,
                            color: '#34C38F' // Green for Pengeluaran
                        },
                        {
                            name: 'Belanja Produk',
                            type: 'bar',
                            data: data.belanjaProduk,
                            color: '#f46a6a' // Red for Belanja Produk
                        }
                    ],
                    plotOptions: {
                        bar: {
                            borderRadius: 5,
                            columnWidth: '40%'
                        }
                    },
                    markers: {
                        size: 5,
                        strokeWidth: 2,
                        fillOpacity: 1,
                        strokeOpacity: 1,
                        strokeColors: '#fff'
                    },
                    stroke: {
                        width: [2, 0, 0], // Width 2 for line, 0 for bars
                        curve: 'smooth'
                    },
                    dataLabels: {
                        enabled: false
                    },
                    legend: {
                        show: true,
                        position: 'top',
                        horizontalAlign: 'center'
                    },
                    grid: {
                        strokeDashArray: 5
                    },
                    xaxis: {
                        categories: data.labels,
                        tickPlacement: 'on'
                    },
                    yaxis: {
                        labels: {
                            formatter: function(val) {
                                if (val >= 1000000) {
                                    return Math.floor(val / 1000000) + ' Jt';
                                } else if (val >= 1000) {
                                    return Math.floor(val / 1000) + 'K';
                                }
                                return val;
                            },
                            style: {
                                fontSize: '12px'
                            }
                        }
                    },
                    responsive: [{
                        breakpoint: 1000,
                        options: {
                            plotOptions: {
                                bar: {
                                    horizontal: false
                                }
                            },
                            legend: {
                                position: "bottom"
                            }
                        }
                    }]
                };

                // Destroy previous chart instance if exists
                if (currentChart) {
                    currentChart.destroy();
                }

                // Create new chart instance
                const chartElement = document.querySelector('#weeklyOverviewChart');
                currentChart = new ApexCharts(chartElement, chartOptions);
                currentChart.render();
            })
            .catch(error => console.error('Error loading the chart data:', error));
    }

    // Initialize chart with monthly data
    updateChart('monthly');

    function updatePerformance(timeframe) {
        fetch(`chart-data2.php?timeframe=${timeframe}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Retrieve the sales data for the current timeframe
                const salesData = data.pemasukan;

                // Calculate the sales performance change compared to the previous period
                const currentPeriodSales = salesData[salesData.length - 1]; // Sales for the current period
                const previousPeriodSales = salesData[salesData.length - 2]; // Sales for the previous period
                const performanceChange = currentPeriodSales - previousPeriodSales;
                const performancePercentage = ((performanceChange / previousPeriodSales) * 100).toFixed(2);

                function formatRupiah(angka) {
                    var reverse = angka.toString().split('').reverse().join('');
                    var ribuan = reverse.match(/\d{1,3}/g);
                    ribuan = ribuan.join('.').split('').reverse().join('');
                    return ribuan;
                }


                // Determine whether sales performance increased or decreased
                let performanceText;
                if (performanceChange > 0) {
                    performanceText = `Kinerja Penjualan Hari ini Meningkat Rp. ${formatRupiah(performanceChange)} dibanding kemarin. 😎`;
                } else if (performanceChange < 0) {
                    performanceText = `Kinerja Penjualan Hari ini Menurun Rp. ${formatRupiah(Math.abs(performanceChange))} dibanding kemarin. 😕`;
                } else {
                    performanceText = `Kinerja Penjualan Hari ini masih sama dibanding kemarin. 😐`;
                }

                // Update the performance element with the calculated text
                const performanceElement = document.querySelector('#performance');
                if (performanceElement) {
                    performanceElement.textContent = performanceText;
                }

                // Mendapatkan elemen dengan ID tertentu
                const h3Element = document.getElementById('percentage');

                // Misalkan kita punya variabel yang menyimpan persentase yang ingin ditampilkan

                // Mengubah teks di dalam elemen
                h3Element.textContent = performancePercentage + '%';

            })
            .catch(error => {
                console.error('Error loading performance data:', error);
            });
    }


    // Call the function to update performance initially
    updatePerformance('monthly'); // You can change the timeframe as needed
</script>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

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


<script>
    $(document).ready(function() {
        var currentPage = window.location.pathname.split('/').pop();
        $('.menu-item').removeClass('active');
        $('.menu-item a[href="' + currentPage + '"]').closest('.menu-item').addClass('active');

        // Menambahkan fungsi untuk mengelola dropdown
        $('.menu-link.menu-toggle').click(function(e) {
            e.preventDefault(); // Mencegah perubahan URL jika menu link adalah href="#"
            var submenu = $(this).next('.menu-sub');
            submenu.slideToggle(300); // Animasi slide untuk submenu
            $(this).parent().toggleClass('expanded'); // Toggle class 'expanded' untuk item menu
        });
    });
</script>


</body>

</html>