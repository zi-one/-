<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class teacherCourse extends Model
{
    //
    public $table='teachercourse';
    public $primaryKey='tc_id';
    public $guarded=[];
    public $timestamps=false;
}
