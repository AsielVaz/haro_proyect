<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transmision extends Model
{
    protected $table = 'transmision';

    public $timestamps = false;

    protected $guarded = ['id'];
}
