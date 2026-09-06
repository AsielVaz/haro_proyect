const sidebar = document.querySelector('#sidebar');
const overlay = document.querySelector('[data-sidebar-overlay]');
const sidebarToggle = document.querySelector('[data-sidebar-toggle]');
const desktop = window.matchMedia('(min-width: 1024px)');
const main = document.querySelector('#main-content');

const setSidebar = (open, restoreFocus = false) => {
    if (!sidebar) return;
    const mobileOpen = open && !desktop.matches;
    sidebar.classList.toggle('-translate-x-full', !mobileOpen);
    sidebar.inert = !desktop.matches && !mobileOpen;
    overlay?.classList.toggle('hidden', !mobileOpen);
    sidebarToggle?.setAttribute('aria-expanded', String(mobileOpen));
    sidebarToggle?.setAttribute('aria-label', mobileOpen ? 'Cerrar menú' : 'Abrir menú');
    document.body.classList.toggle('menu-open', mobileOpen);
    if (main) main.inert = mobileOpen;
    if (mobileOpen) sidebar.querySelector('[data-sidebar-close]')?.focus();
    else if (restoreFocus) sidebarToggle?.focus();
};
sidebarToggle?.addEventListener('click', () => setSidebar(sidebarToggle.getAttribute('aria-expanded') !== 'true'));
overlay?.addEventListener('click', () => setSidebar(false, true));
document.querySelector('[data-sidebar-close]')?.addEventListener('click', () => setSidebar(false, true));
desktop.addEventListener('change', () => setSidebar(false));
setSidebar(false);
document.addEventListener('keydown', (event) => {
    if (!document.body.classList.contains('menu-open')) return;
    if (event.key === 'Escape') setSidebar(false, true);
    if (event.key !== 'Tab') return;
    const focusable = [...sidebar.querySelectorAll('a[href], button, input, select')].filter(el => !el.disabled && el.getClientRects().length);
    const first = focusable[0];
    const last = focusable.at(-1);
    if (event.shiftKey && document.activeElement === first) { event.preventDefault(); last?.focus(); }
    else if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first?.focus(); }
});

const dismissAlert = (alert) => {
    if (!alert || alert.classList.contains('is-leaving')) return;
    alert.classList.add('is-leaving');
    window.setTimeout(() => alert.remove(), 450);
};

document.querySelectorAll('[data-liquid-alert]').forEach((alert, index) => {
    window.setTimeout(() => alert.classList.add('is-visible'), 80 * index);
    alert.querySelector('[data-alert-close]')?.addEventListener('click', () => dismissAlert(alert));
    if (alert.classList.contains('liquid-alert--success')) {
        window.setTimeout(() => dismissAlert(alert), 6000 + (index * 350));
    }
});

const confirmDialog = document.querySelector('[data-confirm-dialog]');
let pendingForm = null;

document.addEventListener('submit', (event) => {
    const form = event.target.closest('form[data-confirm]');
    if (!form || form.dataset.confirmed === 'true' || !confirmDialog) return;

    event.preventDefault();
    pendingForm = form;
    confirmDialog.querySelector('[data-confirm-title]').textContent = form.dataset.confirmTitle || '¿Deseas continuar?';
    confirmDialog.querySelector('[data-confirm-message]').textContent = form.dataset.confirm;
    confirmDialog.querySelector('[data-confirm-accept]').textContent = form.dataset.confirmAction || 'Confirmar';
    confirmDialog.classList.toggle('is-danger', form.hasAttribute('data-confirm-danger'));
    confirmDialog.showModal();
    confirmDialog.querySelector('[data-confirm-cancel]')?.focus();
});

confirmDialog?.querySelector('[data-confirm-cancel]')?.addEventListener('click', () => {
    confirmDialog.close();
    pendingForm = null;
});

confirmDialog?.querySelector('[data-confirm-accept]')?.addEventListener('click', () => {
    if (!pendingForm) return;
    pendingForm.dataset.confirmed = 'true';
    confirmDialog.close();
    pendingForm.requestSubmit();
});

