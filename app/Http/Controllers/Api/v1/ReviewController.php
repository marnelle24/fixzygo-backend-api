<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Review;
use App\Http\Requests\Api\v1\StoreReviewRequest;
use App\Http\Requests\Api\v1\UpdateReviewRequest;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try
        {
            $interests = Review::all();
            return response()->json(['status' => true, 'message' => 'Reviews fetched successfully', 'data' => $interests], 201);
        }
        catch (\Throwable $th) 
        {
            \Log::error('Failed to fetch reviews: ' . $th->getMessage(), [
                'exception' => $th
            ]);
            return response()->json(['status' => false, 'message' => 'Failed to fetch reviews', 'error' => $th->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request)
    {
        try
        {
            $validated = $request->validated();
            $review = Review::create($validated);
            return response()->json(['status' => true, 'message' => 'Review created successfully', 'data' => $review], 201);
        }
        catch (\Throwable $th) 
        {
            \Log::error('Failed to create review: ' . $th->getMessage(), [
                'exception' => $th
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        try
        {   
            $review = Review::find($review->id);
            return response()->json(['status' => true, 'message' => 'Review created successfully', 'data' => $review], 201);   
        }
        catch (\Throwable $th) 
        {       
            \Log::error('Failed to fetch review: ' . $th->getMessage(), [
                'exception' => $th
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewRequest $request, Review $review)
    {
        try 
        {   
            $validated = $request->validated();
            $review->update($validated);
            return response()->json(['status' => true, 'message' => 'Review updated successfully', 'data' => $review], 201);   
        }
        catch (\Throwable $th) 
        {       
            \Log::error('Failed to update review: ' . $th->getMessage(), [
                'exception' => $th
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        // Implement logic to delete the review
        try 
        {   
            $review->delete();
            return response()->json(['status' => true, 'message' => 'Review deleted successfully'], 201);   
        }
        catch (\Throwable $th) 
        {       
            \Log::error('Failed to delete review: ' . $th->getMessage(), [
                'exception' => $th
            ]);
        }
    }
}
