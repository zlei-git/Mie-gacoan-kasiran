/**
 * Kedai Mie - Bespoke Luxury Modal System (Anti-Slop, High-Craft)
 */
const LuxuryModal = {
    activeModal: null,

    open(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) return;

        this.activeModal = modal;
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        // Allow DOM reflow then trigger transition
        requestAnimationFrame(() => {
            const backdrop = modal.querySelector('.modal-backdrop');
            const panel = modal.querySelector('.modal-panel');
            if (backdrop) backdrop.classList.remove('opacity-0');
            if (panel) {
                panel.classList.remove('opacity-0', 'scale-95', 'translate-y-4');
                panel.classList.add('opacity-100', 'scale-100', 'translate-y-0');
            }
        });
    },

    close(modalId) {
        const modal = modalId ? document.getElementById(modalId) : this.activeModal;
        if (!modal) return;

        const backdrop = modal.querySelector('.modal-backdrop');
        const panel = modal.querySelector('.modal-panel');

        if (backdrop) backdrop.classList.add('opacity-0');
        if (panel) {
            panel.classList.add('opacity-0', 'scale-95', 'translate-y-4');
            panel.classList.remove('opacity-100', 'scale-100', 'translate-y-0');
        }

        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            if (this.activeModal === modal) this.activeModal = null;
        }, 250);
    },

    showToastWarning(message) {
        if (typeof Cart !== 'undefined' && Cart.showWarningToast) {
            Cart.showWarningToast(message);
        } else {
            alert(message);
        }
    },

    // Open product customization modal
    openProductCustomizer(productData) {
        const modal = document.getElementById('productCustomizerModal');
        if (!modal) return;

        document.getElementById('customizerProductId').value = productData.id;
        document.getElementById('customizerProductCode').value = productData.code || '';
        document.getElementById('customizerProductName').textContent = productData.name;
        document.getElementById('customizerProductDesc').textContent = productData.description;
        document.getElementById('customizerProductPrice').textContent = 'Rp ' + parseInt(productData.price).toLocaleString('id-ID');
        document.getElementById('customizerProductBasePrice').value = productData.price;
        document.getElementById('customizerProductImage').src = productData.image;

        // Spicy level container
        const spicySection = document.getElementById('customizerSpicySection');
        const spicyLevelsContainer = document.getElementById('customizerSpicyLevels');
        if (productData.has_spicy_level) {
            spicySection.classList.remove('hidden');
            let spicyHtml = '';
            const maxLvl = productData.max_spicy_level || 8;
            for (let i = 0; i <= maxLvl; i++) {
                const label = i === 0 ? 'Original (0)' : `Level ${i}`;
                const isSelected = i === 1; // Default level 1
                spicyHtml += `
                    <label class="relative flex-1 cursor-pointer">
                        <input type="radio" name="spicy_level" value="${i}" ${isSelected ? 'checked' : ''} class="sr-only peer" onchange="LuxuryModal.onSpicyChange(${i})">
                        <div class="py-2.5 px-2 text-center rounded-xl border border-stone-200 peer-checked:border-red-600 peer-checked:bg-red-50 peer-checked:text-red-700 font-semibold text-xs transition-all hover:bg-stone-50">
                            <span>${label}</span>
                        </div>
                    </label>
                `;
            }
            spicyLevelsContainer.innerHTML = spicyHtml;
            this.onSpicyChange(1);
        } else {
            spicySection.classList.add('hidden');
        }

        // Reset Addons & Notes
        const addonsCheckboxes = modal.querySelectorAll('input[name="addons"]:checked');
        addonsCheckboxes.forEach(cb => cb.checked = false);
        const notesInput = document.getElementById('customizerNotes');
        if (notesInput) notesInput.value = '';

        // Reset Qty
        document.getElementById('customizerQty').value = 1;
        document.getElementById('customizerQtyDisplay').textContent = '1';

        this.open('productCustomizerModal');
    },

    onSpicyChange(level) {
        const indicator = document.getElementById('spicyIntensityText');
        if (!indicator) return;
        const descriptions = [
            'Level 0 (Non-pedas)',
            'Level 1 (Pedas Ringan)',
            'Level 2 (Pedas Sedang)',
            'Level 3 (Pedas Standar)',
            'Level 4 (Ekstra Pedas)',
            'Level 5 (Sangat Pedas)',
            'Level 6 (Super Pedas)',
            'Level 7 (Maksimal)',
            'Level 8 (Tingkat Tertinggi)'
        ];
        indicator.textContent = descriptions[level] || `Level ${level}`;
    },

    changeQty(delta) {
        const input = document.getElementById('customizerQty');
        const display = document.getElementById('customizerQtyDisplay');
        let current = parseInt(input.value, 10) || 1;
        current += delta;
        if (current < 1) current = 1;
        input.value = current;
        display.textContent = current;
    },

    submitCustomizer() {
        const id = document.getElementById('customizerProductId').value;
        const code = document.getElementById('customizerProductCode').value;
        const name = document.getElementById('customizerProductName').textContent;
        const price = parseInt(document.getElementById('customizerProductBasePrice').value, 10);
        const image = document.getElementById('customizerProductImage').src;
        const qty = parseInt(document.getElementById('customizerQty').value, 10) || 1;
        const notes = document.getElementById('customizerNotes')?.value || '';

        const spicyRadio = document.querySelector('input[name="spicy_level"]:checked');
        const spicyLevel = spicyRadio ? parseInt(spicyRadio.value, 10) : null;

        const checkedAddons = Array.from(document.querySelectorAll('input[name="addons"]:checked'))
            .map(cb => cb.value)
            .join(', ');

        Cart.addItem({
            id,
            code,
            name,
            price,
            image,
            quantity: qty,
            spicy_level: spicyLevel,
            addons: checkedAddons,
            notes
        });

        this.close('productCustomizerModal');
        CartDrawer.open();
    }
};

/**
 * Slide-over Cart Drawer Manager
 */
const CartDrawer = {
    open() {
        const drawer = document.getElementById('cartDrawer');
        if (!drawer) return;
        drawer.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        requestAnimationFrame(() => {
            const backdrop = drawer.querySelector('.drawer-backdrop');
            const panel = drawer.querySelector('.drawer-panel');
            if (backdrop) backdrop.classList.remove('opacity-0');
            if (panel) panel.classList.remove('translate-x-full');
        });
    },

    close() {
        const drawer = document.getElementById('cartDrawer');
        if (!drawer) return;
        const backdrop = drawer.querySelector('.drawer-backdrop');
        const panel = drawer.querySelector('.drawer-panel');

        if (backdrop) backdrop.classList.add('opacity-0');
        if (panel) panel.classList.add('translate-x-full');

        setTimeout(() => {
            drawer.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }, 300);
    }
};

// Global Keyboard Escape listener
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        if (LuxuryModal.activeModal) {
            LuxuryModal.close();
        }
        CartDrawer.close();
    }
});
