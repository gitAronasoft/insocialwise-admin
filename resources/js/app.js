import './bootstrap';

import Alpine from 'alpinejs';
import dataTable from './datatable';

window.Alpine = Alpine;

Alpine.data('dataTable', dataTable);

Alpine.store('sidebar', {
    expanded: localStorage.getItem('sidebarExpanded') !== 'false',
    mobileOpen: false,
    
    toggle() {
        this.expanded = !this.expanded;
        localStorage.setItem('sidebarExpanded', this.expanded);
    },
    
    toggleMobile() {
        this.mobileOpen = !this.mobileOpen;
    },
    
    closeMobile() {
        this.mobileOpen = false;
    }
});

Alpine.store('darkMode', {
    on: localStorage.getItem('darkMode') === 'true' || 
        (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches),
    
    init() {
        this.updateClass();
    },
    
    toggle() {
        this.on = !this.on;
        localStorage.setItem('darkMode', this.on);
        this.updateClass();
    },
    
    updateClass() {
        if (this.on) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }
});

Alpine.data('dropdown', () => ({
    open: false,
    
    toggle() {
        this.open = !this.open;
    },
    
    close() {
        this.open = false;
    }
}));

Alpine.data('navGroup', (initialOpen = false) => ({
    open: initialOpen,
    
    toggle() {
        this.open = !this.open;
    }
}));

Alpine.store('toast', {
    notifications: [],
    nextId: 0,
    maxNotifications: 5,
    
    show(message, type = 'info', options = {}) {
        const id = this.nextId++;
        const duration = options.duration ?? 5000;
        const title = options.title ?? this.getDefaultTitle(type);
        const dismissible = options.dismissible ?? true;
        
        if (this.notifications.length >= this.maxNotifications) {
            this.notifications.shift();
        }
        
        this.notifications.push({ 
            id, 
            message, 
            type, 
            title,
            dismissible,
            entering: true,
            leaving: false
        });
        
        setTimeout(() => {
            const notification = this.notifications.find(n => n.id === id);
            if (notification) notification.entering = false;
        }, 50);
        
        if (duration > 0) {
            setTimeout(() => {
                this.dismiss(id);
            }, duration);
        }
        
        return id;
    },
    
    getDefaultTitle(type) {
        const titles = {
            success: 'Success',
            error: 'Error',
            warning: 'Warning',
            info: 'Information'
        };
        return titles[type] || 'Notification';
    },
    
    dismiss(id) {
        const notification = this.notifications.find(n => n.id === id);
        if (notification) {
            notification.leaving = true;
            setTimeout(() => {
                const index = this.notifications.findIndex(n => n.id === id);
                if (index > -1) {
                    this.notifications.splice(index, 1);
                }
            }, 300);
        }
    },
    
    dismissAll() {
        this.notifications.forEach(n => this.dismiss(n.id));
    },
    
    success(message, options = {}) {
        return this.show(message, 'success', typeof options === 'number' ? { duration: options } : options);
    },
    
    error(message, options = {}) {
        const opts = typeof options === 'number' ? { duration: options } : options;
        opts.duration = opts.duration ?? 8000;
        return this.show(message, 'error', opts);
    },
    
    info(message, options = {}) {
        return this.show(message, 'info', typeof options === 'number' ? { duration: options } : options);
    },
    
    warning(message, options = {}) {
        const opts = typeof options === 'number' ? { duration: options } : options;
        opts.duration = opts.duration ?? 6000;
        return this.show(message, 'warning', opts);
    }
});

Alpine.data('notifications', () => ({
    open: false,
    unreadCount: 0,
    items: [],
    
    init() {
        this.items = [
            { id: 1, title: 'New user registered', time: '5 min ago', read: false },
            { id: 2, title: 'New subscription', time: '1 hour ago', read: false },
            { id: 3, title: 'System update complete', time: '2 hours ago', read: true },
        ];
        this.updateUnreadCount();
    },
    
    toggle() {
        this.open = !this.open;
    },
    
    close() {
        this.open = false;
    },
    
    markAsRead(id) {
        const item = this.items.find(i => i.id === id);
        if (item) {
            item.read = true;
            this.updateUnreadCount();
        }
    },
    
    markAllAsRead() {
        this.items.forEach(item => item.read = true);
        this.updateUnreadCount();
    },
    
    updateUnreadCount() {
        this.unreadCount = this.items.filter(i => !i.read).length;
    }
}));

Alpine.data('confirmDialog', () => ({
    show: false,
    title: '',
    message: '',
    confirmText: 'Confirm',
    cancelText: 'Cancel',
    onConfirm: null,
    
    open(options) {
        this.title = options.title || 'Confirm';
        this.message = options.message || 'Are you sure?';
        this.confirmText = options.confirmText || 'Confirm';
        this.cancelText = options.cancelText || 'Cancel';
        this.onConfirm = options.onConfirm || null;
        this.show = true;
    },
    
    confirm() {
        if (this.onConfirm) {
            this.onConfirm();
        }
        this.close();
    },
    
    close() {
        this.show = false;
        this.onConfirm = null;
    }
}));

if (Alpine.store('darkMode')) {
    Alpine.store('darkMode').init();
}

Alpine.start();

window.showToast = function(message, type = 'info', options = {}) {
    if (typeof options === 'number') {
        options = { duration: options };
    }
    Alpine.store('toast').show(message, type, options);
};

window.handleApiError = function(error, defaultMessage = 'An error occurred. Please try again.') {
    let message = defaultMessage;
    
    if (error.response) {
        if (error.response.data && error.response.data.message) {
            message = error.response.data.message;
        } else if (error.response.status === 401) {
            message = 'Your session has expired. Please log in again.';
            setTimeout(() => window.location.reload(), 2000);
        } else if (error.response.status === 403) {
            message = 'You do not have permission to perform this action.';
        } else if (error.response.status === 404) {
            message = 'The requested resource was not found.';
        } else if (error.response.status === 422) {
            const errors = error.response.data.errors;
            if (errors) {
                message = Object.values(errors).flat().join(' ');
            }
        } else if (error.response.status >= 500) {
            message = 'Server error. Please try again later.';
        }
    } else if (error.message) {
        message = error.message;
    }
    
    Alpine.store('toast').error(message);
    return message;
};

window.handleApiSuccess = function(response, defaultMessage = 'Operation completed successfully.') {
    const message = response?.data?.message || response?.message || defaultMessage;
    Alpine.store('toast').success(message);
    return message;
};

window.axios.interceptors.response.use(
    response => response,
    error => {
        if (error.response?.status === 401) {
            Alpine.store('toast').error('Your session has expired. Redirecting to login...', { duration: 3000 });
            setTimeout(() => window.location.href = '/admin/login', 2000);
        }
        return Promise.reject(error);
    }
);
