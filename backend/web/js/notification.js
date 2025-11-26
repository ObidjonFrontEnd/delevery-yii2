// Notification System
class NotificationManager {
    constructor() {
        this.container = null;
        this.init();
    }

    init() {
        // Создаем контейнер если его нет
        if (!document.querySelector('.notification-container')) {
            this.container = document.createElement('div');
            this.container.className = 'notification-container';
            document.body.appendChild(this.container);
        } else {
            this.container = document.querySelector('.notification-container');
        }
    }

    show(options) {
        const {
            type = 'info',
            title = '',
            message = '',
            duration = 3000,
            closeButton = true
        } = options;

        // Создаем уведомление
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;

        // Иконки для разных типов
        const icons = {
            success: '✓',
            error: '✕',
            warning: '⚠',
            info: 'ℹ'
        };

        // HTML структура
        notification.innerHTML = `
            <div class="notification-icon">${icons[type]}</div>
            <div class="notification-content">
                ${title ? `<div class="notification-title">${title}</div>` : ''}
                <div class="notification-message">${message}</div>
            </div>
            ${closeButton ? '<button class="notification-close">×</button>' : ''}
        `;

        // Добавляем в контейнер
        this.container.appendChild(notification);

        // Кнопка закрытия
        if (closeButton) {
            const closeBtn = notification.querySelector('.notification-close');
            closeBtn.addEventListener('click', () => this.remove(notification));
        }

        // Автоудаление
        if (duration > 0) {
            setTimeout(() => this.remove(notification), duration);
        }

        return notification;
    }

    remove(notification) {
        notification.classList.add('removing');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }

    success(message, title = '') {
        return this.show({ type: 'success', message, title });
    }

    error(message, title = '') {
        return this.show({ type: 'error', message, title });
    }

    warning(message, title = '') {
        return this.show({ type: 'warning', message, title });
    }

    info(message, title = '') {
        return this.show({ type: 'info', message, title });
    }
}

// Глобальный экземпляр
const notification = new NotificationManager();

// Для использования в Yii2
window.notification = notification;