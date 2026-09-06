@php
    $alerts = collect([
        session('success') ? ['type' => 'success', 'title' => 'Operación completada', 'message' => session('success')] : null,
        session('warning') ? ['type' => 'warning', 'title' => 'Atención', 'message' => session('warning')] : null,
        session('error') ? ['type' => 'error', 'title' => 'No se pudo completar', 'message' => session('error')] : null,
    ])->filter();

    if ($errors->any()) {
        $alerts->push([
            'type' => 'error',
            'title' => 'Revisa la información',
            'message' => $errors->count() === 1 ? $errors->first() : 'Hay '.$errors->count().' campos que necesitan atención.',
            'details' => $errors->all(),
        ]);
    }
@endphp

<div class="liquid-alert-stack" aria-live="polite" aria-atomic="true">
    @foreach($alerts as $alert)
        <article class="liquid-alert liquid-alert--{{ $alert['type'] }}" data-liquid-alert role="status">
            <div class="liquid-alert__shine"></div>
            <div class="liquid-alert__icon" aria-hidden="true">
                @if($alert['type'] === 'success') ✓ @elseif($alert['type'] === 'warning') ! @else × @endif
            </div>
            <div class="min-w-0 flex-1">
                <p class="liquid-alert__title">{{ $alert['title'] }}</p>
                <p class="liquid-alert__message">{{ $alert['message'] }}</p>
                @if(!empty($alert['details']) && count($alert['details']) > 1)
                    <ul class="liquid-alert__details">@foreach($alert['details'] as $detail)<li>{{ $detail }}</li>@endforeach</ul>
                @endif
            </div>
            <button type="button" class="liquid-alert__close" data-alert-close aria-label="Cerrar alerta">×</button>
            @if($alert['type'] === 'success')<span class="liquid-alert__timer"></span>@endif
        </article>
    @endforeach
</div>

<dialog class="liquid-confirm" data-confirm-dialog aria-labelledby="confirm-title" aria-describedby="confirm-message">
    <div class="liquid-confirm__orb"></div>
    <div class="relative">
        <span class="liquid-confirm__icon" data-confirm-icon>!</span>
        <p class="eyebrow mt-5">Confirmar operación</p>
        <h2 class="mt-1 text-2xl font-black" id="confirm-title" data-confirm-title>¿Deseas continuar?</h2>
        <p class="mt-3 text-sm leading-6 text-slate-600" id="confirm-message" data-confirm-message>Esta acción modificará la información del sistema.</p>
        <div class="mt-7 flex justify-end gap-3">
            <button type="button" class="btn-secondary" data-confirm-cancel autofocus>Cancelar</button>
            <button type="button" class="btn-primary" data-confirm-accept>Confirmar</button>
        </div>
    </div>
</dialog>
