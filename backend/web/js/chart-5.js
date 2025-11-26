// ============================================
// ГРАФИК ПРОДАЖ ПО МЕСЯЦАМ (APEXCHARTS)
// ============================================

// Переменные monthlyData и translations передаются из PHP
// const monthlyData = [...]; // данные из БД
// const translations = {...}; // переводы

// ============================================
// НАЗВАНИЯ МЕСЯЦЕВ НА РАЗНЫХ ЯЗЫКАХ
// ============================================

const monthNames = {
    ru: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь',
        'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
    uz: ['Yanvar', 'Fevral', 'Mart', 'Aprel', 'May', 'Iyun',
        'Iyul', 'Avgust', 'Sentabr', 'Oktabr', 'Noyabr', 'Dekabr'],
    en: ['January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December']
};

// ============================================
// ФУНКЦИЯ ПОЛУЧЕНИЯ НАЗВАНИЯ МЕСЯЦА
// ============================================

function getMonthName(monthNumber, language = 'ru') {
    const index = parseInt(monthNumber) - 1;
    if (index >= 0 && index < 12) {
        return monthNames[language][index];
    }
    return monthNumber;
}

// ============================================
// ПРЕОБРАЗОВАНИЕ ДАННЫХ ИЗ БД
// ============================================

function transformMonthlyData(dbData, language = 'ru') {
    // Сортируем по месяцам
    const sortedData = [...dbData].sort((a, b) => parseInt(a.month) - parseInt(b.month));

    const labels = sortedData.map(item => getMonthName(item.month, language));
    const counts = sortedData.map(item => parseInt(item.count) || 0);
    const totals = sortedData.map(item => parseFloat(item.total) || 0);

    return { labels, counts, totals };
}

// ============================================
// СОЗДАНИЕ И РЕНДЕР ГРАФИКА
// ============================================

function initMonthlyChart(monthlyData, language = 'ru') {
    const chartElement = document.getElementById('widget-1');
    if (!chartElement) {
        console.error('Chart element not found');
        return;
    }

    // Очищаем элемент
    chartElement.innerHTML = '';

    // Преобразуем данные
    const { labels, counts, totals } = transformMonthlyData(monthlyData, language);

    // Проверка наличия данных
    if (counts.length === 0) {
        chartElement.innerHTML = '<p style="text-align: center; color: #999; padding: 20px;">Нет данных для отображения</p>';
        return;
    }

    // Настройки графика
    const options = {
        series: [{
            name: translations.itemsSold || 'Items sold (pcs)',
            data: counts
        }],
        chart: {
            type: 'bar',
            height: 300,
            fontFamily: 'inherit',
            toolbar: {
                show: false
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                borderRadius: 5
            }
        },
        xaxis: {
            categories: labels,
            labels: {
                style: {
                    fontSize: '12px'
                }
            }
        },
        yaxis: {
            title: {
                text: translations.quantity || 'Quantity (pcs)'
            },
            labels: {
                formatter: function(val) {
                    return Math.round(val);
                }
            }
        },
        dataLabels: {
            enabled: false
        },
        tooltip: {
            y: {
                formatter: function(val, opts) {
                    const index = opts.dataPointIndex;
                    const total = totals[index];
                    return val + ' ' + (translations.pcs || 'pcs.') +
                        '<br/>' + (translations.total || 'Total') + ': ' +
                        total.toLocaleString() + ' ' + (translations.currency || 'sum');
                }
            }
        },
        colors: [KTUtil.getCssVariableValue('--bs-success') || '#10b981'],
        grid: {
            borderColor: KTUtil.getCssVariableValue('--bs-border-dashed-color') || '#e5e7eb',
            strokeDashArray: 4,
            yaxis: {
                lines: {
                    show: true
                }
            }
        }
    };

    // Создаём и рендерим график
    const chart = new ApexCharts(chartElement, options);
    chart.render();

    return chart;
}

// ============================================
// ОБНОВЛЕНИЕ ГРАФИКА ПРИ СМЕНЕ ЯЗЫКА
// ============================================

function updateChartLanguage(chart, monthlyData, newLanguage) {
    const { labels } = transformMonthlyData(monthlyData, newLanguage);

    chart.updateOptions({
        xaxis: {
            categories: labels
        }
    });
}

// ============================================
// ИНИЦИАЛИЗАЦИЯ ПРИ ЗАГРУЗКЕ СТРАНИЦЫ
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    // Небольшая задержка для загрузки ApexCharts
    setTimeout(function() {
        if (typeof monthlyData !== 'undefined' && typeof translations !== 'undefined') {
            // Определяем язык из translations или используем по умолчанию
            const language = translations.language || 'ru';
            initMonthlyChart(monthlyData, language);
        } else {
            console.error('monthlyData or translations not defined');
        }
    }, 500);
});