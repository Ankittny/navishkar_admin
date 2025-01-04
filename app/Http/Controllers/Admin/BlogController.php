<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Enums\ViewPaths\Admin\{Blog, Vendor};
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Contracts\Repositories\{BlogCategoryInterface,BlogInterface};
use App\Models\{BlogCategory,Category};
use App\Models\Blog as BlogDB;
use App\Traits\FileManagerTrait;


class BlogController extends Controller
{
    use FileManagerTrait;
    public function __construct(
        private readonly BlogCategoryInterface         $blogcatRepo,
        private readonly BlogInterface                 $blogRepo,
    )
    {
     }
     public function index(Request $request)
     {
         $query = BlogCategory::select('id', 'name', 'slug')->where('status',1);
             if ($request->has('searchValue') && $request->searchValue !== '') {
             $query->where('name', 'LIKE', '%' . $request->searchValue . '%'); // Use LIKE for partial matches
         }

         // Limit the results to 10
         $blogCategories = $query->paginate(10);
         // Return the view with the categories
         return view(Blog::LIST[VIEW], compact('blogCategories'));
     }

     public function blog_list_index(Request $request)
     {
         $query = BlogDB::select('id', 'cat_id','slug','title','description','image')->where('status',1);
             if ($request->has('searchValue') && $request->searchValue !== '') {
             $query->where('title', 'LIKE', '%' . $request->searchValue . '%'); // Use LIKE for partial matches
         }

         // Limit the results to 10
         $bloglist = $query->paginate(10);
         $categories = BlogCategory::all();
         $languages = getWebConfig(name: 'pnc_language') ?? null;
         return view(Blog::LISTBLOG[VIEW], compact('bloglist','categories','languages'));
     }



    public function add(Request $request){

        $slugExists = BlogCategory::where('slug', $request->slug)->exists();
        if ($slugExists) {
            Toastr::error(translate('slug_already_exist'));
            return redirect()->route('admin.home-blog');
        }

        if($this->blogcatRepo->add(request: $request)){
            Toastr::success(translate('blog_category_added_successfully'));
            return redirect()->route('admin.home-blog');
        }
    }


    public function addBlog(Request $request){
        $slugExists = BlogCategory::where('slug', $request->slug)->exists();
        if ($slugExists) {
            Toastr::error(translate('slug_already_exist'));
            return redirect()->route('admin.blog-list-blog');
        }
        $imageName = $this->upload('bloges/', 'webp', $request->file('image'));
        $request->merge(['image_file' => $imageName]);
        if($this->blogRepo->add(request: $request)){
            Toastr::success(translate('blog_updated_successfully'));
            return redirect()->route('admin.blog-list-blog');
        }
      }
      public function updatedata(Request $request){
        if($this->blogcatRepo->update(request: $request)){
            Toastr::success(translate('blog_updated_successfully'));
            return redirect()->route('admin.home-blog');
        }
      }
    public function updateBlog(Request $request){
        if($this->blogcatRepo->add(request: $request)){
            Toastr::success(translate('blog_added_successfully'));
            return redirect()->route('admin.home-blog');
        }
      }

    public function getUpdateView(Request $request){
      $data  = BlogCategory::where('id',$request->id)->first();
      return view(Blog::UPDATE[VIEW], compact('data'));
    }

    public function blogUpdatehome(Request $request){
      $data  = BlogDB::where('id',$request->id)->first();
      $categories = BlogCategory::all();
      $languages = getWebConfig(name: 'pnc_language') ?? null;
      return view(Blog::UPDATEBLOG[VIEW], compact('data','categories','languages'));
    }

    public function blogUpdatedata(Request $request){
      if($request->hasFile('image')){
          $imageName = $this->upload('bloges/', 'webp', $request->file('image'));
          $request->merge(['image_file' => $imageName]);
      }
      if($this->blogRepo->update(request: $request)){
        Toastr::success(translate('blog_updated_successfully'));
        return redirect()->route('admin.blog-list-blog');
      }
    }

    public function delete(Request $request){
      if($this->blogcatRepo->delete(request: $request)){
        Toastr::success(translate('blog_deleted_successfully'));
        return redirect()->route('admin.home-blog');
    }
    }

    public function delete_home(Request $request){
      if($this->blogRepo->delete(request: $request)){
        Toastr::success(translate('blog_deleted_successfully'));
        return redirect()->route('admin.home-blog');
    }
    }






}
