<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Certification;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\StoreCertificationRequest;
use App\Http\Requests\Api\v1\UpdateCertificationRequest;

class CertificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try 
        {
            $certifications = Certification::with('user')->get();
            return response()->json(['status' => true, 'certifications' => $certifications], 200);
        }
        catch (\Throwable $th) 
        {
            // Log the error for debugging
            \Log::error('Failed to fetch certifications: ' . $th->getMessage(), [
                'exception' => $th
            ]);
        
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch certifications.',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCertificationRequest $request)
    {
        try 
        {
            $validatedData = $request->validated();
            $certification = Certification::create($validatedData);
    
            return response()->json(['status' => true, 'message' => 'Certification created successfully', 'certification' => $certification], 200);
        }
        catch (\Throwable $th) 
        {
            // Log the error for debugging
            \Log::error('Failed to create certification: ' . $th->getMessage(), [
                'exception' => $th
            ]);
        
            return response()->json(['status' => false, 'message' => 'Failed to create certification.', 'error' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Certification $certification)
    {
        try 
        {
            $certification->user = $certification->user;
            return response()->json(['status' => true, 'certification' => $certification], 200);
        }
        catch (\Throwable $th) 
        {
            // Log the error for debugging
            \Log::error('Failed to fetch certification: ' . $th->getMessage(), [
                'exception' => $th
            ]);
        
            return response()->json(['status' => false, 'message' => 'Failed to fetch certification.', 'error' => $th->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCertificationRequest $request, Certification $certification)
    {
        try 
        {
            $validatedData = $request->validated();
            $certification->update($validatedData);
            return response()->json(['status' => true, 'message' => 'Certification updated successfully', 'certification' => $certification], 200);
        }
        catch (\Throwable $th) 
        {
            // Log the error for debugging
            \Log::error('Failed to update certification: ' . $th->getMessage(), [
                'exception' => $th
            ]);
        
            return response()->json(['status' => false, 'message' => 'Failed to update certification.', 'error' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Certification $certification)
    {
        try 
        {
            $certification->delete();
            return response()->json(['status' => true, 'message' => 'Certification deleted successfully']);
        }
        catch (\Throwable $th) 
        {
            // Log the error for debugging
            \Log::error('Failed to delete certification: ' . $th->getMessage(), [
                'exception' => $th
            ]);
        
            return response()->json(['status' => false, 'message' => 'Failed to delete certification.', 'error' => $th->getMessage()], 500);
        }
    }

    // get user certifications
    public function getUserCertifications()
    {
        try 
        {
            $certifications = auth()->user()->certifications;
            return response()->json(['status' => true, 'message' => 'User certifications retrieved successfully', 'data' => $certifications], 200);
        }
        catch (\Throwable $th) 
        {
            // Log the error for debugging
            \Log::error('Failed to fetch user certifications: ' . $th->getMessage(), [
                'exception' => $th
            ]);
        
            return response()->json(['status' => false, 'message' => 'Failed to fetch user certifications.', 'error' => $th->getMessage()], 500);
        }
    }

    // get user certification
    public function getUserCertification(Certification $certification)
    {
        try 
        {
            if($certification->user_id !== auth()->id()) 
                return response()->json(['status' => false, 'message' => 'Unauthorized action'], 403);

            $sertification = auth()->user()->certifications()->where('id', $certification->id)->first();

            return response()->json(['status' => true, 'message' => 'User certification retrieved successfully', 'data' => $certification], 200);
        }
        catch (\Throwable $th) 
        {
            // Log the error for debugging
            \Log::error('Failed to fetch user certification: ' . $th->getMessage(), [
                'exception' => $th
            ]);
        
            return response()->json(['status' => false, 'message' => 'Failed to fetch user certification.', 'error' => $th->getMessage()], 500);
        }
    }

    // update user certification
    public function updateUserCertification(UpdateCertificationRequest $request, Certification $certification)
    {
        try 
        {
            if($certification->user_id !== auth()->id()) 
                return response()->json(['status' => false, 'message' => 'Unauthorized action'], 403);
    
            $validatedData = $request->validated();
            $certification->update($validatedData);
    
            return response()->json(['status' => true, 'message' => 'User certification updated successfully', 'data' => $certification], 200);
        }
        catch (\Throwable $th) 
        {
            // Log the error for debugging
            \Log::error('Failed to update user certification: ' . $th->getMessage(), [
                'exception' => $th
            ]);
        
            return response()->json(['status' => false, 'message' => 'Failed to update user certification.', 'error' => $th->getMessage()], 500);
        }
    }

}
