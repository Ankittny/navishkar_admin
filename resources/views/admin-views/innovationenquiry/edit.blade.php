@extends('layouts.back-end.app')

@section('title', translate('Edit Innovation Enquiry'))

@section('content')
<div class="content container-fluid">
    <div class="mb-3">
        <h2 class="h1 mb-0 d-flex gap-10">
            <img src="{{ dynamicAsset('public/assets/back-end/img/enquiry.png') }}" alt="">
            {{ translate('Edit Innovation Enquiry') }}
        </h2>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body text-start">
                    <form action="{{ route('admin.innovationenquiry.update', [$enquiry->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Use PUT method here for updates -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="title-color">{{ translate('Name') }}<span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" placeholder="{{ translate('Enter Name') }}" value="{{ $enquiry->name }}" required>
                                </div>

                                <div class="form-group">
                                    <label class="title-color">{{ translate('Email') }}<span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" placeholder="{{ translate('Enter Email') }}" value="{{ $enquiry->email }}" required>
                                </div>

                                <div class="form-group">
                                    <label class="title-color">{{ translate('Contact No') }}<span class="text-danger">*</span></label>
                                    <input type="text" name="contact_no" class="form-control" placeholder="{{ translate('Enter Contact Number') }}" value="{{ $enquiry->contact_no }}" required>
                                </div>

                                <div class="form-group">
                                    <label class="title-color">{{ translate('Class/Branch') }}</label>
                                    <input type="text" name="class_branch" class="form-control" placeholder="{{ translate('Enter Class or Branch') }}" value="{{ $enquiry->class_branch }}">
                                </div>

                                <div class="form-group">
                                    <label class="title-color">{{ translate('Parent Name') }}</label>
                                    <input type="text" name="parent_name" class="form-control" placeholder="{{ translate('Enter Parent Name') }}" value="{{ $enquiry->parent_name }}">
                                </div>

                                <div class="form-group">
                                    <label class="title-color">{{ translate('Parent Contact No') }}</label>
                                    <input type="text" name="parent_contact_no" class="form-control" placeholder="{{ translate('Enter Parent Contact Number') }}" value="{{ $enquiry->parent_contact_no }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="title-color">{{ translate('School/College Name') }}</label>
                                    <input type="text" name="school_college_name" class="form-control" placeholder="{{ translate('Enter School or College Name') }}" value="{{ $enquiry->school_college_name }}">
                                </div>

                                <div class="form-group">
                                    <label class="title-color">{{ translate('Enquiry') }}</label>
                                    <input type="text" name="enquiry" class="form-control" placeholder="{{ translate('Enter Enquiry') }}" value="{{ $enquiry->enquiry }}">
                                </div>

                                <div class="form-group">
                                    <label class="title-color">{{ translate('Options') }}</label>
                                    <input type="text" name="options" class="form-control" placeholder="{{ translate('Enter Options') }}" value="{{ $enquiry->options }}">
                                </div>

                                <div class="form-group">
                                    <label class="title-color">{{ translate('Description') }}</label>
                                    <textarea name="description" class="form-control" rows="4" placeholder="{{ translate('Enter Description') }}">{{ $enquiry->description }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2 justify-content-end">
                            <button type="reset" id="reset" class="btn btn-secondary">{{ translate('Reset') }}</button>
                            <button type="submit" class="btn btn--primary">{{ translate('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
