@extends('layouts.back-end.app')

@section('title', translate('work_shop_product'))

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="content container-fluid">
        <div class="mb-3">
            <h2 class="h1 mb-0 d-flex gap-10">
                <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/brand-setup.png') }}" alt="">
                {{ translate('work_shop_product_Setup') }}
            </h2>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body text-start">
                    <form action="{{ route('admin.products.work-shop-product-add')}}" method="POST" enctype="multipart/form-data">
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
                                                <label class="title-color">{{ translate('Title') }}<span class="text-danger">*</span> ({{strtoupper($lang) }})</label>
                                                <input type="text" name="title" class="form-control category-title-name" placeholder="{{ translate('new_product') }}">
                                            </div>
                                            <input type="hidden" name="lang[]" value="{{ $lang}}">
                                        @endforeach
                                        <input name="position" value="0" class="d-none">
                                    </div>

                                    <!-- New fields for slug, meta_title, description, and keywords -->
                                    @foreach($languages as $lang)
                                        <div class="form-group {{ $lang != $defaultLanguage ? 'd-none' : ''}} form-system-language-form" id="{{ $lang}}-form">
                                            <label class="title-color">{{ translate('Slug') }} ({{strtoupper($lang) }})</label>
                                            <input type="text" name="slug" class="form-control" id="slug-id" placeholder="{{ translate('slug') }}">
                                        </div>
                                        <div class="form-group {{ $lang != $defaultLanguage ? 'd-none' : ''}} form-system-language-form" id="{{ $lang}}-form">
                                            <label class="title-color">{{ translate('Meta Title') }} ({{strtoupper($lang) }})</label>
                                            <input type="text" name="meta_title" class="form-control" placeholder="{{ translate('meta_title') }}">
                                        </div>
                                        <div class="form-group {{ $lang != $defaultLanguage ? 'd-none' : ''}} form-system-language-form" id="{{ $lang}}-form">
                                            <label class="title-color">{{ translate('Description') }} ({{strtoupper($lang) }})</label>
                                            <textarea name="description" class="form-control" placeholder="{{ translate('description_placeholder') }}"></textarea>
                                        </div>
                                        <div class="form-group {{ $lang != $defaultLanguage ? 'd-none' : ''}} form-system-language-form" id="{{ $lang}}-form">
                                            <label class="title-color">{{ translate('meta_discription') }} ({{strtoupper($lang) }})</label>
                                            <textarea name="meta_description" class="form-control" placeholder="{{ translate('description_placeholder') }}"></textarea>
                                        </div>
                             <div class="form-group {{ $lang != $defaultLanguage ? 'd-none' : ''}} form-system-language-form" id="{{ $lang}}-form">
                                            <label class="title-color">{{ translate('Keywords') }} ({{strtoupper($lang) }})</label>
                                            <input type="text" name="keywords" class="form-control" placeholder="{{ translate('keywords') }}">
                                        </div>
                                        
                                        <div class="form-group {{ $lang != $defaultLanguage ? 'd-none' : '' }} form-system-language-form" id="{{ $lang }}-dropdown-form">
                                            <label class="title-color">{{ translate('work_shop_category') }} ({{ strtoupper($lang) }})</label>
                                            <select class="form-control" name="cat_id" id="dropdown">
                                                <option>Select Work Shop Category</option>
                                  
       

                                                @foreach($workshopcat as $cat)
                                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    @endforeach
                                    <div class="from_part_2">
                                        <label class="title-color">{{ translate('cover_pic') }}</label>
                                        <span class="text-info"><span class="text-danger">*</span> Cover Pic</span>
                                        <div class="custom-file text-left">
                                            <input type="file" name="image-file" id="category-image" class="custom-file-input image-preview-before-upload" data-preview="#viewer" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" required>
                                            <label class="custom-file-label" for="category-image">{{ translate('choose_File') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mt-4 mt-lg-0 from_part_2">
                                    <div class="form-group">
                                        <div class="text-center mx-auto">
                                            <img class="upload-img-view" id="viewer" alt="" src="{{ dynamicAsset(path: 'public/assets/back-end/img/image-place-holder.png') }}">
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

        <div class="row mt-20" id="cate-table">
            <div class="col-md-12">
                <div class="card">
                    <div class="px-3 py-4">
                        <div class="d-flex flex-wrap justify-content-between gap-3 align-items-center">
                            <div class="">
                                <h5 class="text-capitalize d-flex gap-1">
                                    {{ translate('category_list') }}
                                    <span
                                        class="badge badge-soft-dark radius-50 fz-12"></span>
                                </h5>
                            </div>
                            <div class="d-flex flex-wrap gap-3 align-items-center">
                            <form action="{{route('admin.category.work-shop-category')}}" method="GET">
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
                                <div class="dropdown">
                                    <button type="button" class="btn btn-outline--primary text-nowrap btn-block"
                                            data-toggle="dropdown">
                                        <i class="tio-download-to"></i>
                                        {{translate('export')}}
                                        <i class="tio-chevron-down"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li>
                                            <a class="dropdown-item"
                                               href="{{ route('admin.category.export',['searchValue'=>request('searchValue')]) }}">
                                                <img width="14" src="{{asset('/public/assets/back-end/img/excel.png')}}"
                                                     alt="">
                                                {{translate('excel')}}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="table-responsive">
                        <table
                            class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100 text-start">
                            <thead class="thead-light thead-50 text-capitalize">
                            <tr>
                                <th>{{ translate('ID') }}</th>
                                <th>{{ translate('title') }}</th>
                                <th class="text-center">{{ translate('image') }}</th>
                                <th class="text-center">{{ translate('meta_title') }}</th>
                                <!-- <th class="text-center">{{ translate('keywords') }}</th> -->
                                <th class="text-center">{{ translate('action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($product as $key=>$category)
                                <tr>
                                    <td>{{ $category['id'] }}</td>
                                    <td>{{ $category['title'] }}</td>
                                    <td class="d-flex justify-content-center">
                                        <div class="avatar-60 d-flex align-items-center rounded">
                                        <img class="img-fluid" alt="" src="{{ asset('public/assets/back-end/work-shop-product/' . $category['image']) }}">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        {{ $category['meta_title'] }}
                                    </td>
                                    <!-- <td>{{$category['keywords']}}</td> -->
                                    <td>
                                        <div class="d-flex justify-content-center gap-10">
                                            <a class="btn btn-outline-info btn-sm square-btn "
                                               title="{{ translate('edit') }}"
                                               href="{{ route('admin.products.work-shop-get-update-product', ['id' => $category['id']]) }}">
                                                <i class="tio-edit"></i>
                                            </a>
                                            <a class="btn btn-outline-danger btn-sm square-btn delete-work-shop-product"
                                               title="{{ translate('delete') }}"
                                               data-product-count = ""
                                               data-text=""
                                               id="{{ $category['id'] }}">
                                                <i class="tio-delete"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive mt-4">
                        <div class="d-flex justify-content-lg-end">
                            {{ $product->links() }}
                        </div>
                        <div style="display: none;" id="url-container" data-delete-url="{{ route('admin.products.work-shop-product-delete') }}"></div>
                    </div>
                    @if(count($product) == 0)
                        @include('layouts.back-end._empty-state',['text'=>'no_category_found'],['image'=>'default'])
                    @endif
                </div>
            </div>
        </div>
    </div>
    <span id="route-admin-category-delete" data-url="{{ route('admin.category.delete') }}"></span>
    <span id="get-categories" data-categories="{{ json_encode($product) }}"></span>
    <div class="modal fade" id="select-category-modal" tabindex="-1" aria-labelledby="toggle-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header border-0 pb-0 d-flex justify-content-end">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i
                            class="tio-clear"></i></button>
                </div>
                <div class="modal-body px-4 px-sm-5 pt-0 pb-sm-5">
                    <div class="d-flex flex-column align-items-center text-center gap-2 mb-2">
                        <div
                            class="toggle-modal-img-box d-flex flex-column justify-content-center align-items-center mb-3 position-relative">
                            <img src="{{dynamicAsset('public/assets/back-end/img/icons/info.svg')}}" alt="" width="90"/>
                        </div>
                        <h5 class="modal-title mb-2 category-title-message category-title-message"></h5>
                    </div>
                    <form action="{{ route('admin.category.delete') }}" method="post" class="product-category-update-form-submit">
                        @csrf
                        <input name="id" hidden="">
                        <div class="gap-2 mb-3">
                            <label class="title-color"
                                   for="exampleFormControlSelect1">{{ translate('select_Category') }}
                                <span class="text-danger">*</span>
                            </label>
                            <select name="category_id" class="form-control js-select2-custom category-option" required>
                            </select>
                        </div>
                        <div class="d-flex justify-content-center gap-3">
                            <button type="submit" class="btn btn--primary min-w-120">{{translate('update')}}</button>
                            <button type="button" class="btn btn-danger-light min-w-120"
                                    data-dismiss="modal">{{ translate('cancel') }}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('script')
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/work-shop-product.js') }}"></script>
    <script>
        $('.category-title-name').on('change keyup keypress', function () {
            var slugValue = $(this).val().replace(/\s+/g, '-');
            $('#slug-id').val(slugValue);
        });
    </script>
@endpush
