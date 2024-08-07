import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', () => {
    // Fetch average temperature data
    fetch('/public/api/average-temperature')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('averageTemperatureChart').getContext('2d');
            const labels = data.data.map(item => item.year);
            const se1 = data.data.map(item => item.SE1);
            const se2 = data.data.map(item => item.SE2);
            const se3 = data.data.map(item => item.SE3);
            const se4 = data.data.map(item => item.SE4);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'SE1',
                            data: se1,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            fill: true
                        },
                        {
                            label: 'SE2',
                            data: se2,
                            borderColor: 'rgba(153, 102, 255, 1)',
                            backgroundColor: 'rgba(153, 102, 255, 0.2)',
                            fill: true
                        },
                        {
                            label: 'SE3',
                            data: se3,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            fill: true
                        },
                        {
                            label: 'SE4',
                            data: se4,
                            borderColor: 'rgba(255, 206, 86, 1)',
                            backgroundColor: 'rgba(255, 206, 86, 0.2)',
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            type: 'category',
                            title: {
                                display: true,
                                text: 'År'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: '°C'
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching average temperature data:', error));

    // Fetch average consumption data
    fetch('/public/api/average-consumption')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('averageConsumptionChart').getContext('2d');
            const labels = data.data.map(item => item.year);
            const se1 = data.data.map(item => item.SE1);
            const se2 = data.data.map(item => item.SE2);
            const se3 = data.data.map(item => item.SE3);
            const se4 = data.data.map(item => item.SE4);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'SE1',
                            data: se1,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            fill: true
                        },
                        {
                            label: 'SE2',
                            data: se2,
                            borderColor: 'rgba(153, 102, 255, 1)',
                            backgroundColor: 'rgba(153, 102, 255, 0.2)',
                            fill: true
                        },
                        {
                            label: 'SE3',
                            data: se3,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            fill: true
                        },
                        {
                            label: 'SE4',
                            data: se4,
                            borderColor: 'rgba(255, 206, 86, 1)',
                            backgroundColor: 'rgba(255, 206, 86, 0.2)',
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            type: 'category',
                            title: {
                                display: true,
                                text: 'År'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'GWh'
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching average consumption data:', error));

    // Fetch average electricity price data
    fetch('/public/api/electricity-price')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('averageElectricityPriceChart').getContext('2d');
            const labels = data.data.map(item => item.year);
            const se1 = data.data.map(item => item.SE1);
            const se2 = data.data.map(item => item.SE2);
            const se3 = data.data.map(item => item.SE3);
            const se4 = data.data.map(item => item.SE4);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'SE1',
                            data: se1,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            fill: true
                        },
                        {
                            label: 'SE2',
                            data: se2,
                            borderColor: 'rgba(153, 102, 255, 1)',
                            backgroundColor: 'rgba(153, 102, 255, 0.2)',
                            fill: true
                        },
                        {
                            label: 'SE3',
                            data: se3,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            fill: true
                        },
                        {
                            label: 'SE4',
                            data: se4,
                            borderColor: 'rgba(255, 206, 86, 1)',
                            backgroundColor: 'rgba(255, 206, 86, 0.2)',
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            type: 'category',
                            title: {
                                display: true,
                                text: 'År'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'SEK/kWh'
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching average electricity price data:', error));

    // Fetch average cost data
    fetch('/public/api/average-cost')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('averageCostChart').getContext('2d');

            if (!ctx) {
                console.error('Canvas context not found');
                return;
            }

            const labels = data.data.map(item => item.year);
            const se1 = data.data.map(item => item.SE1); // Change to 'SE1' if required
            const se2 = data.data.map(item => item.SE2); // Change to 'SE2' if required
            const se3 = data.data.map(item => item.SE3); // Change to 'SE3' if required
            const se4 = data.data.map(item => item.SE4); // Change to 'SE4' if required

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'SE1',
                            data: se1,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            fill: true
                        },
                        {
                            label: 'SE2',
                            data: se2,
                            borderColor: 'rgba(153, 102, 255, 1)',
                            backgroundColor: 'rgba(153, 102, 255, 0.2)',
                            fill: true
                        },
                        {
                            label: 'SE3',
                            data: se3,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            fill: true
                        },
                        {
                            label: 'SE4',
                            data: se4,
                            borderColor: 'rgba(255, 206, 86, 1)',
                            backgroundColor: 'rgba(255, 206, 86, 0.2)',
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            type: 'category',
                            title: {
                                display: true,
                                text: 'År'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'SEK/kWh'
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching average cost data:', error));
});
