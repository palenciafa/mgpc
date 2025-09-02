document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('overviewChart');
    if (!canvas) return;

    const products = parseInt(canvas.dataset.products);
    const suppliers = parseInt(canvas.dataset.suppliers);
    const sales = parseInt(canvas.dataset.sales);

    new Chart(canvas.getContext('2d'), {
        type: 'pie',
        data: {
            labels: ['Products', 'Suppliers', 'Sales'],
            datasets: [{
                label: 'Overview',
                data: [products, suppliers, sales],
                backgroundColor: [
                    'rgba(0, 191, 255, 0.6)',
                    'rgba(0, 255, 127, 0.6)',
                    'rgba(255, 99, 132, 0.6)'
                ],
                borderColor: [
                    'rgba(0, 191, 255, 1)',
                    'rgba(0, 255, 127, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
});
