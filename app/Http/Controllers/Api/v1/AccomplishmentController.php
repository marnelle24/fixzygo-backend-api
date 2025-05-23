<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Accomplishment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\StoreAccomplishmentRequest;
use App\Http\Requests\Api\v1\UpdateAccomplishmentRequest;

class AccomplishmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accomplishments = Accomplishment::with('user')->get();
        return response()->json(['status' => true, 'accomplishments' => $accomplishments], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAccomplishmentRequest $request)
    {
        try
        {
            $validatedData = $request->validated();
            $validatedData['user_id'] = auth()->user()->id; // Set the user_id to the authenticated user's ID
            $accomplishment = Accomplishment::create($validatedData);
    
            return response()->json(['status' => true, 'message' => 'Accomplishment created successfully', 'accomplishment' => $accomplishment], 200);  
        }
        catch (\Throwable $th) 
        {
            // Log the error for debugging
            \Log::error('Failed to fetch accomplishment: ' . $th->getMessage(), [
                'exception' => $th
            ]);
        
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch accomplishment.',
                'error' => $th->getMessage(),
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Accomplishment $accomplishment)
    {
        try
        {
            $accomplishment = Accomplishment::with('user')->find($accomplishment->id);

            if (!$accomplishment)
                return response()->json(['status' => false, 'message' => 'Accomplishment not found'], 404);
    
            return response()->json(['status' => true, 'accomplishment' => $accomplishment], 200);
        }
        catch (\Throwable $th) 
        {
            // Log the error for debugging
            \Log::error('Failed to fetch accomplishment: ' . $th->getMessage(), [
                'exception' => $th
            ]);
        
            return response()->json(['status' => false, 'message' => 'Failed to fetch accomplishment.', 'error' => $th->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccomplishmentRequest $request, Accomplishment $accomplishment)
    {
        try
        {
            $validatedData = $request->validated();
            $accomplishment->update($validatedData);
            return response()->json(['status' => true, 'message' => 'Accomplishment updated successfully', 'accomplishment' => $accomplishment], 200);
        }
        catch (\Throwable $th) 
        {
            // Log the error for debugging
            \Log::error('Failed to update accomplishment: ' . $th->getMessage(), [
                'exception' => $th
            ]);
        
            return response()->json(['status' => false, 'message' => 'Failed to update accomplishment.', 'error' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Accomplishment $accomplishment)
    {
        try
        {
            $accomplishment->delete();
            return response()->json(['status' => true, 'message' => 'Accomplishment deleted successfully'], 200);
        }
        catch (\Throwable $th) 
        {
            // Log the error for debugging
            \Log::error('Failed to delete accomplishment: ' . $th->getMessage(), [
                'exception' => $th
            ]);
        
            return response()->json(['status' => false, 'message' => 'Failed to delete accomplishment.', 'error' => $th->getMessage()], 500);
        }
    }

    //get the loggedin user accomplishments
    public function getUserAccomplishments()
    {
        try
        {
            $user = auth()->user();
            $accomplishments = $user->accomplishments()->get();
            return response()->json(['status' => true, 'accomplishments' => $accomplishments], 200);
        }
        catch (\Throwable $th) 
        {
            // Log the error for debugging
            \Log::error('Failed to fetch user accomplishments: ' . $th->getMessage(), [
                'exception' => $th
            ]);
        
            return response()->json(['status' => false, 'message' => 'Failed to fetch user accomplishments.', 'error' => $th->getMessage()], 500);
        }
    }

    // get the loggedin user specific accomplishment
    public function getUserAccomplishment(Accomplishment $accomplishment)
    {
        try
        {
            $user = auth()->user();
            $accomplishment = $user->accomplishments()->find($accomplishment->id);
            if (!$accomplishment)
                return response()->json(['status' => false, 'message' => 'Accomplishment not found'], 404);
    
            return response()->json(['status' => true, 'accomplishment' => $accomplishment], 200);
        }
        catch (\Throwable $th) 
        {
            // Log the error for debugging
            \Log::error('Failed to fetch user accomplishment: ' . $th->getMessage(), [
                'exception' => $th
            ]);
        
            return response()->json(['status' => false, 'message' => 'Failed to fetch user accomplishment.', 'error' => $th->getMessage()], 500);
        }
    }

    // logged in user delete their accomplishment
    public function deleteUserAccomplishment(Accomplishment $accomplishment)
    {
        try
        {
            $user = auth()->user();
            $accomplishment = $user->accomplishments()->find($accomplishment->id);
            if (!$accomplishment)
                return response()->json(['status' => false, 'message' => 'Accomplishment not found'], 404);
    
            $accomplishment->delete();
            return response()->json(['status' => true, 'message' => 'Accomplishment deleted successfully'], 200);
        }
        catch (\Throwable $th) 
        {
            // Log the error for debugging
            \Log::error('Failed to delete user accomplishment: ' . $th->getMessage(), [
                'exception' => $th
            ]);
        
            return response()->json(['status' => false, 'message' => 'Failed to delete user accomplishment.', 'error' => $th->getMessage()], 500);
        }
    }
}
