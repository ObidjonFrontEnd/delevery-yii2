// ============================================
// ПОЛНЫЙ КОД ДЛЯ ГРАФИКА С ДАННЫМИ ИЗ БД
// ============================================

// Переменные translations и dbData передаются из PHP
// const translations = {...}; // из PHP
// const dbData = [...]; // сырые данные из БД

let chartData = [];
let usedColors = new Set(); // Для отслеживания использованных цветов

// ============================================
// ФУНКЦИИ ДЛЯ РАБОТЫ С ЦВЕТАМИ
// ============================================

function getRandomColor() {
    const colors = [
        '#3b82f6', '#ef4444', '#10b981', '#f59e0b', '#8b5cf6',
        '#ec4899', '#06b6d4', '#84cc16', '#f97316', '#6366f1',
        '#14b8a6', '#eab308', '#a855f7', '#22c55e', '#fb923c',
        '#0ea5e9', '#f43f5e', '#059669', '#d97706', '#7c3aed',
        '#db2777', '#0891b2', '#65a30d', '#ea580c', '#4f46e5',
        '#0d9488', '#ca8a04', '#9333ea', '#16a34a', '#f97316',
        '#06b6d4', '#e11d48', '#047857', '#b45309', '#6d28d9',
        '#be185d', '#0e7490', '#4d7c0f', '#c2410c', '#4338ca',
        '#115e59', '#a16207', '#7e22ce', '#15803d', '#c2410c'
    ];

    // Если использованы все цвета, сбрасываем
    if (usedColors.size >= colors.length) {
        usedColors.clear();
    }

    // Находим неиспользованный цвет
    let availableColors = colors.filter(color => !usedColors.has(color));

    // Если нет доступных, берем любой
    if (availableColors.length === 0) {
        availableColors = colors;
    }

    // Выбираем случайный цвет из доступных
    const selectedColor = availableColors[Math.floor(Math.random() * availableColors.length)];
    usedColors.add(selectedColor);

    return selectedColor;
}

// Сброс использованных цветов
function resetColors() {
    usedColors.clear();
}

// ============================================
// ПРЕОБРАЗОВАНИЕ ДАННЫХ ИЗ БД
// ============================================

function transformDBData(dbData) {
    // Сбрасываем использованные цвета при новой трансформации
    resetColors();

    // Группируем по категориям и суммируем quantity
    const categoryMap = new Map();

    dbData.forEach(item => {
        const categoryName = item.product?.category?.name || 'Без категории';
        const categoryId = item.product?.category?.id || null;
        const quantity = parseInt(item.quantity) || 0;

        if (categoryMap.has(categoryName)) {
            const existing = categoryMap.get(categoryName);
            categoryMap.set(categoryName, {
                value: existing.value + quantity,
                id: categoryId || existing.id
            });
        } else {
            categoryMap.set(categoryName, {
                value: quantity,
                id: categoryId
            });
        }
    });

    // Преобразуем Map в массив объектов с уникальными цветами
    return Array.from(categoryMap, ([category, data]) => ({
        category,
        value: data.value,
        id: data.id,
        color: getRandomColor()
    }));
}

// ============================================
// РЕНДЕРИНГ ГРАФИКА
// ============================================

function renderChart() {
    const chart = document.getElementById('chart');
    if (!chart) return;

    chart.innerHTML = '';

    if (!chartData || chartData.length === 0) {
        chart.innerHTML = '<p style="text-align: center; color: #999; padding: 20px;">Нет данных для отображения</p>';
        updateStats();
        return;
    }

    const maxValue = Math.max(...chartData.map(item => item.value));

    const label1 = document.getElementById('label1');
    const label2 = document.getElementById('label2');
    const label3 = document.getElementById('label3');

    if (label1) label1.textContent = Math.round(maxValue * 0.33);
    if (label2) label2.textContent = Math.round(maxValue * 0.66);
    if (label3) label3.textContent = Math.round(maxValue);

    // Сортировка по убыванию
    const sortedData = [...chartData].sort((a, b) => b.value - a.value);

    sortedData.forEach((item, index) => {
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

        // Tooltip события
        bar.addEventListener('mouseenter', (e) => showTooltip(e, item));
        bar.addEventListener('mouseleave', hideTooltip);
        bar.addEventListener('mousemove', moveTooltip);

        barContainer.appendChild(bar);
        barWrapper.appendChild(label);
        barWrapper.appendChild(barContainer);
        chart.appendChild(barWrapper);
    });

    updateStats();
}

