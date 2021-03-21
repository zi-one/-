<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    public $table='student';
    public $primaryKey='s_id';
    public $guarded=[];
    public $timestamps=false;
}