confirmDialog?.addEventListener('click', (event) => {
    const bounds = confirmDialog.getBoundingClientRect();
    if (event.target === confirmDialog && (event.clientX < bounds.left || event.clientX > bounds.right || event.clientY < bounds.top || event.clientY > bounds.bottom)) {
        confirmDialog.close();
        pendingForm = null;
    }
});

window.HaroAlert = (message, type = 'success', title = 'Haro Smart') => {
    const stack = document.querySelector('.liquid-alert-stack');
    if (!stack) return;
    const alert = document.createElement('article');
    alert.className = `liquid-alert liquid-alert--${type}`;
    alert.dataset.liquidAlert = '';
    alert.setAttribute('role', 'status');
    alert.innerHTML = `<div class="liquid-alert__shine"></div><div class="liquid-alert__icon">${type === 'success' ? '✓' : type === 'warning' ? '!' : '×'}</div><div class="min-w-0 flex-1"><p class="liquid-alert__title"></p><p class="liquid-alert__message"></p></div><button type="button" class="liquid-alert__close" aria-label="Cerrar alerta">×</button><span class="liquid-alert__timer"></span>`;
    alert.querySelector('.liquid-alert__title').textContent = title;
    alert.querySelector('.liquid-alert__message').textContent = message;
    alert.querySelector('.liquid-alert__close').addEventListener('click', () => dismissAlert(alert));
    stack.append(alert);
    requestAnimationFrame(() => alert.classList.add('is-visible'));
    if (type === 'success') window.setTimeout(() => dismissAlert(alert), 6000);
    else alert.querySelector('.liquid-alert__timer')?.remove();
};

window.HaroAdmin = {
    filterModels() {
        const brand = document.querySelector('#brand');
        const model = document.querySelector('#model');
        if (!brand || !model) return;

        const filter = () => {
            [...model.options].forEach((option) => {
                if (!option.dataset.brand) return;
                option.hidden = option.dataset.brand !== brand.value;
            });
            if (model.selectedOptions[0]?.hidden) model.value = '';
        };
        brand.addEventListener('change', filter);
        filter();
    },
};

confirmDialog?.addEventListener('close', () => { pendingForm = null; });

window.HaroAdmin.filterModels();

document.querySelector('[data-password-toggle]')?.addEventListener('click', (event) => {
    const button = event.currentTarget;
    const password = document.getElementById(button.getAttribute('aria-controls'));
    const visible = password.type === 'password';
    password.type = visible ? 'text' : 'password';
    button.textContent = visible ? 'Ocultar' : 'Mostrar';
    button.setAttribute('aria-pressed', String(visible));
});

const upload = document.querySelector('[data-upload-input]');
let previewUrls = [];
upload?.addEventListener('change', () => {
    const preview = document.querySelector('[data-upload-preview]');
    const status = document.querySelector('[data-upload-status]');
    previewUrls.forEach(url => URL.revokeObjectURL(url));
    previewUrls = [];
    preview.replaceChildren();
    const files = [...upload.files];
    status.textContent = files.length ? files.length + ' fotografía(s) seleccionada(s). ' + (files.length > 12 ? 'Vista previa de las primeras 12.' : 'Listas para subir.') : '';
    files.slice(0, 12).filter(file => ['image/jpeg', 'image/png', 'image/webp'].includes(file.type)).forEach(file => {
        const url = URL.createObjectURL(file);
        previewUrls.push(url);
        const image = document.createElement('img');
        image.src = url;
        image.alt = file.name;
        preview.append(image);
    });
});
window.addEventListener('pagehide', () => previewUrls.forEach(url => URL.revokeObjectURL(url)));

const mediaLibrary = document.querySelector('.media-library');
if (mediaLibrary) {
    const counter = mediaLibrary.querySelector('[data-gallery-count]');
    const updateGalleryCount = () => {
        const selected = mediaLibrary.querySelectorAll('input[name="gallery_images[]"]:checked').length;
        counter.hidden = false;
        counter.textContent = selected === 1 ? '1 seleccionada' : selected + ' seleccionadas';
        counter.classList.toggle('has-selection', selected > 0);
    };
    mediaLibrary.addEventListener('change', updateGalleryCount);
    window.addEventListener('pageshow', updateGalleryCount);
    updateGalleryCount();
}

