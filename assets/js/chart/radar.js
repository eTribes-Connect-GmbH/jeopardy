import Chart from 'chart.js';

const element = document.getElementById('radar');
const elements = document.querySelectorAll('[data-radar]');
elements.forEach((element) => {
    const ctx = element.getContext('2d');
    const data = JSON.parse(element.dataset.radar);
    const myChart = new Chart(ctx, {
        type: 'radar',
        data: {
            labels: data.labels,
            datasets: data.datasets
        },
        options: {
            scale: {
                angleLines: {
                    display: false
                },
                ticks: {
                    suggestedMin: 0,
                    suggestedMax: 6
                }
            }
        }
    });
});

