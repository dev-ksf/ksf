<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'plan_categories';

    protected $guarded = [];

    public function plans()
    {
        return $this->hasMany(Plan::class, 'plan_category_id', 'id');
    }
}
