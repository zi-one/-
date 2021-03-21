<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    //
    public $table='course';
    public $primaryKey='c_id';
    public $guarded=[];
    public $timestamps=false;
}
