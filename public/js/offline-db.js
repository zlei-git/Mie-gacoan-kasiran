/**
 * Kedai Mie - IndexedDB Offline Storage & Synchronization Queue
 */
const OfflineDB = {
    DB_NAME: 'kedai_mie_pos_db',
    DB_VERSION: 1,
    STORE_NAME: 'offline_orders',
    db: null,

    async init() {
        if (this.db) return this.db;

        return new Promise((resolve, reject) => {
            const request = indexedDB.open(this.DB_NAME, this.DB_VERSION);

            request.onupgradeneeded = (event) => {
                const db = event.target.result;
                if (!db.objectStoreNames.contains(this.STORE_NAME)) {
                    db.createObjectStore(this.STORE_NAME, { keyPath: 'id', autoIncrement: true });
                }
            };

            request.onsuccess = (event) => {
                this.db = event.target.result;
                this.updateSyncBadge();
                resolve(this.db);
            };

            request.onerror = (event) => {
                console.error('IndexedDB open error:', event.target.error);
                reject(event.target.error);
            };
        });
    },

    async saveOrder(order) {
        await this.init();
        return new Promise((resolve, reject) => {
            const transaction = this.db.transaction([this.STORE_NAME], 'readwrite');
            const store = transaction.objectStore(this.STORE_NAME);
            order.created_at = new Date().toISOString();
            order.is_synced = false;

            const request = store.add(order);
            request.onsuccess = () => {
                this.updateSyncBadge();
                resolve(request.result);
            };
            request.onerror = (e) => reject(e.target.error);
        });
    },

    async getAllPending() {
        await this.init();
        return new Promise((resolve, reject) => {
            const transaction = this.db.transaction([this.STORE_NAME], 'readonly');
            const store = transaction.objectStore(this.STORE_NAME);
            const request = store.getAll();

            request.onsuccess = () => resolve(request.result || []);
            request.onerror = (e) => reject(e.target.error);
        });
    },

    async clearSynced(ids) {
        await this.init();
        return new Promise((resolve, reject) => {
            const transaction = this.db.transaction([this.STORE_NAME], 'readwrite');
            const store = transaction.objectStore(this.STORE_NAME);
            ids.forEach(id => store.delete(id));

            transaction.oncomplete = () => {
                this.updateSyncBadge();
                resolve();
            };
            transaction.onerror = (e) => reject(e.target.error);
        });
    },

    async syncWithServer() {
        const pending = await this.getAllPending();
        if (pending.length === 0) return { count: 0 };

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const response = await fetch('/pos/sync', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken || '',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ orders: pending })
            });

            const result = await response.json();
            if (result.success) {
                const ids = pending.map(p => p.id);
                await this.clearSynced(ids);
                if (window.Cart) Cart.showToast('✅ Berhasil menyinkronkan ' + pending.length + ' transaksi offline!');
                return { count: pending.length };
            }
        } catch (error) {
            console.warn('Sync failed, waiting for connection...', error);
        }
        return { count: 0 };
    },

    async updateSyncBadge() {
        const badge = document.getElementById('offlineSyncBadge');
        if (!badge) return;
        const pending = await this.getAllPending();
        if (pending.length > 0) {
            badge.classList.remove('hidden');
            badge.textContent = `${pending.length} Menunggu Sync`;
        } else {
            badge.classList.add('hidden');
        }
    }
};

// Automatic listener when network status changes
window.addEventListener('online', () => {
    console.log('Online detected. Starting auto-sync...');
    OfflineDB.syncWithServer();
});

document.addEventListener('DOMContentLoaded', () => {
    OfflineDB.init();
});
