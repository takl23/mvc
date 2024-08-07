import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', () => {
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

    // Fetch renewable energy percentage data
    fetch('/public/api/renewable-energy')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('renewableEnergyPercentageChart').getContext('2d');
            const labels = data.data.map(item => item.year);
            const values = data.data.map(item => item.total);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Förnybar energi i procent',
                        data: values,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true
                    }]
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
                                text: '%'
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching renewable energy percentage data:', error));

    // Fetch renewable energy TWh data
    fetch('/public/api/renewable_energy_twh')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('renewableEnergyTWhChart').getContext('2d');
            const labels = data.data.map(item => item.year);
            const values = data.data.map(item => item.total);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Förnybar energi i TWh',
                        data: values,
                        borderColor: 'rgba(153, 102, 255, 1)',
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        fill: true
                    }]
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
                                text: 'TWh'
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching renewable energy TWh data:', error));

    // Fetch energy supply GDP data
    fetch('/public/api/energy_supply_gdp')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('energySupplyGDPChart').getContext('2d');
            const labels = data.data.map(item => item.year);
            const values = data.data.map(item => item.precentage);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Energitillförsel som andel av BNP',
                        data: values,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        fill: true
                    }]
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
                                text: '%-andel av BNP'
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching energy supply GDP data:', error));

    // Fetch Län och Elområde data and populate table
    fetch('/public/api/lan_elomrade')
        .then(response => response.json())
        .then(data => {
            const tableBody = document.querySelector('#lanElomradeTable tbody');

            data.data.forEach(item => {
                const row = document.createElement('tr');
                const lanCell = document.createElement('td');
                const elomradeCell = document.createElement('td');

                lanCell.textContent = item.lan;
                elomradeCell.textContent = item.elomrade;

                row.appendChild(lanCell);
                row.appendChild(elomradeCell);
                tableBody.appendChild(row);
            });
        })
        .catch(error => console.error('Error fetching Län och Elområde data:', error));
});
