<div class="card h-100 w-100">
    <div class="card-header">Monatsumsatz im Vergleich zum Vorjahr</div>
    <div class="card-body">
        <canvas id="gaugeChart"></canvas>
        <div id="chartSummary"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    fetch('<?= base_url('home/current-month-comparison') ?>')
        .then(response => response.json())
        .then(data => {
            const current = Number(data.current_revenue);
            const previous = Number(data.previous_year_revenue);

            const now = new Date();
            const daysInMonth = new Date(now.getFullYear(), now.getMonth() + 1, 0).getDate();
            const today = now.getDate();
            const remainingDays = daysInMonth - today;

            const stillNeeded = Math.max(previous - current, 0);
            const dailyTarget = remainingDays > 0 ? stillNeeded / remainingDays : 0;

            const reachedPercent = previous > 0 ? (current / previous) * 100 : 0;
            const clampedPercent = Math.min(reachedPercent, 200); // Max 200% Anzeige

            const color = clampedPercent >= 100 ? 'rgba(75, 192, 192, 0.8)' : 'rgba(255, 99, 132, 0.8)';
            const remainderColor = 'rgba(230, 230, 230, 0.7)';

            new Chart(document.getElementById('gaugeChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Erreicht', 'Fehlend'],
                    datasets: [{
                        data: [Math.min(clampedPercent, 100), Math.max(0, 100 - clampedPercent)],
                        backgroundColor: [color, remainderColor],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    cutout: '75%',
                    rotation: -90,
                    circumference: 180,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const label = context.label;
                                    if (label === 'Erreicht') {
                                        return `Erreicht: €${current.toFixed(2)}`;
                                    } else if (label === 'Fehlend') {
                                        return `Noch erforderlich: €${stillNeeded.toFixed(2)}`;
                                    } else {
                                        return `${label}: €${context.raw.toFixed(2)}`;
                                    }
                                }
                            }
                        },
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: `Aktueller Umsatz: €${current.toFixed(2)} (${reachedPercent.toFixed(1)}%)`,
                            font: {
                                size: 14
                            },
                            padding: {
                                top: 10,
                                bottom: 0
                            }
                        }
                    }
                }
            });

            // 👇 Text unter dem Chart einfügen
            document.getElementById('chartSummary').innerHTML = `
                <p>
                    Umsatz Vorjahr (Monat): <strong>€${previous.toFixed(2)}</strong><br>
                    Noch <strong>${remainingDays}</strong> Tage übrig<br>
                    → Täglicher Zielumsatz: <strong>€${dailyTarget.toFixed(2)}</strong>
                </p>
            `;
        });
</script>
