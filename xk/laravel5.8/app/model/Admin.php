<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    //
    public $table='admin';
    public $primaryKey='a_id';
    public $guarded=[];
    public $timestamps=false;
}
