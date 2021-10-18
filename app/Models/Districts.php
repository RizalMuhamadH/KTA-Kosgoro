<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Districts extends Model
{
    use HasFactory;
    protected $table = 'districts';
    protected $primaryKey = 'id';
    protected $fillable = ['province_id','name'];

    public function SubDistricts(){
        return $this->hasMany(SubDistricts::class,'district_id','id');
    }

    public function Province(){
        return $this->belongsTo(Provinces::class,'province_id','id');
    }
}
