<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class studentCourse extends Model
{
    //
    public $table='studentcourse';
    public $primaryKey='sc_id';
    public $guarded=[];
    public $timestamps=false;
}
