import Chart from 'chart.js';

const elements = document.querySelectorAll('[data-chart]');
elements.forEach((element) => {
    const ctx = element.getContext('2d');
    const data = JSON.parse(element.dataset.chart);
    console.log(data);
    const myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: data.labels,
            datasets: data.dataset
        },
        options: {}
    });
})

