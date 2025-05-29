<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Interest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\StoreInterestRequest;
use App\Http\Requests\Api\v1\UpdateInterestRequest;

class InterestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try 
        {
            $interests = Interest::all();
            return response()->json(['status' => true, 'message' => 'Interest fetched successfully', 'data' => $interests], 201);
        }
        catch (\Throwable $th) 
        {
            \Log::error('Failed to fetch interests: ' . $th->getMessage(), [
                'exception' => $th
            ]);
            return response()->json(['status' => false, 'message' => 'Failed to fetch interests', 'error' => $th->getMessage()], 500);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInterestRequest $request)
    {
        try 
        {
            $validated = $request->validated();
            $interest = Interest::create($validated);
            return response()->json(['status' => true, 'message' => 'Interest created successfully', 'data' => $interest], 201);
        } 
        catch (\Throwable $th) 
        {
            \Log::error('Failed to create interest: ' . $th->getMessage(), [
                'exception' => $th
            ]);
            return response()->json(['status' => false, 'message' => 'Failed to create interest', 'error' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Interest $interest)
    {
        try 
        {
            return response()->json(['status' => true, 'message' => 'Interest fetched successfully', 'data' => $interest], 201);
        }
        catch (\Throwable $th) 
        {
            \Log::error('Failed to fetch interest: ' . $th->getMessage(), [
                'exception' => $th
            ]);
            return response()->json(['status' => false, 'message' => 'Failed to fetch interest', 'error' => $th->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInterestRequest $request, Interest $interest)
    {
        try 
        {
            $validated = $request->validated();
            $interest->update($validated);
            return response()->json(['status' => true, 'message' => 'Interest updated successfully', 'data' => $interest], 200);
        } 
        catch (\Throwable $th) 
        {
            \Log::error('Failed to update interest: ' . $th->getMessage(), [
                'exception' => $th
            ]);
            return response()->json(['status' => false, 'message' => 'Failed to update interest', 'error' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Interest $interest)
    {
        try 
        {
            $interest->delete();
            return response()->json(['status' => true, 'message' => 'Interest deleted successfully'], 200);
        } 
        catch (\Throwable $th) 
        {
            \Log::error('Failed to delete interest: ' . $th->getMessage(), [
                'exception' => $th
            ]);
            return response()->json(['status' => false, 'message' => 'Failed to delete interest', 'error' => $th->getMessage()], 500);
        }
    }

    // Get all interests for the authenticated user
    public function getUserInterests()
    {
        try
        {
            $interests = auth()->user()->interests;
            return response()->json(['status' => true, 'message' => 'User interests fetched successfully', 'data' => $interests], 200);
        } 
        catch (\Throwable $th) 
        {
            \Log::error('Failed to fetch user interests: ' . $th->getMessage(), [
                'exception' => $th
            ]);
            return response()->json(['status' => false, 'message' => 'Failed to fetch user interests', 'error' => $th->getMessage()], 500);
        }
    }

    // Get a specific interest for the authenticated user
    public function getUserInterest(Interest $interest)
    {
        try
        {
            $user = auth()->user();
            $interest = $user->interests()->find($interest->id);
            if (!$interest) 
                return response()->json(['status' => false, 'message' => 'Interest not found for user'], 404);
            
            return response()->json(['status' => true, 'message' => 'User interest fetched successfully', 'data' => $interest], 200);
        } 
        catch (\Throwable $th) 
        {
            \Log::error('Failed to fetch user interest: ' . $th->getMessage(), [
                'exception' => $th
            ]);
            return response()->json(['status' => false, 'message' => 'Failed to fetch user interest', 'error' => $th->getMessage()], 500);
        }
    }

    //update a specific interest for the authenticated user
    public function updateUserInterest(UpdateInterestRequest $request, Interest $interest)
    {
        try
        {
            $user = auth()->user();
            if ($interest->user_id !== $user->id) 
                return response()->json(['status' => false, 'message' => 'Unauthorized action'], 403);
            
            $validated = $request->validated();
            $interest->update($validated);
            return response()->json(['status' => true, 'message' => 'User interest updated successfully', 'data' => $interest], 200);
        } 
        catch (\Throwable $th) 
        {
            \Log::error('Failed to update user interest: ' . $th->getMessage(), [
                'exception' => $th
            ]);
            return response()->json(['status' => false, 'message' => 'Failed to update user interest', 'error' => $th->getMessage()], 500);
        }
    }

    // Delete a specific interest for the authenticated user
    public function deleteUserInterest(Interest $interest)
    {
        try
        {
            $user = auth()->user();
            if ($interest->user_id !== $user->id) 
                return response()->json(['status' => false, 'message' => 'Unauthorized action'], 403);
            
            $interest->delete();
            return response()->json(['status' => true, 'message' => 'User interest deleted successfully'], 200);
        } 
        catch (\Throwable $th) 
        {
            \Log::error('Failed to delete user interest: ' . $th->getMessage(), [
                'exception' => $th
            ]);
            return response()->json(['status' => false, 'message' => 'Failed to delete user interest', 'error' => $th->getMessage()], 500);
        }
    }

}
