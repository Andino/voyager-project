<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Spatial;

class Parada extends Model
{
    use Spatial;

    protected $spatial = ['ubicacion'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'imagen', 'ubicacion',
    ];
}
