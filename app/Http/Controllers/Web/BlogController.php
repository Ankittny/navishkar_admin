<?php
namespace App\Http\Controllers\Web;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    public function home(){
        $recent_posts = Blog::select('cat_id', 'title', 'description', 'image', 'slug', 'status','created_at')->where('status', 1)
        ->orderBy('created_at', 'desc') // Order by latest posts
        ->take(5) // Limit to the latest five
        ->get();
        return view('web-views.blog.view', compact('recent_posts'));
    }

    public function blog_Detail(Request $request, $slug){
        $blog = Blog::where('slug',$slug)->first();
        return view('web-views.blog.blog-detail', compact('blog'));
    }

    public function pending(){
        Mail::to('kvikesh775@gmail.com')->send(new \App\Mail\PendingOrder(100206));
        dd(56);
    }
}
