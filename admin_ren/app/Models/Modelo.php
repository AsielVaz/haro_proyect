<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Modelo extends Model
{
    protected $table = 'modelo';

    public $timestamps = false;

    protected $fillable = ['id_marca', 'modelo'];

    public function marca(): BelongsTo
    {
        return $this->belongsTo(Marca::class, 'id_marca');
    }

    public function autos(): HasMany
    {
        return $this->hasMany(Auto::class, 'id_modelo');
    }
}
