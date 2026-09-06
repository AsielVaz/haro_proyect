<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interior extends Model
{
    protected $table = 'interiores';

    public $timestamps = false;

    protected $guarded = ['id'];
}
