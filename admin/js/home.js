// Define global reference to the chart instance
let currentChart = null;

// Update the chart with new data based on timeframe
function updateChart(timeframe) {
    fetch(baseUrl + 'admin/data/chart-data2.php?timeframe=' + timeframe) // Dynamic URL based on selected timeframe
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

// Update the sales performance comparison
function updatePerformance(timeframe) {
    fetch(baseUrl + 'admin/data/chart-data2.php?timeframe=' + timeframe)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const salesData = data.pemasukan;
            const currentPeriodSales = salesData[salesData.length - 1];
            const previousPeriodSales = salesData[salesData.length - 2];
            const performanceChange = currentPeriodSales - previousPeriodSales;
            const performancePercentage = ((performanceChange / previousPeriodSales) * 100).toFixed(2);

            // Determine whether sales performance increased or decreased
            let performanceText;
            if (performanceChange > 0) {
                performanceText = `Kinerja Penjualan Hari ini Meningkat Rp. ${formatRupiah(performanceChange)} dibanding kemarin. 😎`;
            } else if (performanceChange < 0) {
                performanceText = `Kinerja Penjualan Hari ini Menurun Rp. ${formatRupiah(Math.abs(performanceChange))} dibanding kemarin. 😕`;
            } else {
                performanceText = `Kinerja Penjualan Hari ini masih sama dibanding kemarin. 😐`;
            }

            const performanceElement = document.querySelector('#performance');
            if (performanceElement) {
                performanceElement.textContent = performanceText;
            }

            const h3Element = document.getElementById('percentage');
            h3Element.textContent = performancePercentage + '%';

        })
        .catch(error => {
            console.error('Error loading performance data:', error);
        });
}

// Helper function to format numbers as rupiah
function formatRupiah(angka) {
    var reverse = angka.toString().split('').reverse().join('');
    var ribuan = reverse.match(/\d{1,3}/g);
    ribuan = ribuan.join('.').split('').reverse().join('');
    return ribuan;
}

function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
      color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}
  // Color Variables
  const purpleColor = '#836AF9',
    yellowColor = '#ffe800',
    cyanColor = '#28dac6',
    orangeColor = '#FF8132',
    orangeLightColor = '#ffcf5c',
    oceanBlueColor = '#299AFF',
    greyColor = '#4F5D70',
    greyLightColor = '#EDF1F4',
    blueColor = '#2B9AFF',
    blueLightColor = '#84D0FF';

  let cardColor, headingColor, labelColor, borderColor, legendColor;

  if (isDarkStyle) {
    cardColor = config.colors_dark.cardColor;
    headingColor = config.colors_dark.headingColor;
    labelColor = config.colors_dark.textMuted;
    legendColor = config.colors_dark.bodyColor;
    borderColor = config.colors_dark.borderColor;
  } else {
    cardColor = config.colors.cardColor;
    headingColor = config.colors.headingColor;
    labelColor = config.colors.textMuted;
    legendColor = config.colors.bodyColor;
    borderColor = config.colors.borderColor;
  }
  // Doughnut Chart
  // --------------------------------------------------------------------

  function loadHome(){
  const doughnutChart = document.getElementById('doughnutChart');
  if (doughnutChart) {
    const doughnutChartVar = new Chart(doughnutChart, {
      type: 'doughnut',
      data: {
        labels: ['Tablet', 'Mobile', 'Desktop'],
        datasets: [
          {
            data: [10, 10, 80],
            backgroundColor: [getRandomColor(), getRandomColor(), getRandomColor()],
            borderWidth: 0,
            pointStyle: 'rectRounded'
          }
        ]
      },
      options: {
        responsive: true,
        animation: {
          duration: 500
        },
        cutout: '68%',
        plugins: {
          legend: {
            display: false
          },
          tooltip: {
            callbacks: {
              label: function (context) {
                const label = context.labels || '',
                  value = context.parsed;
                const output = ' ' + label + ' : ' + value + ' %';
                return output;
              }
            },
            // Updated default tooltip UI
            rtl: isRtl,
            backgroundColor: cardColor,
            titleColor: headingColor,
            bodyColor: legendColor,
            borderWidth: 1,
            borderColor: borderColor
          }
        }
      }
    });
  }
  }

  