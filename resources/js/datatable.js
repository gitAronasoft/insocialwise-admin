export default function dataTable(config = {}) {
    return {
        endpoint: config.endpoint || '',
        data: [],
        loading: false,
        search: '',
        searchTimeout: null,
        sortColumn: config.defaultSort || '',
        sortDirection: config.defaultSortDirection || 'desc',
        currentPage: 1,
        lastPage: 1,
        perPage: config.perPage || 15,
        total: 0,
        selected: [],
        selectAll: false,
        filters: config.filters || {},
        bulkActionUrl: '',
        csrfToken: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
        
        init() {
            this.loadFromUrl();
            this.fetchData();
            
            this.$watch('perPage', () => {
                this.currentPage = 1;
                this.fetchData();
            });
            
            this.$watch('selectAll', (value) => {
                if (value) {
                    this.selected = this.data.map(item => item.id);
                } else {
                    this.selected = [];
                }
            });
        },
        
        loadFromUrl() {
            const params = new URLSearchParams(window.location.search);
            if (params.get('search')) this.search = params.get('search');
            if (params.get('sort')) this.sortColumn = params.get('sort');
            if (params.get('direction')) this.sortDirection = params.get('direction');
            if (params.get('page')) this.currentPage = parseInt(params.get('page'));
            if (params.get('per_page')) this.perPage = parseInt(params.get('per_page'));
            
            Object.keys(this.filters).forEach(key => {
                if (params.get(key)) this.filters[key] = params.get(key);
            });
        },
        
        updateUrl() {
            const params = new URLSearchParams();
            if (this.search) params.set('search', this.search);
            if (this.sortColumn) params.set('sort', this.sortColumn);
            if (this.sortDirection) params.set('direction', this.sortDirection);
            if (this.currentPage > 1) params.set('page', this.currentPage);
            if (this.perPage !== 15) params.set('per_page', this.perPage);
            
            Object.keys(this.filters).forEach(key => {
                if (this.filters[key]) params.set(key, this.filters[key]);
            });
            
            const newUrl = params.toString() 
                ? `${window.location.pathname}?${params.toString()}`
                : window.location.pathname;
            
            window.history.replaceState({}, '', newUrl);
        },
        
        async fetchData() {
            this.loading = true;
            this.selectAll = false;
            this.selected = [];
            
            const params = new URLSearchParams();
            params.set('page', this.currentPage);
            params.set('per_page', this.perPage);
            if (this.search) params.set('search', this.search);
            if (this.sortColumn) params.set('sort', this.sortColumn);
            if (this.sortDirection) params.set('direction', this.sortDirection);
            
            Object.keys(this.filters).forEach(key => {
                if (this.filters[key]) params.set(key, this.filters[key]);
            });
            
            try {
                const response = await fetch(`${this.endpoint}?${params.toString()}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });
                
                if (!response.ok) throw new Error('Network response was not ok');
                
                const result = await response.json();
                this.data = result.data;
                this.currentPage = result.current_page;
                this.lastPage = result.last_page;
                this.perPage = result.per_page;
                this.total = result.total;
                
                this.updateUrl();
            } catch (error) {
                console.error('Error fetching data:', error);
                if (window.showToast) {
                    window.showToast('Error loading data. Please try again.', 'error');
                }
            } finally {
                this.loading = false;
            }
        },
        
        onSearch() {
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(() => {
                this.currentPage = 1;
                this.fetchData();
            }, 300);
        },
        
        sort(column) {
            if (this.sortColumn === column) {
                this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                this.sortColumn = column;
                this.sortDirection = 'asc';
            }
            this.currentPage = 1;
            this.fetchData();
        },
        
        getSortIcon(column) {
            if (this.sortColumn !== column) return 'sort';
            return this.sortDirection === 'asc' ? 'sort-asc' : 'sort-desc';
        },
        
        goToPage(page) {
            if (page < 1 || page > this.lastPage) return;
            this.currentPage = page;
            this.fetchData();
        },
        
        nextPage() {
            if (this.currentPage < this.lastPage) {
                this.currentPage++;
                this.fetchData();
            }
        },
        
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
                this.fetchData();
            }
        },
        
        toggleSelect(id) {
            const index = this.selected.indexOf(id);
            if (index > -1) {
                this.selected.splice(index, 1);
            } else {
                this.selected.push(id);
            }
            this.selectAll = this.selected.length === this.data.length && this.data.length > 0;
        },
        
        isSelected(id) {
            return this.selected.includes(id);
        },
        
        get hasSelected() {
            return this.selected.length > 0;
        },
        
        get selectedCount() {
            return this.selected.length;
        },
        
        get paginationInfo() {
            const start = (this.currentPage - 1) * this.perPage + 1;
            const end = Math.min(this.currentPage * this.perPage, this.total);
            return `Showing ${start} to ${end} of ${this.total} results`;
        },
        
        get visiblePages() {
            const pages = [];
            const maxVisible = 7;
            
            if (this.lastPage <= maxVisible) {
                for (let i = 1; i <= this.lastPage; i++) {
                    pages.push(i);
                }
            } else {
                if (this.currentPage <= 3) {
                    for (let i = 1; i <= 5; i++) pages.push(i);
                    pages.push('...');
                    pages.push(this.lastPage);
                } else if (this.currentPage >= this.lastPage - 2) {
                    pages.push(1);
                    pages.push('...');
                    for (let i = this.lastPage - 4; i <= this.lastPage; i++) pages.push(i);
                } else {
                    pages.push(1);
                    pages.push('...');
                    for (let i = this.currentPage - 1; i <= this.currentPage + 1; i++) pages.push(i);
                    pages.push('...');
                    pages.push(this.lastPage);
                }
            }
            
            return pages;
        },
        
        async executeBulkAction(action, url, confirmMessage = null) {
            if (this.selected.length === 0) {
                if (window.showToast) {
                    window.showToast('Please select at least one item.', 'warning');
                }
                return;
            }
            
            if (confirmMessage && !confirm(confirmMessage)) {
                return;
            }
            
            this.loading = true;
            
            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': this.csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({
                        ids: this.selected,
                        action: action,
                    }),
                });
                
                const result = await response.json();
                
                if (response.ok) {
                    if (window.showToast) {
                        window.showToast(result.message || 'Action completed successfully.', 'success');
                    }
                    this.selected = [];
                    this.selectAll = false;
                    this.fetchData();
                } else {
                    throw new Error(result.message || 'Action failed');
                }
            } catch (error) {
                console.error('Bulk action error:', error);
                if (window.showToast) {
                    window.showToast(error.message || 'An error occurred.', 'error');
                }
            } finally {
                this.loading = false;
            }
        },
        
        async exportSelected(url) {
            if (this.selected.length === 0) {
                if (window.showToast) {
                    window.showToast('Please select items to export.', 'warning');
                }
                return;
            }
            
            this.loading = true;
            
            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'text/csv',
                        'X-CSRF-TOKEN': this.csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({
                        ids: this.selected,
                    }),
                });
                
                if (!response.ok) throw new Error('Export failed');
                
                const blob = await response.blob();
                const downloadUrl = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.style.display = 'none';
                a.href = downloadUrl;
                a.download = `export-${Date.now()}.csv`;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(downloadUrl);
                a.remove();
                
                if (window.showToast) {
                    window.showToast('Export completed successfully.', 'success');
                }
            } catch (error) {
                console.error('Export error:', error);
                if (window.showToast) {
                    window.showToast('Export failed. Please try again.', 'error');
                }
            } finally {
                this.loading = false;
            }
        },
        
        updateFilter(key, value) {
            this.filters[key] = value;
            this.currentPage = 1;
            this.fetchData();
        },
        
        resetFilters() {
            this.search = '';
            Object.keys(this.filters).forEach(key => {
                this.filters[key] = '';
            });
            this.sortColumn = config.defaultSort || '';
            this.sortDirection = config.defaultSortDirection || 'desc';
            this.currentPage = 1;
            this.fetchData();
        },
    };
}
