<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteBanca extends Model
{
    protected $table = 'clientes_banca';

    public $timestamps = false;

    protected $guarded = ['id'];
}
