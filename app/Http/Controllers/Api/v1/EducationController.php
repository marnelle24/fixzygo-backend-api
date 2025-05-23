<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Education;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\StoreEducationRequest;
use App\Http\Requests\Api\v1\UpdateEducationRequest;

class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $educations = Education::all();

        foreach ($educations as $education) {
            $education['user'] = $education->user;
        }

        return response()->json(['status' => true, 'message' => 'Educations retrieved successfully', 'data' => $educations], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEducationRequest $request)
    {
        try
        {
            $validated = $request->validated();
            $education = Education::create($validated);
    
            return response()->json(['status' => true, 'message' => 'Education created successfully', 'data' => $education], 201);
        }
        catch (\Throwable $th) 
        {
            // Log the error for debugging
            \Log::error('Failed to add education: ' . $th->getMessage(), [
                'exception' => $th
            ]);
        
            return response()->json(['status' => false, 'message' => 'Failed to add education', 'error' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Education $education)
    {
        return response()->json(['status' => true, 'message' => 'Education retrieved successfully', 'data' => $education], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEducationRequest $request, Education $education)
    {
        $validated = $request->validated();
        $education->update($validated);

        return response()->json(['status' => true, 'message' => 'Education updated successfully', 'data' => $education], 200);
    }

    public function userEducations()
    {
        $educations = auth()->user()->educations;

        return response()->json(['status' => true, 'message' => 'User educations retrieved successfully', 'total' => $educations->count(), 'data' => $educations], 200);
    }

    public function userEducation(Education $education)
    {
        if($education->user_id !== auth()->id()) 
            return response()->json(['status' => false, 'message' => 'Unauthorized action'], 403);

        return response()->json(['status' => true, 'message' => 'User education retrieved successfully', 'total' => $education->count, 'data' => $education], 200);
    }

    public function userEducationUpdate(UpdateEducationRequest $request, Education $education)
    {
        if($education->user_id !== auth()->id())
            return response()->json(['status' => false, 'message' => 'Unauthorized action'], 403);

        $validated = $request->validated();
        $education->update($validated);

        return response()->json(['status' => true, 'message' => 'User education updated successfully', 'data' => $education], 200);
    }

    public function userEducationDestroy(Education $education)
    {
        if($education->user_id !== auth()->id())
            return response()->json(['status' => false, 'message' => 'Unauthorized action'], 403);

        $education->delete();
        return response()->json(['status' => true, 'message' => 'User education deleted successfully'], 200);
    }
}
