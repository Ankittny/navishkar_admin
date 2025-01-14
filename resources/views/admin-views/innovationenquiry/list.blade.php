@extends('layouts.back-end.app')

@section('title', translate('Innovation Enquiry'))

@section('content')
<div class="content container-fluid">
    <div class="mb-3">
        <h2 class="h1 mb-0 d-flex gap-10">
            <img src="{{ dynamicAsset('public/assets/back-end/img/enquiry.png') }}" alt="">
            {{ translate('Innovation Enquiry') }}
        </h2>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body text-start">
                    <form action="{{ route('admin.innovationenquiry.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="title-color">{{ translate('Name') }}<span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" placeholder="{{ translate('Enter Name') }}" required>
                                </div>

                                <div class="form-group">
                                    <label class="title-color">{{ translate('Email') }}<span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" placeholder="{{ translate('Enter Email') }}" required>
                                </div>

                                <div class="form-group">
                                    <label class="title-color">{{ translate('Contact No') }}<span class="text-danger">*</span></label>
                                    <input type="text" name="contact_no" class="form-control" placeholder="{{ translate('Enter Contact Number') }}" required>
                                </div>

                                <div class="form-group">
                                    <label class="title-color">{{ translate('Class/Branch') }}</label>
                                    <input type="text" name="class_branch" class="form-control" placeholder="{{ translate('Enter Class or Branch') }}">
                                </div>

                                <div class="form-group">
                                    <label class="title-color">{{ translate('Parent Name') }}</label>
                                    <input type="text" name="parent_name" class="form-control" placeholder="{{ translate('Enter Parent Name') }}">
                                </div>

                                <div class="form-group">
                                    <label class="title-color">{{ translate('Parent Contact No') }}</label>
                                    <input type="text" name="parent_contact_no" class="form-control" placeholder="{{ translate('Enter Parent Contact Number') }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="title-color">{{ translate('School/College Name') }}</label>
                                    <input type="text" name="school_college_name" class="form-control" placeholder="{{ translate('Enter School or College Name') }}">
                                </div>

                                <div class="form-group">
                                    <label class="title-color">{{ translate('Enquiry') }}</label>
                                    <input type="text" name="enquiry" class="form-control" placeholder="{{ translate('Enter Enquiry') }}">
                                </div>

                                <div class="form-group">
                                    <label class="title-color">{{ translate('Options') }}</label>
                                    <input type="text" name="options" class="form-control" placeholder="{{ translate('Enter Options') }}">
                                </div>

                                <div class="form-group">
                                    <label class="title-color">{{ translate('Description') }}</label>
                                    <textarea name="description" class="form-control" rows="4" placeholder="{{ translate('Enter Description') }}"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2 justify-content-end">
                            <button type="reset" id="reset" class="btn btn-secondary">{{ translate('Reset') }}</button>
                            <button type="submit" class="btn btn--primary">{{ translate('Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{ translate('Enquiry List') }}</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                    <table class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100 text-start">
                    <thead class="thead-light thead-50 text-capitalize">
                                <tr>
                                    <th>{{ translate('SL') }}</th>
                                    <th>{{ translate('Name') }}</th>
                                    <th>{{ translate('Email') }}</th>
                                    <th>{{ translate('Contact No') }}</th>
                                    <th>{{ translate('Class/Branch') }}</th>
                                    <th>{{ translate('Enquiry') }}</th>
                                    <th>{{ translate('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $key => $enquiry)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $enquiry->name }}</td>
                                        <td>{{ $enquiry->email }}</td>
                                        <td>{{ $enquiry->contact_no }}</td>
                                        <td>{{ $enquiry->class_branch }}</td>
                                        <td>{{ $enquiry->enquiry }}</td>
                                        <td>
                                            <a class="btn btn-outline-info btn-sm square-btn "
                                               title="{{ translate('delete') }}"
                                               href="{{ route('admin.innovationenquiry.delete',[$enquiry['id']]) }}">
                                                <i class="tio-delete"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">{{ translate('No enquiries found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
