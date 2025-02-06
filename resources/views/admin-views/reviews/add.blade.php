@extends('layouts.back-end.app')

@section('title', translate('add_review'))

@section('content')
    <div class="content container-fluid">
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex gap-2 align-items-center">
                <img width="20" src="{{ dynamicAsset(path: 'public/assets/back-end/img/customer_review.png') }}" alt="">
                {{ translate('add_review') }}
            </h2>
        </div>

        <div class="card card-body">
        <form action="{{ route('admin.reviews.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row gy-3">
                    <!-- Product Selection -->
                    <div class="col-md-4">
                        <label for="product_id" class="title-color">{{ translate('products') }}</label>
                        <div class="dropdown select-product-search w-100">
                            <input type="text" class="product_id" name="product_id" value="{{ old('product_id') }}" hidden>
                            <button class="form-control text-start dropdown-toggle text-truncate select-product-button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" type="button">
                                {{ old('product_id') != null ? $product['name'] : translate('select_Product') }}
                            </button>
                            <div class="dropdown-menu w-100 px-2">
                                <div class="search-form mb-3">
                                    <button type="button" class="btn"><i class="tio-search"></i></button>
                                    <input type="text" class="js-form-search form-control search-bar-input search-product" placeholder="{{ translate('search_product') . '...' }}">
                                </div>
                                <div class="d-flex flex-column gap-3 max-h-40vh overflow-y-auto overflow-x-hidden search-result-box">
                                    @include('admin-views.partials._search-product',['products'=>$products])
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Selection -->
                    <div class="col-md-4">
                        <label for="customer_id" class="title-color">{{ translate('customer') }}</label>
                        <input type="hidden" id="customer_id" name="customer_id" value="{{ old('customer_id') }}">
                        <select class="get-customer-list-by-ajax-request form-control form-ellipsis set-customer-value">
                            <option value="">{{ translate('select_customer') }}</option>
                        </select>
                    </div>

                    <!-- Rating Selection -->
                    <div class="col-md-4">
                        <label for="rating" class="title-color">{{ translate('rating') }}</label>
                        <select name="rating" id="rating" class="form-control">
                            <option value="">{{ translate('select_rating') }}</option>
                            <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>{{ translate('1_star') }}</option>
                            <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>{{ translate('2_stars') }}</option>
                            <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>{{ translate('3_stars') }}</option>
                            <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>{{ translate('4_stars') }}</option>
                            <option value="5" {{ old('rating') == 5 ? 'selected' : '' }}>{{ translate('5_stars') }}</option>
                        </select>
                    </div>

                    <!-- Review Comment -->
                    <div class="col-md-12">
                        <label for="comment" class="title-color">{{ translate('review_comment') }}</label>
                        <textarea name="comment" id="comment" class="form-control" rows="4" placeholder="{{ translate('write_a_review') }}">{{ old('comment') }}</textarea>
                    </div>

                    <!-- Review Attachments -->
                    <div class="col-md-12">
                        <label for="attachments" class="title-color">{{ translate('attachments') }}</label>
                        <input type="file" class="form-control" name="attachment[]" multiple>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn--primary">{{ translate('submit_review') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/search-product.js') }}"></script>
@endpush