// ============================================
// ФУНКЦИИ ДЛЯ TOOLTIP
// ============================================

function showTooltip(e, item) {
    const tooltip = document.getElementById('tooltip');
    if (!tooltip) return;

    const total = chartData.reduce((sum, i) => sum + i.value, 0);
    const percent = total > 0 ? ((item.value / total) * 100).toFixed(1) : 0;

    tooltip.innerHTML = `
        <strong>${item.category}</strong><br>
        ${translations.sales}: ${item.value.toLocaleString()}<br>
        ${translations.percent}: ${percent}%
    `;
    tooltip.classList.add('show');
    moveTooltip(e);
}

function hideTooltip() {
    const tooltip = document.getElementById('tooltip');
    if (tooltip) tooltip.classList.remove('show');
}

function moveTooltip(e) {
    const tooltip = document.getElementById('tooltip');
    if (tooltip) {
        tooltip.style.left = (e.pageX + 15) + 'px';
        tooltip.style.top = (e.pageY + 15) + 'px';
    }
}

// ============================================
// ОБНОВЛЕНИЕ СТАТИСТИКИ
// ============================================

function updateStats() {
    const total = chartData.reduce((sum, item) => sum + item.value, 0);
    const avg = chartData.length > 0 ? Math.round(total / chartData.length) : 0;
    const maxItem = chartData.length > 0
        ? chartData.reduce((max, item) => item.value > max.value ? item : max)
        : { value: 0, category: '-', id: null };

    const totalEl = document.getElementById('totalValue');
    const avgEl = document.getElementById('avgValue');
    const maxEl = document.getElementById('maxCategory');

    if (totalEl) totalEl.textContent = total.toLocaleString();
    if (avgEl) avgEl.textContent = avg.toLocaleString();

    if (maxEl) {
        // Очищаем содержимое
        maxEl.innerHTML = '';

        if (maxItem.id && maxItem.category !== '-') {
            // Создаем ссылку если есть ID категории
            const link = document.createElement('a');
            link.href = categoryViewUrl.replace('__ID__', maxItem.id);
            link.textContent = maxItem.category;
            link.style.color = 'inherit';
            link.style.textDecoration = 'none';
            link.style.borderBottom = '1px dashed currentColor';
            link.addEventListener('mouseenter', function() {
                this.style.borderBottom = '1px solid currentColor';
            });
            link.addEventListener('mouseleave', function() {
                this.style.borderBottom = '1px dashed currentColor';
            });
            maxEl.appendChild(link);
        } else {
            // Просто текст если нет ID
            maxEl.textContent = maxItem.category;
        }
    }
}

// ============================================
// ДОБАВЛЕНИЕ НОВОЙ КАТЕГОРИИ ВРУЧНУЮ
// ============================================

function addBar() {
    const categoryInput = document.getElementById('categoryInput');
    const valueInput = document.getElementById('valueInput');

    if (!categoryInput || !valueInput) return;

    const category = categoryInput.value.trim();
    const value = parseInt(valueInput.value);

    if (category && value && !isNaN(value)) {
        const color = getRandomColor();
        chartData.push({ category, value, color, id: null });
        renderChart();

        // Очистить поля
        categoryInput.value = '';
        valueInput.value = '';
    } else {
        alert(translations.pleaseFillFields);
    }
}

// Обработчик Enter для поля ввода
const valueInput = document.getElementById('valueInput');
if (valueInput) {
    valueInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') addBar();
    });
}

// ============================================
// ИНИЦИАЛИЗАЦИЯ (вызывается из PHP)
// ============================================

function initChart(dbData) {
    chartData = transformDBData(dbData);
    renderChart();
}

// ============================================
// ОБНОВЛЕНИЕ ДАННЫХ (для динамического обновления)
// ============================================

function updateChartData(newDbData) {
    chartData = transformDBData(newDbData);
    renderChart();
}