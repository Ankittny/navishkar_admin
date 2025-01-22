<?php

namespace App\Http\Controllers\RestAPI\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\{BlogCategory,Category};
use App\Models\Blog;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{

    public function get_blog(Request $request)
    {
        $data = [];
    
        $blog = Blog::all(['cat_id', 'title', 'description','image','slug','meta_title','meta_discription','keywords']);
        if(!empty($blog)){
            return response()->json(["status"=>true,"blog"=>$blog], 200);
        } else {
            return response()->json(["status"=>false,"message"=>"No blog found"], 404);
        }
    }

    public function blog_create(Request $request)
    {
        try {
        
            $validator = Validator::make($request->all(), [
                'cat_id' => 'required|integer|exists:blog_categories,id', 
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:500', 
                'image' => 'nullable|string|max:255',
                'slug' => 'nullable|string|max:255|unique:blogs,slug',
                'status' => 'nullable|in:active,inactive', 
                'meta_title' => 'nullable|string|max:255',
                'keywords' => 'nullable|string|max:500',
                'meta_discription' => 'nullable|string|max:255',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 202); 
            }
    
            $blog = Blog::create($request->all());
    
            return response()->json([
                'status' => true,
                'message' => 'Blog successfully created.',
                'data' => $blog,
            ], 201); 
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while creating the blog.',
                'errors' => $e->getMessage(),
            ], 500); 
        }
    }

    public function get_blog_categorie(Request $request)
{
    $data = [];

    $blogCategories = BlogCategory::all(['id', 'name', 'slug']);

    if(!empty($blogCategories)){
        return response()->json(["status"=>true,"blogCategories"=>$blogCategories], 200);
    } else 
    {
        return response()->json(["status"=>false,"message"=>"No blog found"], 404);
    }
}


    public function blog_category_create(Request $request)
    {
        try {
        
            $validator = Validator::make($request->all(), [
                'name' => 'required|integer|exists:blog_categories,id', 
                'slug' => 'required|string|max:255',
                'status' => 'required|string|max:500', 
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 202); 
            }
    
            $blog_category = BlogCategory::create($request->all());
    
            return response()->json([
                'status' => true,
                'message' => 'Blog successfully created.',
                'data' => $blog_category,
            ], 201); 
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while creating the blog.',
                'errors' => $e->getMessage(),
            ], 500); 
        }
    }

    public function blog_details($slug)
    {
        
        $blog = Blog::where('slug', $slug)->first();

        if (!$blog) {
            return response()->json([
                'status' => 'flase',
                'message' => 'Blog not found'
            ], 404);
        }

        $blog_category = BlogCategory::where('id', $blog->cat_id)->first();

        return response()->json([
            'status' => 'true',
            'message' => 'Blog details retrieved successfully',
            'blog' => $blog,
            'blog_category' => $blog_category
        ]);
    }
    
}
