<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Villages extends Model
{
    use HasFactory;

    protected $table = 'villages';
    protected $primaryKey = 'id';
    protected $fillable = ['id','sub_district_id','name'];

    public function SubDistrict(){
        return $this->belongsTo(SubDistricts::class,'sub_district_id','id');
    }
}
