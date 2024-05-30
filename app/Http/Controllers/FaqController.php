<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Faq::get()->toArray();
    }

    public function updateOrCreate(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required'
        ]);

        $faq = Faq::updateOrCreate(
            [
                'id' => $request->id
            ],
            [
                'question' => $request->question,
                'answer' => $request->answer,
            ]
        );

        if (!$faq) {
            return response()->json(['error' => 'Something went wrong. Please try again!']);
        }

        return response()->json([
            'message' => 'Successfully saved FAQ',
            'newItem' => Faq::where('id', $faq->id)->first()
        ], 200);
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
        $faq = Faq::find($id);

        if (!$faq->delete()) {
            return response()->json(['error' => 'Something went wrong. Please try again!']);
        }

        return response()->json([
            'message' => 'Successfully deleted FAQ'
        ], 200);
    }
}