const inventoryRows = document.querySelectorAll('.inventory-row, [data-inventory-context]');
if (inventoryRows.length) {
    const contextMenu = document.createElement('div');
    contextMenu.className = 'inventory-context-menu';
    contextMenu.id = 'inventory-context-menu';
    contextMenu.setAttribute('role', 'menu');
    contextMenu.hidden = true;
    document.body.append(contextMenu);
    let activeRow = null;

    const closeContextMenu = (restoreFocus = false) => {
        contextMenu.hidden = true;
        if (activeRow) {
            activeRow.setAttribute('aria-expanded', 'false');
            if (restoreFocus) activeRow.focus({ preventScroll: true });
        }
        activeRow = null;
    };

    const openContextMenu = (row, x, y) => {
        closeContextMenu();
        const source = row.hasAttribute('data-context-all')
            ? row.querySelector('.inventory-actions')
            : row.querySelector('.inventory-more__content') || row.querySelector('.inventory-actions');
        const actions = source ? [...source.querySelectorAll('a[href], button:not(:disabled)')] : [];
        if (!actions.length) return;
        activeRow = row;
        row.setAttribute('aria-expanded', 'true');
        contextMenu.replaceChildren();
        contextMenu.setAttribute('aria-label', row.querySelector('.inventory-actions').getAttribute('aria-label'));

        actions.forEach(action => {
            const item = action.cloneNode(true);
            item.removeAttribute('id');
            item.removeAttribute('form');
            item.className = 'inventory-context-menu__item';
            item.classList.toggle('is-danger', action.classList.contains('inventory-option--danger'));
            item.setAttribute('role', 'menuitem');
            item.tabIndex = -1;
            if (item.tagName === 'BUTTON') {
                item.type = 'button';
                item.addEventListener('click', () => {
                    closeContextMenu(true);
                    action.form?.requestSubmit(action);
                });
            } else {
                item.addEventListener('click', () => closeContextMenu(true));
            }
            contextMenu.append(item);
        });

        contextMenu.hidden = false;
        const bounds = contextMenu.getBoundingClientRect();
        contextMenu.style.left = Math.max(8, Math.min(x, window.innerWidth - bounds.width - 8)) + 'px';
        contextMenu.style.top = Math.max(8, Math.min(y, window.innerHeight - bounds.height - 8)) + 'px';
        contextMenu.querySelector('[role="menuitem"]')?.focus({ preventScroll: true });
    };

    inventoryRows.forEach(row => {
        row.tabIndex = 0;
        row.setAttribute('aria-haspopup', 'menu');
        row.setAttribute('aria-controls', contextMenu.id);
        row.setAttribute('aria-expanded', 'false');
        row.addEventListener('contextmenu', event => {
            if (event.target.closest('input, textarea, select, [contenteditable="true"]')) return;
            event.preventDefault();
            const bounds = row.getBoundingClientRect();
            openContextMenu(row, event.clientX || bounds.left + 20, event.clientY || bounds.top + 20);
        });
        row.addEventListener('keydown', event => {
            if (event.key === 'ContextMenu' || (event.shiftKey && event.key === 'F10')) {
                event.preventDefault();
                const bounds = row.getBoundingClientRect();
                openContextMenu(row, bounds.left + 20, bounds.top + 20);
            }
        });
    });

    contextMenu.addEventListener('keydown', event => {
        if (event.key === 'Escape' || event.key === 'Tab') {
            event.preventDefault();
            closeContextMenu(true);
            return;
        }
        const items = [...contextMenu.querySelectorAll('[role="menuitem"]')];
        const current = items.indexOf(document.activeElement);
        let next;
        if (event.key === 'ArrowDown') next = (current + 1) % items.length;
        if (event.key === 'ArrowUp') next = (current - 1 + items.length) % items.length;
        if (event.key === 'Home') next = 0;
        if (event.key === 'End') next = items.length - 1;
        if (next !== undefined) {
            event.preventDefault();
            items[next].focus();
        }
    });
    document.addEventListener('pointerdown', event => {
        if (!contextMenu.contains(event.target)) closeContextMenu();
    });
    document.addEventListener('scroll', event => {
        if (!contextMenu.contains(event.target)) closeContextMenu();
    }, true);
    window.addEventListener('resize', () => closeContextMenu());
    window.addEventListener('blur', () => closeContextMenu());
}

