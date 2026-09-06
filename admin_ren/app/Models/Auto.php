<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Auto extends Model
{
    protected $table = 'auto';

    public $timestamps = false;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return ['precio' => 'float', 'fecha_cap' => 'datetime', 'pausado' => 'boolean', 'vendido' => 'boolean', 'consig' => 'boolean', 'en_banner' => 'boolean'];
    }

    public function marca(): BelongsTo
    {
        return $this->belongsTo(Marca::class, 'id_marca');
    }

    public function modelo(): BelongsTo
    {
        return $this->belongsTo(Modelo::class, 'id_modelo');
    }

    public function transmision(): BelongsTo
    {
        return $this->belongsTo(Transmision::class, 'id_transmision');
    }

    public function interior(): BelongsTo
    {
        return $this->belongsTo(Interior::class, 'id_interiores');
    }

    public function almacen(): BelongsTo
    {
        return $this->belongsTo(Almacen::class, 'id_almacen');
    }

    public function imagenes(): HasMany
    {
        return $this->hasMany(Imagen::class, 'id_auto');
    }
}
