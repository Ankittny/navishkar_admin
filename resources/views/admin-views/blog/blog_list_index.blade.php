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
            {{translate('blog_list')}}
         </h2>
         <span class="badge badge-soft-dark radius-50 fz-14"></span>
      </div>
      <div class="card">
         <div class="card-body text-start">
            <form action="{{route('admin.blog-home-add')}}" method="post" enctype="multipart/form-data">
               @csrf
               @foreach ($languages as $lang)
               <?php $defaultLanguage = $languages[0]; ?>
               <div class="row">
                  <div class="col-lg-6">
                        <div class="form-group">
                           <label class="title-color">Title<span class="text-danger">*</span></label>
                           <input type="text" name="title" class="form-control category-title-name" value="" placeholder="{{ translate('title') }}" required>
                        </div>
                        <div class="form-group">
                           <label class="title-color">Slug<span class="text-danger">*</span></label>
                           <input type="text" name="slug" class="form-control" id="slug-id" value="" placeholder="{{ translate('slug') }}" required>
                        </div>
                        <div class="form-group">
                           <label class="title-color">Meta Title<span class="text-danger">*</span></label>
                           <input type="text" name="meta_title" class="form-control" value="" placeholder="{{ translate('meta_title') }}" required>
                        </div>
                        <div class="form-group">
                           <label class="title-color">Meta Description<span class="text-danger">*</span></label>
                           <textarea name="meta_discription" class="form-control" placeholder="{{ translate('meta_discription') }}" required></textarea>
                        </div>

                        <div class="form-group">
                           <label class="title-color">Keywords<span class="text-danger">*</span></label>
                           <input type="text" name="keywords" class="form-control" value="" placeholder="{{ translate('keywords') }}" required>
                        </div>
                        <div class="form-group">
                           <label class="title-color">Category ID<span class="text-danger">*</span></label>
                           <select name="cat_id" class="form-control js-select2-custom form-control action-get-request-onchange" required>
                              <option value="" disabled selected>Select a category</option>
                              @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">
                                       {{ $cat->name }} <!-- Change 'name' to the appropriate attribute for category display -->
                                    </option>
                              @endforeach
                           </select>
                        </div>

                        <div class="form-group pt-2">
                            <label class="title-color" for="{{ $lang }}_description">
                                {{ translate('description') }} ({{ strtoupper($lang) }})
                            </label>
                            <textarea class="summernote {{ $lang == $defaultLanguage ? 'description' : '' }}" name="description">{{ old('description') }}</textarea>
                        </div>
                        @endforeach
                        <div class="from_part_2">
                                        <label class="title-color">{{ translate('blog_banner') }}</label>
                                        <span class="text-info"><span class="text-danger">*</span> Blog Image Ratio 1:1 (1307 x 400 px)</span>
                                        <div class="custom-file text-left">
                                            <input type="file" name="image" id="category-image"
                                                   class="custom-file-input image-preview-before-upload"
                                                   data-preview="#viewer"
                                                   accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*"
                                                   required>
                                            <label class="custom-file-label"
                                                   for="category-image">{{ translate('choose_File') }}</label>
                                        </div>
                     </div>

                  </div>
                  <div class="col-lg-6 mt-4 mt-lg-0 from_part_2">
                                    <div class="form-group">
                                        <div class="text-center mx-auto">
                                            <img class="upload-img-view" id="viewer" alt=""
                                                 src="{{ dynamicAsset(path: 'public/assets/back-end/img/image-place-holder.png') }}">
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

      <div class="card mt-3">
         <div class="card-body">
            <div class="px-3 py-4 light-bg">
               <div class="row g-2 align-items-center flex-grow-1 justify-content-between">
                  <div class="col-md-4">
                     <h5 class="text-capitalize d-flex gap-1">
                        {{translate('blog_list')}}
                        <span class="badge badge-soft-dark radius-50 fz-12"></span>
                     </h5>
                  </div>
                  <div class="col-sm-8 col-md-6 col-lg-4">
                     <form action="{{route('admin.blog-list-blog')}}" method="GET">
                        <div class="input-group input-group-custom input-group-merge">
                           <div class="input-group-prepend">
                              <div class="input-group-text">
                                 <i class="tio-search"></i>
                              </div>
                           </div>
                           <input type="search" name="searchValue" class="form-control" placeholder="Search HSN Code" aria-label="Search by brand name" value="" required="">
                           <button type="submit" class="btn btn--primary input-group-text">Search</button>
                        </div>
                     </form>
                  </div>
                  <div class="col-md-8 d-flex gap-3 flex-wrap flex-sm-nowrap justify-content-md-end">
                     <div class="dropdown">
                        <ul class="dropdown-menu dropdown-menu-right">
                           <li>
                              <a type="submit" class="dropdown-item d-flex align-items-center gap-2" href="">
                              <img width="14" src="{{asset('public/assets/back-end/img/excel.png')}}" alt="">
                              {{translate('excel')}}
                              </a>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
            <div class="table-responsive datatable-custom">
               <table class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100 text-start">
                  <thead class="thead-light thead-50 text-capitalize">
                     <tr>
                        <th>{{translate('id')}}</th>
                        <th class="text-capitalize">{{translate('category')}}</th>
                        <th class="text-capitalize">{{translate('title')}}</th>
                        <th class="text-capitalize">{{translate('slug')}}</th>
                        <!-- <th class="text-capitalize">{{translate('description')}}</th> -->
                        <th class="text-capitalize">{{translate('image')}}</th>
                        <th class="text-center">{{translate('action')}}</th>
                     </tr>
                  </thead>
                  <tbody>

                    @foreach($bloglist as $blog)
                    <tr>
                        <td>{{ $blog->id }}</td>
                        <?php
                        $category_name = optional(App\Models\BlogCategory::find($blog->cat_id))->name ?? 'Null';
                        ?>
                        <td>{{ $category_name }}</td>
                        <td>{{ $blog->title }}</td>
                        <td>{{ $blog->slug }}</td>
                        <!-- <td>{{ strip_tags($blog->description) }}</td> -->
                        <td>
                        <img src="{{asset('public/assets/back-end/bloges/').'/'.$blog->image }}" alt="blog" class="img-thumbnail" style="width: 60px; height: 60px;">
                        </td>
                        <td class="text-center d-flex gap-2">
                            <a href="{{ route('admin.update-blog-view', $blog->id) }}" class="btn btn-outline--primary btn-sm square-btn" title="Edit"><i class="tio-edit"></i></a>
                            <a class="btn btn-outline-danger btn-sm delete-blog square-btn " title="{{ translate('delete') }}"
                                                   data-product-count = "{{count($bloglist)}}"
                                                   data-text=""
                                                   id="{{ $blog->id }}">
                                                   <i class="tio-delete"></i>
                                    </a>
                        </td>

                    </tr>
                    @endforeach
                </tbody>

               </table>
               <div class="table-responsive mt-4">
                        <div class="px-4 d-flex justify-content-lg-end">
                            {{ $bloglist->links() }}
               </div>
               </div>
            </div>
            <div class="table-responsive mt-4">
               <div class="d-flex justify-content-lg-end">
               </div>
            </div>
            <div style="display: none;" id="url-container" data-delete-url="{{ route('admin.blog-home-delete') }}"></div>
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
<script src="{{ dynamicAsset(path: 'public/assets/back-end/js/bloghomecode-management.js') }}"></script>
 <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/products-management.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/tags-input.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/spartan-multi-image-picker.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/admin/product-add-update.js') }}"></script>
    {{-- <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/admin/product-add-colors-img.js') }}"></script> --}}
    <script>
        $('.category-title-name').on('change keyup keypress', function () {
            var slugValue = $(this).val().replace(/\s+/g, '-');
            $('#slug-id').val(slugValue);
        });
    </script>
@endpush
