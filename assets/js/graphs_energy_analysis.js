import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', () => {
    const fetchDataAndRenderChart = (url, canvasId, chartType, yLabel) => {
        fetch(url)
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById(canvasId).getContext('2d');
                const labels = data.data.map(item => item.year);
                const datasets = Object.keys(data.data[0])
                    .filter(key => key !== 'year')
                    .map((key, index) => {
                        const colors = [
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(255, 206, 86, 1)'
                        ];
                        const backgroundColors = colors.map(color => color.replace('1)', '0.2)'));

                        return {
                            label: key,
                            data: data.data.map(item => item[key]),
                            borderColor: colors[index % colors.length],
                            backgroundColor: backgroundColors[index % colors.length],
                            fill: true
                        };
                    });

                new Chart(ctx, {
                    type: chartType,
                    data: {
                        labels: labels,
                        datasets: datasets
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
                                    text: yLabel
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => console.error(`Error fetching data from ${url}:`, error));
    };

    // Restore line chart for average consumption
    fetchDataAndRenderChart(
        '/public/api/average-consumption', 'averageConsumptionChart', 'line', 'GWh');

    // Restore line chart for electricity price
    fetchDataAndRenderChart(
        '/public/api/electricity-price', 'averageElectricityPriceChart', 'line', 'SEK/kWh');

    // Change to bar chart for population per elomrade
    fetch('/public/api/population-per-elomrade')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('populationPerElomradeChart').getContext('2d');
            const labels = Array.from(new Set(data.data.map(item => item.year)));
            const elomrades = ['SE1', 'SE2', 'SE3', 'SE4'];

            const datasets = elomrades.map((elomrade, index) => {
                const colors = [
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 206, 86, 1)'
                ];
                const backgroundColors = colors.map(color => color.replace('1)', '0.2)'));

                return {
                    label: elomrade,
                    data: labels.map(year => {
                        const item = data.data.find(
                            d => d.year === year && d.elomrade === elomrade);

                        return item ? item.population : 0;
                    }),
                    borderColor: colors[index % colors.length],
                    backgroundColor: backgroundColors[index % colors.length],
                    fill: true
                };
            });

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: datasets
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
                                text: 'Population'
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error(
            `Error fetching data from /public/api/population-per-elomrade:`, error));

    // Change to bar chart for consumption per capita
    // Konsumtion per capita graf
    fetch('/public/api/consumption-per-capita')
        .then(response => response.json())
        .then(data => {
            console.log("Fetched data for consumption per capita:", data);

            const ctx = document.getElementById('consumptionPerCapitaChart').getContext('2d');
            const labels = Array.from(new Set(data.data.map(item => item.year)));
            const elomrades = ['SE1', 'SE2', 'SE3', 'SE4'];

            const datasets = elomrades.map((elomrade, index) => {
                const colors = [
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 206, 86, 1)'
                ];
                const backgroundColors = colors.map(color => color.replace('1)', '0.2)'));

                return {
                    label: elomrade,
                    data: labels.map(year => {
                        const item = data.data.find(
                            d => d.year === year && d.elomrade === elomrade
                        );

                        return item ? item.consumptionPerCapita : 0;
                    }),
                    borderColor: colors[index % colors.length],
                    backgroundColor: backgroundColors[index % colors.length],
                    fill: true
                };
            });

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: datasets
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
                                text: 'kWh per capita'
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching data for consumption per capita:', error));

    fetch('/public/api/annual-cost-per-person')
        .then(response => response.json())
        .then(data => {
            console.log("Data fetched from API:", data);
            const ctx = document.getElementById('annualCostPerPersonChart').getContext('2d');

            // Hämta unika år som etiketter för X-axeln
            const labels = Array.from(new Set(data.data.map(item => item.year)));

            // Definiera elområden
            const elomrades = ['se1', 'se2', 'se3', 'se4'];

            // Skapa dataset för varje elområde
            const datasets = elomrades.map((elomrade, index) => {
                const colors = [
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 206, 86, 1)'
                ];
                const backgroundColors = colors.map(color => color.replace('1)', '0.2)'));

                return {
                    label: elomrade,
                    data: labels.map(year => {
                        const item = data.data.find(
                            d => d.year === year && d.elomrade === elomrade);

                        return item ? item.annualCost : 0;
                    }),
                    borderColor: colors[index % colors.length],
                    backgroundColor: backgroundColors[index % colors.length],
                    fill: true
                };
            });

            console.log("Datasets prepared for Chart.js:", datasets);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: datasets
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
                                text: 'SEK per capita'
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error(
            `Error fetching data from /public/api/annual-cost-per-person:`, error));
});
