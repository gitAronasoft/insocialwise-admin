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

Alpine.data('globalSearch', () => ({
    query: '',
    results: [],
    loading: false,
    showResults: false,
    searchTimeout: null,
    
    get groupedResults() {
        const groups = {};
        this.results.forEach(result => {
            const groupName = result.type === 'customer' ? 'Customers' : 
                              result.type === 'page' ? 'Connected Pages' : 'Social Accounts';
            if (!groups[groupName]) groups[groupName] = [];
            groups[groupName].push(result);
        });
        return groups;
    },
    
    async search() {
        if (this.query.length < 2) {
            this.results = [];
            this.showResults = false;
            return;
        }
        
        this.loading = true;
        this.showResults = true;
        
        try {
            const response = await fetch(`/admin/global-search?q=${encodeURIComponent(this.query)}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (!response.ok) throw new Error('Search failed');
            
            const data = await response.json();
            this.results = data.results || [];
        } catch (error) {
            console.error('Search error:', error);
            this.results = [];
        } finally {
            this.loading = false;
        }
    },
    
    clearSearch() {
        this.query = '';
        this.results = [];
        this.showResults = false;
    }
}));

Alpine.store('commandPalette', {
    open: false,
    query: '',
    selectedIndex: 0,
    
    commands: [
        { id: 'dashboard', name: 'Go to Dashboard', icon: 'home', url: '/admin/dashboard', category: 'Navigation' },
        { id: 'customers', name: 'Go to Customers', icon: 'users', url: '/admin/customers', category: 'Navigation' },
        { id: 'subscriptions', name: 'Go to Subscriptions', icon: 'credit-card', url: '/admin/subscriptions', category: 'Navigation' },
        { id: 'billing', name: 'Go to Billing Overview', icon: 'calculator', url: '/admin/billing/overview', category: 'Navigation' },
        { id: 'plans', name: 'Go to Subscription Plans', icon: 'clipboard', url: '/admin/subscription-plans', category: 'Navigation' },
        { id: 'revenue', name: 'Go to Revenue', icon: 'dollar', url: '/admin/revenue', category: 'Navigation' },
        { id: 'payments', name: 'Go to Payments', icon: 'wallet', url: '/admin/billing/payments', category: 'Navigation' },
        { id: 'posts', name: 'Go to Posts', icon: 'document', url: '/admin/posts', category: 'Navigation' },
        { id: 'analytics', name: 'Go to Analytics', icon: 'chart', url: '/admin/analytics', category: 'Navigation' },
        { id: 'reports', name: 'Go to Reports', icon: 'report', url: '/admin/reports', category: 'Navigation' },
        { id: 'webhooks', name: 'Go to Webhooks', icon: 'link', url: '/admin/webhooks', category: 'Navigation' },
        { id: 'webhook-logs', name: 'Go to Webhook Logs', icon: 'clipboard', url: '/admin/webhook-logs', category: 'Navigation' },
        { id: 'settings', name: 'Go to Settings', icon: 'cog', url: '/admin/settings', category: 'Navigation' },
        { id: 'profile', name: 'Go to Profile', icon: 'user', url: '/admin/profile', category: 'Navigation' },
        { id: 'admin-users', name: 'Go to Admin Users', icon: 'users', url: '/admin/admin-users', category: 'Navigation' },
        { id: 'toggle-dark', name: 'Toggle Dark Mode', icon: 'moon', action: 'toggleDarkMode', category: 'Actions' },
        { id: 'toggle-sidebar', name: 'Toggle Sidebar', icon: 'menu', action: 'toggleSidebar', category: 'Actions' },
        { id: 'logout', name: 'Logout', icon: 'logout', action: 'logout', category: 'Actions' },
    ],
    
    get filteredCommands() {
        if (!this.query) return this.commands;
        const q = this.query.toLowerCase();
        return this.commands.filter(cmd => 
            cmd.name.toLowerCase().includes(q) || 
            cmd.category.toLowerCase().includes(q)
        );
    },
    
    get groupedCommands() {
        const groups = {};
        this.filteredCommands.forEach(cmd => {
            if (!groups[cmd.category]) groups[cmd.category] = [];
            groups[cmd.category].push(cmd);
        });
        return groups;
    },
    
    toggle() {
        this.open = !this.open;
        if (this.open) {
            this.query = '';
            this.selectedIndex = 0;
        }
    },
    
    close() {
        this.open = false;
        this.query = '';
        this.selectedIndex = 0;
    },
    
    moveUp() {
        const total = this.filteredCommands.length;
        if (total === 0) return;
        this.selectedIndex = (this.selectedIndex - 1 + total) % total;
    },
    
    moveDown() {
        const total = this.filteredCommands.length;
        if (total === 0) return;
        this.selectedIndex = (this.selectedIndex + 1) % total;
    },
    
    selectCurrent() {
        const cmd = this.filteredCommands[this.selectedIndex];
        if (cmd) this.execute(cmd);
    },
    
    execute(command) {
        this.close();
        
        if (command.url) {
            window.location.href = command.url;
        } else if (command.action) {
            switch (command.action) {
                case 'toggleDarkMode':
                    Alpine.store('darkMode').toggle();
                    Alpine.store('toast').success('Dark mode toggled');
                    break;
                case 'toggleSidebar':
                    Alpine.store('sidebar').toggle();
                    break;
                case 'logout':
                    document.getElementById('logout-form')?.submit();
                    break;
            }
        }
    }
});

document.addEventListener('keydown', (e) => {
    if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
        e.preventDefault();
        Alpine.store('commandPalette').toggle();
    }
    
    if (Alpine.store('commandPalette').open) {
        if (e.key === 'Escape') {
            e.preventDefault();
            Alpine.store('commandPalette').close();
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            Alpine.store('commandPalette').moveUp();
        } else if (e.key === 'ArrowDown') {
            e.preventDefault();
            Alpine.store('commandPalette').moveDown();
        } else if (e.key === 'Enter') {
            e.preventDefault();
            Alpine.store('commandPalette').selectCurrent();
        }
    }
});

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
    let suggestion = '';
    
    if (error.response) {
        const status = error.response.status;
        const data = error.response.data;
        
        if (data && data.message) {
            message = data.message;
        } else if (status === 401) {
            message = 'Your session has expired.';
            suggestion = 'Redirecting to login page...';
            setTimeout(() => window.location.reload(), 2000);
        } else if (status === 403) {
            message = 'You do not have permission to perform this action.';
            suggestion = 'Contact your administrator if you need access.';
        } else if (status === 404) {
            message = 'The requested resource was not found.';
            suggestion = 'It may have been deleted or moved. Try refreshing the page.';
        } else if (status === 419) {
            message = 'Your session token has expired.';
            suggestion = 'Please refresh the page and try again.';
        } else if (status === 422) {
            const errors = data.errors;
            if (errors) {
                const errorMessages = Object.values(errors).flat();
                message = errorMessages[0] || 'Please check your input.';
                if (errorMessages.length > 1) {
                    suggestion = `${errorMessages.length - 1} more issue(s) found. Please review all fields.`;
                }
            }
        } else if (status === 429) {
            message = 'Too many requests.';
            suggestion = 'Please wait a moment before trying again.';
        } else if (status >= 500) {
            message = 'Server error occurred.';
            suggestion = 'Our team has been notified. Please try again later.';
        }
        
        if (data && data.suggestion) {
            suggestion = data.suggestion;
        }
    } else if (error.message) {
        if (error.message.includes('Network Error')) {
            message = 'Unable to connect to server.';
            suggestion = 'Please check your internet connection and try again.';
        } else {
            message = error.message;
        }
    }
    
    const fullMessage = suggestion ? `${message} ${suggestion}` : message;
    Alpine.store('toast').error(fullMessage, { title: 'Error' });
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
