<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioHaro extends Model
{
    protected $table = 'usuario';

    public $timestamps = false;

    protected $guarded = ['id'];

    protected $hidden = ['contrasena'];
}
