<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Constellation extends Model
{
    protected $table='constellation';


    public function items(){
        return $this->hasMany(ConstellationItem::class,'constellation_id','id');
    }
}
