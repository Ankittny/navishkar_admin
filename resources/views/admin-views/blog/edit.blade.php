@extends('layouts.back-end.app')
@section('title', translate('blog_category'))
@section('content')
<div class="content container-fluid">
   <div>
      <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
         <h2 class="h1 mb-0">
            <img src="{{dynamicAsset(path: 'public/assets/back-end/img/all-orders.png')}}" class="mb-1 mr-1" alt="">
            {{translate('blog_edit_category')}}
         </h2>
         <span class="badge badge-soft-dark radius-50 fz-14"></span>
      </div>
      <div class="card">
         <div class="card-body text-start">
            <form action="{{route('admin.update-blog-data')}}" method="post">
               @csrf
               <span class="nav-link form-system-language-tab cursor-pointer active" id="en-link">
               English(EN)
               </span>
               </li>
               </ul>
               <div class="row">
                  <div class="col-lg-6">
                     <div>
                        <div class="form-group  form-system-language-form" id="en-form">
                           <label class="title-color">Category Name<span class="text-danger">*</span> (EN)</label>
                           <input type="text" name="name" class="form-control" placeholder="{{translate('blog_category_name')}}" value="{{$data->name}}" required="">
                        </div>
                        <input type="hidden" name="id"  value="{{$data->id}}">
                     </div>
                     <div class="form-group">
                        <label class="title-color" for="slug">{{ translate('Slug') }}</label>
                        <input type="text" name="slug" class="form-control" id="slug-id" value="{{$data->slug}}" placeholder="{{ translate('enter_slugs') }}">
                     </div>
                  </div>
                  <div class="col-lg-6 mt-4 mt-lg-0 from_part_2">
                     <div class="form-group">
                        <div class="text-center mx-auto">
                           <!-- <img class="upload-img-view" id="viewer" alt="" src="http://127.0.0.1:8000/assets/back-end/img/image-place-holder.png"> -->
                        </div>
                     </div>
                  </div>
               </div>
               <div class="d-flex flex-wrap gap-2 justify-content-end">
                  <button type="reset" id="reset" class="btn btn-secondary">Reset</button>
                  <button type="submit" class="btn btn--primary">Submit</button>
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
@push('script_2')
<script src="{{ dynamicAsset(path: 'public/assets/back-end/js/hsncode-management.js') }}"></script>
@endpush
