@extends('layouts.back-end.app')

@section('title', translate('edit_work_shop'))

@section('content')
    <div class="content container-fluid">
        <div class="mb-3">
            <h2 class="h1 mb-0 d-flex gap-10">
                <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/brand-setup.png') }}" alt="">
                {{ translate('edit_work_shop_category') }}
            </h2>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body text-start">
                    <form action="{{ route('admin.category.work-shop-update-data')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <ul class="nav nav-tabs w-fit-content mb-4">
                                @foreach($languages as $lang)
                                    <li class="nav-item text-capitalize">
                                        <span class="nav-link form-system-language-tab cursor-pointer {{ $lang == $defaultLanguage ? 'active' : ''}}"
                                            id="{{ $lang}}-link">
                                            {{ucfirst(getLanguageName($lang)).'('.strtoupper($lang).')'}}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div>
                                        @foreach($languages as $lang)
                                            <div class="form-group {{ $lang != $defaultLanguage ? 'd-none' : ''}} form-system-language-form" id="{{ $lang}}-form">
                                                <label class="title-color">{{ translate('Name') }}<span class="text-danger">*</span> ({{strtoupper($lang) }})</label>
                                                <input type="text" name="name" class="form-control" value="{{$categories->name}}" placeholder="{{ translate('new_Category') }}">
                                            </div>
                                            <input type="hidden" name="lang[]" value="{{ $lang}}">
                                        @endforeach
                                        <input name="position" value="0" class="d-none">
                                    </div>

                                    <!-- New fields for slug, meta_title, description, and keywords -->
                                    @foreach($languages as $lang)
                                        <div class="form-group {{ $lang != $defaultLanguage ? 'd-none' : ''}} form-system-language-form" id="{{ $lang}}-form">
                                            <label class="title-color">{{ translate('Slug') }} ({{strtoupper($lang) }})</label>
                                            <input type="text" name="slug" class="form-control" value="{{$categories->slug}}" placeholder="{{ translate('slug') }}">
                                        </div>
                                        <div class="form-group {{ $lang != $defaultLanguage ? 'd-none' : ''}} form-system-language-form" id="{{ $lang}}-form">
                                            <label class="title-color">{{ translate('Meta Title') }} ({{strtoupper($lang) }})</label>
                                            <input type="text" name="meta_title" value="{{$categories->meta_title}}" class="form-control" placeholder="{{ translate('meta_title') }}">
                                        </div>
                                        <div class="form-group {{ $lang != $defaultLanguage ? 'd-none' : ''}} form-system-language-form" id="{{ $lang}}-form">
                                            <label class="title-color">{{ translate('Description') }} ({{strtoupper($lang) }})</label>
                                            <textarea name="description" class="form-control"   placeholder="{{ translate('description_placeholder') }}">{{$categories->description}}</textarea>
                                            <input type="hidden" name="id" value="{{$categories->id}}">
                                        </div>
                                        <div class="form-group {{ $lang != $defaultLanguage ? 'd-none' : ''}} form-system-language-form" id="{{ $lang}}-form">
                                            <label class="title-color">{{ translate('Keywords') }} ({{strtoupper($lang) }})</label>
                                            <input type="text" name="keywords" class="form-control" value="{{$categories->keywords}}"  placeholder="{{ translate('keywords') }}">
                                        </div>
                                        <div class="form-group {{ $lang != $defaultLanguage ? 'd-none' : '' }} form-system-language-form" id="{{ $lang }}-dropdown-form">
                                            <label class="title-color">{{ translate('type') }} ({{ strtoupper($lang) }})</label>
                                            <select class="form-control" name="type" id="dropdown" required>
                                                <option>Select Type</option>
                                                <option value="K-12 Offering" {{ $categories->type == 'K-12 Offering' ? 'selected' : '' }}>K-12 Offering</option>
                                                <option value="n-shop" {{ $categories->type == 'n-shop' ? 'selected' : '' }}>N-Shop</option>
                                            </select>
                                        </div>
                                        <div class="from_part_2">
                                        <label class="title-color">{{ translate('cover_pic') }}</label>
                                        <span class="text-info"><span class="text-danger">*</span> Cover Pic</span>
                                        <div class="custom-file text-left">
                                            <input type="file" name="image-file" id="category-image" value="{{ $categories->cover_pic }}" class="custom-file-input image-preview-before-upload" data-preview="#viewer" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                            <label class="custom-file-label" for="category-image">{{ translate('choose_File') }}</label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="col-lg-6 mt-4 mt-lg-0 from_part_2">
                                    <div class="form-group">
                                        <div class="text-center mx-auto">
                                        <img class="upload-img-view" id="viewer" alt="" src="{{ asset('public/assets/back-end/work-shop/'. $categories->cover_pic) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap gap-2 justify-content-end">
                                <button type="reset" id="reset" class="btn btn-secondary">{{ translate('reset') }}</button>
                                <button type="submit" class="btn btn--primary">{{ translate('submit') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>


    </div>
    <span id="route-admin-category-delete" data-url="{{ route('admin.category.delete') }}"></span>
    <span id="get-categories" data-categories="{{ json_encode($categories) }}"></span>


@endsection

@push('script')
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/products-management.js') }}"></script>
@endpush
