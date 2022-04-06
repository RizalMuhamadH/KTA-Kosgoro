<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Events extends Model
{
    use HasFactory, HasSlug, SoftDeletes;

    protected $table = 'events';
    protected $primaryKey = 'id';
    protected $fillable = ['slug','title','description','body','thumbnail','featured','category_id','user_id','status','meta_description','start_date','end_date'];
    protected $dates = ['deleted_at'];

    public function Category(){
        return $this->hasOne(CategoryEvent::class,'id','category_id');
    }

    public function Author(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }
}
