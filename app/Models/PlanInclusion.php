<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanInclusion extends Model
{
    use HasFactory;

    protected $table = 'plan_inclusions';

    protected $guarded = [];
}
