<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarHunter extends Model
{
    protected $table = 'car_hunter';

    public $timestamps = false;

    protected $guarded = ['id'];
}
