<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubDistricts extends Model
{
    use HasFactory;
    protected $table = 'sub_districts';
    protected $primaryKey = 'id';
    protected $fillable = ['district_id','name'];

    public function Villages(){
        return $this->hasMany(Villages::class,'sub_district_id','id');
    }

    public function District(){
        return $this->belongsTo(Districts::class,'district_id','id');
    }
}
