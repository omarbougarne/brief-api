<?php

namespace App\Http\Controllers;


use App\Models\BusinessCard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BusinessCardController extends Controller
{
    public function index()
    {
        return BusinessCard::all();
    }

    public function show($id)
    {
        return BusinessCard::findOrFail($id);
    }

    public function store(Request $request)
    {
        return BusinessCard::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $businessCard = BusinessCard::findOrFail($id);
        $businessCard->update($request->all());
        return $businessCard;
    }

    public function destroy($id)
    {
        BusinessCard::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}

