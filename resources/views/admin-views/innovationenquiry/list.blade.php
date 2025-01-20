@extends('layouts.back-end.app')

@section('title', translate('Innovation Enquiry'))

@section('content')

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
                    <div class="table-responsive mt-4">
                        <div class="d-flex justify-content-lg-end">
                            {{ $data->links() }}
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
