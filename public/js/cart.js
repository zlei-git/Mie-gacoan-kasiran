/**
 * Kedai Mie - Vanilla JS Shopping Cart Manager
 */
const Cart = {
    KEY: 'kedai_mie_cart',

    getItems() {
        try {
            return JSON.parse(localStorage.getItem(this.KEY)) || [];
        } catch (e) {
            return [];
        }
    },

    saveItems(items) {
        localStorage.setItem(this.KEY, JSON.stringify(items));
        this.updateBadge();
        this.renderDrawer();
    },

    addItem(item) {
        const items = this.getItems();
        // Match by product ID, spicy level, and toppings
        const existingIndex = items.findIndex(i => 
            i.id === item.id && 
            i.spicy_level === item.spicy_level && 
            i.addons === item.addons
        );

        if (existingIndex > -1) {
            items[existingIndex].quantity += (item.quantity || 1);
        } else {
            items.push({
                id: item.id,
                code: item.code || '',
                name: item.name,
                price: parseInt(item.price, 10),
                image: item.image,
                spicy_level: item.spicy_level ?? null,
                addons: item.addons || '',
                quantity: item.quantity || 1,
                notes: item.notes || ''
            });
        }

        this.saveItems(items);
        this.showToast(item.name + ' berhasil ditambahkan ke keranjang!');
    },

    updateQuantity(index, delta) {
        const items = this.getItems();
        if (items[index]) {
            items[index].quantity += delta;
            if (items[index].quantity <= 0) {
                items.splice(index, 1);
            }
            this.saveItems(items);
        }
    },

    removeItem(index) {
        const items = this.getItems();
        if (items[index]) {
            items.splice(index, 1);
            this.saveItems(items);
        }
    },

    clear() {
        localStorage.removeItem(this.KEY);
        this.updateBadge();
        this.renderDrawer();
    },

    getCount() {
        return this.getItems().reduce((total, item) => total + (item.quantity || 1), 0);
    },

    getSubtotal() {
        return this.getItems().reduce((total, item) => total + (item.price * (item.quantity || 1)), 0);
    },

    updateBadge() {
        const count = this.getCount();
        const badgeEls = document.querySelectorAll('.cart-count-badge');
        badgeEls.forEach(el => {
            el.textContent = count;
            if (count > 0) {
                el.classList.remove('hidden');
            } else {
                el.classList.add('hidden');
            }
        });
    },

    renderDrawer() {
        const container = document.getElementById('cartDrawerItems');
        const emptyState = document.getElementById('cartDrawerEmpty');
        const footer = document.getElementById('cartDrawerFooter');
        const subtotalEl = document.getElementById('cartDrawerSubtotal');
        const totalEl = document.getElementById('cartDrawerTotal');

        if (!container) return;

        const items = this.getItems();
        if (items.length === 0) {
            container.innerHTML = '';
            if (emptyState) emptyState.classList.remove('hidden');
            if (footer) footer.classList.add('hidden');
            return;
        }

        if (emptyState) emptyState.classList.add('hidden');
        if (footer) footer.classList.remove('hidden');

        let html = '';
        items.forEach((item, idx) => {
            const spicyBadge = item.spicy_level !== null 
                ? `<span class="inline-flex items-center px-1.5 py-0.2 rounded text-[10px] font-mono bg-slate-100 text-slate-700">Lv.${item.spicy_level}</span>` 
                : '';
            const addonsText = item.addons ? `<p class="text-[11px] text-slate-500 mt-0.5">+ ${item.addons}</p>` : '';

            html += `
                <div class="flex items-center gap-3 p-2.5 bg-slate-50 rounded-lg border border-slate-200">
                    <img src="${item.image}" alt="${item.name}" class="w-14 h-14 object-cover rounded-md flex-shrink-0 bg-slate-200">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-1">
                            <h4 class="text-xs font-bold text-slate-900 truncate">${item.name}</h4>
                            <button type="button" onclick="Cart.removeItem(${idx})" class="text-slate-400 hover:text-red-500 p-0.5" title="Hapus">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                        <div class="flex items-center gap-1.5 mt-0.5">
                            <span class="text-xs font-bold text-slate-900">Rp ${(item.price).toLocaleString('id-ID')}</span>
                            ${spicyBadge}
                        </div>
                        ${addonsText}
                        <div class="flex items-center justify-between mt-2 pt-1 border-t border-slate-200/60">
                            <div class="flex items-center border border-slate-300 rounded bg-white overflow-hidden text-xs">
                                <button type="button" onclick="Cart.updateQuantity(${idx}, -1)" class="px-2 py-0.5 text-slate-600 hover:bg-slate-100 font-bold">-</button>
                                <span class="px-2 py-0.5 font-semibold text-slate-800">${item.quantity}</span>
                                <button type="button" onclick="Cart.updateQuantity(${idx}, 1)" class="px-2 py-0.5 text-slate-600 hover:bg-slate-100 font-bold">+</button>
                            </div>
                            <span class="text-xs font-bold text-slate-900">Rp ${(item.price * item.quantity).toLocaleString('id-ID')}</span>
                        </div>
                    </div>
                </div>
            `;
        });

        container.innerHTML = html;

        const subtotal = this.getSubtotal();
        const tax = Math.round(subtotal * 0.10);
        const total = subtotal + tax;

        if (subtotalEl) subtotalEl.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
        if (totalEl) totalEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
    },

    showToast(message, type = 'success') {
        let toastContainer = document.getElementById('globalToastContainer');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'globalToastContainer';
            toastContainer.className = 'fixed bottom-6 right-6 z-50 flex flex-col gap-2.5 pointer-events-none';
            document.body.appendChild(toastContainer);
        }

        const toast = document.createElement('div');
        toast.className = 'pointer-events-auto flex items-center gap-3 px-4 py-3 bg-slate-900/95 backdrop-blur-md text-white rounded-xl shadow-2xl border border-slate-700/80 text-xs font-semibold transition-all duration-300 transform translate-y-3 opacity-0';
        
        let iconHtml = `
            <svg class="w-4 h-4 text-rose-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        `;

        if (type === 'warning' || type === 'alert') {
            iconHtml = `
                <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            `;
        }

        toast.innerHTML = `
            ${iconHtml}
            <span class="tracking-wide">${message}</span>
        `;
        toastContainer.appendChild(toast);

        // Animate in with smooth spring
        requestAnimationFrame(() => {
            toast.classList.remove('translate-y-3', 'opacity-0');
        });

        // Auto remove
        setTimeout(() => {
            toast.classList.add('opacity-0', 'translate-y-3');
            setTimeout(() => toast.remove(), 300);
        }, 3200);
    },

    showWarningToast(message) {
        this.showToast(message, 'warning');
    },

    handleProceedToCheckout(event) {
        if (this.getItems().length === 0) {
            if (event) event.preventDefault();
            this.showWarningToast('Mohon tambahkan item terlebih dahulu');
            return false;
        }
        window.location.href = '/checkout';
        return true;
    }
};

// Auto initialize on DOM ready
document.addEventListener('DOMContentLoaded', () => {
    Cart.updateBadge();
    Cart.renderDrawer();
});
