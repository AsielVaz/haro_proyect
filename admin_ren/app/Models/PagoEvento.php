<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagoEvento extends Model
{
    protected $table = 'pago_evento';

    public $timestamps = false;

    protected $guarded = ['id'];
}
