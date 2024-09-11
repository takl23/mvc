import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', () => {
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
                    labels: labels.reverse(), // Reverse labels to ensure ascending order
                    datasets: [{
                        label: 'Förnybar energi i procent',
                        data: values.reverse(), // Reverse data to match the reversed labels
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
                    labels: labels.reverse(), // Reverse labels to ensure ascending order
                    datasets: [{
                        label: 'Förnybar energi i TWh',
                        data: values.reverse(), // Reverse data to match the reversed labels
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
                    labels: labels.reverse(), // Reverse labels to ensure ascending order
                    datasets: [{
                        label: 'Energitillförsel som andel av BNP',
                        data: values.reverse(), // Reverse data to match the reversed labels
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
});
