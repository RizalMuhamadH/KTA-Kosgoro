<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $table = 'members';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'nik',
        'no_member',
        'photo',
        'id_card_photo',
        'address',
        'province_id',
        'district_id',
        'sub_district_id',
        'village_id',
        'post_code',
        'qr_code',
        'status',
        'token',
        'password',
        'otp_used',
        'position_id',
        'active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function Province(){
        return $this->hasOne(Provinces::class,'id','province_id');
    }

    public function District(){
        return $this->hasOne(Districts::class,'id','district_id');
    }

    public function SubDistrict(){
        return $this->hasOne(SubDistricts::class,'id','sub_district_id');
    }

    public function Village(){
        return $this->hasOne(Villages::class,'id','village_id');
    }

    public function Position(){
        return $this->hasOne(Position::class,'id','position_id');
    }
}
