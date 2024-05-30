<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberShippingAddress extends Model
{
    use HasFactory;

    protected $table = 'members_shipping_address';

    protected $guarded = [];

    public function belongs()
    {
        return $this->hasMany(Member::class, 'member_id', 'id');
    }
}
