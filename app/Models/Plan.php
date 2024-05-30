<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'plans';

    protected $with = ['inclusions', 'category'];

    protected $guarded = [];

    public function inclusions()
    {
        return $this->hasMany(PlanInclusion::class, 'plan_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(PlanCategory::class, 'plan_category_id', 'id');
    }
}
