<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberDependent;
use Illuminate\Http\Request;

class MemberDependentController extends Controller
{
    public function store(Request $request, Member $member)
    {
        MemberDependent::where('member_id', $member->id)->delete();

        if ($request->dependents) {
            foreach ($request->dependents as $dependent) {
                MemberDependent::create([
                    'member_id' => $member->id,
                    'relationship' => $dependent['relationship'],
                    'name' => $dependent['name'],
                    'birth_date' => $dependent['birth_date'],
                    'phone_no' => isset($dependent['phone_no']) ? $dependent['phone_no'] : null
                ]);
            }
        }
    }
}
