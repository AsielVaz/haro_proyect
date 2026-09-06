<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Imagen extends Model
{
    protected $table = 'imagen';

    public $timestamps = false;

    protected $fillable = ['id_auto', 'url', 'fecha_subida'];

    protected function casts(): array
    {
        return ['fecha_subida' => 'datetime'];
    }

    public function auto(): BelongsTo
    {
        return $this->belongsTo(Auto::class, 'id_auto');
    }
}
