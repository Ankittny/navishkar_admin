<?php

namespace App\Http\Controllers\RestAPI\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Data;

class DataController extends Controller
{
    public function innovations_enquiry()
    {
        $data=Data::all();

    }

    public function innovations_enquiry_create(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'contact_no' => 'required|string|max:15',
                'class_branch' => 'nullable|string|max:255',
                'parent_name' => 'nullable|string|max:255',
                'parent_contact_no' => 'nullable|string|max:15',
                'school_college_name' => 'nullable|string|max:255',
                'enquiry' => 'nullable|string|max:500',
                'options' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:1000',
            ]);
            // Create a new Data instance and save validated data
            $data = new Data();
            $data->fill($validatedData);
            $data->save();
            // Return a JSON response
            return response()->json([
                'status' => true,
                'message' => 'Enquiry successfully saved.',
            ], 200);
        } catch (ValidationException $e) {
            // Return validation errors in a custom JSON format
            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 200);
        }
    }


}
