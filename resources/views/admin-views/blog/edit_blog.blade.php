@extends('layouts.back-end.app')
@section('title', translate('blog_list'))
@push('css_or_js')
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
@endpush
@section('content')
<div class="content container-fluid">
   <div>
      <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
         <h2 class="h1 mb-0">
            <img src="{{dynamicAsset(path: 'public/assets/back-end/img/all-orders.png')}}" class="mb-1 mr-1" alt="">
            {{translate('Edit_blog_list')}}
         </h2>
         <span class="badge badge-soft-dark radius-50 fz-14"></span>
      </div>
      <div class="card">
         <div class="card-body text-start">
            <form action="{{route('admin.update-blog-data-home')}}" method="post" enctype="multipart/form-data">
               @csrf
               @foreach ($languages as $lang)
               <?php $defaultLanguage = $languages[0]; ?>
               <div class="row">
                  <div class="col-lg-6">
                        <div class="form-group">
                           <label class="title-color">Title<span class="text-danger">*</span></label>
                           <input type="text" name="title" class="form-control category-title-name" value="{{ $data->title }}" placeholder="{{ translate('title') }}">
                           <input type="hidden" value="{{ $data->id }}" name="id">

                        </div>
                        <div class="form-group">
                           <label class="title-color">Meta Title<span class="text-danger">*</span></label>
                           <input type="text" name="meta_title" class="form-control" value="{{ $data->meta_title }}" placeholder="{{ translate('meta_title') }}">
                        </div>
                        <div class="form-group">
                           <label class="title-color">Meta Description<span class="text-danger">*</span></label>
                           <input type="text" name="meta_discription" class="form-control" value="{{ $data->meta_discription }}" placeholder="{{ translate('meta_discription') }}">
                        </div>
                        <div class="form-group">
                           <label class="title-color">Keywords<span class="text-danger">*</span></label>
                           <input type="text" name="keywords" class="form-control" value="{{ $data->keywords }}" placeholder="{{ translate('Keywords') }}">
                        </div>
                        <div class="form-group">
                           <label class="title-color">Slug<span class="text-danger">*</span></label>
                           <input type="text" name="slug" class="form-control" id="slug-id" value="{{ $data->slug }}" placeholder="{{ translate('slug') }}" >
                        </div>
                        <div class="form-group">
                           <label class="title-color">Category ID<span class="text-danger">*</span></label>

                           <?php
                             $categorys = App\Models\BlogCategory::where('id', $data->cat_id)->first();
                           ?>

                           <select name="cat_id" class="form-control js-select2-custom form-control action-get-request-onchange">
                              @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $cat->id == $data->cat_id ? 'selected' : '' }}>
                                       {{ $cat->name }} <!-- Change 'name' to the appropriate attribute for category display -->
                                    </option>
                              @endforeach
                           </select>
                        </div>

                        <div class="form-group pt-2">
                            <label class="title-color" for="{{ $lang }}_description">
                                {{ translate('description') }} ({{ strtoupper($lang) }})
                            </label>
                            <textarea class="summernote {{ $lang == $defaultLanguage ? 'description' : '' }}" name="description">{{ $data->description }}</textarea>
                        </div>
                        @endforeach
                        <div class="from_part_2">
                                        <label class="title-color">{{ translate('category_Logo') }}</label>
                                        <span class="text-info"><span class="text-danger">*</span> Blog Image Ratio 1:1 (1307 x 400 px)</span>
                                        <div class="custom-file text-left">
                                            <input type="file" name="image" id="category-image"
                                                   class="custom-file-input image-preview-before-upload"
                                                   data-preview="#viewer"
                                                   accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*"
                                                   >
                                            <label class="custom-file-label"
                                                   for="category-image">{{ translate('choose_File') }}</label>
                                        </div>
                        </div>
                  </div>
                  <div class="col-lg-6 mt-4 mt-lg-0 from_part_2">
                            <div class="form-group">
                                <div class="text-center mx-auto">
                                    <img class="upload-img-view" id="viewer" alt="blog"
                                            src="{{ asset('public/assets/back-end/bloges/') . '/' . $data->image }}">
                                </div>
                            </div>
                  </div>
               </div>
               <div class="d-flex flex-wrap gap-2 justify-content-end">
                  <button type="reset" id="reset" class="btn btn-secondary">Reset</button>
                  <button type="submit" class="btn btn--primary">Save</button>
               </div>
            </form>

         </div>
      </div>


      <div class="js-nav-scroller hs-nav-scroller-horizontal d-none">
         <span class="hs-nav-scroller-arrow-prev d-none">
         <a class="hs-nav-scroller-arrow-link" href="javascript:">
         <i class="tio-chevron-left"></i>
         </a>
         </span>
         <span class="hs-nav-scroller-arrow-next d-none">
         <a class="hs-nav-scroller-arrow-link" href="javascript:">
         <i class="tio-chevron-right"></i>
         </a>
         </span>
         <ul class="nav nav-tabs page-header-tabs">
            <li class="nav-item">
               <a class="nav-link active" href="#">{{translate('hsnCode')}}</a>
            </li>
         </ul>
      </div>
   </div>
</div>
@endsection
@push('script')
 <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/products-management.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/tags-input.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/spartan-multi-image-picker.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/admin/product-add-update.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/admin/product-add-colors-img.js') }}"></script>
    <script>
        $('.category-title-name').on('change keyup keypress', function () {
            var slugValue = $(this).val().replace(/\s+/g, '-');
            $('#slug-id').val(slugValue);
        });
    </script>
@endpush



