<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\PlanInclusion;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Plan::with(['category'])->orderBy('id', 'DESC')->get()->toArray();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function updateOrCreate(Request $request)
    {
        $request->validate([
            'planName' => 'required|string',
            'categoryId' => 'required',
            'semiAnnualPrice' => 'required',
            'annualPrice' => 'required'
        ]);

        $category = Plan::updateOrCreate(
            [
                'id' => $request->id
            ],
            [
                'plan_category_id' => $request->categoryId,
                'plan_name' => $request->planName,
                'description' => $request->description,
                'semi_annual_price' => $request->semiAnnualPrice,
                'semi_annual_dependent_price' => $request->semiAnnualDependentPrice,
                'annual_price' => $request->annualPrice,
                'annual_dependent_price' => $request->annualDependentPrice,
                'is_recommended' => $request->isRecommended
            ]
        );

        if ($request->inclusions) {

            PlanInclusion::where('plan_id', $category->id)->delete();

            foreach ($request->inclusions as $inclusion) {
                PlanInclusion::create([
                    'plan_id' => $category->id,
                    'name' => $inclusion
                ]);
            }
        }


        if (!$category) {
            return response()->json(['error' => 'Something went wrong. Please try again!']);
        }

        return response()->json([
            'message' => 'Successfully saved plan',
            'newItem' => Plan::where('id', $category->id)->with(['category'])->first()
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $plan = Plan::find($id);

        if (!$plan->delete()) {
            return response()->json(['error' => 'Something went wrong. Please try again!']);
        }

        return response()->json([
            'message' => 'Successfully deleted plan'
        ], 200);
    }
}
