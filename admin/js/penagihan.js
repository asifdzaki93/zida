    const colors = ['#6667AB', '#5CB85C']; // Example colors for the chart segments
    fetch(baseUrl + 'admin/data/home-chart.php')
    .then(response => response.json())
    .then(data => {
        const doughnutChart = document.getElementById('doughnutChart');
        if (doughnutChart) {
            const incomePercentageElement = document.getElementById('incomePercentage');
            const billingPercentageElement = document.getElementById('billingPercentage');
            const incomeColorElement = document.getElementById('incomeColor');
            const billingColorElement = document.getElementById('billingColor');
            const detailButton = document.getElementById('detailButton');

            const totalIncome = parseInt(data.totalIncome, 10);
            const totalBilling = parseInt(data.totalBilling, 10);
            const totalAmount = totalIncome + totalBilling;

            //const incomePercentage = ((totalIncome / totalAmount) * 100).toFixed(2);
            //const billingPercentage = ((totalBilling / totalAmount) * 100).toFixed(2);

            // Update text and background color
            incomePercentageElement.innerText = `Rp. ${totalIncome.toLocaleString()}`;
            billingPercentageElement.innerText = `Rp. ${totalBilling.toLocaleString()}`;
            detailButton.innerText = `Rp. ${totalAmount.toLocaleString()}`;
            incomeColorElement.style.backgroundColor = colors[0];
            billingColorElement.style.backgroundColor = colors[1];

            const doughnutChartVar = new Chart(doughnutChart, {
                type: 'doughnut',
                data: {
                    labels: ['Pemasukan', 'Penagihan'],
                    datasets: [{
                        data: [totalIncome, totalBilling],
                        backgroundColor: colors,
                        borderWidth: 0,
                        pointStyle: 'rectRounded'
                    }]
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
                                label: function (tooltipItem) {
                                    const label = tooltipItem.chart.data.labels[tooltipItem.dataIndex];
                                    const value = tooltipItem.raw;
                                    const percentage = ((value / totalAmount) * 100).toFixed(2);
                                    return `${label}: ${value} (${percentage} %)`;
                                }
                            },
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

            // Handle button click to show total amount
            detailButton.addEventListener('click', function() {
                alert(`Total Estimasi Uang Masuk: Rp ${totalAmount.toLocaleString()}`);
            });
        }
    })
    .catch(error => console.error('Error loading the chart data:', error));
