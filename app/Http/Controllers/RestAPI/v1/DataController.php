<?php

namespace App\Http\Controllers\RestAPI\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{BePartnerWithUs,Data};
use Validator;
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
            $validator = Validator::make($request->all(), [
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

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 200);
            }

            // Create a new Data instance and save validated data
            $data = new Data();
            $data->fill($request->all());
            $data->save();

            // Return a JSON response
            return response()->json([
                'status' => true,
                'message' => 'Enquiry successfully saved.',
            ], 200);
        } catch (\Exception $e) {
            // Return a JSON response
            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'errors' => $e->getMessage(),
            ], 200);
        }
    }

    public function BePartnerWith(Request $request){
        $validator = Validator::make($request->all(), [
            'oraganization_name' => 'required|string|max:255',
            'location' => 'required',
            'official_email' => 'required|email|max:255',
            'contact_number' => 'required|string|max:15',
            'querry_description' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 200);
        }

        $data = new BePartnerWithUs();
        $data->oraganization_name = $request->oraganization_name;
        $data->location = $request->location;
        $data->official_email = $request->official_email;
        $data->contact_number = $request->contact_number;
        $data->querry_description = $request->querry_description;
        $data->save();

        return response()->json([
            'status' => true,
            'message' => 'Enquiry successfully saved.',
        ], 200);
    }

}
