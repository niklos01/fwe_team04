<div class="card h-100 w-100">
    <div class="card-header">Umsätze der letzten 12 Monate</div>
    <div class="card-body">
        <canvas id="barChart"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    fetch('<?= base_url('umsatz/last12-months') ?>')
        .then(response => response.json())
        .then(data => {
            const labels = data.map(d => `${String(d.monat).padStart(2, '0')}.${d.jahr}`);
            const values = data.map(d => Number(d.umsatz)); // Caste zu Zahl

            new Chart(document.getElementById('barChart'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Umsatz (€)',
                        data: values,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Umsätze der letzten 12 Monate'
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const index = context.dataIndex;
                                    const current = Number(context.raw);
                                    const previous = index > 0 ? Number(context.dataset.data[index - 1]) : null;

                                    if (isNaN(current)) return 'Ungültiger Wert';

                                    let changeText = '(kein Vormonat)';
                                    if (previous !== null && !isNaN(previous) && previous !== 0) {
                                        const change = (((current - previous) / previous) * 100).toFixed(1);
                                        changeText = change >= 0 ? `(+${change}%)` : `(${change}%)`;
                                    }

                                    return `€ ${current.toFixed(2)} ${changeText}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: '€ Umsatz'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Monat'
                            }
                        }
                    }
                }
            });
        });
</script>
