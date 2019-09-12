<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberOpen extends Model
{
    protected $table='member_open';

    const Zone_Google='google';
    const Zone_Facebook='facebook';
    //

    public function member(){
        return $this->hasOne(Member::class,'id','member_id');
    }
}
