<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Http\Requests\Api\v1\StoreCategoryRequest;
use App\Http\Requests\Api\v1\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        return response()->json([
            'status' => true,
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $validatedData = $request->validated();
        $category = Category::create($validatedData);
        return response()->json([
            'status' => true,
            'message' => 'Category created successfully',
            'category' => $category,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return response()->json([
            'status' => true,
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $validatedData = $request->validated();
        $category->update($validatedData);

        return response()->json(['status' => true, 'message' => 'Category updated successfully', 'category' => $request->all()], 200);
    }

    /**
     * Add category to user
     */
    public function addCategoryToUser($userId, $categoryId)
    {
        try
        {
            $user = User::findOrFail($userId);
            $category = Category::findOrFail($categoryId);
            $user->categories()->attach($categoryId);

            return response()->json(['status' => true, 'message' => 'Category added to user successfully'], 200);
        }
        catch (\Throwable $th) 
        {
            // Log the error for debugging
            \Log::error('Failed to attach category to user: ' . $th->getMessage(), [
                'exception' => $th
            ]);
        
            return response()->json(['status' => false, 'message' => 'Failed to attach category to user.', 'error' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove category from user
     */
    public function removeCategoryFromUser($userId, $categoryId)
    {
        try
        {
            $user = User::findOrFail($userId);
            $category = Category::findOrFail($categoryId);
            $user->categories()->detach($categoryId);
    
            return response()->json(['status' => true, 'message' => 'Category removed from user successfully'], 200);
        }
        catch (\Throwable $th) 
        {
            // Log the error for debugging
            \Log::error('Failed to detach category from user: ' . $th->getMessage(), [
                'exception' => $th
            ]);
        
            return response()->json(['status' => false, 'message' => 'Failed to detach category from user.', 'error' => $th->getMessage()], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
