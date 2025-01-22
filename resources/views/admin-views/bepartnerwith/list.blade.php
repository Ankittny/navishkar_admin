@extends('layouts.back-end.app')

@section('title', translate('Be Partner With'))

@section('content')

<!-- Table Section -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">{{ translate('Be Partner With') }}</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100 text-start">
                        <thead class="thead-light thead-50 text-capitalize">
                            <tr>
                                <th>{{ translate('SL') }}</th>
                                <th>{{ translate('Organization Name') }}</th>
                                <th>{{ translate('Location') }}</th>
                                <th>{{ translate('Contact Number') }}</th>
                                <th>{{ translate('Official Mail') }}</th>
                                <th>{{ translate('Query Description') }}</th>
                                <th>{{ translate('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bepartnerwithus as $key => $enquiry)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $enquiry->oraganization_name }}</td> 
                                    <td>{{ $enquiry->location }}</td>
                                    <td>{{ $enquiry->contact_number }}</td>
                                    <td>{{ $enquiry->official_email }}</td>
                                    <td>{{ $enquiry->querry_description }}</td>
                                    <td>
                                        <a class="btn btn-outline-info btn-sm square-btn" 
                                           title="{{ translate('Delete') }}"
                                           href="{{ route('admin.bepartnerwith.delete', [$enquiry['id']]) }}">
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
                            {{ $bepartnerwithus->links() }}
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
