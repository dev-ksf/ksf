<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = Member::with(['subscription'])
            ->orderBy('id', 'DESC')
            ->get()
            ->toArray();

        return $members;
    }

    public function store(Request $request, $user)
    {
        return Member::updateOrCreate(
            [
                'user_id' => $user->id
            ],
            [
                'user_id' => $user->id,
                'first_name' => $request->firstName,
                'last_name' => $request->lastName,
                'company' => $request->companyName,
                'house_no' => $request->address,
                'unit_no' => $request->landmark,
                'city' => $request->city,
                'country' => $request->state,
                'zip_code' => $request->zipcode,
                'phone_no' => $request->mobile,
                'email' => $user->email
            ]
        );
    }

    public function updateXenditCustomerId(Member $member, $xenditCustomer = null)
    {
        return Member::updateOrCreate(
            [
                'id' => $member->id
            ],
            [
                'xendit_customer_id' => $xenditCustomer ? $xenditCustomer->id : null
            ]
        );
    }
}
