// Начальные данные (можно получить из Yii2)
// Пример интеграции: let chartData = <?= json_encode($dataFromYii2) ?>;
let chartData = [
    { category: 'Phones', value: 15000, color: '#3b82f6' },
    { category: 'Laptops', value: 12000, color: '#ec4899' },
    { category: 'Headsets', value: 9000, color: '#10b981' },
    { category: 'Games', value: 7000, color: '#f59e0b' },
    { category: 'Keyboards', value: 6000, color: '#8b5cf6' },
    { category: 'Monitors', value: 4000, color: '#06b6d4' },
    { category: 'Speakers', value: 3000, color: '#6b7280' }
];

function renderChart() {
    const chart = document.getElementById('chart');
    chart.innerHTML = '';

    const maxValue = Math.max(...chartData.map(item => item.value));

    // Обновить метки оси
    document.getElementById('label1').textContent = Math.round(maxValue * 0.33 / 1000) + 'K';
    document.getElementById('label2').textContent = Math.round(maxValue * 0.66 / 1000) + 'K';
    document.getElementById('label3').textContent = Math.round(maxValue / 1000) + 'K';

    chartData.forEach((item, index) => {
        const barWrapper = document.createElement('div');
        barWrapper.className = 'bar-wrapper';
        barWrapper.style.animationDelay = `${index * 0.1}s`;

        const label = document.createElement('div');
        label.className = 'category-label';
        label.textContent = item.category;

        const barContainer = document.createElement('div');
        barContainer.className = 'bar-container';

        const bar = document.createElement('div');
        bar.className = 'bar';
        bar.style.width = '0%';
        bar.style.backgroundColor = item.color;

        const valueSpan = document.createElement('span');
        valueSpan.className = 'bar-value';
        valueSpan.textContent = item.value.toLocaleString();
        bar.appendChild(valueSpan);

        // Анимация ширины
        setTimeout(() => {
            bar.style.width = `${(item.value / maxValue) * 100}%`;
        }, 100 + index * 100);

        // Tooltip
        bar.addEventListener('mouseenter', (e) => showTooltip(e, item));
        bar.addEventListener('mouseleave', hideTooltip);
        bar.addEventListener('mousemove', moveTooltip);

        const deleteBtn = document.createElement('button');
        deleteBtn.className = 'delete-btn';
        deleteBtn.textContent = '🗑️ Удалить';
        deleteBtn.onclick = () => deleteBar(index);

        barContainer.appendChild(bar);
        barWrapper.appendChild(label);
        barWrapper.appendChild(barContainer);
        barWrapper.appendChild(deleteBtn);
        chart.appendChild(barWrapper);
    });

    updateStats();
}

function addBar() {
    const category = document.getElementById('categoryInput').value;
    const value = parseInt(document.getElementById('valueInput').value);
    const color = document.getElementById('colorInput').value;

    if (category && value && !isNaN(value)) {
        chartData.push({ category, value, color });
        renderChart();

        // Очистить поля
        document.getElementById('categoryInput').value = '';
        document.getElementById('valueInput').value = '';
        document.getElementById('colorInput').value = '#3b82f6';
    } else {
        alert('Пожалуйста, заполните все поля!');
    }
}

function deleteBar(index) {
    chartData.splice(index, 1);
    renderChart();
}

function showTooltip(e, item) {
    const tooltip = document.getElementById('tooltip');
    tooltip.innerHTML = `
        <strong>${item.category}</strong><br>
        Продажи: ${item.value.toLocaleString()}<br>
        Процент: ${((item.value / chartData.reduce((sum, i) => sum + i.value, 0)) * 100).toFixed(1)}%
    `;
    tooltip.classList.add('show');
    moveTooltip(e);
}

function hideTooltip() {
    document.getElementById('tooltip').classList.remove('show');
}

function moveTooltip(e) {
    const tooltip = document.getElementById('tooltip');
    tooltip.style.left = (e.pageX + 15) + 'px';
    tooltip.style.top = (e.pageY + 15) + 'px';
}

function updateStats() {
    const total = chartData.reduce((sum, item) => sum + item.value, 0);
    const avg = chartData.length > 0 ? Math.round(total / chartData.length) : 0;
    const maxItem = chartData.reduce((max, item) => item.value > max.value ? item : max, chartData[0] || { value: 0, category: '-' });

    document.getElementById('totalValue').textContent = total.toLocaleString();
    document.getElementById('avgValue').textContent = avg.toLocaleString();
    document.getElementById('maxCategory').textContent = maxItem.category;
}

// Нажатие Enter для добавления
document.getElementById('valueInput').addEventListener('keypress', (e) => {
    if (e.key === 'Enter') addBar();
});

// Инициализация
renderChart();