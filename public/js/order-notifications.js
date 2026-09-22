/**
 * Mie Gacoan - Realtime Order Notification Engine
 * For Kasir (POS) & Admin Dashboard
 */
(function() {
    let lastKnownId = 0;
    let isInitialized = false;
    let pollInterval = null;
    let audioContext = null;
    let isAudioUnlocked = false;

    // Unlock Web Audio API on first user interaction
    function unlockAudio() {
        if (isAudioUnlocked) return;
        try {
            const AudioCtx = window.AudioContext || window.webkitAudioContext;
            if (AudioCtx) {
                audioContext = new AudioCtx();
                if (audioContext.state === 'suspended') {
                    audioContext.resume();
                }
                isAudioUnlocked = true;
            }
        } catch (e) {
            console.warn('AudioContext initialization error:', e);
        }
    }

    ['click', 'touchstart', 'keydown'].forEach(evt => {
        document.addEventListener(evt, unlockAudio, { once: true, passive: true });
    });

    // Synthesize two-tone pleasant restaurant chime (Ding-Dong)
    function playOrderChime() {
        try {
            unlockAudio();
            if (!audioContext) return;
            if (audioContext.state === 'suspended') {
                audioContext.resume();
            }

            const now = audioContext.currentTime;

            // Tone 1: 880 Hz (A5)
            const osc1 = audioContext.createOscillator();
            const gain1 = audioContext.createGain();
            osc1.type = 'sine';
            osc1.frequency.setValueAtTime(880, now);
            gain1.gain.setValueAtTime(0.3, now);
            gain1.gain.exponentialRampToValueAtTime(0.001, now + 0.45);
            osc1.connect(gain1);
            gain1.connect(audioContext.destination);
            osc1.start(now);
            osc1.stop(now + 0.45);

            // Tone 2: 1320 Hz (E6) - higher chime
            const osc2 = audioContext.createOscillator();
            const gain2 = audioContext.createGain();
            osc2.type = 'sine';
            osc2.frequency.setValueAtTime(1320, now + 0.12);
            gain2.gain.setValueAtTime(0.35, now + 0.12);
            gain2.gain.exponentialRampToValueAtTime(0.001, now + 0.85);
            osc2.connect(gain2);
            gain2.connect(audioContext.destination);
            osc2.start(now + 0.12);
            osc2.stop(now + 0.85);
        } catch (err) {
            console.warn('Could not play synthesized chime:', err);
        }
    }

    // Request native browser desktop notifications
    function requestDesktopPermission() {
        if ('Notification' in window && Notification.permission === 'default') {
            Notification.requestPermission();
        }
    }

    function showDesktopNotification(order) {
        if ('Notification' in window && Notification.permission === 'granted') {
            try {
                const notif = new Notification('🔔 Pesanan Baru Masuk!', {
                    body: `${order.order_code} • ${order.customer_name} (${order.order_type_label}) - ${order.total_formatted}`,
                    icon: '/images/logo.png',
                    tag: 'order-' + order.id,
                });
                notif.onclick = function() {
                    window.focus();
                    if (window.location.pathname.startsWith('/admin')) {
                        window.location.href = '/admin/orders';
                    }
                };
            } catch (e) {
                // Ignore if in restricted context
            }
        }
    }

    // Toast Container in DOM
    function ensureToastContainer() {
        let container = document.getElementById('orderNotifToastContainer');
        if (!container) {
            container = document.createElement('div');
            container.id = 'orderNotifToastContainer';
            container.className = 'fixed top-5 right-5 z-[9999] flex flex-col gap-3 max-w-sm w-full pointer-events-none px-4 sm:px-0';
            document.body.appendChild(container);
        }
        return container;
    }

    // Show floating toast popup for a new order
    function showOrderToast(order, isInitial = false) {
        const container = ensureToastContainer();

        const toast = document.createElement('div');
        toast.className = 'pointer-events-auto transform transition-all duration-300 translate-x-12 opacity-0 bg-stone-900 border-2 border-rose-500 text-white rounded-2xl p-4 shadow-2xl space-y-2.5 backdrop-blur-md relative overflow-hidden';
        
        // Glowing red accent bar
        const accent = document.createElement('div');
        accent.className = 'absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-rose-500 via-amber-400 to-rose-600 animate-pulse';
        toast.appendChild(accent);

        let actionUrl = window.location.pathname.startsWith('/admin') ? '/admin/orders' : null;
        let actionBtn = actionUrl 
            ? `<a href="${actionUrl}" class="px-3 py-1.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-white font-bold text-[11px] transition text-center">Lihat Antrean Dapur &rarr;</a>`
            : `<button type="button" onclick="window.OrderNotifier.openOrderPreview('${order.order_code}')" class="px-3 py-1.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-white font-bold text-[11px] transition text-center">Lihat Detail &rarr;</button>`;

        toast.innerHTML += `
            <div class="flex items-start justify-between gap-3">
                <div class="flex items-center gap-2">
                    <span class="flex h-3 w-3 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-rose-500"></span>
                    </span>
                    <span class="text-xs font-black uppercase tracking-wider text-rose-400">
                        ${isInitial ? 'Pesanan Aktif Menunggu' : 'Pesanan Baru Masuk!'}
                    </span>
                </div>
                <button type="button" class="text-stone-400 hover:text-white text-xs font-bold p-1 leading-none" onclick="this.closest('div.pointer-events-auto').remove()">
                    ✕
                </button>
            </div>

            <div class="space-y-1">
                <div class="flex items-center justify-between">
                    <span class="font-mono font-bold text-sm text-white">${order.order_code}</span>
                    <span class="font-mono font-bold text-xs text-amber-400">${order.total_formatted}</span>
                </div>
                <div class="text-xs text-stone-300">
                    <span class="font-semibold text-white">${order.customer_name}</span> • <span class="text-stone-400">${order.order_type_label}</span>
                </div>
                <p class="text-[11px] text-stone-400 line-clamp-1 italic">${order.items_summary}</p>
            </div>

            <div class="pt-1.5 flex items-center justify-between gap-2 border-t border-stone-800">
                <span class="text-[10px] text-stone-500 font-mono">${order.created_at_time || 'Baru saja'}</span>
                ${actionBtn}
            </div>
        `;

        container.appendChild(toast);

        // Animate in
        requestAnimationFrame(() => {
            toast.classList.remove('translate-x-12', 'opacity-0');
            toast.classList.add('translate-x-0', 'opacity-100');
        });

        // Auto remove after 9 seconds
        setTimeout(() => {
            if (toast.parentElement) {
                toast.classList.add('translate-x-12', 'opacity-0');
                setTimeout(() => toast.remove(), 350);
            }
        }, 9000);
    }

    // Update Notification Bell badge and dropdown
    function updateBellUI(activeCount, activeOrders) {
        const badges = [
            document.getElementById('posOrderNotifBadge'),
            document.getElementById('adminOrderNotifBadge')
        ];

        badges.forEach(badge => {
            if (!badge) return;
            if (activeCount > 0) {
                badge.textContent = activeCount > 99 ? '99+' : activeCount;
                badge.classList.remove('hidden');
                badge.classList.add('flex');
            } else {
                badge.classList.add('hidden');
                badge.classList.remove('flex');
            }
        });

        // Update dropdown lists if present
        const listContainers = [
            document.getElementById('posOrderNotifList'),
            document.getElementById('adminOrderNotifList')
        ];

        listContainers.forEach(container => {
            if (!container) return;
            if (!activeOrders || activeOrders.length === 0) {
                container.innerHTML = `
                    <div class="p-6 text-center text-stone-400 text-xs">
                        <svg class="w-8 h-8 mx-auto text-stone-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Belum ada pesanan baru yang menunggu.
                    </div>
                `;
                return;
            }

            let html = '';
            activeOrders.forEach(o => {
                let viewAction = window.location.pathname.startsWith('/admin')
                    ? `<a href="/admin/orders" class="text-rose-500 hover:underline font-bold text-[11px]">Proses di Dapur &rarr;</a>`
                    : `<button type="button" onclick="window.OrderNotifier.openOrderPreview('${o.order_code}')" class="text-rose-400 hover:underline font-bold text-[11px]">Lihat Detail &rarr;</button>`;

                html += `
                    <div class="p-3.5 border-b border-stone-800/80 hover:bg-stone-800/40 transition flex flex-col gap-1 text-xs">
                        <div class="flex items-center justify-between">
                            <span class="font-mono font-bold text-white text-xs">${o.order_code}</span>
                            <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-rose-950 text-rose-400 border border-rose-800/60">
                                Di Dapur
                            </span>
                        </div>
                        <div class="flex items-center justify-between text-stone-300 text-[11px]">
                            <span><strong>${o.customer_name}</strong> • ${o.order_type_label}</span>
                            <span class="font-mono font-bold text-amber-400">${o.total_formatted}</span>
                        </div>
                        <div class="text-[10px] text-stone-400 line-clamp-1 italic">${o.items_summary}</div>
                        <div class="pt-1 flex items-center justify-between text-[10px] text-stone-500">
                            <span>${o.created_at_diff || o.created_at_time}</span>
                            ${viewAction}
                        </div>
                    </div>
                `;
            });
            container.innerHTML = html;
        });
    }

    // Main Polling Loop
    async function checkOrders() {
        try {
            const url = `/orders/live-feed?last_id=${lastKnownId}`;
            const res = await fetch(url, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!res.ok) return;
            const data = await res.json();
            if (!data.success) return;

            // Handle first initialization
            if (!isInitialized) {
                lastKnownId = data.latest_id;
                isInitialized = true;
                updateBellUI(data.active_count, data.active_orders);

                // If user just logged in and there are active orders, show notification summary once
                if (data.active_count > 0 && data.active_orders && data.active_orders.length > 0) {
                    showOrderToast(data.active_orders[0], true);
                }
                return;
            }

            // If there are brand-new incoming orders
            if (data.new_orders && data.new_orders.length > 0) {
                lastKnownId = data.latest_id;
                playOrderChime();

                data.new_orders.forEach(order => {
                    showOrderToast(order, false);
                    showDesktopNotification(order);
                });

                // Update orders table if currently viewing admin orders page
                if (window.location.pathname === '/admin/orders') {
                    showRefreshNotice();
                }
            }

            updateBellUI(data.active_count, data.active_orders);
        } catch (err) {
            // Silently handle offline or momentary connection drops
        }
    }

    function showRefreshNotice() {
        const existing = document.getElementById('newOrderPageRefreshNotice');
        if (existing) return;

        const notice = document.createElement('div');
        notice.id = 'newOrderPageRefreshNotice';
        notice.className = 'fixed bottom-6 left-1/2 -translate-x-1/2 z-50 bg-stone-900 border-2 border-amber-400 text-white px-5 py-3 rounded-full shadow-2xl flex items-center gap-3 animate-bounce cursor-pointer';
        notice.innerHTML = `
            <span class="w-2.5 h-2.5 rounded-full bg-amber-400 animate-ping"></span>
            <span class="text-xs font-bold">Ada pesanan baru masuk! Klik untuk memuat ulang daftar.</span>
            <span class="text-xs bg-amber-400 text-stone-950 px-2 py-0.5 rounded-full font-black">Refresh</span>
        `;
        notice.onclick = () => window.location.reload();
        document.body.appendChild(notice);
    }

    // Start polling once DOM is ready
    function init() {
        requestDesktopPermission();
        checkOrders();
        pollInterval = setInterval(checkOrders, 4500); // Check every 4.5 seconds
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Expose global controller
    window.OrderNotifier = {
        playChime: playOrderChime,
        checkNow: checkOrders,
        toggleDrawer: function(drawerId) {
            const drawer = document.getElementById(drawerId);
            if (!drawer) return;
            const isHidden = drawer.classList.contains('hidden');
            if (isHidden) {
                drawer.classList.remove('hidden');
            } else {
                drawer.classList.add('hidden');
            }
        },
        openOrderPreview: function(orderCode) {
            window.open(`/order/track/${orderCode}`, '_blank');
        }
    };
})();
