<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    //
    public $table='teacher';
    public $primaryKey='t_id';
    public $guarded=[];
    public $timestamps=false;
}
