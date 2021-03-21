<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class applyCourse extends Model
{
    //
    public $table='applycourse';
    public $primaryKey='c_id';
    public $guarded=[];
    public $timestamps=false;
}