let closeVehiclePicker = null;
document.querySelectorAll('[data-vehicle-picker]').forEach(picker => {
    const select = picker.querySelector('[data-vehicle-select]');
    const normalize = value => value.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase().trim();
    const options = [...select.options].filter(option => option.value).map(option => ({ value: option.value, label: option.textContent, searchable: normalize(option.textContent) }));
    const trigger = document.createElement('button');
    trigger.type = 'button';
    trigger.className = 'field vehicle-picker__trigger';
    trigger.setAttribute('aria-haspopup', 'listbox');
    trigger.setAttribute('aria-expanded', 'false');
    trigger.setAttribute('aria-label', select.getAttribute('aria-label'));
    const caption = document.createElement('span');
    trigger.append(caption);
    const updateCaption = () => {
        caption.textContent = select.selectedOptions[0]?.textContent || 'Selecciona un auto';
        trigger.classList.toggle('has-value', Boolean(select.value));
        if (select.value) trigger.removeAttribute('aria-invalid');
    };
    picker.append(trigger);
    select.classList.add('sr-only');
    select.tabIndex = -1;
    select.setAttribute('aria-hidden', 'true');
    const popup = document.createElement('div');
    popup.className = 'vehicle-picker__popup';
    popup.hidden = true;
    const search = document.createElement('input');
    search.type = 'search';
    search.className = 'field vehicle-picker__input';
    search.placeholder = 'Folio, marca, modelo o año';
    search.autocomplete = 'off';
    search.setAttribute('aria-label', 'Buscar auto');
    search.setAttribute('role', 'combobox');
    search.setAttribute('aria-autocomplete', 'list');
    search.setAttribute('aria-expanded', 'false');
    const list = document.createElement('div');
    list.id = select.id + '-list';
    list.className = 'vehicle-picker__list';
    list.setAttribute('role', 'listbox');
    list.setAttribute('aria-label', 'Autos disponibles');
    search.setAttribute('aria-controls', list.id);
    trigger.setAttribute('aria-controls', list.id);
    const status = document.createElement('p');
    status.className = 'vehicle-picker__status';
    status.setAttribute('role', 'status');
    popup.append(search, list, status);
    document.body.append(popup);
    let matches = [];
    let active = -1;
    const close = (restore = false) => {
        popup.hidden = true;
        trigger.setAttribute('aria-expanded', 'false');
        search.setAttribute('aria-expanded', 'false');
        search.removeAttribute('aria-activedescendant');
        if (closeVehiclePicker === close) closeVehiclePicker = null;
        if (restore) trigger.focus({ preventScroll: true });
    };
    const highlight = index => {
        active = index;
        [...list.children].forEach((item, i) => item.classList.toggle('is-active', i === active));
        const item = list.children[active];
        if (item) {
            search.setAttribute('aria-activedescendant', item.id);
            item.scrollIntoView({ block: 'nearest' });
        } else search.removeAttribute('aria-activedescendant');
    };
    const choose = index => {
        if (!matches[index]) return;
        select.value = matches[index].value;
        select.dispatchEvent(new Event('change', { bubbles: true }));
        close(true);
    };
    const render = () => {
        const words = normalize(search.value).split(/\s+/).filter(Boolean);
        matches = options.filter(option => words.every(word => option.searchable.includes(word)));
        list.replaceChildren(...matches.map((option, index) => {
            const item = document.createElement('div');
            item.id = list.id + '-' + index;
            item.className = 'vehicle-picker__option';
            item.setAttribute('role', 'option');
            item.setAttribute('aria-selected', String(option.value === select.value));
            item.textContent = option.label;
            item.addEventListener('pointerdown', event => event.preventDefault());
            item.addEventListener('click', () => choose(index));
            return item;
        }));
        status.textContent = matches.length ? matches.length + ' autos disponibles' : 'Sin coincidencias. Prueba otra búsqueda.';
        active = -1;
        search.removeAttribute('aria-activedescendant');
        list.scrollTop = 0;
    };
    const open = () => {
        closeVehiclePicker?.();
        closeVehiclePicker = close;
        search.value = '';
        render();
        popup.hidden = false;
        trigger.setAttribute('aria-expanded', 'true');
        search.setAttribute('aria-expanded', 'true');
        const rect = trigger.getBoundingClientRect();
        const below = window.innerHeight - rect.bottom - 12;
        const above = rect.top - 12;
        const upwards = below < 260 && above > below;
        const height = Math.min(340, Math.max(100, upwards ? above : below));
        const width = Math.min(Math.max(rect.width, 280), window.innerWidth - 16);
        popup.style.width = width + 'px';
        popup.style.maxHeight = height + 'px';
        list.style.maxHeight = Math.max(30, height - 108) + 'px';
        popup.style.left = Math.max(8, Math.min(rect.left, window.innerWidth - width - 8)) + 'px';
        popup.style.top = upwards ? Math.max(8, rect.top - popup.offsetHeight - 6) + 'px' : rect.bottom + 6 + 'px';
        search.focus({ preventScroll: true });
    };
    trigger.addEventListener('click', () => popup.hidden ? open() : close(true));
    trigger.addEventListener('keydown', event => {
        if (event.key === 'ArrowDown' || event.key === 'ArrowUp') { event.preventDefault(); open(); }
    });
    search.addEventListener('input', render);
    search.addEventListener('keydown', event => {
        if (event.key === 'Escape') { event.preventDefault(); close(true); }
        if (event.key === 'Tab') close(true);
        if (event.key === 'Enter') { event.preventDefault(); choose(active); }
        if ((event.key === 'ArrowDown' || event.key === 'ArrowUp') && matches.length) {
            event.preventDefault();
            highlight(event.key === 'ArrowDown' ? (active + 1) % matches.length : (active <= 0 ? matches.length - 1 : active - 1));
        }
    });
    select.addEventListener('change', updateCaption);
    select.addEventListener('invalid', event => {
        event.preventDefault();
        trigger.setAttribute('aria-invalid', 'true');
        open();
        status.textContent = 'Selecciona un auto para asignar la fotografía.';
    });
    document.addEventListener('pointerdown', event => {
        if (!popup.hidden && !picker.contains(event.target) && !popup.contains(event.target)) close();
    });
    document.addEventListener('scroll', event => {
        if (!popup.hidden && !popup.contains(event.target)) close();
    }, true);
    window.addEventListener('resize', () => close());
    updateCaption();
});

