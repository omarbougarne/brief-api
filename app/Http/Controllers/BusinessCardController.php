<?php

namespace App\Http\Controllers;

use App\Models\BusinessCard;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $businessCards = BusinessCard::where('user_id', $userId)->get();
        return response()->json($businessCards, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userId = $request->user()->id;
        // if (!$userId) {
        //     return response()->json(['error' => 'Unauthenticated.'], 401);
        // }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        $businessCard = new BusinessCard($validatedData);
        $businessCard->user_id = $userId;
        $businessCard->save();
        return response()->json($businessCard, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $businessCard = BusinessCard::where('user_id', $userId)->findOrFail($id);
        return response()->json($businessCard, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BusinessCard $businessCard)
    {
        // $userId = Auth::id();
        // if (!$userId) {
        //     return response()->json(['error' => 'Unauthenticated.'], 401);
        // }

        // $businessCard = BusinessCard::where('user_id', $userId)->findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        $businessCard->update($validatedData);
        return response()->json($businessCard, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $businessCard = BusinessCard::where('user_id', $userId)->findOrFail($id);
        $businessCard->delete();
        return response()->json(null, 204);
    }
}
