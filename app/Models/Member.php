<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'members';

    protected $guarded = [];

    protected $with = ['subscription'];

    public function subscription()
    {
        return $this->hasOne(Subscription::class, 'member_id', 'id');
    }
}