const assignmentsForm = document.querySelector('[data-gallery-assignments]');
if (assignmentsForm) {
    const selects = [...document.querySelectorAll('[data-assignment-card] [data-vehicle-select]')];
    const count = assignmentsForm.querySelector('[data-assignment-count]');
    const save = assignmentsForm.querySelector('[data-save-assignments]');
    let pending = 0;
    let saving = false;
    const updateAssignments = () => {
        pending = selects.filter(select => select.value).length;
        count.textContent = pending === 1 ? '1 fotografía por guardar' : pending + ' fotografías por guardar';
        save.disabled = pending === 0;
        selects.forEach(select => {
            const card = select.closest('[data-assignment-card]');
            card.classList.toggle('has-assignment', Boolean(select.value));
            card.querySelector('[data-assignment-pending]').hidden = !select.value;
            card.querySelector('[data-clear-assignment]').hidden = !select.value;
        });
    };
    selects.forEach(select => {
        select.addEventListener('change', updateAssignments);
        select.closest('[data-assignment-card]').querySelector('[data-clear-assignment]').addEventListener('click', () => {
            select.value = '';
            select.dispatchEvent(new Event('change', { bubbles: true }));
        });
    });
    document.addEventListener('submit', event => {
        if (event.target === assignmentsForm && !event.defaultPrevented) saving = true;
    });
    window.addEventListener('beforeunload', event => {
        if (pending > 0 && !saving) {
            event.preventDefault();
            event.returnValue = '';
        }
    });
    window.addEventListener('pageshow', () => { saving = false; updateAssignments(); });
    updateAssignments();
}
