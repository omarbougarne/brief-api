<?php

namespace App\Http\Controllers;

use App\Models\BusinessCard;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Schema(
 *     schema="VisitCard",
 *     required={"id", "name", "email", "tel", "adress", "company", "description"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *     @OA\Property(property="tel", type="string", example="123456789"),
 *     @OA\Property(property="adress", type="string", example="123 Main St"),
 *     @OA\Property(property="company", type="string", example="ABC Inc."),
 *     @OA\Property(property="description", type="string", example="Lorem ipsum"),
 * )
 */

class BusinessCardController extends Controller
{

 /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/visitcards",
     *     summary="Get all visit cards",
     *     tags={"Visit Cards"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/VisitCard")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     )
     * )
     */

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
      /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/visitcards",
     *     summary="Store a new visit card",
     *     tags={"Visit Cards"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Visit card data",
     *         @OA\JsonContent(
     *             required={"name", "email", "tel", "adress", "company", "description"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="tel", type="string"),
     *             @OA\Property(property="adress", type="string"),
     *             @OA\Property(property="company", type="string"),
     *             @OA\Property(property="description", type="string"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Visit card created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=201),
     *             @OA\Property(property="message", type="string", example="Visit card created successfully"),
     *             @OA\Property(property="visitCard", ref="#/components/schemas/VisitCard")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to create visit card",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=500),
     *             @OA\Property(property="message", type="string", example="Failed to create visit card")
     *         )
     *     )
     * )
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
     /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/visitcards/{visitcard}",
     *     summary="Update a visit card",
     *     tags={"Visit Cards"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="visitcard",
     *         in="path",
     *         description="ID of the visit card to update",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Updated visit card data",
     *         @OA\JsonContent(
     *             required={"name", "email", "tel", "adress", "company", "description"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="tel", type="string"),
     *             @OA\Property(property="adress", type="string"),
     *             @OA\Property(property="company", type="string"),
     *             @OA\Property(property="description", type="string"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Visit card updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Visit card updated successfully"),
     *             @OA\Property(property="visitCard", ref="#/components/schemas/VisitCard")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized: You do not have permission to update this visit card",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=403),
     *             @OA\Property(property="message", type="string", example="Unauthorized: You do not have permission to update this visit card")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to update visit card",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=500),
     *             @OA\Property(property="message", type="string", example="Failed to update visit card")
     *         )
     *     )
     * )
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
     /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/visitcards/{visitcard}",
     *     summary="Delete a visit card",
     *     tags={"Visit Cards"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="visitcard",
     *         in="path",
     *         description="ID of the visit card to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Visit card deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized: You do not have permission to delete this visit card",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=403),
     *             @OA\Property(property="message", type="string", example="Unauthorized: You do not have permission to delete this visit card")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to delete visit card",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=500),
     *             @OA\Property(property="message", type="string", example="Failed to delete visit card")
     *         )
     *     )
     * )
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
    // public function swagger()
    // {
    //     $swagger = \Swagger\scan(app_path('Http/Controllers'));
    //     return response()->json($swagger);
    // }
}
