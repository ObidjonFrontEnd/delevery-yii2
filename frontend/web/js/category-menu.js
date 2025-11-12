/**
 * Скрипт для управления активной категорией в меню
 */
document.addEventListener('DOMContentLoaded', function() {
    const categoryLinks = document.querySelectorAll('.category-link');
    const categorySections = document.querySelectorAll('.category-section');

    // Функция для установки активной категории
    function setActiveCategory(categoryId) {
        // Убираем активный класс со всех ссылок
        categoryLinks.forEach(link => {
            link.classList.remove('bg-gray-700', 'active' , 'text-white');

            link.classList.add('hover:bg-gray-700');
        });

        // Добавляем активный класс к текущей ссылке
        const activeLink = document.querySelector(`.category-link[data-category-id="${categoryId}"]`);
        if (activeLink) {
            activeLink.classList.add('bg-gray-700', 'active' , 'text-white');
            activeLink.classList.remove('hover:bg-gray-700');
        }
    }

    // Клик по ссылке категории
    categoryLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const categoryId = this.getAttribute('data-category-id');
            const targetSection = document.getElementById(`category-${categoryId}`);

            if (targetSection) {
                // Плавный скролл к секции
                targetSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                setActiveCategory(categoryId);
            }
        });
    });

    // Настройки для IntersectionObserver
    // Следит за видимостью секций на экране
    const observerOptions = {
        root: null, // viewport
        rootMargin: '-50% 0px -50% 0px', // Активируется когда секция в центре экрана
        threshold: 0 // Порог видимости
    };

    // Создаем наблюдатель
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const categoryId = entry.target.getAttribute('data-category-id');
                setActiveCategory(categoryId);
            }
        });
    }, observerOptions);

    // Наблюдаем за всеми секциями категорий
    categorySections.forEach(section => {
        observer.observe(section);
    });

    // Установка первой категории как активной при загрузке страницы
    if (categoryLinks.length > 0) {
        const firstCategoryId = categoryLinks[0].getAttribute('data-category-id');
        setActiveCategory(firstCategoryId);
    }
});