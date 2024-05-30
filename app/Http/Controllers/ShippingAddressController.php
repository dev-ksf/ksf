<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MemberShippingAddress;

class ShippingAddressController extends Controller
{
    public function store(Request $request, $member)
    {
        $shippingAddressData = [
            'house_no' => $request->address,
            'unit_no' => $request->landmark,
            'city' => $request->city,
            'country' => $request->state,
            'zip_code' => $request->zipcode,
        ];

        if ($request->hasDifShippingAddress) {
            $shippingAddressData = [
                'house_no' => $request->shippingAddress['address'],
                'unit_no' => $request->shippingAddress['landmark'],
                'city' => $request->shippingAddress['city'],
                'country' => $request->shippingAddress['state'],
                'zip_code' => $request->shippingAddress['zipcode'],
            ];
        }

        $shippingAddressData['member_id']  = $member->id;

        return MemberShippingAddress::updateOrCreate(['member_id' => $member->id], $shippingAddressData);
    }
}
