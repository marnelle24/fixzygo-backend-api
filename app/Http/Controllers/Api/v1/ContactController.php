<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Http\Requests\Api\v1\StoreContactRequest;
use App\Http\Requests\Api\v1\UpdateContactRequest;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::with('user')->get();
        return response()->json(['status' => true, 'contact' => $contacts], 20);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = auth()->user()->id; // Set the user_id to the authenticated user's ID
        $contact = Contact::create($validatedData);

        return response()->json(['status' => true, 'message' => 'Added contact successful', 'data' => $contact], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        try 
        {
            return response()->json(['status' => true, 'contact' => $contact->user], 200);
        } 
        catch (\Throwable $th) 
        {
            // Log the error for debugging
            \Log::error('Failed to fetch contact: ' . $th->getMessage(), [
                'exception' => $th
            ]);
        
            return response()->json(['status' => false, 'message' => 'Failed to fetch contact details.', 'error' => $th->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactRequest $request, Contact $contact)
    {
        if($contact->user_id != auth()->user()->id) 
            return response()->json(['status' => false, 'message' => 'You are not authorized to update this contact.', 'user_auth' => auth()->user()->id, 'contact_user_id' => $contact->user_id], 403);

        // Validate the request
        $contact->update($request->validated());
        return response()->json(['status' => true, 'message' => 'Updated contact successful', 'contact' => $contact, 'user_auth' => auth()->user()->id, 'contact_user_id' => $contact->user_id], 200);
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
