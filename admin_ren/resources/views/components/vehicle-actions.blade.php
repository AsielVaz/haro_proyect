@props(['auto'])
<div class="inventory-actions" role="group" aria-label="Acciones de la unidad #{{ $auto->id }}">
                @if(!$auto->vendido)
                    <a class="inventory-button inventory-button--primary" href="{{ route('operaciones.index', ['seccion' => 'ventas', 'auto' => $auto->id]) }}"><x-icon name="sales" /> Vender</a>
                    <a class="inventory-button" href="{{ route('autos.edit', $auto) }}"><x-icon name="edit" /> Editar</a>
                    <details class="inventory-more"><summary><x-icon name="more" /><span>Más acciones</span><x-icon name="chevron" class="inventory-chevron" /></summary><div class="inventory-more__content"><form method="POST" action="{{ route('autos.renew', $auto) }}" data-confirm="La unidad pasará al inicio del inventario con un folio nuevo; sus imágenes y registros asociados se conservarán." data-confirm-title="¿Renovar publicación?" data-confirm-action="Renovar">@csrf @method('PATCH')<button class="inventory-option" type="submit"><x-icon name="refresh" /> Renovar</button></form>
                    <a class="inventory-option" href="{{ route('autos.qr', $auto) }}"><x-icon name="qr" /> Código QR</a>
                    <form method="POST" action="{{ route('autos.pause', $auto) }}" data-confirm="{{ $auto->pausado ? 'La unidad volverá a mostrarse públicamente.' : 'La unidad dejará de mostrarse públicamente.' }}" data-confirm-title="{{ $auto->pausado ? '¿Mostrar unidad?' : '¿Ocultar unidad?' }}" data-confirm-action="{{ $auto->pausado ? 'Mostrar' : 'Ocultar' }}">@csrf @method('PATCH')<button class="inventory-option" type="submit"><x-icon name="eye" /> {{ $auto->pausado ? 'Poner visible' : 'Ocultar' }}</button></form>
                    @if(!$auto->pausado)
                        <form method="POST" action="{{ route('autos.banner', $auto) }}" data-confirm="{{ $auto->en_banner ? 'La unidad se retirará del banner principal.' : 'La unidad se destacará en el banner principal del sitio.' }}" data-confirm-title="{{ $auto->en_banner ? '¿Quitar del banner?' : '¿Mostrar en banner?' }}" data-confirm-action="{{ $auto->en_banner ? 'Quitar' : 'Agregar' }}">@csrf @method('PATCH')<button class="inventory-option" type="submit"><x-icon name="image" /> {{ $auto->en_banner ? 'Quitar banner' : 'Poner banner' }}</button></form>
                    @endif
                    <form method="POST" action="{{ route('autos.destroy', $auto) }}" data-confirm="La unidad se archivará como vendida, se ocultará del sitio y saldrá del inventario disponible." data-confirm-title="¿Archivar como vendido?" data-confirm-action="Archivar auto" data-confirm-danger>@csrf @method('DELETE')<button class="inventory-option inventory-option--danger" type="submit"><x-icon name="archive" /> Archivar vendido</button></form></div></details>
                @else
                    <a class="inventory-button" href="{{ route('autos.edit', $auto) }}"><x-icon name="edit" /> Editar unidad</a>
                    <a class="inventory-button" href="{{ route('autos.qr', $auto) }}"><x-icon name="qr" /> Código QR</a>
                    <form method="POST" action="{{ route('autos.restore', $auto) }}" data-confirm="La unidad regresará al inventario en estado oculto para que puedas revisarla antes de publicarla." data-confirm-title="¿Recuperar unidad?" data-confirm-action="Recuperar">@csrf @method('PATCH')<button class="inventory-button inventory-button--primary" type="submit"><x-icon name="refresh" /> Recuperar</button></form>
                @endif
            </div>
