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
    
    show(message, type = 'info', duration = 5000) {
        const id = this.nextId++;
        this.notifications.push({ id, message, type });
        
        if (duration > 0) {
            setTimeout(() => {
                this.dismiss(id);
            }, duration);
        }
        
        return id;
    },
    
    dismiss(id) {
        const index = this.notifications.findIndex(n => n.id === id);
        if (index > -1) {
            this.notifications.splice(index, 1);
        }
    },
    
    success(message, duration = 5000) {
        return this.show(message, 'success', duration);
    },
    
    error(message, duration = 5000) {
        return this.show(message, 'error', duration);
    },
    
    info(message, duration = 5000) {
        return this.show(message, 'info', duration);
    },
    
    warning(message, duration = 5000) {
        return this.show(message, 'warning', duration);
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

window.showToast = function(message, type = 'info', duration = 5000) {
    Alpine.store('toast').show(message, type, duration);
};
