const sidebar = document.querySelector('#sidebar');
const overlay = document.querySelector('[data-sidebar-overlay]');

document.querySelector('[data-sidebar-toggle]')?.addEventListener('click', () => {
    sidebar?.classList.toggle('-translate-x-full');
    overlay?.classList.toggle('hidden');
});

overlay?.addEventListener('click', () => {
    sidebar?.classList.add('-translate-x-full');
    overlay.classList.add('hidden');
});

const dismissAlert = (alert) => {
    if (!alert || alert.classList.contains('is-leaving')) return;
    alert.classList.add('is-leaving');
    window.setTimeout(() => alert.remove(), 450);
};

document.querySelectorAll('[data-liquid-alert]').forEach((alert, index) => {
    window.setTimeout(() => alert.classList.add('is-visible'), 80 * index);
    alert.querySelector('[data-alert-close]')?.addEventListener('click', () => dismissAlert(alert));
    window.setTimeout(() => dismissAlert(alert), 6000 + (index * 350));
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
    if (event.target === confirmDialog) {
        confirmDialog.close();
        pendingForm = null;
    }
});

window.HaroAlert = (message, type = 'success', title = 'HARO Motor') => {
    const stack = document.querySelector('.liquid-alert-stack');
    if (!stack) return;
    const alert = document.createElement('article');
    alert.className = `liquid-alert liquid-alert--${type}`;
    alert.dataset.liquidAlert = '';
    alert.innerHTML = `<div class="liquid-alert__shine"></div><div class="liquid-alert__icon">${type === 'success' ? '✓' : type === 'warning' ? '!' : '×'}</div><div class="min-w-0 flex-1"><p class="liquid-alert__title"></p><p class="liquid-alert__message"></p></div><button type="button" class="liquid-alert__close" aria-label="Cerrar alerta">×</button><span class="liquid-alert__timer"></span>`;
    alert.querySelector('.liquid-alert__title').textContent = title;
    alert.querySelector('.liquid-alert__message').textContent = message;
    alert.querySelector('.liquid-alert__close').addEventListener('click', () => dismissAlert(alert));
    stack.append(alert);
    requestAnimationFrame(() => alert.classList.add('is-visible'));
    window.setTimeout(() => dismissAlert(alert), 6000);
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
