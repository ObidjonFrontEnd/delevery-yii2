document.addEventListener("DOMContentLoaded", () => {
    const html = document.documentElement;
    const themeBtn = document.getElementById("theme-toggle");

    // Проверяем куки — если указана тёмная тема, применяем её
    const isDarkSaved = document.cookie.includes("theme=dark");
    if (isDarkSaved) {
        html.classList.add("dark");
        console.log("🌙 Тёмная тема активна (из cookie)");
    } else {
        console.log("☀️ Светлая тема активна (по умолчанию)");
    }

    // Обработчик переключения темы
    if (themeBtn) {
        themeBtn.addEventListener("click", () => {
            const isDark = html.classList.toggle("dark");
            const theme = isDark ? "dark" : "light";

            // Сохраняем выбор пользователя в cookie на 1 год
            document.cookie = `theme=${theme}; path=/; max-age=31536000`;

            console.log(`🌓 Тема переключена на: ${theme}`);
        });
    } else {
        console.warn("⚠️ Кнопка #theme-toggle не найдена в DOM!");
    }
});



document.addEventListener('DOMContentLoaded', function() {
    const avatar = document.getElementById('avatar');
    const menu = document.getElementById('avatar-menu');

    if (avatar && menu) { // проверяем наличие элементов
        avatar.addEventListener('click', function() {
            menu.classList.toggle('hidden'); // переключает видимость меню
        });

        // Закрыть меню при клике вне блока
        document.addEventListener('click', function(e) {
            if (!avatar.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });
    }
});


