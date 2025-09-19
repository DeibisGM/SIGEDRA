import Chart from 'chart.js/auto';

// --- CONFIGURACIÓN DE DISEÑO AVANZADA --- //

const themeColors = {
    primary: '#193F4C',
    secondary: '#7AA352',
    accent: '#34A853',
    error: '#D9534F',
    warning: '#F0AD4E',
    grid: '#E5E7EB',
    text: '#4B5563',
    textDark: '#1F2937',
    tooltipBg: '#FFFFFF'
};

Chart.defaults.font.family = 'Figtree', 'sans-serif';
Chart.defaults.font.size = 14;
Chart.defaults.color = themeColors.text;

// Helper para crear degradados
function createGradient(ctx, color1, color2) {
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, color1);
    gradient.addColorStop(1, color2);
    return gradient;
}

// Plugin para dibujar texto en el centro del gráfico de dona
const doughnutCenterText = {
    id: 'doughnutCenterText',
    afterDraw(chart) {
        if (chart.config.type !== 'doughnut') return;

        const { ctx, data, chartArea: { top, width, height } } = chart;
        const total = data.datasets[0].data.reduce((a, b) => a + b, 0);

        ctx.save();
        ctx.font = `bold 2rem Figtree`;
        ctx.fillStyle = themeColors.primary;
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        ctx.fillText(total, width / 2, top + (height / 2) - 10);

        ctx.font = `1rem Figtree`;
        ctx.fillStyle = themeColors.text;
        ctx.fillText('Estudiantes', width / 2, top + (height / 2) + 20);
        ctx.restore();
    }
};

// --- INICIALIZACIÓN DE GRÁFICOS --- //

function initCharts() {
    const attendanceChartEl = document.getElementById('attendanceChart');
    const gradesChartEl = document.getElementById('gradesChart');

    if (attendanceChartEl) {
        try {
            const attendanceData = JSON.parse(attendanceChartEl.dataset.attendance);
            const ctx = attendanceChartEl.getContext('2d');

            attendanceData.datasets[0].backgroundColor = createGradient(ctx, themeColors.secondary, '#A8C590');
            attendanceData.datasets[1].backgroundColor = createGradient(ctx, themeColors.error, '#E58C8A');

            new Chart(attendanceChartEl, {
                type: 'bar',
                data: attendanceData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    borderWidth: 0,
                    borderRadius: 8,
                    plugins: {
                        legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 8 } },
                        tooltip: {
                            backgroundColor: themeColors.tooltipBg,
                            titleColor: themeColors.primary,
                            bodyColor: themeColors.text,
                            borderColor: themeColors.grid,
                            borderWidth: 1,
                            padding: 10,
                            cornerRadius: 8,
                            callbacks: { label: (c) => `${c.dataset.label}: ${c.raw}%` }
                        }
                    },
                    scales: {
                        y: { beginAtZero: true, grid: { color: themeColors.grid, drawBorder: false }, ticks: { callback: (v) => v + '%' } },
                        x: { grid: { display: false } }
                    }
                }
            });
        } catch (e) {
            console.error('Failed to initialize attendance chart:', e);
        }
    }

    if (gradesChartEl) {
        try {
            const gradesData = JSON.parse(gradesChartEl.dataset.grades);
            const ctx = gradesChartEl.getContext('2d');

            gradesData.datasets[0].backgroundColor = [
                createGradient(ctx, themeColors.accent, '#7ED496'),
                createGradient(ctx, themeColors.secondary, '#A8C590'),
                createGradient(ctx, themeColors.warning, '#F7D08A'),
                createGradient(ctx, themeColors.error, '#E58C8A')
            ];
            gradesData.datasets[0].borderColor = themeColors.tooltipBg;
            gradesData.datasets[0].borderWidth = 4;

            new Chart(gradesChartEl, {
                type: 'doughnut',
                data: gradesData,
                plugins: [doughnutCenterText],
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 8 } },
                        tooltip: {
                            backgroundColor: themeColors.tooltipBg,
                            titleColor: themeColors.primary,
                            bodyColor: themeColors.text,
                            borderColor: themeColors.grid,
                            borderWidth: 1,
                            padding: 10,
                            cornerRadius: 8,
                        }
                    }
                }
            });
        } catch (e) {
            console.error('Failed to initialize grades chart:', e);
        }
    }
}

export default initCharts;
