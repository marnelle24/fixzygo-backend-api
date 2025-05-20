<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use App\Models\Contact;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\StoreContactRequest;
use App\Http\Requests\Api\v1\UpdateContactRequest;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::all();
        
        foreach ($contacts as $contact) {
            $contact['user'] = $contact->user;
        }

        return response()->json([
            'status' => true,
            'contact' => $contacts,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRequest $request)
    {
        $contact = Contact::create($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Added contact successful'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        try 
        {
            $contact['user'] = $contact->user;
        
            return response()->json([
                'status' => true,
                'contact' => $contact,
            ]);
        } 
        catch (\Throwable $th) 
        {
            // Log the error for debugging
            \Log::error('Failed to fetch contact: ' . $th->getMessage(), [
                'exception' => $th
            ]);
        
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch contact details.',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactRequest $request, Contact $contact)
    {
        if($contact->user_id != auth()->user()->id) 
        {
            return response()->json([
                'status' => false,
                'message' => 'You are not authorized to update this contact.',
                'user_auth' => auth()->user()->id,
                'contact_user_id' => $contact->user_id,
            ], 403);
        }

        // Validate the request
        $contact->update($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Updated contact successful',
            'contact' => $contact,
            'user_auth' => auth()->user()->id,
            'contact_user_id' => $contact->user_id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        // Delete the contact
        $contact->delete();

        return response()->json([
            'message' => 'Contact deleted successfully.'
        ]);
    }
}
