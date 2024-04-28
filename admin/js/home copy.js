document.addEventListener("DOMContentLoaded", function() {
    // Memastikan ApexCharts telah dimuat
    if (typeof ApexCharts === 'undefined') {
        console.error('ApexCharts is not loaded. Please include ApexCharts library.');
        return;
    }

    // Fungsi untuk memperbarui chart berdasarkan timeframe
    function updateChart(timeframe) {
        fetch(`chart-data2.php?timeframe=${timeframe}`) // Dynamic URL based on selected timeframe
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

                const chartElement = document.querySelector('#weeklyOverviewChart');
                if (!chartElement) {
                    console.error('Chart element #weeklyOverviewChart not found.');
                    return;
                }

                if (currentChart) {
                    currentChart.destroy();
                }

                currentChart = new ApexCharts(chartElement, chartOptions);
                currentChart.render();
            })
            .catch(error => console.error('Error loading the chart data:', error));
    }

    // Inisialisasi chart dengan data bulanan ketika halaman dimuat
    updateChart('monthly');

    // Fungsi untuk memperbarui informasi performa penjualan
    function updatePerformance(timeframe) {
        fetch(`chart-data2.php?timeframe=${timeframe}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                const salesData = data.pemasukan;
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

                let performanceText = `Kinerja Penjualan Hari ini masih sama dibanding kemarin. 😐`;
                if (performanceChange > 0) {
                    performanceText = `Kinerja Penjualan Hari ini Meningkat Rp. ${formatRupiah(performanceChange)} dibanding kemarin. 😎`;
                } else if (performanceChange < 0) {
                    performanceText = `Kinerja Penjualan Hari ini Menurun Rp. ${formatRupiah(Math.abs(performanceChange))} dibanding kemarin. 😕`;
                }

                const performanceElement = document.querySelector('#performance');
                const h3Element = document.getElementById('percentage');
                if (performanceElement && h3Element) {
                    performanceElement.textContent = performanceText;
                    h3Element.textContent = performancePercentage + '%';
                } else {
                    console.error('Element #performance or #percentage not found.');
                }
            })
            .catch(error => {
                console.error('Error loading performance data:', error);
            });
    }

    // Inisialisasi data performa dengan data bulanan ketika halaman dimuat
    updatePerformance('monthly');
});
