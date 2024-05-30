<?php

namespace App\Http\Controllers;

use App\Models\PlanCategory;
use Illuminate\Http\Request;

class PlanCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PlanCategory::with(['plans'])->orderBy('id', 'DESC')->get()->toArray();
    }

    /**
     * Display a listing of the resource.
     */
    public function publicList()
    {
        return PlanCategory::with(['plans'])->whereHas('plans')->orderBy('id', 'ASC')->get()->toArray();
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
            'name' => 'required|string'
        ]);

        $category = PlanCategory::updateOrCreate(
            [
                'id' => $request->id
            ],
            [
                'name' => $request->name
            ]
        );

        if (!$category) {
            return response()->json(['error' => 'Something went wrong. Please try again!']);
        }

        return response()->json([
            'message' => 'Successfully saved category',
            'newItem' => $category
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
        $category = PlanCategory::find($id);

        if (!$category->delete()) {
            return response()->json(['error' => 'Something went wrong. Please try again!']);
        }

        return response()->json([
            'message' => 'Successfully deleted category'
        ], 200);
    }
}
